<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
          <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">PLPs</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                      <tr>
                        <th>Numero</th>
                        <th>Quant Tags</th>
                        <th>Data</th>
                        <th>Usuario</th>
                      </tr>
                      </thead>
                        <tbody>
                        <?php  foreach ($plps as $k => $v): ?>
                        <tr>                                                   
                          <td><a target="_blank" href="<?= base_url().$v->caminho ?>" ><?= $v->numero ?></a></td>
                          <td> <?= $this->db->where('idplp', $v->numero)->get('etiquetas')->num_rows(); ?> </td>
                          <td> <?= $v->data_hora ?> </td>
                          <td> <a href="<?= site_url('admin/users/profile/').$v->user_id; ?>/"><?= $this->db->where('id', $v->user_id)->get('users')->row()->first_name ?></a> </td>
                        </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Etiquetas</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                      <tr>
                        <th>ID</th>
                        <th>Data/Hora</th>
                        <th>Serviço</th>
                        <th>Status</th>
                        <th>Origem</th>
                        <th>Destinatário</th>
                      </tr>
                      </thead>
                        <tbody>
                        <?php  foreach ($etiqueta as $k => $v): ?>
                        <tr>                                                   
                          <td><a target="_blank" href="<?= base_url().$v->caminho ?>" ><?= $v->codigo ?></a></td>
                          <td> <?= $v->dt_emissao ?> </td>
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
                          <td> <?= $v->title.'|'.$v->cidade.'/'.$v->estado ?> </td>
                          <td> <?= $v->dest_title.' | '.$v->dest_cep.'|'.$v->dest_cidade.'/'.$v->dest_estado ?> </td>
                        </tr>
                        <?php endforeach ?>
                        </tbody>                      
                    </table>
                  </div>
                </div>
              </div>
           </div>   
      </div>

</div>
