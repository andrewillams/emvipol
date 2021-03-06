<?php

$codigobanco            = "341"                                             ;
$codigo_banco_com_dv    = geraCodigoBanco($codigobanco)                     ;
$nummoeda               = "9"                                               ;
$fator_vencimento       = fator_vencimento($dadosboleto["data_vencimento"]) ;

$valor      = formata_numero(               $dadosboleto["valor_boleto" ]           , 10    , 0 , "valor"   )   ; //valor tem 10 digitos, sem virgula
$agencia    = formata_numero(               $dadosboleto["agencia"      ]           , 04    , 0             )   ; //agencia � 4 digitos
$conta      = formata_numero(               $dadosboleto["conta"        ]           , 05    , 0             )   ; //conta � 5 digitos + 1 do dv
$conta_dv   = formata_numero(               $dadosboleto["conta_dv"     ]           , 01    , 0             )   ;
$carteira   =                               $dadosboleto["carteira"     ]                                   ; //carteira 175
$nnum       = formata_numero( substr(trim(  $dadosboleto["nosso_numero" ]   ),0,8)  , 08    , 0             )   ;//nosso_numero no maximo 8 digitos

/*
$parteH = modulo_10($agencia . $conta . $carteira . $nnum);
$parteK = modulo_10($agencia . $conta);

echo 'parteH';

var_dump($parteH);

echo '<br><br>';*/

$codigo_barras = $codigobanco . $nummoeda . $fator_vencimento . $valor . $carteira . $nnum . modulo_10($agencia . $conta . $carteira . $nnum) . $agencia . $conta . modulo_10($agencia . $conta) . '000';
//$codigo_barras = $codigobanco . $nummoeda . $fator_vencimento . $valor . $carteira . $nnum . $parteH . $agencia . $conta . $parteK . '000';


// 43 numeros para o calculo do digito verificador
$dv = digitoVerificador_barra($codigo_barras);
// Numero para o codigo de barras com 44 digitos
$linha = substr($codigo_barras, 0, 4) . $dv . substr($codigo_barras, 4, 43);

//$nossonumero = $carteira . '/' . $nnum . '-' . modulo_10($agencia . $conta . $carteira . $nnum);
$nossonumero =  $carteira . '/' . substr($dadosboleto["nosso_numero"],0,8) . '-' . substr($dadosboleto["nosso_numero"],8,1); 

$agencia_codigo = $agencia . " / " . $conta . "-" . modulo_10($agencia . $conta);
/*
echo 'codBanco: ' . $codigobanco        . '<br>';
echo 'numMoeda: ' . $nummoeda           . '<br>';
echo 'digVerif: ' . $dv                 . '<br>';
echo 'fatVenci: ' . $fator_vencimento   . '<br>';
echo 'Valor   : ' . $valor              . '<br>';
echo 'Carteira: ' . $carteira           . '<br>';
echo 'nossoNum: ' . $nnum               . '<br>';
echo 'Parte H : ' . $parteH             . '<br>';
echo 'Agencia : ' . $agencia            . '<br>';
echo 'Conta   : ' . $conta              . '<br>';
echo 'Parte K : ' . $parteK             . '<br>';*/

$dadosboleto["codigo_barras"        ] = $linha                          ;
$dadosboleto["linha_digitavel"      ] = monta_linha_digitavel($linha)   ; // verificar
$dadosboleto["agencia_codigo"       ] = $agencia_codigo                 ;
$dadosboleto["nosso_numero"         ] = $nossonumero                    ;
$dadosboleto["codigo_banco_com_dv"  ] = $codigo_banco_com_dv            ;

// FUN��ES
// Algumas foram retiradas do Projeto PhpBoleto e modificadas para atender as particularidades de cada banco

function digitoVerificador_barra($numero) {
    $resto2 = modulo_11($numero, 9, 1);
    $digito = 11 - $resto2;
    if ($digito == 0 || $digito == 1 || $digito == 10 || $digito == 11) {
        $dv = 1;
    } else {
        $dv = $digito;
    }
    return $dv;
}

function formata_numero($numero, $loop, $insert, $tipo = "geral") {
    
    if ($tipo == "geral") {
        $numero = str_replace(",", "", $numero);
        
/*        if (strlen($numero) > $loop)
        {
            $numero = substr($numero, (strlen($numero) - 8), 8);
        } else {*/
            
            while (strlen($numero) < $loop) {
                $numero = $insert . $numero;
            }
//        }
    }
    
    if ($tipo == "valor") {
        /*
          retira as virgulas
          formata o numero
          preenche com zeros
         */
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    
    if ($tipo == "convenio") {
        while (strlen($numero) < $loop) {
            $numero = $numero . $insert;
        }
    }
    
    return $numero;
    
}

function fbarcode($valor) {

    $fino = 1;
    $largo = 3;
    $altura = 50;

    $barcodes[0] = "00110";
    $barcodes[1] = "10001";
    $barcodes[2] = "01001";
    $barcodes[3] = "11000";
    $barcodes[4] = "00101";
    $barcodes[5] = "10100";
    $barcodes[6] = "01100";
    $barcodes[7] = "00011";
    $barcodes[8] = "10010";
    $barcodes[9] = "01010";
    for ($f1 = 9; $f1 >= 0; $f1--) {
        for ($f2 = 9; $f2 >= 0; $f2--) {
            $f = ($f1 * 10) + $f2;
            $texto = "";
            for ($i = 1; $i < 6; $i++) {
                $texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
            }
            $barcodes[$f] = $texto;
        }
    }


//Desenho da barra
//Guarda inicial
    ?><img src=../images/p.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img 
        src=../images/b.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img 
        src=../images/p.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img 
        src=../images/b.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img 
    <?php
    $texto = $valor;
    if ((strlen($texto) % 2) <> 0) {
        $texto = "0" . $texto;
    }

// Draw dos dados
    while (strlen($texto) > 0) {
        $i = round(esquerda($texto, 2));
        $texto = direita($texto, strlen($texto) - 2);
        $f = $barcodes[$i];
        for ($i = 1; $i < 11; $i+=2) {
            if (substr($f, ($i - 1), 1) == "0") {
                $f1 = $fino;
            } else {
                $f1 = $largo;
            }
            ?>
                src=../images/p.png width=<?php echo $f1 ?> height=<?php echo $altura ?> border=0><img 
                <?php
                if (substr($f, $i, 1) == "0") {
                    $f2 = $fino;
                } else {
                    $f2 = $largo;
                }
                ?>
                src=../images/b.png width=<?php echo $f2 ?> height=<?php echo $altura ?> border=0><img 
                <?php
            }
        }

// Draw guarda final
        ?>
        src=../images/p.png width=<?php echo $largo ?> height=<?php echo $altura ?> border=0><img 
        src=../images/b.png width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img 
        src=../images/p.png width=<?php echo 1 ?> height=<?php echo $altura ?> border=0> 
        <?php
    }

//Fim da fun��o

    function esquerda($entra, $comp) {
        return substr($entra, 0, $comp);
    }

    function direita($entra, $comp) {
        return substr($entra, strlen($entra) - $comp, $comp);
    }

    function fator_vencimento($data) {
        $data = explode("/", $data);
        
        $ano = $data[2];
        $mes = $data[1];
        $dia = $data[0];
        return(abs((_dateToDays("1997", "10", "07")) - (_dateToDays($ano, $mes, $dia))));
    }

    function _dateToDays($year, $month, $day) {
        $century = substr($year, 0, 2);
        $year = substr($year, 2, 2);
        if ($month > 2) {
            $month -= 3;
        } else {
            $month += 9;
            if ($year) {
                $year--;
            } else {
                $year = 99;
                $century --;
            }
        }
        return ( floor(( 146097 * $century) / 4) +
                floor(( 1461 * $year) / 4) +
                floor(( 153 * $month + 2) / 5) +
                $day + 1721119);
    }

    function modulo_10($num) {
        $numtotal10 = 0;
        $fator = 2;

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo (falor 10)
            // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Ita�
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;
            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
                $temp0+=$v;
            }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }

        // v�rias linhas removidas, vide fun��o original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }

        return $digito;
    }

    function modulo_11($num, $base = 9, $r = 0) {
        /**
         *   Autor:
         *           Pablo Costa <pablo@users.sourceforge.net>
         *
         *   Fun��o:
         *    Calculo do Modulo 11 para geracao do digito verificador 
         *    de boletos bancarios conforme documentos obtidos 
         *    da Febraban - www.febraban.org.br 
         *
         *   Entrada:
         *     $num: string num�rica para a qual se deseja calcularo digito verificador;
         *     $base: valor maximo de multiplicacao [2-$base]
         *     $r: quando especificado um devolve somente o resto
         *
         *   Sa�da:
         *     Retorna o Digito verificador.
         *
         *   Observa��es:
         *     - Script desenvolvido sem nenhum reaproveitamento de c�digo pr� existente.
         *     - Assume-se que a verifica��o do formato das vari�veis de entrada � feita antes da execu��o deste script.
         */
        $soma = 0;
        $fator = 2;

        /* Separacao dos numeros */
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo falor
            $parcial[$i] = $numeros[$i] * $fator;
            // Soma dos digitos
            $soma += $parcial[$i];
            if ($fator == $base) {
                // restaura fator de multiplicacao para 2 
                $fator = 1;
            }
            $fator++;
        }

        /* Calculo do modulo 11 */
        if ($r == 0) {
            $soma *= 10;
            $digito = $soma % 11;
            if ($digito == 10) {
                $digito = 0;
            }
            return $digito;
        } elseif ($r == 1) {
            $resto = $soma % 11;
            return $resto;
        }
    }

// Alterada por Glauber Portella para especifica��o do Ita�
    function monta_linha_digitavel($codigo) {
        
        
/*
 *  codBanco: 341           //a
    numMoeda: 9             //b
    digVerif: 1             //c
    fatVenci: 6455          //d
    Valor   : 0000021850    //e
    Carteira: 109           //f
    nossoNum: 000666007     //g
    Parte H : 6             //h
    Agencia : 7123          //i
    Conta   : 11075         //j
    Parte K : 6             //k
 *                    1          2           3            4          5
 *      012 3 4 5678 9012345678 901 23456789 0 1234 56789 0 1234567890
 *       a  b c   d       e      f      g     h   i    j   k
 *      341 9 1 6455 0000021850 109 000666007 6 7123 11075 6 000 (errado)
 *      341 9 3 6455 0000021850 109 00066600 7 7123 11075 6 000  (certo )
 * 
 *      34191.09008 06660.077121 31107.560000 3 64550000021850 (protheus)
 *      34191.09008 06660.077121 31107.560000 3 64550000021850 (certo   )
 *      34191.09008 06660.767124 31107.560000 1 64550000021850 (errado  )
 * 
 * ===========================================================================================
 * 
 *  codBanco: 341           //a
    numMoeda: 9             //b
    digVerif: 9             //c
    fatVenci: 6460          //d
    Valor   : 0000014402    //e
    Carteira: 109           //f
    nossoNum: 00066686      //g
    Parte H : 6             //h
    Agencia : 7123          //i
    Conta   : 11075         //j
    Parte K : 6             //k
 * 
 *                    1          2           3            4          5
 *      012 3 4 5678 9012345678 901 23456789 0 1234 56789 0 1234567890
 *       a  b c   d       e      f      g    h   i    j   k
 *      341 9 9 6460 0000014402 109 00066686 6 7123 11075 6 000
 *      341 9   6458 0000014402 109 00066686 6 7123 11075 6 000
 * 
 *      34191.09008 06668.667121 31107.560000 8 64600000014402 (PROTHEUS)
 *      34191.09008 06668.667121 31107.560000 9 64600000014402 (errado  )
 * 0666866712
 **/
        
//        echo 'codigo: ' . $codigo;
        
        // campo 1
        $banco      = substr($codigo, 00, 3);
        $moeda      = substr($codigo, 03, 1);
        $ccc        = substr($codigo, 19, 3);
        $ddnnum     = substr($codigo, 22, 2);
        $dv1        = modulo_10($banco . $moeda . $ccc . $ddnnum);
        
        // campo 2
        $resnnum    = substr($codigo, 24, 6);
        $dac1       = substr($codigo, 30, 1); //modulo_10($agencia.$conta.$carteira.$nnum);
        $dddag      = substr($codigo, 31, 3);
        $dv2        = modulo_10($resnnum . $dac1 . $dddag);
        
        // campo 3
        $resag      = substr($codigo, 34, 1);
        $contadac   = substr($codigo, 35, 6); //substr($codigo,35,5).modulo_10(substr($codigo,35,5));
        $zeros      = substr($codigo, 41, 3);
        $dv3        = modulo_10($resag . $contadac . $zeros);
        
        // campo 4
        $dv4        = substr($codigo, 4, 1);
        
        // campo 5
        $fator      = substr($codigo, 5, 4);
        $valor      = substr($codigo, 9, 10);
        
        $campo1 =   substr($banco       . $moeda    . $ccc   . $ddnnum . $dv1   , 0, 5) . '.' . 
                    substr($banco       . $moeda    . $ccc   . $ddnnum . $dv1   , 5, 5)         ;
        
                         //066600           7          712
        $campo2 =   substr($resnnum     . $dac1     . $dddag . $dv2             , 0, 5) . '.' . 
                    substr($resnnum     . $dac1     . $dddag . $dv2             , 5, 6)         ;
        
        $campo3 =   substr($resag       . $contadac . $zeros . $dv3             , 0, 5) . '.' . 
                    substr($resag       . $contadac . $zeros . $dv3             , 5, 6)         ;
        
        $campo4 =   $dv4                                                                        ;
        $campo5 =   $fator . $valor                                                             ;

        return "$campo1 $campo2 $campo3 $campo4 $campo5";
    }

    function geraCodigoBanco($numero) {
        $parte1 = substr($numero, 0, 3);
        $parte2 = modulo_11($parte1);
        return $parte1 . "-" . $parte2;
    }
?>