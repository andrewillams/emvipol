<?php if (isset($dados) && $dados != NULL) { ?>
    <div class="row">
        <div class="col-sm-12">
            <table id="grid_boletos" class="table table-striped table-bordered table-hover table-full-width dataTable">
                <thead>
                    <tr>
                        <th>Emissão</th>
                        <th>Vencimento</th>
                        <th>Valor</th>
                        <th>Chave</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php for ($cnt = 0; $cnt < sizeof($dados); $cnt++) { ?>
                        <tr>
                            <td><?php echo $dados[$cnt]['emissao']; ?></td>
                            <td><?php echo $dados[$cnt]['vencimento']; ?></td>
                            <td><?php echo number_format($dados[$cnt]['valor'], 2, ',','.')?></td>
                            <td class="no-orderable"><?php echo $dados[$cnt]['chave']?></td>
                            
                            <td>
                                <?php if($dados[$cnt]['saldo'] > 0) { ?>

                                    <form method="post" 
                                          action=" <?php echo Yii::app()->getBaseUrl(true) . '/boleto/imprimir'; ?>">
                                        
                                        <button style="height: 20px; width: 50px">Boleto</button>
                                        <input type="hidden" 
                                               name="regSE1" 
                                               value="<?php echo $dados[$cnt]['reg'] ?>">

                                        <input type="hidden" name="nomecliente"     value="<?= $dados[$cnt]['nomecliente']?>">
                                        <input type="hidden" name="endcliente"      value="<?= $dados[$cnt]['endcliente']?>">
                                        <input type="hidden" name="cepcliente"      value="<?= $dados[$cnt]['cepcliente']?>">
                                        <input type="hidden" name="cidcliente"      value="<?= $dados[$cnt]['cidcliente']?>">
                                        <input type="hidden" name="estcliente"      value="<?= $dados[$cnt]['estcliente']?>">
                                        <input type="hidden" name="nossonumero"     value="<?= $dados[$cnt]['nossonumero']?>">
                                        <input type="hidden" name="conta"           value="<?= $dados[$cnt]['conta']?>">
                                        <input type="hidden" name="agencia"         value="<?= $dados[$cnt]['agencia']?>">
                                        <input type="hidden" name="numeroDocumento" value="<?= $dados[$cnt]['numeroDocumento']?>">
                                        <input type="hidden" name="valor"           value="<?= $dados[$cnt]['valor']?>">
                                        <input type="hidden" name="vencimento"      value="<?= $dados[$cnt]['vencimento']?>">
                                        <input type="hidden" name="emissao"         value="<?= $dados[$cnt]['emissao']?>">
                                        <input type="hidden" name="nomeempresa"     value="<?= $dados[$cnt]['nomeempresa']?>">
                                        <input type="hidden" name="jurosmora"       value="<?= number_format($dados[$cnt]['mora'], 2, ',', '.')?>">
                                    </form>
                                    
                                <?php } ?>
                                
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="searchable">Emissão</th>
                        <th class="searchable">Vencimento</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php } ?>