<?php

class BoletoController extends Controller {

    public $layout = '//layouts/boleto_layout';

    public function filters(){

        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete' // we only allow deletion via POST request
        );
    }

    public function accessRules(){

        return array(
            array('allow',
                'actions'       => array('index','listarBoletos'),
                'users'         => array('@'),
            ),
        );
        
    }
    
    public function actionIndex()
    {
        $cs = Yii::app()->getClientScript();

        $cs->registerCssFile($baseUrl . '/css/jquery.dataTables.css');
        $cs->registerCssFile($baseUrl . '/css/dataTables.tableTools.css');
        
        
    }
    
}