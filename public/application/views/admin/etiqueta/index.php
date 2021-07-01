<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                        <div class="box-body">

                      <p align="center" class="alert alert-danger <?= isset($ambiente) && $ambiente == 1 ? 'hidden' : ''; ?>"> Emitindo etiqueta em ambiente de <code><?= isset($ambiente) && $ambiente == 1 ? 'Produção' : ' Homologação (TESTE)'; ?></code></p>

                      <a onclick="javascript: location.reload();"  href="#gera" aria-controls="gera" role="tab" data-toggle="tab" class="btn btn-app " style="background: #3c8dbc; color: white;">
                        <i class="fa fa-plus-square-o"></i> Gerar Etiqueta
                      </a>
<!--                       <a href="#simular" aria-controls="simular" role="tab" data-toggle="tab" class="btn btn-app">
                        <i class="fa fa-clock-o"></i> Simular Custo e Prazo
                      </a>
                      <a href="#verificar" aria-controls="verificar" role="tab" data-toggle="tab" class="btn btn-app" >
                        <i class="fa fa-check-square-o"></i> Verificar Disponibilidade
                      </a> -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="gera">
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title">Gerar nova etiqueta</h3>
                                  </div>
                                  <div class="panel-body">
                                    <!-- target="_blank"  -->
                                    <form class="form-horizontal" action="<?= site_url('admin/etiqueta/index/'); ?>" method="post">
                                      <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="form-group" style="margin: 0;">
                                              <label class="control-label">Remetente</label>
                                              <div class="input-group">
                                                <select class="form-control" name="remetente">
                                                    <?php if(isset($remetente)): foreach ($remetente as $k => $v): ?>
                                                       <option value="<?= $v->id; ?>"><?= $v->title.' | '.$v->rua.', '.$v->num.' - '.$v->bairro.' - '.$v->cidade.' / '.$v->estado; ?></option>
                                                    <?php endforeach; endif?>
                                                 </select>
                                                 <a tipo="2" href="#new_remetente" id="new_remetente"  class="input-group-addon">
                                                     <i class="fa fa-plus-square-o" ></i>
                                                 </a>
                                                 <a href="#edit_remetente" data-toggle="modal" data-target="#edit_remetente" class="input-group-addon">
                                                     <i class="fa fa-edit" ></i>
                                                 </a>
                                              </div>
                                              <!-- /.input group -->
                                            </div>
                                            <hr>
                                        </div>

<!--                                       <div class="col-sm-6">
                                            <div class="form-group hidden" style="margin: 0;">
                                              <label class="control-label">Remetente</label>
                                              <div class="input-group">
                                                <select class="form-control" name="remetente">
                                                    <?php if(isset($destinatario)): foreach ($destinatario as $k => $v): ?>
                                                       <option value="<?= $v->id; ?>"><?= $v->rua.' - '.$v->bairro.' - '.$v->cidade.' - '.$v->estado; ?></option>
                                                    <?php endforeach; endif?>
                                                </select>
                                                <a tipo="1" href="#new_destinatario" id="new_destinatario" class="input-group-addon">
                                                    <i class="fa fa-plus-square-o" ></i>
                                                </a>
                                              </div>
                                            </div>
                                        </div>-->

                                        <div class=" ">
                                            <div class="col-sm-6 col-md-8 col-lg-8">
                                                <div class="">
                                                    <label for="dest_title">Nome do destinatario</label>
                                                     <input type="text" class="form-control" name="dest_title" id="dest_title" value="<?= set_value('dest_title'); ?>">
                                                </div>
                                            </div>
                                          <div class="col-sm-3 col-md-4 col-lg-4">
                                                <div class="">
                                                    <label for="dest_cep">CEP</label>
                                                     <input type="text" class="form-control" required name="dest_cep" id="dest_cep" value="<?= set_value('dest_cep'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-8 col-lg-8">
                                                <div class="">
                                                    <label for="dest_rua">Logradouro</label>
                                                     <input type="text" class="form-control" required name="dest_rua" id="dest_rua"  value="<?= set_value('dest_rua'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-md-4 col-lg-4">
                                                <div class="">
                                                    <label for="dest_num">Número</label>
                                                     <input type="text" class="form-control" name="dest_num" id="dest_num"  value="<?= set_value('dest_num'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-md-8 col-lg-8">
                                                <div class="">
                                                    <label for="dest_complemento">Complemento</label>
                                                     <input type="text" class="form-control" name="dest_complemento" id="dest_complemento"  value="<?= set_value('dest_complemento'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-md-4 col-lg-4">
                                                <div class="">
                                                    <label for="dest_bairro">Bairro</label>
                                                     <input type="text" class="form-control" required name="dest_bairro" id="dest_bairro" value="<?= set_value('dest_bairro'); ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-5 col-md-4 col-lg-4">
                                                <div class="">
                                                    <label for="dest_estado">Estado</label>
                                                     <input type="text" class="form-control" required name="dest_estado" id="dest_estado" value="<?= set_value('dest_estado'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div class="">
                                                    <label for="dest_cidade">Cidade</label>
                                                     <input type="text" class="form-control" required name="dest_cidade" id="dest_cidade" value="<?= set_value('dest_cidade'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div class="">
                                                    <label for="dest_nfe">NF_E</label>
                                                     <input type="text" class="form-control"  name="dest_nfe" id="dest_nfe" value="<?= set_value('dest_nfe'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                      <hr>
                                      <div class="form-group">
                                        <div class="col-sm-3">
                                          <label class="control-label">Altura</label>
                                          <input type="text" class="form-control " required min="12" max="26" name="altura" id="altura" placeholder="Altura" value="<?= set_value('altura'); ?>">
                                        </div>
                                        <div class="col-sm-3">
                                          <label class="control-label">Largura</label>
                                          <input type="text" class="form-control" required min="12" max="26"  name="largura" id="largura" placeholder="Largura" value="<?= set_value('largura'); ?>">
                                        </div>
                                        <div class="col-sm-3">
                                          <label class="control-label">Diametro</label>
                                          <input type="text" class="form-control "  name="diamentro" id="diamentro" placeholder="Diametro" value="0" value="<?= set_value('diamentro'); ?>">
                                        </div>
                                        <div class="col-sm-3">
                                          <label class="control-label">Comprimento</label>
                                          <input type="text" class="form-control " min="12" max="26" required name="comprimento" id="comprimento" placeholder="Comprimento" value="<?= set_value('comprimento'); ?>">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <div class="col-sm-3">
                                          <label class="control-label">Peso</label>
                                            <select class="custom-select form-control " required id="peso" name="peso" >
                                                <option value="0.3" >Até 300 gramas</option>
                                                <option value="0.5">Até 500 gramas</option>
                                                <option value="1">Até 1 KG</option>
                                                <option value="2">Até 2 KG</option>
                                                <option value="3">Até 3 KG</option>
                                                <option value="4">Até 4 KG</option>
                                                <option value="5">Até 5 KG</option>
                                                <option value="6">Até 6 KG</option>
                                                <option value="7">Até 7 KG</option>
                                                <option value="8">Até 8 KG</option>
                                                <option value="9">Até 9 KG</option>
                                                <option value="10">Até 10 KG</option>
                                                <option value="11">Até 11 KG</option>
                                                <option value="12">Até 12 KG</option>
                                                <option value="13">Até 13 KG</option>
                                                <option value="14">Até 14 KG</option>
                                                <option value="15">Até 15 KG</option>
                                                <option value="16">Até 16 KG</option>
                                                <option value="17">Até 17 KG</option>
                                                <option value="18">Até 18 KG</option>
                                                <option value="19">Até 19 KG</option>
                                                <option value="20">Até 20 KG</option>
                                                <option value="21">Até 21 KG</option>
                                                <option value="22">Até 22 KG</option>
                                                <option value="23">Até 23 KG</option>
                                                <option value="24">Até 24 KG</option>
                                                <option value="25">Até 25 KG</option>
                                                <option value="26">Até 26 KG</option>
                                                <option value="27">Até 27 KG</option>
                                                <option value="28">Até 28 KG</option>
                                                <option value="29">Até 29 KG</option>
                                                <option value="30">Até 30 KG</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="">
                                                <label for="servico">Serviço de postagem</label>
                                                <select class="form-control" name="servico" id="servico" required>
                                                   <option value="">Selecione...</option>
                                                   <?php foreach ($servicos as $k => $v): ?>
                                                     <option value="<?= $v->codigo ?>">41068 - <?= $v->nome ?></option>
                                                   <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="">
                                                <label for="adicional">Serviços adicionais</label>
                                                <select class="form-control" name="adicional" id="adicional"  size="2" >
                                                    <option value="02" >Mão própria</option>
                                                    <option value="19" id="vl_d">Valor declarado</option>
                                                    <option value="01" >Aviso de recebimento</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="hidden" id="valorDeclarado">
                                                <label for="valor">Valor declarado</label>
                                                <input type="text" class="form-control" id="valor" name="valor" value="0" required>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="">
                                        <div class="col-sm-12">
                                          <button type="submit" class="btn btn-success" style="width: 100%;"> SOLICITAR ETIQUETA </button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                            </div>
<!--                             <div role="tabpanel" class="tab-pane " id="simular">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a id="demo-calc-preco-prazo"></a>
                                        <h1>Calcular preços e prazos</h1>
                                        <div id="demo-calc-preco-prazo-wp">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  <form action="<?= base_url('admin/etiqueta/calcular/'); ?>" method="post">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-lg-2">
                                                            <div class="form-group">
                                                                <label for="demo-calc-preco-prazo-remetenteCep">CEP origem</label>
                                                                <input type="text" class="form-control" name="remetenteCep" id="demo-calc-preco-prazo-remetenteCep" value="30170-010">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="demo-calc-preco-prazo-destinatarioCep">CEP destino</label>
                                                                <input type="text" class="form-control" name="destinatarioCep" id="demo-calc-preco-prazo-destinatarioCep" value="04538-132">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="demo-calc-preco-prazo-servicosDePostagem">Serviço de postagem</label>
                                                                <select class="form-control" name="servicosDePostagem[]" id="demo-calc-preco-prazo-servicosDePostagem" multiple="" size="6">
                                                                    <option value="81019" selected="">81019 - E-sedex</option>
                                                                    <option value="41068" selected="">41068 - Pac</option>
                                                                    <option value="40096" selected="">40096 - Sedex</option>
                                                                    <option value="40215" selected="">40215 - Sedex 10 Envelope</option>
                                                                    <option value="40886" selected="">40886 - Sedex 10 Pacote</option>
                                                                    <option value="40878" selected="">40878 - Sedex Hoje</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label for="demo-calc-preco-prazo-servicosAdicionais">Serviços adicionais</label>
                                                                <select class="form-control" name="servicosAdicionais[]" id="servicosAdicionais" multiple="" size="6" onchange="app.servicosAdicionaisChange(this, '#calc-valorDeclarado-wp')">
                                                                    <option value="mp" selected="">Mão própria</option>
                                                                    <option value="vd" selected="">Valor declarado</option>
                                                                    <option value="ar" selected="">Aviso de recebimento</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-lg-3">
                                                            <div class="form-group">
                                                                <label for="demo-calc-preco-prazo-peso">
                                                                    Peso
                                                                    <small>Em gramas (caixa + produto)</small>
                                                                </label>
                                                                <input type="text" class="form-control" id="demo-calc-preco-prazo-peso" name="peso" value="0.500">
                                                            </div>
                                                            <div class="form-group" id="calc-valorDeclarado-wp">
                                                                <label for="demo-calc-preco-prazo-valorDeclarado">Valor declarado</label>
                                                                <input type="text" class="form-control" id="demo-calc-preco-prazo-valorDeclarado" name="valorDeclarado" value="75.90">
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </form>
                                                </div>
                                            </div>

                                            <div class="well">
                                                <button class="btn btn-primary" onclick="_pageView(this);app.btCalcPrecosClick()">Calcular preços e prazos</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> -->
<!--                             <div role="tabpanel" class="tab-pane " id="verificar">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a id="demo-disponibilidade-servico"></a>
                                        <h1>Verificar disponibilidade do serviço</h1>
                                        <div id="demo-disponibilidade-servico-wp">
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2">
                                                    <div class="form-group">
                                                        <label for="demo-calc-remetenteCep">CEP origem</label>
                                                        <input type="text" class="form-control" name="remetenteCep" id="demo-calc-remetenteCep" value="30170-010">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-md-2">
                                                    <div class="form-group">
                                                        <label for="demo-calc-destinatarioCep">CEP destino</label>
                                                        <input type="text" class="form-control" name="destinatarioCep" id="demo-calc-destinatarioCep" value="04538-132">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label for="demo-calc-servicoDePostagem">Serviço de postagem</label>
                                                        <select class="form-control" name="servicoDePostagem" id="demo-calc-servicoDePostagem">
                                                            <option value="81019" selected="">81019 - E-sedex</option>
                                                            <option value="41068" selected="">41068 - Pac</option>
                                                            <option value="40096" selected="">40096 - Sedex</option>
                                                            <option value="40215" selected="">40215 - Sedex 10 Envelope</option>
                                                            <option value="40886" selected="">40886 - Sedex 10 Pacote</option>
                                                            <option value="40878" selected="">40878 - Sedex Hoje</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="well">
                                                <button class="btn btn-primary" onclick="_pageView(this);app.btDisponibilidadeServicoClick()">Verificar disponibilidade do serviço</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
             </div>
            <div class="col-md-6">
              <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Etiquetas esperando PLP</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="table-responsive">
                      <form action="<?= site_url('admin/etiqueta/plp/'); ?>" method="post">
                        <table class="table no-margin">
                          <thead>
                          <tr>
                            <th>
                              <input type="checkbox" id="selecctall">
                            </th>
                            <th>ID</th>
                            <th>Serviço</th>
                            <th>Status</th>
                            <th>Origem</th>
                            <th>Destino</th>
                          </tr>
                          </thead>

                            <button type="submit" name="simples" value="1" class="btn btn-sm btn-primary" style=""> <i class="fa fa-gears"></i> Gerar PLP</button>
                            <button type="submit" name="massa" value="1" class="btn btn-sm btn-primary" style="margin-left: 15px;"> <i class="fa fa-print"></i> Imprimir em massa</button>
                            <button type="submit" name="a4" value="1" class="btn btn-sm btn-primary" style="margin-left: 15px;"> <i class="fa fa-files-o"></i> Imprimir em massa A4</button>
                            <hr>
                            <tbody>
                            <?php  foreach ($etiqueta as $k => $v): ?>
                            <tr>
                              <td><input type="checkbox" name="etiquetas[]" class="checkbox" value="<?= $v->id_etiquetas; ?>"></td>
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
                      </form>
                    </div>
                  </div>
              </div>
           </div>
        </div>
    </section>
</div>
<!-- CADASTRA ENDEREÇO REMETENTE-->
<div class="modal fade" id="edit_remetente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CADASTRAR ENDEREÇO REMETENTE</h4>
      </div>
      <div class="modal-body">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <?php foreach ($remetente as $k => $v): ?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" >
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#remetente_<?= $v->id ?>" aria-expanded="false" aria-controls="collapseThree">
                  <?= $v->bairro.', '.$v->cidade.' - '.$v->estado.' | '.$v->contato ?>
                </a>
              </h4>
            </div>
            <div id="remetente_<?= $v->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                <form action="<?= site_url(); ?>/admin/etiqueta/editar_endereco/<?= $v->id ?>" method="post">
                  <div class="form-group col-sm-4">
                    <label for="cep">Cep:</label>
                    <input type="text" name="cep" required class="form-control" id="edit_cep_<?= $v->id ?>" placeholder="Cep" value="<?= $v->cep ?>">
                  </div>
                  <div class="form-group col-sm-8">
                    <label for="title">Nome Remetente:</label>
                    <input type="text" name="title" required class="form-control" id="edit_title" placeholder="titulo" value="<?= $v->title ?>">
                  </div>
                  <div class="form-group col-sm-8">
                    <label for="rua">Logradouro:</label>
                    <input type="text" name="rua" required class="form-control" id="edit_rua" placeholder="" value="<?= $v->rua ?>">
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="num">Numero:</label>
                    <input type="text" name="num" class="form-control" id="edit_num" placeholder="ex: 1206 ou s/n" value="<?= $v->num ?>">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="bairro">Bairro:</label>
                    <input type="text" name="bairro" required class="form-control" id="edit_bairro" placeholder="" value="<?= $v->bairro ?>">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="complemento">Complemento:</label>
                    <input type="text" name="complemento" class="form-control" id="edit_complemento" placeholder="" value="<?= $v->complemento ?>">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" required class="form-control" id="edit_cidade" placeholder="" value="<?= $v->cidade ?>">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="estado">Estado:</label>
                    <input type="text" name="estado" class="form-control" id="edit_estado" placeholder="ex: MG " value="<?= $v->estado ?>">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="contato">Contato:</label>
                    <input type="text" name="contato" required class="form-control" id="edit_contato" placeholder="Nome do responsavel" value="<?= $v->contato ?>">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="fone">Telefone:</label>
                    <input type="text" name="fone" class="form-control" id="edit_fone_<?= $v->id ?>" placeholder="Telefone de contato" value="<?= $v->fone ?>">
                  </div>
                  <div class="">
                    <button type="button" class="btn btn-danger " data-dismiss="modal">Cancelar</button>
                    <button style="float: right" type="submit" class="btn btn-success " align="right">Salvar Endereço</button>
                  </div>
                  </form>
                </div>
            </div>
          </div>
          <script>
            $("#edit_cep_<?= $v->id ?>").mask('99999-999');
            $("#edit_fone_<?= $v->id ?>").mask('(99) 9 9999-9999');
          </script>
          <?php endforeach; ?>

        </div>
      </div>
    </div>
  </div>
</div>



<!-- CADASTRA ENDEREÇO REMETENTE-->
<div class="modal fade" id="new_endereco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CADASTRAR ENDEREÇO REMETENTE</h4>
      </div>
      <form action="<?= site_url(); ?>/admin/etiqueta/novo_endereco/" method="post">
      <input type="hidden" name="tipo" id="tipo" >
      <div class="modal-body">
          <div class="form-group col-sm-4">
            <label for="cep">Cep:</label>
            <input type="text" name="cep" required class="form-control" id="cep" placeholder="Cep">
          </div>
          <div class="form-group col-sm-8">
            <label for="title">Nome Remetente:</label>
            <input type="text" name="title" required class="form-control" id="title" placeholder="titulo">
          </div>
          <div class="form-group col-sm-8">
            <label for="rua">Logradouro:</label>
            <input type="text" name="rua" required class="form-control" id="rua" placeholder="">
          </div>
          <div class="form-group col-sm-4">
            <label for="num">Numero:</label>
            <input type="text" name="num" class="form-control" id="num" placeholder="ex: 1206 ou s/n">
          </div>
          <div class="form-group col-sm-6">
            <label for="bairro">Bairro:</label>
            <input type="text" name="bairro" required class="form-control" id="bairro" placeholder="">
          </div>
          <div class="form-group col-sm-6">
            <label for="complemento">Complemento:</label>
            <input type="text" name="complemento" class="form-control" id="complemento" placeholder="">
          </div>
          <div class="form-group col-sm-6">
            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" required class="form-control" id="cidade" placeholder="">
          </div>
          <div class="form-group col-sm-6">
            <label for="estado">Estado:</label>
            <input type="text" name="estado" class="form-control" id="estado" placeholder="ex: MG ">
          </div>
          <div class="form-group col-sm-6">
            <label for="contato">Contato:</label>
            <input type="text" name="contato" required class="form-control" id="contato" placeholder="Nome do responsavel">
          </div>
          <div class="form-group col-sm-6">
            <label for="fone">Telefone:</label>
            <input type="text" name="fone" class="form-control" id="fone" placeholder="Telefone de contato">
          </div>
      </div>
      <div class="modal-footer" style="border: none !important;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Salvar Endereço</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade etiqueta"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        <iframe id="file" name="file" style="width: 100%; height: 70vh;" src="<?= base_url().'/'.$file; ?>"></iframe>
      </div>
      <div class="modal-footer" style="border: none !important;">
        <button type="button" class="btn btn-default" onclick="javascript: location.reload();">Voltar</button>
        <button type="submit" class="btn btn-success btn_print">Imprimir</button>
      </div>

    </div>
  </div>
</div>
