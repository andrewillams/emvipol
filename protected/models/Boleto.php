<?php


class Boleto extends CActiveRecord {
    
    public function listarTitulos()
    {
        echo 'eita';
/*
        $db = new PDO("dblib:host=187.60.78.18:1435;dbname=TREINA;charset=utf8", "acesso", "@cesso");
        
        $query  = "SELECT  E1_FILIAL  AS FILIAL,  E1_PREFIXO AS PREFIXO,    E1_NUM   AS NUMERO, E1_PARCELA AS PARCELA, E1_TIPO   AS TIPO, ";
        $query .= "E1_EMISSAO AS EMISSAO, E1_VENCREA AS VENCIMENTO, E1_VALOR AS VALOR,  E1_CLIENTE AS CLIENTE, E1_NOMCLI AS NOMECLIENTE ";
        $query .= "FROM SE1010 AS SE1 ";
        $query .= "WHERE SE1.D_E_L_E_T_ <> '*' ";
        $query .= "AND SE1.E1_TIPO NOT LIKE '%-%' ";
        $query .= "ORDER BY R_E_C_N_O_ DESC ";

        $sth = $db->prepare('EXEC AUDITORIANCC :filialDe, :filialAte, :dataDe, :dataAte');
        
        $sth->execute();
        
        $retorno = $sth->fetchAll();
        
        var_dump($retorno);*/
        
    }
}