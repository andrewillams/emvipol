<?php

class BoletoController extends Controller {

    //public $layout = '//layouts/boleto_layout';

    public function filters() {

        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete' // we only allow deletion via POST request
        );
    }

    public function accessRules() {

        return array(
            array('allow',
                'actions' => array('index', 'listar', 'imprimir'),
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {

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

        $this->render('grid_boletos', array('dados' => $retorno));
    }

    public function actionImprimir() {

        $this->layout = 'empty_template';

        // DADOS DO BOLETO PARA O SEU CLIENTE
        $dias_de_prazo_para_pagamento       = 5;
        //$taxa_boleto                        = 2.95;
        $data_venc                          = $_POST['vencimento']; //date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
        /*$valor_cobrado                      = "2950,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
        $valor_cobrado                      = str_replace(",", ".", $valor_cobrado);*/
        
        $valor_boleto                       = number_format($_POST['valor'], 2, ',', '.');

        $dadosboleto["nosso_numero"]        = $_POST['nossonumero'];  // Nosso numero - REGRA: Máximo de 8 caracteres!
        $dadosboleto["numero_documento"]    = $_POST['numeroDocumento']; // Num do pedido ou nosso numero
        $dadosboleto["data_vencimento"]     = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
        $dadosboleto["data_documento"]      = $_POST['emissao']; //date("d/m/Y"); // Data de emissão do Boleto
        $dadosboleto["data_processamento"]  = date("d/m/Y"); // Data de processamento do boleto (opcional)
        $dadosboleto["valor_boleto"]        = $valor_boleto;  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

        // DADOS DO SEU CLIENTE
        $dadosboleto["sacado"]              = $_POST['nomecliente'];
        $dadosboleto["endereco1"]           = $_POST['endcliente'];
        $dadosboleto["endereco2"]           = $_POST['cidcliente']." - ".$_POST['estcliente']." - CEP: " .$_POST['cepcliente'];

        // INFORMACOES PARA O CLIENTE
        //$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Nonononono";
        //$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ " . number_format($taxa_boleto, 2, ',', '');
        //$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
        $dadosboleto["instrucoes1"]         = "- Mora diária de R$ " . $_POST['jurosmora'];
        $dadosboleto["instrucoes2"]         = "- Não efetuar depósito em conta sem autorização";
        $dadosboleto["instrucoes3"]         = "- Não receber 05 dias após o vencimento";
        $dadosboleto["instrucoes4"]         = "- Não conceder quaisquer Descontos";
        $dadosboleto["instrucoes5"]         = "&nbsp; Multa de 2,00% Após o Vencimento";

        // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
        $dadosboleto["quantidade"]          = "";
        $dadosboleto["valor_unitario"]      = "";
        $dadosboleto["aceite"]              = "";
        $dadosboleto["especie"]             = "R$";
        $dadosboleto["especie_doc"]         = "DM";

        // ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
        // DADOS DA SUA CONTA - ITAÚ
        $conta      = trim($_POST['conta']);
        $tamConta = strlen($conta);
        
        $dadosboleto["agencia"]             = substr($_POST['agencia'],0,4); //"1565"; // Num da agencia, sem digito
        $dadosboleto["conta"]               = substr($_POST['conta'],0, ($tamConta-1));       //"13877"; // Num da conta, sem digito
        $dadosboleto["conta_dv"]            = substr($_POST['conta'],($tamConta), 1); //"4";  // Digito do Num da conta
        // DADOS PERSONALIZADOS - ITAÚ
        $dadosboleto["carteira"]            = "109";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157
        // SEUS DADOS
        $dadosboleto["identificacao"]               = "BoletoPhp - Código Aberto de Sistema de Boletos";
        $dadosboleto["cpf_cnpj"]                    = "";
        $dadosboleto["endereco"]                    = "Coloque o endereço da sua empresa aqui";
        $dadosboleto["cidade_uf"]                   = "Cidade / Estado";
        $dadosboleto["cedente"]                     = $_POST['nomeempresa'];

        $this->render('imprimir',
                array(
                    'dias_de_prazo_para_pagamento'  => $dias_de_prazo_para_pagamento,
                    'taxa_boleto'                   => 0,
                    'data_venc'                     => $data_venc,
                    'valor_cobrado'                 => 0,
                    'valor_boleto'                  => $valor_boleto,
                    'dadosboleto'                   => $dadosboleto,
                )
            );
    }

    public function actionListar() {

        $boleto = new Boleto;

        $retorno = $boleto->listarTitulos();

        //echo json_encode( $retorno );

        return $retorno;
        //var_dump($retorno);
    }

}
