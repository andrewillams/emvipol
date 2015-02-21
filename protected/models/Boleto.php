<?php

class Boleto extends CActiveRecord {

    public function listarTitulos() {
        
        

        # MS SQL Server and Sybase with PDO_DBLIB
        $db = new PDO("dblib:host=rn.emvipol.com.br:1435;dbname=TREINA", "acesso", "@ccess");

        //          $db = new PDO("dblib:host=10.0.254.8:1433;dbname=GMM;charset=utf8", "sa", "Grup0M@r3SA");

        $query = "SELECT TOP 10 E1_FILIAL  AS FILIAL,  E1_PREFIXO AS PREFIXO,    E1_NUM   AS NUMERO, E1_PARCELA AS PARCELA, E1_TIPO   AS TIPO, ";
        $query .= "E1_EMISSAO AS EMISSAO, E1_VENCREA AS VENCIMENTO, E1_VALOR AS VALOR,  E1_CLIENTE AS CLIENTE, E1_NOMCLI AS NOMECLIENTE ";
        $query .= "FROM SE1010 AS SE1 ";
        $query .= "WHERE SE1.D_E_L_E_T_ <> '*' ";
        $query .= "AND SE1.E1_TIPO NOT LIKE '%-%' ";
        $query .= "ORDER BY R_E_C_N_O_ DESC ";

        $sth = $db->prepare($query);

        $sth->execute();

        $retorno = $sth->fetchAll();

        foreach ($retorno as $r) {
            $retJSON[] = [
                'emissao' => $r['EMISSAO'],
                'vencimento' => $r['VENCIMENTO'],
                'valor' => $r['VALOR'],
                'chave' => $r['FILIAL'] . $r['PREFIXO'] . $r['NUMERO'] . $r['PARCELA'] . $r['TIPO'],
                'btn' => ''
            ];
        }

        return [
            "recordsTotal" => count($retorno),
            "recordsFiltered" => count($retorno),
            "data" => $retJSON];
    }

}
