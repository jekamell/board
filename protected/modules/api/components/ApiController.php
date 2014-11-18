<?php

class ApiController extends Controller
{
    public $layout = '/layouts/column1';
    public $menu = array();
    public $sidebarCaption = 'Actions';
    public $topMenu = array();
    public $rightMenu = array();

    public function init()
    {
        parent::init();
    }

    public function accessRules()
    {
        return array(
            'allow',
        );
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }
}
