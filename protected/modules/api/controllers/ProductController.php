<?php

class ProductController extends ApiController
{

    public function actionIndex()
    {
      echo __METHOD__;
    }

    public function actionView()
    {

    }

    public function actionCreate()
    {
        $this->pageCaption = 'Adding content to your Channel';
        $this->pageDescription = ' ';

        $model = $this->loadModel();
        $asset = $this->loadAssetModel();
        $type = isset($_GET['type']) ? $_GET['type'] : Contents::TYPE_VIDEO;

        $this->performAjaxValidation($model);

        if ($type && in_array($type, array_keys(Contents::$types))) {
            $model->type = $type;
            $asset->type = $this->contentAssetTypeRelation[$type];
        }

        $role = MemberHelper::getRole(MemberHelper::getCurrent());

        $types = Contents::$types;
        if (in_array($role, array(Members::ROLE_CHANNEL_OWNER, Members::ROLE_MEMBER))) {
            $types = Contents::$typesForRole[$role];
        }

        if (isset($_POST[$this->_modelClass])) {
            $contentType = $_POST['Contents']['type'] = $_GET['type'];
            $contentTitle = isset($_POST['Contents']['name']) ? $_POST['Contents']['name'] : '';
            // determine which models we need:
            $modelAsset = null; // for node files like a video, audio, picture and pdf
            $modelThumb = null; // for node thumbnail (
            switch ($contentType) {
                case Contents::TYPE_AUDIO:
                case Contents::TYPE_FILE:
                    $modelAsset = $this->loadAssetModel();
                    $modelAsset->type = $this->contentAssetTypeRelation[$contentType];
                    $modelAsset->title = $contentTitle;

                    if ($_POST['Contents']['thumb']) {
                        $modelThumb = $this->loadAssetModel();
                        $modelThumb->type = ContentAssets::TYPE_IMAGE;
                        $modelThumb->title = $contentTitle;
                    }
                    break;
                case Contents::TYPE_IMAGE:
                case Contents::TYPE_VIDEO:
                    $modelAsset = $this->loadAssetModel();
                    $modelAsset->type = $this->contentAssetTypeRelation[$contentType];
                    $modelAsset->title = $contentTitle;
                    break;
                case Contents::TYPE_LINK;
                    $modelThumb = $this->loadAssetModel();
                    $modelThumb->type = ContentAssets::TYPE_IMAGE;
                    $modelThumb->title = $contentTitle;
                    break;
            }

            if ($this->_save($model) && (!$modelAsset || $this->_saveAsset($modelAsset,
                        array('file' => $_POST['Contents']['asset']))) && (!$modelThumb || $this->_saveAsset($modelThumb,
                        array('file' => $_POST['Contents']['thumb'])))
            ) {
                // set access to the node for user who created that node
                $model->nodeAccess->setAccessToNode(array('read' => 1, 'insert' => 1, 'update' => 1, 'delete' => 1));
                $model->nodeAccess->setAccessToNodeForParentUsers();

                // set asset relation
                if ($modelAsset) {
                    $this->attachAsset($model->id, $modelAsset->id);
                }
                if ($modelThumb) {
                    $this->attachAsset($model->id, $modelThumb->id);
                }


                Yii::app()->user->setFlash(WebUser::FLASH_SUCCESS,
                    "It will take approximately 5 minutes to be processed");

                $this->redirect(array('index'));
            }
        }

        if ($this->_isModBreadcrumbs) {
            $this->breadcrumbs[] = 'Create';
        }
        $this->render('form', array(
            'model' => $model,
            'type' => $type,
            'asset' => $asset,
            'types' => $types,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['Contents'])) {
            if ($this->_save($model)) {
                Yii::app()->user->setFlash(WebUser::FLASH_SUCCESS, "The data was saved successfully!");
                $this->redirect(array('view', 'id' => $model->primaryKey));
            }
        }

        $role = MemberHelper::getRole(MemberHelper::getCurrent());
        $types = Contents::$types;
        if (in_array($role, array(Members::ROLE_CHANNEL_OWNER, Members::ROLE_MEMBER))) {
            $types = Contents::$typesForRole[$role];
        }

        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jwplayer/jwplayer.js',
            CClientScript::POS_HEAD);

        $this->render('form', array(
            'model' => $model,
            'type' => $model->type,
            'types' => $types,
        ));
    }

    public function actionUpdateInfoScreen($id)
    {
        if ($model = InfoScreens::model()->findByPk($id)) {
            $this->performAjaxValidation($model);
            if (isset($_POST['InfoScreens'])) {
                $model->attributes = $_POST['InfoScreens'];
                if ($model->save()) {
                    Yii::app()->user->setFlash(WebUser::FLASH_SUCCESS, "The data was saved successfully!");
                    $this->redirect(array('view', 'id' => $model->primaryKey));
                }
            }
            $types[Contents::TYPE_INFO_SCREEN] = Contents::TITLE_INFO_SCREEN;

            $this->render('form-is', array(
                'model' => $model,
                'type' => $model->type,
                'types' => array(Contents::TYPE_INFO_SCREEN => Contents::TITLE_INFO_SCREEN),
            ));
        }
    }

    public function actionUpdateInfoPage($id)
    {
        if (($model = InfoPages::model()->findByPk($id)) && ($_POST['NodesData'] || $_POST['InfoPages'])) {
            $isSaved = true;
            if (isset($_POST['InfoPages'])) {
                $model->attributes = $_POST['InfoPages'];
                $isSaved = $isSaved && $model->save();
            }
            if (isset($_POST['NodesData'])) {
                $model->nodes_data->attributes = $_POST['NodesData'];
                $isSaved = $isSaved && $model->nodes_data->save();
            }

            if ($isSaved) {
                Yii::app()->user->setFlash(WebUser::FLASH_SUCCESS, 'The data was saved successfully!');
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer ?: Yii::app()->controller->module->returnUrl);
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model && $model->type == Contents::TYPE_INFO_SCREEN) {
            Yii::app()->user->setFlash(WebUser::FLASH_ERROR,
                'Info screen cannot be deleted. Disable it in edit form');
        } else {
            parent::actionDelete($id);
        }
    }

    public function actionUpload($contentType = null)
    {
        if (isset($this->contentFileTypes[$contentType])) {
            Yii::import('ext.Uploader.UploaderHandler');
            $types = array_map('trim', $this->contentFileTypes[$contentType]);
            $accept_file_types = '/\.(' . implode('|', $types) . ')$/i';

            $old = umask(0);

            $uploaderHandler = new UploaderHandler(array(
                'param_name' => key($_FILES) ?: false,
                'upload_dir' => Assets::getTmpDir(),
                'inline_file_types' => '/^(!.*)$/',
                'mkdir_mode' => 0777,
                'accept_file_types' => $accept_file_types,//'/\.(gif|jpeg|jpg|png|avi|mp3)$/i',
            ), false);

            umask($old);

            $response = $uploaderHandler->post(false);
            $files = reset($response); // we upload only one file per time
            if (is_array($files)) {
                foreach ($files as &$file) {
                    if (!$this->contentAssetTypeRelation[$contentType]) {
                        continue;
                    }
                    $asset = $this->loadAssetModel();
                    $asset->type = $this->contentAssetTypeRelation[$contentType];
                    $assetFile = $asset->files[0];
                    $assetFile->file = $file->name;
                    $assetFile->fileinfoSet();
                    if (!$assetFile->fileinfoCheck()) {
                        $file->error = Utils::arr2scalar($asset->errors);
                    }
                    if (isset($file->name)) {
                        $file->info = Files::model()->fileinfoGet(Assets::getTmpDir() . $file->name);
                    }
                }
            }

            echo json_encode($response);
        }

        Yii::app()->end();
    }

    public function loadModel($id = null)
    {
        $model = parent::loadModel($id);

        if (!$model->parent_id) {
            $model->parent_id = MemberHelper::getChannel(MemberHelper::getCurrent())->id;
        }

        if (!$model->nodes_data) {
            $model->nodes_data = new NodesData();
        }

        return $model;
    }

    /**
     * @param integer $id
     * @return Assets
     * @throws CHttpException
     */
    public function loadAssetModel($id = null)
    {
        if ($id === null) {
            $model = new ContentAssets();
            $file = new Files;
            $file->asset = $model;
            $model->files = array($file);
        } else {
            $model = ContentAssets::model()->findByPk($id);
        }
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    protected function attachAsset($node_id, $asset_id)
    {
        $model = new NodesAssets;
        $model->node_id = $node_id;
        $model->asset_id = $asset_id;
        $model->save();
    }

    protected function _save(CActiveRecord $model)
    {
        if (isset($_POST['Contents'])) {
            $model->attributes = $_POST['Contents'];
        }
        if (isset($_POST['NodesData'])) {
            $model->nodes_data->attributes = $_POST['NodesData'];
        }

        return $model->saveAll();
    }

    protected function _saveAsset(Assets $model, array $fileParams)
    {
        if (empty($fileParams)) {
            return false;
        }
        $model->status = Assets::STATUS_NEW;

        $file = $model->files[0];
        /* @var $file Files */
        $file->attributes = $fileParams;
        $file->status = Files::STATUS_NEW;
        $file->format = Files::FORMAT_FULL;
        $file->fileinfoSet();

        if (!$file->fileinfoCheck()) {
            return false;
        }
        $file->fileinfoQuality();
        $warnings = implode(', ', $file->fileinfoQualityWarnings());
        switch ($model->quality) {
            case Assets::QUALITY_HD_SD:
                Yii::app()->user->setFlash(WebUser::FLASH_INFO, "SD and HD videos will be cteated.");
                break;
            case Assets::QUALITY_SD:
                Yii::app()->user->setFlash(WebUser::FLASH_WARNING,
                    "Only SD video will be cteated. Source file quality is too low for HD: {$warnings}.");
                break;
            case Assets::QUALITY_FULL:
                Yii::app()->user->setFlash(WebUser::FLASH_WARNING,
                    "SD video will be copied from source. Source file quality is too low for SD and HD: {$warnings}.");
                break;
        }
        $tr = $model->dbConnection->beginTransaction();
        if ($model->save() && ($file->asset_id = $model->id) && $file->save()) {
            $tr->commit();
            return true;
        } else {

            $tr->rollback();
            return false;
        }
    }
}
