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
                        <div class="col-md-12">

                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Resumo</h3>
                                </div>
                                <div class="box-body">
                                  <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <input type="text" class="knob" value="<?= $this->db->like("dt_emissao", date('m-Y'))->where('user_id', $user_info[0]->id)->get('etiquetas')->num_rows(); ?>" data-min="0" data-max="<?= $user_info[0]->limit_tags ?>" data-width="90" data-height="90" data-fgColor="#00a65a">
                                      <div class="knob-label" style="font-size: 1.2em; font-weight: 700;">LIMITE DE ETIQUETAS NO MÊS</div>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <input type="text" class="knob" value="<?= $this->db->where('user_id', $user_info[0]->id)->get('etiquetas')->num_rows(); ?>" data-min="0" data-max="<?= $this->db->get('etiquetas')->num_rows(); ?>" data-width="90" data-height="90" data-fgColor="#00a65a">
                                      <div class="knob-label" style="font-size: 1.2em; font-weight: 700;">TOTAL DE ETIQUETAS EMITIDAS</div>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <input type="text" class="knob" value="<?= $this->db->where('user_id', $user_info[0]->id)->get('plp')->num_rows(); ?>" data-min="0" data-max="<?= $this->db->get('plp')->num_rows(); ?>" data-width="90" data-height="90" data-fgColor="#00a65a">
                                      <div class="knob-label" style="font-size: 1.2em; font-weight: 700;">TOTAL DE PLP GERADAS</div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Dados</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                            <?php foreach ($user_info as $user):?>
                                            <tr>
                                                <th><strong>LIMITE DE ETIQUETAS MENSAL</strong></th>
                                                <td><?php echo '<span class="label label-success" style="font-size: 1.1em">'.$user->limit_tags.'</span>'; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo lang('users_ip_address'); ?></th>
                                                <td><?php echo $user->ip_address; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo lang('users_firstname'); ?></th>
                                                <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo lang('users_lastname'); ?></th>
                                                <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nome de usuario</th>
                                                <td><?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo lang('users_email'); ?></th>
                                                <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo lang('users_created_on'); ?></th>
                                                <td><?php echo date('d-m-Y', $user->created_on); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo lang('users_last_login'); ?></th>
                                                <td><?php echo ( ! empty($user->last_login)) ? date('d-m-Y', $user->last_login) : NULL; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo lang('users_status'); ?></th>
                                                <td><?php echo ($user->active) ? '<span class="label label-success">'.lang('users_active').'</span>' : '<span class="label label-default">'.lang('users_inactive').'</span>'; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Empresa</th>
                                                <td><?php echo htmlspecialchars($user->company, ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo lang('users_phone'); ?></th>
                                                <td><?php echo $user->phone; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo lang('users_groups'); ?></th>
                                                <td>
                                                    <?php foreach ($user->groups as $group): ?>
                                                    <?php echo '<span class="label" style="background:'.$group->bgcolor.'">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>'; ?>
                                                    <?php endforeach?>
                                                </td>
                                            </tr>
                                                <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                         </div>

                        <div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Ultimas Etiquetas</h3>

                                  <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <div class="table-responsive">
                                    <table class="table no-margin">
                                      <thead>
                                      <tr>
                                        <th>Order ID</th>
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
                                        <td><?php switch ($v->servico) {  case '40096': echo "PAC"; break;case '65421': echo "SEDEX"; break; } ?></td>
                                        <td><span class="label label-<?php switch ($v->status) {  case '0': echo "default"; break; case '1': echo "success"; break; } ?>"><?php switch ($v->status) {  case '0': echo "EMITIDA"; break; case '1': echo "ENVIADA A PLP" ; break; } ?></span></td>
                                        <td> <?= $v->cep.'|'.$v->cidade.'/'.$v->estado ?> </td>
                                        <td> <?= $v->dest_cep.'|'.$v->dest_cidade.'/'.$v->dest_estado ?> </td>
                                      </tr>
                                    <?php endforeach ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
