<?php

class Boleto extends CActiveRecord {

    public function listarTitulos() {

        $CGC = NULL;

        $retJSON = [];

        # MS SQL Server and Sybase with PDO_DBLIB
        $db = new PDO("dblib:host=187.60.78.18:1435;dbname=EMVIPOL", "acesso", "@ccess");

        if (isset($_POST['cgc'])) {
            
            $CGC = trim($_POST['cgc']);

            //          $db = new PDO("dblib:host=10.0.254.8:1433;dbname=GMM;charset=utf8", "sa", "Grup0M@r3SA");
            //AAAAMMDD

            $query = "SELECT * FROM ( ";

            $query .= "SELECT   'NATAL TECNOLOGIA E SEGURANÇA LTDA'                                 AS EMPRESA          , "
//                . "         LEFT(SE12.E1_NUMBCO,8)                                              AS NOSSONUMERO      , "
                    . "         LTRIM(RTRIM(SE12.E1_NUMBCO))                                        AS NOSSONUMERO      , "
                    . "         SE12.E1_FILIAL                                                      AS FILIAL           , "
                    . "         SE12.E1_PREFIXO                                                     AS PREFIXO          , "
                    . "         SE12.E1_NUM                                                         AS NUMERO           , "
                    . "         SE12.E1_PARCELA                                                     AS PARCELA          , "
                    . "         SE12.E1_TIPO                                                        AS TIPO             , "
                    . "         SE12.E1_EMISSAO                                                     AS EMISSAO          , "
                    . "         SE12.E1_VALJUR                                                      AS JUROMORA         , "
                    . "         CASE                                                                                      "
                    . "             WHEN SE12.E1_DTULTNG <> ''  THEN SE12.E1_DTULTNG                                      "
                    . "                                         ELSE SE12.E1_VENCTO  END            AS VENCIMENTO       , "
                    . "         ((SE12.E1_VALOR - SUM(ISNULL(SE1i.E1_VALOR,0))) + SE12.E1_ACRESC)   AS VALOR            , "
                    . "         SE12.E1_CLIENTE                                                     AS CLIENTE          , "
                    . "         A1_LOJA                                                             AS LOJACLIENTE      , "
                    . "         RTRIM(A1_NOME) + ' (' + A1_NREDUZ + ')'                             AS NOMECLIENTE      , "
                    . "         SE12.E1_SALDO                                                       AS SALDO            , "
                    . "         SE12.R_E_C_N_O_                                                     AS REG              , "
                    . "         A1_END                                                              AS ENDERECO_CLIENTE , "
                    . "         A1_MUN                                                              AS CIDADE_CLIENTE   , "
                    . "         A1_CEP                                                              AS CEP_CLIENTE      , "
                    . "         A1_EST                                                              AS ESTADO_CLIENTE   , "
                    . "         A1_CGC                                                              AS CGC              , "
                    . "         EE_AGENCIA                                                          AS AGENCIA          , "
                    . "         LTRIM(RTRIM(EE_CONTA))                                              AS CONTA              "
                    . "FROM                     SE1200 AS SE12 "
                    . "LEFT     OUTER   JOIN    SE1200 AS SE1i ON   SE1i.D_E_L_E_T_ =       ''              AND "
                    . "                                             SE12.E1_FILIAL  =       SE1i.E1_FILIAL  AND "
                    . "                                             SE12.E1_PREFIXO =       SE1i.E1_PREFIXO AND "
                    . "                                             SE12.E1_NUM     =       SE1i.E1_NUM     AND "
                    . "                                             SE12.E1_PARCELA =       SE1i.E1_PARCELA AND "
                    . "                                             SE1i.E1_TIPO    LIKE    '%-%'               "
                    . "INNER            JOIN    SA1200 AS SA1  ON   SA1.D_E_L_E_T_  =       ''              AND "
                    . "                                             SE12.E1_FILIAL  =       A1_FILIAL       AND "
                    . "                                             SE12.E1_CLIENTE =       A1_COD          AND "
                    . "                                             SE12.E1_LOJA    =       A1_LOJA             "
                    . "INNER            JOIN    SEE200 AS SEE  ON   SEE.D_E_L_E_T_  =       ''              AND "
                    . "                                             EE_CODIGO       =       '341'           AND "
                    . "                                             EE_CARTEIR      =       '109'           AND "
                    . "                                             SE12.E1_FILIAL  =       EE_FILIAL           "
                    . "WHERE                                        SE12.D_E_L_E_T_ <>      '*'             AND "
                    . "                                             SE12.E1_PREFIXO =       'R'             AND "
                    . "                                             SE12.E1_TIPO    =       'NF'            AND "
                    . "                                             SE12.E1_FILIAL  =       '01'            AND "
                    . "                                             SE12.E1_SALDO   =       SE12.E1_VALOR   AND "
                    . "                                             SE12.E1_NUMBCO  !=      ''                  ";

            $query .= "GROUP BY SE12.E1_NUMBCO                      , "
                    . "         SE12.E1_FILIAL                      , "
                    . "         SE12.E1_PREFIXO                     , "
                    . "         SE12.E1_NUM                         , "
                    . "         SE12.E1_PARCELA                     , "
                    . "         SE12.E1_TIPO                        , "
                    . "         SE12.E1_EMISSAO                     , "
                    . "         SE12.E1_VALJUR                      , "
                    . "         SE12.E1_VENCTO                      , "
                    . "         SE12.E1_DTULTNG                     , "
                    . "         SE12.E1_CLIENTE                     , "
                    . "         A1_LOJA                             , "
                    . "         A1_NOME                             , "
                    . "         A1_NREDUZ                           , "
                    . "         SE12.E1_VALOR                       , "
                    . "         SE12.E1_SALDO                       , "
                    . "         SE12.E1_ACRESC                      , "
                    . "         SE12.R_E_C_N_O_                     , "
                    . "         A1_END                              , "
                    . "         A1_MUN                              , "
                    . "         A1_CEP                              , "
                    . "         A1_EST                              , "
                    . "         A1_CGC                              , "
                    . "         EE_AGENCIA                          , "
                    . "         EE_CONTA                              ";

            $query .= "UNION ";

            $query .= "SELECT   'EMPRESA DE VIGILÂNCIA POTIGUAR'                                    AS EMPRESA          , "
                    . "         LTRIM(RTRIM(SE11.E1_NUMBCO))                                        AS NOSSONUMERO      , "
                    . "         SE11.E1_FILIAL                                                      AS FILIAL           , "
                    . "         SE11.E1_PREFIXO                                                     AS PREFIXO          , "
                    . "         SE11.E1_NUM                                                         AS NUMERO           , "
                    . "         SE11.E1_PARCELA                                                     AS PARCELA          , "
                    . "         SE11.E1_TIPO                                                        AS TIPO             , "
                    . "         SE11.E1_EMISSAO                                                     AS EMISSAO          , "
                    . "         SE11.E1_VALJUR                                                      AS JUROMORA         , "
                    . "         CASE                                                                                      "
                    . "             WHEN SE11.E1_DTULTNG <> ''  THEN SE11.E1_DTULTNG                                      "
                    . "                                         ELSE SE11.E1_VENCTO  END            AS VENCIMENTO       , "
                    . "         ((SE11.E1_VALOR - SUM(ISNULL(SE1i.E1_VALOR,0))) + SE11.E1_ACRESC)   AS VALOR            , "
                    . "         SE11.E1_CLIENTE                                                     AS CLIENTE          , "
                    . "         A1_LOJA                                                             AS LOJACLIENTE      , "
                    . "         RTRIM(A1_NOME) + ' (' + A1_NREDUZ + ')'                             AS NOMECLIENTE      , "
                    . "         SE11.E1_SALDO                                                       AS SALDO            , "
                    . "         SE11.R_E_C_N_O_                                                     AS REG              , "
                    . "         A1_END                                                              AS ENDERECO_CLIENTE , "
                    . "         A1_MUN                                                              AS CIDADE_CLIENTE   , "
                    . "         A1_CEP                                                              AS CEP_CLIENTE      , "
                    . "         A1_EST                                                              AS ESTADO_CLIENTE   , "
                    . "         A1_CGC                                                              AS CGC              , "
                    . "         EE_AGENCIA                                                          AS AGENCIA          , "
                    . "         LTRIM(RTRIM(EE_CONTA))                                              AS CONTA              "
                    . "FROM                     SE1100 AS SE11 "
                    . "LEFT     OUTER   JOIN    SE1100 AS SE1i ON   SE1i.D_E_L_E_T_ =       ''              AND "
                    . "                                             SE11.E1_FILIAL  =       SE1i.E1_FILIAL  AND "
                    . "                                             SE11.E1_PREFIXO =       SE1i.E1_PREFIXO AND "
                    . "                                             SE11.E1_NUM     =       SE1i.E1_NUM     AND "
                    . "                                             SE11.E1_PARCELA =       SE1i.E1_PARCELA AND "
                    . "                                             SE1i.E1_TIPO    LIKE    '%-%'               "
                    . "INNER            JOIN    SA1100 AS SA1  ON   SA1.D_E_L_E_T_  =       ''              AND "
                    . "                                             SE11.E1_FILIAL  =       A1_FILIAL       AND "
                    . "                                             SE11.E1_CLIENTE =       A1_COD          AND "
                    . "                                             SE11.E1_LOJA    =       A1_LOJA             "
                    . "INNER            JOIN    SEE100 AS SEE  ON   SEE.D_E_L_E_T_  =       ''              AND "
                    . "                                             EE_CODIGO       =       '341'           AND "
                    . "                                             EE_CARTEIR      =       '109'           AND "
                    . "                                             SE11.E1_FILIAL  =       EE_FILIAL           "
                    . "WHERE                                        SE11.D_E_L_E_T_ <>      '*'             AND "
                    . "                                             SE11.E1_PREFIXO =       'R'             AND "
                    . "                                             SE11.E1_TIPO    =       'NF'            AND "
                    . "                                             SE11.E1_FILIAL  =       '01'            AND "
                    . "                                             SE11.E1_SALDO   =       SE11.E1_VALOR   AND "
                    . "                                             SE11.E1_NUMBCO  !=      ''                  ";
            
            $query .= "GROUP BY SE11.E1_NUMBCO                      , "
                    . "         SE11.E1_FILIAL                      , "
                    . "         SE11.E1_PREFIXO                     , "
                    . "         SE11.E1_NUM                         , "
                    . "         SE11.E1_PARCELA                     , "
                    . "         SE11.E1_TIPO                        , "
                    . "         SE11.E1_EMISSAO                     , "
                    . "         SE11.E1_VALJUR                      , "
                    . "         SE11.E1_VENCTO                      , "
                    . "         SE11.E1_DTULTNG                     , "
                    . "         SE11.E1_CLIENTE                     , "
                    . "         A1_LOJA                             , "
                    . "         A1_NOME                             , "
                    . "         A1_NREDUZ                           , "
                    . "         SE11.E1_VALOR                       , "
                    . "         SE11.E1_SALDO                       , "
                    . "         SE11.E1_ACRESC                      , "
                    . "         SE11.R_E_C_N_O_                     , "
                    . "         A1_END                              , "
                    . "         A1_MUN                              , "
                    . "         A1_CEP                              , "
                    . "         A1_EST                              , "
                    . "         A1_CGC                              , "
                    . "         EE_AGENCIA                          , "
                    . "         EE_CONTA                              ";

            $query .= ") "
                    . "AS SE1 "
                    . "WHERE VENCIMENTO  >= " . date('Ymd') . " AND CGC = '" . $CGC . "' ";

            //$query .= "ORDER BY REG DESC ";

            $sth = $db->prepare($query);

            $sth->execute();

            $retorno = $sth->fetchAll();

            foreach ($retorno as $r) {

                $vencimento = date("d/m/Y", strtotime($r['VENCIMENTO']));
                $emissao = date("d/m/Y", strtotime($r['EMISSAO']));

                $retJSON[] = [
                    'emissao' => $emissao,
                    'vencimento' => $vencimento,
                    'nomeempresa' => $r['EMPRESA'],
                    'valor' => $r['VALOR'],
                    'saldo' => $r['SALDO'],
                    'reg' => $r['REG'],
                    'nomecliente' => $r['NOMECLIENTE'],
                    'endcliente' => $r['ENDERECO_CLIENTE'],
                    'cidcliente' => $r['CIDADE_CLIENTE'],
                    'cepcliente' => $r['CEP_CLIENTE'],
                    'estcliente' => $r['ESTADO_CLIENTE'],
                    'mora' => $r['JUROMORA'],
                    'chave' => $r['FILIAL'] . $r['PREFIXO'] . $r['NUMERO'] . $r['PARCELA'] . $r['TIPO'],
                    'numeroDocumento' => $r['PREFIXO'] . '-' . $r['NUMERO'] . '-' . $r['PARCELA'],
                    'nossonumero' => $r['NOSSONUMERO'],
                    'agencia' => $r['AGENCIA'],
                    'conta' => $r['CONTA']
                ];
            }
        }

        /* return [
          "recordsTotal" => count($retorno),
          "recordsFiltered" => count($retorno),
          "data" => $retJSON
          ]; */

        return $retJSON;
    }

}
