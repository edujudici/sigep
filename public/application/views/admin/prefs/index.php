<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


            <div class="content-wrapper">
                <section class="content-header">
                    <?php echo $pagetitle; ?>
                    <?php echo $breadcrumb; ?>
                </section>

                <section class="content">
                    <div class="row">

                      <div class="col-md-6 hidden">
                        <div class="box box-info">
                            <div class="box-header with-border">
                              <h3 class="box-title">Dados Atuais</h3>
                            </div>                            
                            <div class="box-body">
                              <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <tbody>                                        
                                            <tr>
                                                <th><strong>AMBIENTE</strong></th>
                                                <td><?= $perf->ambiente ? '<span class="label label-success"> PRODUÇÃO </span>' : '<span class="label label-danger"> HOMOLOGAÇÃO </span>'; ?></td>
                                            </tr>
                                            <tr>
                                                <th>USUARIO</th>
                                                <td><?php echo $perf->usuario; ?></td>
                                            </tr>
                                            <tr>
                                                <th>SENHA</th>
                                                <td><?php echo htmlspecialchars($perf->senha, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>NUMERO CONTRATO</th>
                                                <td><?php echo htmlspecialchars($perf->numeroContrato, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>CARTÃO POSTAGEM</th>
                                                <td><?php echo htmlspecialchars($perf->codAdministrativo, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>COD ADMINISTRATIVO</th>
                                                <td><?php echo htmlspecialchars($perf->codAdministrativo, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>CNPJ</th>
                                                <td><?php echo htmlspecialchars($perf->cnpjEmpresa, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>ANO DO CONTRATO</th>
                                                <td><?php echo $perf->anoContrato; ?></td>
                                            </tr>
                                            <tr>
                                                <th>DIRETORIA</th>
                                                <td><?php echo $perf->diretoria; ?></td>
                                            </tr>
                                            <tr>
                                                <th>ULTIMA ATUALIZAÇÃO</th>
                                                <td><?php echo date('d-m-Y', $perf->ultimo_update); ?></td>
                                            </tr>

                                                
                                        </tbody>
                                    </table>
                              </div>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-md-offset-3">
                        <div class="box box-info">
                            <div class="box-header with-border">
                              <h3 class="box-title">Atualizar </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <div class="table-responsive">
                                <form action="<?= site_url('admin/contrato/up_dados/') ?>" method="post">
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                            <tr>
                                                <th><strong>AMBIENTE</strong></th>
                                                <td>
                                                    <select name="ambiente" class="form-control " id="ambiente">
                                                        <option value="1">produção</option>
                                                        <option value="0">homologação</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>USUARIO</th>
                                                <td><input type="text" name="usuario" value="<?= $perf->usuario ?>" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th>SENHA</th>
                                                <td><input type="text" name="senha" value="<?= $perf->senha ?>" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th>NUMERO CONTRATO</th>
                                                <td><input type="text" name="numeroContrato" value="<?= $perf->numeroContrato ?>" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th>CARTÃO POSTAGEM</th>
                                                <td><input type="text" name="cartaoPostagem" value="<?= $perf->cartaoPostagem ?>" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th>CODIGO ADMINISTRATIVO</th>
                                                <td><input type="text" name="codAdministrativo" value="<?= $perf->codAdministrativo ?>" class="form-control"></td>
                                            </tr>                                            
                                            <tr>
                                                <th>CNPJ</th>
                                                <td><input type="text" name="cnpjEmpresa" value="<?= $perf->cnpjEmpresa ?>" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th>ANO DO CONTRATO</th>
                                                <td><input type="text" name="anoContrato" value="<?= $perf->anoContrato ?>" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th>DIRETORIA</th>
                                                <td>
                                                    <select name="diretoria" class="form-control" id="diretoria">
                                                        <option value="1">DIRETORIA_AC_ADMINISTRACAO_CENTRAL</option>
                                                        <option value="3">DIRETORIA_DR_ACRE</option>
                                                        <option value="4">DIRETORIA_DR_ALAGOAS</option>
                                                        <option value="6">DIRETORIA_DR_AMAZONAS</option>
                                                        <option value="5">DIRETORIA_DR_AMAPA</option>
                                                        <option value="8">DIRETORIA_DR_BAHIA</option>
                                                        <option value="10">DIRETORIA_DR_BRASILIA</option>
                                                        <option value="12">DIRETORIA_DR_CEARA</option>
                                                        <option value="14">DIRETORIA_DR_ESPIRITO_SANTO</option>
                                                        <option value="16">DIRETORIA_DR_GOIAS</option>
                                                        <option value="18">DIRETORIA_DR_MARANHAO</option>
                                                        <option value="20">DIRETORIA_DR_MINAS_GERAIS</option>
                                                        <option value="22">DIRETORIA_DR_MATO_GROSSO_DO_SUL</option>
                                                        <option value="24">DIRETORIA_DR_MATO_GROSSO</option>
                                                        <option value="28">DIRETORIA_DR_PARA</option>
                                                        <option value="30">DIRETORIA_DR_PARAIBA</option>
                                                        <option value="32">DIRETORIA_DR_PERNAMBUCO</option>
                                                        <option value="34">DIRETORIA_DR_PIAUI</option>
                                                        <option value="36">DIRETORIA_DR_PARANA</option>
                                                        <option value="50">DIRETORIA_DR_RIO_DE_JANEIRO</option>
                                                        <option value="60">DIRETORIA_DR_RIO_GRANDE_DO_NORTE</option>
                                                        <option value="26">DIRETORIA_DR_RONDONIA</option>
                                                        <option value="65">DIRETORIA_DR_RORAIMA</option>                                               
                                                        <option value="64">DIRETORIA_DR_RIO_GRANDE_DO_SUL</option>
                                                        <option value="68">DIRETORIA_DR_SANTA_CATARINA</option>
                                                        <option value="70">DIRETORIA_DR_SERGIPE</option>
                                                        <option value="74">DIRETORIA_DR_SAO_PAULO_INTERIOR</option>
                                                        <option value="72">DIRETORIA_DR_SAO_PAULO</option>
                                                        <option value="75">DIRETORIA_DR_TOCANTINS</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                    <div class="col-md-12">
                                        
                                        <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary pull-right', 'content' => lang('actions_submit'))); ?>
                                        <?php echo anchor('admin/dashboard/', lang('actions_cancel'), array('class' => 'btn btn-danger pull-left ')); ?>
                                        
                                    </div>                                
                                </form>
                              </div>
                            </div>
                          </div>
                       </div> 
                    </div>
                </section>
            </div>
            <script type="text/javascript">
                document.getElementById('ambiente').value = "<?= $perf->ambiente ?>";
                document.getElementById('diretoria').value = "<?= $perf->diretoria ?>";
            </script>