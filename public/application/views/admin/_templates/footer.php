<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
    <div class="modal fade eventos" tabindex="-1"  >
      <div class="modal-dialog " role="document">
        <div class="modal-cosntent text-center">
            <?php if ($this->session->flashdata('successo') != NULL) {
                    echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>'
                    . $this->session->flashdata('successo') . '</div>';
                } else if ($this->session->flashdata('error') != NULL) {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>'
                    . $this->session->flashdata('error') . '</div>';
                } else if (validation_errors() != NULL) {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>'
                    . validation_errors() . '</div>';
                } ?>
        </div>
      </div>
    </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b><?php echo lang('footer_version'); ?></b> Development
                </div>
                <strong><?php echo lang('footer_copyright'); ?> &copy; 2014-<?php echo date('Y'); ?> <a href="http://replaysistemas.com.br" target="_blank">ReplaySistemas</a> <a href="//replaysistemas.com.br" target="_blank"></a></strong> <?php echo lang('footer_all_rights_reserved'); ?>.
            </footer>
        </div>

        <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/slimscroll/slimscroll.min.js'); ?>"></script>
        <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

        <?php if ($mobile == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/fastclick/fastclick.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($admin_prefs['transition_page'] == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/animsition/animsition.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/pwstrength/pwstrength.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/tinycolor/tinycolor.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.js'); ?>"></script>
<?php endif; ?>
        <script src="<?php echo base_url($frameworks_dir . '/adminlte/js/adminlte.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/domprojects/js/dp.min.js'); ?>"></script>
    <script type="text/javascript">
    <?php if ($this->session->flashdata('successo') != NULL  OR  validation_errors() != NULL OR $this->session->flashdata('error') != NULL) {   ?>
        $('.eventos').modal('show');
        <?php } ?>
    </script>
<!-- Adicionando Javascript -->
    <script type="text/javascript" >
        $(document).ready(function() {
            $("#cep").mask('99999-999');
            $("#fone").mask('(99) 9 9999-9999');
            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#estado").val("");
            }
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep != "") {
                    var validacep = /^[0-9]{8}$/;
                    if(validacep.test(cep)) {
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#estado").val("...");
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#estado").val(dados.uf);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>
    <!-- Adicionando Javascript -->
        <script type="text/javascript" >
            $(document).ready(function() {
                $("#dest_cep").mask('99999-999');
                $("#fone").mask('(99) 9 9999-9999');
                function limpa_formulário_cep() {
                    // Limpa valores do formulário de cep.
                    $("#dest_rua").val("");
                    $("#dest_bairro").val("");
                    $("#dest_cidade").val("");
                    $("#dest_estado").val("");
                }
                //Quando o campo cep perde o foco.
                $("#dest_cep").blur(function() {
                    var cep = $(this).val().replace(/\D/g, '');
                    if (cep != "") {
                        var validacep = /^[0-9]{8}$/;
                        if(validacep.test(cep)) {
                            $("#dest_rua").val("...");
                            $("#dest_bairro").val("...");
                            $("#dest_cidade").val("...");
                            $("#dest_estado").val("...");
                            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                                if (!("erro" in dados)) {
                                    //Atualiza os campos com os valores da consulta.
                                    $("#dest_rua").val(dados.logradouro);
                                    $("#dest_bairro").val(dados.bairro);
                                    $("#dest_cidade").val(dados.localidade);
                                    $("#dest_estado").val(dados.uf);
                                } //end if.
                                else {
                                    //CEP pesquisado não foi encontrado.
                                    limpa_formulário_cep();
                                    alert("CEP não encontrado.");
                                }
                            });
                        } //end if.
                        else {
                            //cep é inválido.
                            limpa_formulário_cep();
                            alert("Formato de CEP inválido.");
                        }
                    } //end if.
                    else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep();
                    }
                });
            });

        </script>

<!-- Adicionando Javascript -->
    <script type="text/javascript" >
        $(document).ready(function() {
            $("#edit_cep").mask('99999-999');
            $("#edit_fone").mask('(99) 9 9999-9999');
            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#edit_rua").val("");
                $("#edit_bairro").val("");
                $("#edit_cidade").val("");
                $("#edit_estado").val("");
            }
            //Quando o campo cep perde o foco.
            $("#edit_cep").blur(function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep != "") {
                    var validacep = /^[0-9]{8}$/;
                    if(validacep.test(cep)) {
                        $("#edit_rua").val("...");
                        $("#edit_bairro").val("...");
                        $("#edit_cidade").val("...");
                        $("#edit_estado").val("...");
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#edit_rua").val(dados.logradouro);
                                $("#edit_bairro").val(dados.bairro);
                                $("#edit_cidade").val(dados.localidade);
                                $("#edit_estado").val(dados.uf);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>

    <script type="text/javascript">
    $('#new_remetente').click(function () {
      var tipo = $(this).attr('tipo');
      $('#tipo').val(tipo);
      $('#new_endereco').modal('show');
    })
    $('#new_destinatario').click(function () {
      var tipo = $(this).attr('tipo');
      $('#tipo').val(tipo);
      $('#new_endereco').modal('show');
    })
    </script>
    <script type="text/javascript">
       $('#adicional').change(function(){
          if (document.getElementById('vl_d').selected == true) {
            $('#valorDeclarado').removeClass('hidden');
          } else {
            $('#valorDeclarado').addClass('hidden');
          }
      });



    </script>

    <script type="text/javascript">
        <?php if (isset($file)): ?>
           $('.etiqueta').modal('show');
        <?php endif ?>
            $('.btn_print').click(function(){
                window.frames['file'].print();
            });
    </script>
        <!-- Basic scenario end -->
    <script type="text/javascript">
      $(document).ready(function() {
        $('#selecctall').click(function(event) {
            if(this.checked) {
                $('.checkbox').each(function() {
                    this.checked = true;
                });
            }else{
                $('.checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
      });
    </script>
    <script type="text/javascript">
        $(document).ready( function () {
            $('.table').DataTable( {
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                },
            } );
        } );
    </script>
    <script type="text/javascript" src="//adminlte.io/themes/AdminLTE/bower_components/jquery-knob/js/jquery.knob.js"></script>
    <script type="text/javascript">
    /* jQueryKnob */

    $(".knob").knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a = this.angle(this.cv)  // Angle
              , sa = this.startAngle          // Previous start angle
              , sat = this.startAngle         // Start angle
              , ea                            // Previous end angle
              , eat = sat + a                 // End angle
              , r = true;

          this.g.lineWidth = this.lineWidth;

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3);

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value);
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3);
            this.g.beginPath();
            this.g.strokeStyle = this.previousColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
            this.g.stroke();
          }

          this.g.beginPath();
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
          this.g.stroke();

          this.g.lineWidth = 2;
          this.g.beginPath();
          this.g.strokeStyle = this.o.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
          this.g.stroke();

          return false;
        }
      }
    });
    /* END JQUERY KNOB */

    </script>
    </body>
</html>
