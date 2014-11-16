<?php

class OperationRestrictionFilter extends CFilter
{
    public $id;

    protected function preFilter($filterChain)
    {
        if ($product = Product::model()->noDeleted()->findByPk($this->id)) {
            if ($product->user_id == Yii::app()->getUser()->getId()) {
                return true;
            }
        }

        throw new CHttpException(403, 'You are not authorized to perform this action.');
    }
}
