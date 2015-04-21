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
                            <td><?php echo substr($dados[$cnt]['emissao'], 6, 2) . '/'. substr($dados[$cnt]['emissao'], 4, 2) . '/' . substr($dados[$cnt]['emissao'], 0, 4); ?></td>
                            <td><?php echo substr($dados[$cnt]['vencimento'], 6, 2) . '/'. substr($dados[$cnt]['vencimento'], 4, 2) . '/' . substr($dados[$cnt]['vencimento'], 0, 4); ?></td>
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

                                        <input type="hidden" name="nomecliente" value="<?= $dados[$cnt]['nomecliente']?>">
                                        <input type="hidden" name="endcliente" value="<?= $dados[$cnt]['endcliente']?>">
                                        <input type="hidden" name="cepcliente" value="<?= $dados[$cnt]['cepcliente']?>">
                                        <input type="hidden" name="cidcliente" value="<?= $dados[$cnt]['cidcliente']?>">
                                        <input type="hidden" name="estcliente" value="<?= $dados[$cnt]['estcliente']?>">
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