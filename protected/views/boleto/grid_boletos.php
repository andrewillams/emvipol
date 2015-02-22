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
                            <td><?php echo $dados[$cnt]['emissao']?></td>
                            <td><?php echo $dados[$cnt]['vencimento']?></td>
                            <td><?php echo $dados[$cnt]['valor']?></td>
                            <td class="no-orderable"><?php echo $dados[$cnt]['chave']?></td>
                            
                            <td>
                                <?php if($dados[$cnt]['saldo'] > 0) { ?>

                                    <form method="post" 
                                          action=" <?php echo Yii::app()->getBaseUrl(true) . '/boleto/imprimir'; ?>">
                                        
                                        <button style="height: 20px; width: 50px">Boleto</button>
                                        <input type="hidden" 
                                               name="regSE1" 
                                               value="<?php echo $dados[$cnt]['reg'] ?>">
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