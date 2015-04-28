<?php

class Boleto extends CActiveRecord {

    public function listarTitulos() {
        
        $CGC    = NULL;

        # MS SQL Server and Sybase with PDO_DBLIB
        $db     = new PDO("dblib:host=187.60.78.18:1435;dbname=TREINA", "acesso", "@ccess");

        if( isset( $_POST['CGC'] ) )
        {
            $CGC    = $_POST['CGC'];
        }

        //          $db = new PDO("dblib:host=10.0.254.8:1433;dbname=GMM;charset=utf8", "sa", "Grup0M@r3SA");

        $query  = "SELECT TOP 1000 * FROM ( ";
        $query .= "SELECT E1_NUMBCO AS NOSSONUMERO, E1_FILIAL  AS FILIAL,  E1_PREFIXO AS PREFIXO,    E1_NUM   AS NUMERO, E1_PARCELA AS PARCELA, E1_TIPO   AS TIPO, ";
        $query .= "E1_EMISSAO AS EMISSAO, E1_VENCREA AS VENCIMENTO, E1_VALOR AS VALOR,  E1_CLIENTE AS CLIENTE, A1_LOJA AS LOJACLIENTE, E1_NOMCLI AS NOMECLIENTE, ";
        $query .= "E1_SALDO AS SALDO, SE12.R_E_C_N_O_ AS REG, A1_END AS ENDERECO_CLIENTE, A1_MUN AS CIDADE_CLIENTE, A1_CEP AS CEP_CLIENTE, ";
        $query .= "A1_EST AS ESTADO_CLIENTE, A1_CGC AS CGC ";
        $query .= "FROM SE1200 AS SE12 ";
        $query .= "INNER JOIN SA1200 AS SA1 ON SA1.D_E_L_E_T_ = '' AND SE12.E1_CLIENTE = A1_COD AND SE12.E1_LOJA = A1_LOJA ";
        $query .= "WHERE SE12.D_E_L_E_T_ <> '*' AND E1_PREFIXO = 'R' AND E1_TIPO = 'NF' AND E1_FILIAL = '01' AND E1_SALDO > 0";
        
        if( $CGC != NULL )
        {
            $query .= " AND CGC = " . $CGC . " ";
        }
        
        $query .= "UNION ";

        $query .= "SELECT E1_NUMBCO AS NOSSONUMERO, E1_FILIAL  AS FILIAL,  E1_PREFIXO AS PREFIXO,    E1_NUM   AS NUMERO, E1_PARCELA AS PARCELA, E1_TIPO   AS TIPO, ";
        $query .= "E1_EMISSAO AS EMISSAO, E1_VENCREA AS VENCIMENTO, E1_VALOR AS VALOR,  E1_CLIENTE AS CLIENTE, A1_LOJA AS LOJACLIENTE, E1_NOMCLI AS NOMECLIENTE, ";
        $query .= "E1_SALDO AS SALDO, SE11.R_E_C_N_O_ AS REG, A1_END AS ENDERECO_CLIENTE, A1_MUN AS CIDADE_CLIENTE, A1_CEP AS CEP_CLIENTE, ";
        $query .= "A1_EST AS ESTADO_CLIENTE, A1_CGC AS CGC ";
        $query .= "FROM SE1100 AS SE11 ";
        $query .= "INNER JOIN SA1100 AS SA1 ON SA1.D_E_L_E_T_ = '' AND E1_CLIENTE = A1_COD AND E1_LOJA = A1_LOJA ";
        $query .= "WHERE SE11.D_E_L_E_T_ <> '*' AND E1_PREFIXO = 'R' AND E1_TIPO = 'NF' AND E1_FILIAL = '01' AND E1_SALDO > 0 ";
        
        if( $CGC != NULL )
        {
            $query .= " AND CGC = " . $CGC . " ";
        }

        $query .= ") ";
        $query .= "AS SE1 ";
        
        $query .= "ORDER BY REG DESC ";

        //

        $sth = $db->prepare($query);

        $sth->execute();

        $retorno = $sth->fetchAll();
        
        foreach ($retorno as $r) {
            
            $vencimento = date("d/m/Y"  , strtotime(    $r['VENCIMENTO' ]   )   );
            $emissao    = date("d/m/Y"  , strtotime(    $r['EMISSAO'    ]   )   );
            
            $retJSON[]          = [
                'emissao'       => $emissao,
                'vencimento'    => $vencimento,
                'valor'         => $r['VALOR'],
                'saldo'         => $r['SALDO'],
                'reg'           => $r['REG'],
                'nomecliente'   => $r['NOMECLIENTE'],
                'endcliente'    => $r['ENDERECO_CLIENTE'],
                'cidcliente'    => $r['CIDADE_CLIENTE'],
                'cepcliente'    => $r['CEP_CLIENTE'],
                'estcliente'    => $r['ESTADO_CLIENTE'],
                'chave'         => $r['FILIAL'] . $r['PREFIXO'] . $r['NUMERO'] . $r['PARCELA'] . $r['TIPO'],
                'nossonumero'   => $r['NOSSONUMERO']
            ];
        }

        /*return [
            "recordsTotal" => count($retorno),
            "recordsFiltered" => count($retorno),
            "data" => $retJSON
        ];*/
        
        return $retJSON;
        
    }
}
