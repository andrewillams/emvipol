<?php

class Boleto extends CActiveRecord {

    public function listarTitulos() {
        
        

        # MS SQL Server and Sybase with PDO_DBLIB
        $db = new PDO("dblib:host=187.60.78.18:1435;dbname=TREINA", "acesso", "@ccess");

        //          $db = new PDO("dblib:host=10.0.254.8:1433;dbname=GMM;charset=utf8", "sa", "Grup0M@r3SA");

        $query = "SELECT E1_FILIAL  AS FILIAL,  E1_PREFIXO AS PREFIXO,    E1_NUM   AS NUMERO, E1_PARCELA AS PARCELA, E1_TIPO   AS TIPO, ";
        $query .= "E1_EMISSAO AS EMISSAO, E1_VENCREA AS VENCIMENTO, E1_VALOR AS VALOR,  E1_CLIENTE AS CLIENTE, E1_NOMCLI AS NOMECLIENTE, ";
        $query .= "E1_SALDO AS SALDO, SE1.R_E_C_N_O_ AS REG, A1_END AS ENDERECO_CLIENTE, A1_MUN AS CIDADE_CLIENTE, A1_CEP AS CEP_CLIENTE, ";
        $query .= "A1_EST AS ESTADO_CLIENTE ";
        $query .= "FROM SE1010 AS SE1 ";
        $query .= "INNER JOIN SA1010 AS SA1 ON SA1.D_E_L_E_T_ = '' AND E1_CLIENTE = A1_COD AND E1_LOJA = A1_LOJA ";
        $query .= "WHERE SE1.D_E_L_E_T_ <> '*' ";
        $query .= "AND SE1.E1_TIPO NOT LIKE '%-%' ";
        $query .= "ORDER BY SE1.R_E_C_N_O_ DESC ";

        //

        $sth = $db->prepare($query);

        $sth->execute();

        $retorno = $sth->fetchAll();
        
        foreach ($retorno as $r) {
            $retJSON[]          = [
                'emissao'       => $r['EMISSAO'],
                'vencimento'    => $r['VENCIMENTO'],
                'valor'         => $r['VALOR'],
                'saldo'         => $r['SALDO'],
                'reg'           => $r['REG'],
                'nomecliente'   => $r['NOMECLIENTE'],
                'endcliente'    => $r['ENDERECO_CLIENTE'],
                'cidcliente'    => $r['CIDADE_CLIENTE'],
                'cepcliente'    => $r['CEP_CLIENTE'],
                'estcliente'    => $r['ESTADO_CLIENTE'],
                'chave'         => $r['FILIAL'] . $r['PREFIXO'] . $r['NUMERO'] . $r['PARCELA'] . $r['TIPO'],
                //'btn' => ''
            ];
        }

/*        return [
            "recordsTotal" => count($retorno),
            "recordsFiltered" => count($retorno),
            "data" => $retJSON];*/
        
        return $retJSON;
        
    }

}
