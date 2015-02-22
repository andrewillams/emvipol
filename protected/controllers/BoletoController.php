<?php

class BoletoController extends Controller {

    //public $layout = '//layouts/boleto_layout';

    public function filters(){

        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete' // we only allow deletion via POST request
        );
    }

    public function accessRules(){

        return array(
            array('allow',
                'actions'       => array('index','listar'),
                'users'         => array('*'),
            ),
        );
        
    }
    
    public function actionIndex()
    {
        
        $baseUrl = Yii::app()->baseUrl;
        
        $cs = Yii::app()->getClientScript();

        $cs->registerCssFile($baseUrl . '/css/jquery.dataTables.css');
        $cs->registerCssFile($baseUrl . '/css/dataTables.tableTools.css');
        
        $cs->registerScriptFile($baseUrl . '/js/boleto/grid.js', CClientScript::POS_END);

        $cs->registerScriptFile($baseUrl . '/js/jquery.js');
        $cs->registerScriptFile($baseUrl . '/js/jquery.dataTables.js', CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl . '/js/dataTables.fnReloadAjax.js', CClientScript::POS_END);
        
        $boleto = new Boleto;
        
        $retorno = $boleto->listarTitulos();
        
        $this->render('grid_boletos',array('dados' => $retorno));
        
    }
    
    public function actionListar()
    {
        
        $boleto = new Boleto;
        
        $retorno = $boleto->listarTitulos();
        
        //echo json_encode( $retorno );
        
        return $retorno;
        //var_dump($retorno);
    }
    
}