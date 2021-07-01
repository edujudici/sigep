<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <div class="content-wrapper">
                <section class="content-header">
                    <?php echo $pagetitle; ?>
                    <?php echo $breadcrumb; ?>
                </section>

                <section class="content">
                    <?php echo $dashboard_alert_file_install; ?>
                    <div class="row">
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-maroon"><i class="fa fa-legal"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">PLP Emitidas</span>
                                    <span class="info-box-number"> <?= isset($plp) ? $plp : '' ?> </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Etiquetas Emitidas</span>
                                    <span class="info-box-number"> <?= isset($etiquetas) ? $etiquetas : '' ?> </span>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-md-2 col-sm-6 col-xs-12 <?= isset($noadmin) ? $noadmin : '' ?>">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Usuarios Cadastrados</span>
                                    <span class="info-box-number"><?php echo $count_users; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12 <?= isset($noadmin) ? $noadmin : '' ?>">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-shield"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Grupos de Segurança</span>
                                    <span class="info-box-number"><?php echo $count_groups; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12 <?= isset($noadmin) ? $noadmin : '' ?>">
                            <div class="info-box">
                                <span class="info-box-icon bg-orange"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Custo do Mês</span>
                                    <span class="info-box-number"><?= number_format($this->db->select_sum('custo')->like("dt_emissao", date('m-Y'))->get('etiquetas')->row()->custo, 2); ?></span>
                                    <!-- ->where('user_id', $this->session->userdata('user_id')) -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12 <?= isset($noadmin) ? $noadmin : '' ?>">
                            <div class="info-box">
                                <span class="info-box-icon bg-pink"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Custo Total</span>
                                    <span class="info-box-number"><?= number_format($this->db->select_sum('custo')->get('etiquetas')->row()->custo, 2) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Resumo</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <div class="">
                                                <table class="table no-margin">
                                                  <thead>
                                                  <tr>
                                                    <th>ID</th>
                                                    <th>Serviço</th>
                                                    <th>Status</th>
                                                    <th>Origem</th>
                                                    <th>Destino</th>
                                                  </tr>
                                                  </thead>
                                                    <tbody>
                                                    <?php  foreach ($etiqueta as $k => $v): ?>
                                                    <tr>
                                                      <td><a target="_blank" href="<?= base_url().$v->caminho ?>" ><?= $v->codigo ?></a></td>
                                                      <td><?php switch ($v->servico) {
                                                        case '41068':
                                                          echo "PAC";
                                                          break;
                                                        case '40096':
                                                          echo "SEDEX";
                                                          break;
                                                        case '40215':
                                                          echo "SEDEX 10 Envelope";
                                                          break;
                                                        case '40886':
                                                          echo "SEDEX 10 Pacote";
                                                          break;
                                                        case '40878':
                                                          echo "SEDEX Hoje";
                                                          break;
                                                        } ?></td>
                                                      <td><span class="label label-<?php switch ($v->status) {  case '0': echo "default"; break; case '1': echo "success"; break; } ?>"><?php switch ($v->status) {  case '0': echo "EMITIDA"; break; case '1': echo "VINCULADA A PLP" ; break; } ?></span></td>
                                                      <td> <?= $v->cep.'|'.$v->cidade.'/'.$v->estado ?> </td>
                                                      <td> <?= $v->dest_cep.'|'.$v->dest_cidade.'/'.$v->dest_estado ?> </td>
                                                    </tr>
                                                    <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-center text-uppercase"><strong>Recursos</strong></p>
                                            <div class="progress-group">
                                                <span class="progress-text">Espaço em Disco</span>
                                                <span class="progress-number"><strong><?php echo byte_format($disk_usespace, 2); ?></strong>/<?php echo byte_format($disk_totalspace, 2); ?></span>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-aqua" role="progressbar" aria-valuenow="<?php echo $disk_usepercent; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $disk_usepercent; ?>%"></div>
                                                </div>
                                            </div>
                                            <div class="progress-group">
                                                <span class="progress-text">Memoria em uso</span>
                                                <span class="progress-number"><strong><?php echo byte_format($memory_usage, 2); ?></strong>/<?php echo byte_format($memory_peak_usage, 2); ?></span>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="<?php echo $memory_usepercent; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $memory_usepercent; ?>%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
