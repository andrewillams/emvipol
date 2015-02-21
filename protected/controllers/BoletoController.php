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
                'actions'       => array('index','grid_boletos'),
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
        
        //$this->render('grid_boletos');
        
        //Boleto::model()->listarTitulos();
        
        $db = new PDO("dblib:host=187.60.78.18:1435;dbname=TREINA;charset=utf8", "acesso", "@cess");
        
        $query  = "SELECT  E1_FILIAL  AS FILIAL,  E1_PREFIXO AS PREFIXO,    E1_NUM   AS NUMERO, E1_PARCELA AS PARCELA, E1_TIPO   AS TIPO, ";
        $query .= "E1_EMISSAO AS EMISSAO, E1_VENCREA AS VENCIMENTO, E1_VALOR AS VALOR,  E1_CLIENTE AS CLIENTE, E1_NOMCLI AS NOMECLIENTE ";
        $query .= "FROM SE1010 AS SE1 ";
        $query .= "WHERE SE1.D_E_L_E_T_ <> '*' ";
        $query .= "AND SE1.E1_TIPO NOT LIKE '%-%' ";
        $query .= "ORDER BY R_E_C_N_O_ DESC ";

        $sth = $db->prepare($query);
        
        $sth->execute();
        
        $retorno = $sth->fetchAll();
        
        var_dump($retorno);
        
        
    }
    
}