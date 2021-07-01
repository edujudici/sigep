<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Etiqueta extends Admin_Controller {

    public function __construct() {

        parent::__construct();
        $this->page_title->push('Etiqueta');
        $this->data['pagetitle'] = $this->page_title->show();
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'etiqueta', 'admin/etiqueta');


    }

	public function index()
	{
        $a_p = $this->db->where('id', 1)->get('admin_preferences')->row();
        define('AMBIENTE', $a_p->ambiente);
        define('USUARIO', $a_p->usuario);
        define('SENHA', $a_p->senha);
        define('CONTRATO', $a_p->numeroContrato);
        define('CODADMIN', $a_p->codAdministrativo);
        define('CARTAO', $a_p->cartaoPostagem);
        define('CNPJ', $a_p->cnpjEmpresa);
        define('ANO_CONTRATO', $a_p->anoContrato);
        define('ID_DIRETORIA', $a_p->diretoria);
        define('ATENDE_CLIENTE', base_url().'AtendeCliente.xml');
        include_once APPPATH."/third_party/Sigep/bootstrap.php";
        include_once APPPATH."/third_party/Sigep/src/PhpSigep/Pdf/php-sigep-fpdf/src/autoload.php";
        $this->data['ambiente'] = $a_p->ambiente;

        $ver = $this->db->where('cod_ver', date('dmY'))->get('servicos')->row();
        if (!$ver) {
          $accessData = new \PhpSigep\Model\AccessDataHomologacao();
          $phpSigep = new PhpSigep\Services\SoapClient\Real();
          $result = $phpSigep->buscaCliente($accessData);
          if ($result->getResult()->descricaoStatusCliente != 'Ativo') {
            $this->session->set_flashdata('error', "Seu contrato com os correios parece não estar ativo... entre em contato com os correios para mais detalhes!!!");
            redirect('admin/', 'refresh');
          }
          if (!$result->hasError()) {
              $buscaClienteResult = $result->getResult();
              $servicos = $buscaClienteResult->getContratos()->cartoesPostagem->servicos;
              foreach ($servicos as &$servico) {
                      $servico->servicoSigep->chancela->chancela = 'Chancelas anulada via código.';
                      $dados = array(
                        'nome' => $servico->descricao,
                        'codigo' => $servico->codigo,
                        'status' => 1,
                        'cod_ver' => date('dmY'),
                      );
                      $serv = $this->db->where('codigo', $servico->codigo)->get('servicos')->result();
                      if ($serv) {
                        $this->db->update('servicos', $dados, array('codigo' => $servico->codigo));
                      }else{
                        $this->db->insert('servicos', $dados);
                      }
              }
          }else{
            echo "erro";
          }
        }

        if ( ! $this->ion_auth->logged_in() OR !$this->ion_auth->is_acesso('tags'))
        {
            $this->session->set_flashdata('error', "Não tem permissão para fazer isso!!!");
            redirect('', 'refresh');
        }
        else
        {
          if( $_SERVER['REQUEST_METHOD']== 'POST' ) {
              $hash = md5( implode( $_POST ) );
              if(isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ) {
                redirect('admin/etiqueta/');
                exit;
              } else {
                if (!$this->ion_auth->is_admin()) {
                    $num_tags = $this->db->where('user_id', $this->session->userdata('user_id'))->get('etiquetas')->num_rows();
                    $limit_tags = $this->db->where('id', $this->session->userdata('user_id'))->get('users')->row()->limit_tags;
                    if ($num_tags > $limit_tags) {
                        $this->session->set_flashdata('error', "Você atingiu seu limite de etiquetas no mês. ");
                        redirect('admin/etiqueta/');
                    }
                }
                  $_SESSION['hash'] = $hash;
                if ($this->input->post()) {
                    $this->form_validation->set_rules('altura', 'altura', 'trim|required');
                    $this->form_validation->set_rules('largura', 'largura', 'trim|required');
                    $this->form_validation->set_rules('comprimento', 'comprimento', 'trim|required');
                    $this->form_validation->set_rules('peso', 'peso', 'trim|required');
                    $this->form_validation->set_rules('servico', 'servico', 'trim');
                    $this->form_validation->set_rules('valor', 'valor', 'trim');
                    $this->form_validation->set_rules('dest_title', 'dest_title', 'trim');
                    $this->form_validation->set_rules('dest_rua', 'dest_rua', 'trim|required');
                    $this->form_validation->set_rules('dest_num', 'dest_num', 'trim');
                    $this->form_validation->set_rules('dest_complemento', 'dest_complemento', 'trim');
                    $this->form_validation->set_rules('dest_bairro', 'dest_bairro', 'trim|required');
                    $this->form_validation->set_rules('dest_cep', 'dest_cep', 'trim|required');
                    $this->form_validation->set_rules('dest_cidade', 'dest_cidade', 'trim|required');
                    $this->form_validation->set_rules('dest_estado', 'dest_estado', 'trim|required');
                    if ($this->form_validation->run() == true) {
                        $remetente = $this->db->where('id', $this->input->post('remetente'))->get('enderecos')->row();
                        $dados = array(
                            'remetente' => $remetente,
                            'altura' => $this->input->post('altura'),
                            'user_id' => $this->session->userdata('user_id'),
                            'largura' => $this->input->post('largura'),
                            'comprimento' => $this->input->post('comprimento'),
                            'peso' => $this->input->post('peso'),
                            'servico' => $this->input->post('servico'),
                            'quant' => 1,
                            'adicional' => $this->input->post('adicional'),///'025'
                            'valor' => $this->input->post('valor'),
                            'diametro' => $this->input->post('diametro'),
                            'dest_title' => $this->input->post('dest_title'),
                            'dest_rua' => $this->input->post('dest_rua'),
                            'dest_num' => $this->input->post('dest_num'),
                            'dest_complemento' => $this->input->post('dest_complemento'),
                            'dest_bairro' => $this->input->post('dest_bairro'),
                            'dest_cep' => $this->input->post('dest_cep'),
                            'dest_cidade' => $this->input->post('dest_cidade'),
                            'dest_estado' => $this->input->post('dest_estado'),
                            'dest_nfe' => $this->input->post('dest_nfe'),
                            'pedido_id' => rand(),
                            'dt_emissao' => date('d-m-Y H:i:s'),
                        );
                        $params = $this->helper($dados);

                        $logoFile = 'assets/image/logosigep.png';
                        $pdf = new \PhpSigep\Pdf\CartaoDePostagem2018($params, $logoFile);
                        if (!file_exists("sigep/".date('m'))) {mkdir('sigep/'.date('m'), 0777, true);}
                        $file = "sigep/".date('m').'/'.rand().".pdf";
                        $pdf->render('F', $file);//
                        $dados['remetente'] = $this->input->post('remetente');
                        $dados['codigo'] = $params->getEncomendas()[0]->getEtiqueta()->getEtiquetaComDv();
                        $dados['sem_dev'] = $params->getEncomendas()[0]->getEtiqueta()->getEtiquetaSemDv();
                        $dados['caminho'] = $file;
                        //new \PhpSigep\Model\ServicoDePostagem($this->input->post('servico'))
                        $dimensao = new \PhpSigep\Model\Dimensao();
                        $dimensao->setTipo(\PhpSigep\Model\Dimensao::TIPO_PACOTE_CAIXA);
                        $dimensao->setAltura($this->input->post('altura')); // em centímetros
                        $dimensao->setComprimento($this->input->post('comprimento')); // em centímetros
                        $dimensao->setLargura($this->input->post('largura')); // em centímetros
                        $params = new \PhpSigep\Model\CalcPrecoPrazo();
                        $params->setAccessData(new \PhpSigep\Model\AccessDataHomologacao());
                        $params->setCepOrigem($remetente->cep);
                        $params->setCepDestino($this->input->post('dest_cep'));
                        $params->setServicosPostagem(\PhpSigep\Model\ServicoDePostagem::getAll() );
                        $params->setAjustarDimensaoMinima(true);
                        $params->setDimensao($dimensao);
                        $params->setPeso($this->input->post('peso'));// 150 gramas
                        $phpSigep = new PhpSigep\Services\SoapClient\Real();
                        $precoprazo = $phpSigep->calcPrecoPrazo($params);
                        $precoprazo = $precoprazo->getResult();
                        $valor = 0;
                        $prazo = 0;
                        foreach ($precoprazo as $k => $v) {
                          if ($v->getServico()->getCodigo() == $this->input->post('servico')) {
                            $valor = $v->getValor();
                            $prazo = $v->getPrazoEntrega();
                          }
                        }

                        $dados['valor'] = $valor;
                        $dados['custo'] = $prazo;
                        $this->db->insert('etiquetas', $dados);
                        $this->data['file'] = $file;
                    }else{
                        echo validation_errors();
                    }
                }
              }
            }

            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            if ($this->ion_auth->is_admin()) {
                $this->data['remetente'] = $this->db->where('ativo', 1)->where('tipo', 2)->get('enderecos')->result();
            } else {
                $this->data['remetente'] = $this->db->where('ativo', 1)->where('tipo', 2)->where('user', $this->session->userdata('user_id'))->get('enderecos')->result();
            }  


            $this->data['destinatario'] = $this->db->where('ativo', 1)->where('tipo', 1)->where('user', $this->session->userdata('user_id'))->get('enderecos')->result();
            $this->data['etiqueta'] = $this->db->join('enderecos', 'enderecos.id = remetente')->order_by("id_etiquetas", "desc")->where('user_id', $this->session->userdata('user_id'))->get('etiquetas')->result();
            $this->data['servicos'] = $this->db->order_by("nome", "desc")->where('status', 1)->get('servicos')->result();
            $this->template->admin_render('admin/etiqueta/index', $this->data);
        }
	}

        private $paramsLibrary = '"en-GB-x","A4","","",10,10,10,10,6,3';
        private $pdfLibrary;

        // if (!$this->input->post('etiquetas')) {
        //     $this->session->set_flashdata('error', "Metodo Invalido");
        //    redirect('admin/etiqueta/');
        // }
        // $itens = $this->input->post('etiquetas');
        // $busca = $this->db->where_in('id_etiquetas', $itens)->get('etiquetas')->result();
        // include_once APPPATH.'/third_party/mpdf/mpdf.php';
        // $pdf = new mPDF('P', array(106.36, 140));
        // $pdf->SetImportUse();
        // $page = 0;
        // foreach ($busca as $c) {
        //     $pagecount = $pdf->SetSourceFile($c->caminho);
        //     if ($page != 0) {
        //         $pdf->AddPage();
        //     }
        //     for ($i = 1; $i <= $pagecount; $i++) {
        //         $import_page = $pdf->ImportPage($i);
        //         $pdf->UseTemplate($import_page);
        //         if ($i < $pagecount) {
        //             $pdf->AddPage();
        //         }
        //     }
        //     $page++;
        // }
        // $dest = "sigep/".date('m').'/'.rand()."_grupo.pdf";
        // $pdf->Output($dest, 'I');

    public function plp() {

        if ($this->input->post('massa')) {
          if (!$this->input->post('etiquetas')) {
              $this->session->set_flashdata('error', "Metodo Invalido");
             redirect('admin/etiqueta/');
          }
          $itens = $this->input->post('etiquetas');
          $busca = $this->db->where_in('id_etiquetas', $itens)->get('etiquetas')->result();
          include_once APPPATH.'/third_party/pdfmerger/PDFMerger.php';
          $pdf = new PDFMerger\PDFMerger;
          foreach ($busca as $c) {
            $pdf->addPDF($c->caminho, 'all');
           }
          $pdf->merge('browser', 'sigep/'.rand().'-massa.pdf'); // generate the file
            exit;
        }else if($this->input->post('a4')){
            if (!$this->input->post('etiquetas')) {
                $this->session->set_flashdata('error', "Metodo Invalido");
               redirect('admin/etiqueta/');
            }
            $itens = $this->input->post('etiquetas');
            $busca = $this->db->where_in('id_etiquetas', $itens)->get('etiquetas')->result();
            include_once APPPATH.'/third_party/mpdf/mpdf.php';
            $pdf = new mPDF('P', 'mm', 'Letter');
            $pdf->SetImportUse();
            $i = 0;
            foreach ($busca as $a => $c) {
              $pagecount = $pdf->SetSourceFile($c->caminho);
              if ($i == 4) {
                $i = 0;
                $pdf->AddPage();
                $a = $pdf->ImportPage($pagecount, '/MediaBox');
              }else{
                $a = $pdf->ImportPage($pagecount, '/MediaBox');
              }
              switch ($i) {
                case 0:
                    $pdf->useTemplate($a, 4, 147, 100, 138, true);
                    break;
                case 1:
                    $pdf->useTemplate($a, 4, 7, 100, 138, true);
                    break;
                case 2:
                    $pdf->useTemplate($a, 106, 7, 100, 138, true);
                    break;
                case 3:
                    $pdf->useTemplate($a, 106, 147, 100, 138, true);
                    break;
              }
              $i++;
            }
            $dest = "sigep/".date('m').'/'.rand()."_grupo.pdf";
            $pdf->Output($dest, 'I');
             exit;
        }

        $a_p = $this->db->where('id', 1)->get('admin_preferences')->row();
        define('AMBIENTE', $a_p->ambiente);
        define('USUARIO', $a_p->usuario);
        define('SENHA', $a_p->senha);
        define('CONTRATO', $a_p->numeroContrato);
        define('CODADMIN', $a_p->codAdministrativo);
        define('CARTAO', $a_p->cartaoPostagem);
        define('CNPJ', $a_p->cnpjEmpresa);
        define('ANO_CONTRATO', $a_p->anoContrato);
        define('ID_DIRETORIA', $a_p->diretoria);
        define('ATENDE_CLIENTE', base_url().'AtendeCliente.xml');
        include_once APPPATH."/third_party/Sigep/bootstrap.php";
        include_once APPPATH."/third_party/Sigep/src/PhpSigep/Pdf/php-sigep-fpdf/src/autoload.php";

        $this->data['ambiente'] = $a_p->ambiente;

        if (!$this->input->post('etiquetas')) {
            $this->session->set_flashdata('error', "Metodo Invalido");
           redirect('admin/etiqueta/');
        }
        $itens = $this->input->post('etiquetas');
        $busca = $this->db->where_in('id_etiquetas', $itens)->join('enderecos', 'id = Remetente')->get('etiquetas')->result();
        $et = array();
        foreach ($busca as $v) {
            $dimensao = new \PhpSigep\Model\Dimensao();
            $dimensao->setAltura($v->altura);
            $dimensao->setLargura($v->largura);
            $dimensao->setComprimento($v->comprimento);
            $dimensao->setDiametro($v->diametro);
            $dimensao->setTipo(\PhpSigep\Model\Dimensao::TIPO_PACOTE_CAIXA);

            $destinatario = new \PhpSigep\Model\Destinatario();
            $destinatario->setNome($v->dest_title);
            $destinatario->setLogradouro($v->dest_rua);
            $destinatario->setNumero($v->dest_num);
            $destinatario->setComplemento($v->dest_complemento);

            $destino = new \PhpSigep\Model\DestinoNacional();
            $destino->setBairro($v->dest_bairro);
            $destino->setCep($v->dest_cep);
            $destino->setCidade($v->dest_cidade);
            $destino->setUf($v->dest_estado);
            $destino->setNumeroNotaFiscal($v->dest_nfe);
            $destino->setNumeroPedido($v->pedido_id);

            $servicoAdicional = new \PhpSigep\Model\ServicoAdicional();
            $servicoAdicional->setCodigoServicoAdicional($v->adicional);
            $servicoAdicional->setValorDeclarado($v->valor);

            $remetente = new \PhpSigep\Model\Remetente();
            $remetente->setNome($v->title);
            $remetente->setLogradouro($v->rua);
            $remetente->setNumero($v->num);
            $remetente->setComplemento($v->complemento);
            $remetente->setBairro($v->bairro);
            $remetente->setCep($v->cep);
            $remetente->setUf($v->estado);
            $remetente->setCidade($v->cidade);
            $remetente->setTelefone($v->fone);

            $etiqueta = new \PhpSigep\Model\Etiqueta();
            $etiqueta->setEtiquetaSemDv($v->sem_dev);
            $encomenda = new \PhpSigep\Model\ObjetoPostal();
            $encomenda->setServicosAdicionais(array($servicoAdicional));
            $encomenda->setDestinatario($destinatario);
            $encomenda->setDestino($destino);
            $encomenda->setDimensao($dimensao);
            $encomenda->setEtiqueta($etiqueta);
            $encomenda->setPeso($v->peso);// 500 gramas
            $encomenda->setServicoDePostagem(new \PhpSigep\Model\ServicoDePostagem($v->servico));//41068
            $et[] = $encomenda;
        }

            $plp = new \PhpSigep\Model\PreListaDePostagem();
            $plp->setAccessData(new \PhpSigep\Model\AccessDataHomologacao());
            $plp->setEncomendas($et);
            $plp->setRemetente($remetente);
            $params = $plp;
            $phpSigep = new PhpSigep\Services\SoapClient\Real();
            $fecha_plp = $phpSigep->fechaPlpVariosServicos($params);
            if ($fecha_plp->getErrorCode() === 0) {
                $this->session->set_flashdata('error', $fecha_plp->getErrorMsg());
                redirect('admin/etiqueta/');
                exit;
            }else{
                $idplp =  $fecha_plp->getResult()->getIdPlp();
                $itens = $this->input->post('etiquetas');
                foreach ($itens as $k => $v) {
                   $this->db->update('etiquetas', array('idplp' => $idplp, 'status' => 1), array('id_etiquetas' => $v));
                }
                $pdf = new \PhpSigep\Pdf\ListaDePostagem_2017($params, $idplp);
                if (!file_exists("sigep/plp/".date('m'))) {mkdir('sigep/plp/'.date('m'), 0777, true);}
                $file = "sigep/plp/".date('m').'/'.$idplp.".pdf";
                $pdf->render('F', $file);// I = mostra na tela   F = salvar na pasta
                $dados = array(
                    'numero' => $idplp,
                    'caminho' => $file,
                    'data_hora' => date('d-m-Y H:i:s'),
                    'status' => 1,
                    'user_id' => $this->session->userdata('user_id'),
                );
                $this->db->insert('plp', $dados);
                $itens = $this->input->post('etiquetas');
                header("Content-type:application/pdf");
                readfile($file);
            }
    }

    public function novo_endereco()
    {
        if ( ! $this->ion_auth->logged_in() )
        {
            redirect('auth', 'refresh');
        }
        else
        {
            if ($this->input->post()) {
                // set validation rules
                $this->form_validation->set_rules('cep', 'Cep', 'trim|required');
                $this->form_validation->set_rules('rua', 'Logradouro', 'trim|required');
                $this->form_validation->set_rules('num', 'Numero', 'trim');
                $this->form_validation->set_rules('bairro', 'Bairro', 'trim|required');
                $this->form_validation->set_rules('cidade', 'Cidade', 'trim|required');
                $this->form_validation->set_rules('estado', 'Estado', 'trim|required');
                $this->form_validation->set_rules('complemento', 'Complemento', 'trim');
                $this->form_validation->set_rules('contato', 'Nome do Contato', 'trim');
                $this->form_validation->set_rules('fone', 'Telefone de Contato', 'trim');
                $this->form_validation->set_rules('title', 'Titulo', 'trim');
                if ($this->form_validation->run() == true) {
                    $dados = array(
                        'cep' => $this->input->post('cep'),
                        'rua' => $this->input->post('rua'),
                        'num' => $this->input->post('num'),
                        'bairro' => $this->input->post('bairro'),
                        'cidade' => $this->input->post('cidade'),
                        'estado' => $this->input->post('estado'),
                        'complemento' => $this->input->post('complemento'),
                        'contato' => $this->input->post('contato'),
                        'fone' => $this->input->post('fone'),
                        'title' => $this->input->post('title'),
                        'tipo' => $this->input->post('tipo'),
                        'user' => $this->session->userdata('user_id'),
                        'status' => 1,
                        'data_cadastro' => date('Y-m-d H:i:s'),
                    );
                   if ($this->db->insert('enderecos', $dados)) {
                      $this->session->set_flashdata('successo', 'Endereço Cadastrado Com sucesso!!!');                
                   } else{
                        $this->session->set_flashdata('error', "Erro ao cadastrar. tente novamente!!!");
                   }             
                }else{
                   $this->session->set_flashdata('error', validation_errors());
                }
            }
            redirect('admin/etiqueta/');
        }
    }
    public function editar_endereco()
    {
        if ( ! $this->ion_auth->logged_in() )
        {
            redirect('auth', 'refresh');
        }
        else
        {
            if ($this->input->post()) {
                $id = $this->uri->segment(4);
                $this->form_validation->set_rules('cep', 'Cep', 'trim|required');
                $this->form_validation->set_rules('rua', 'Logradouro', 'trim|required');
                $this->form_validation->set_rules('num', 'Numero', 'trim');
                $this->form_validation->set_rules('bairro', 'Bairro', 'trim|required');
                $this->form_validation->set_rules('cidade', 'Cidade', 'trim|required');
                $this->form_validation->set_rules('estado', 'Estado', 'trim|required');
                $this->form_validation->set_rules('complemento', 'Complemento', 'trim');
                $this->form_validation->set_rules('contato', 'Nome do Contato', 'trim');
                $this->form_validation->set_rules('fone', 'Telefone de Contato', 'trim');
                $this->form_validation->set_rules('title', 'Titulo', 'trim');
                if ($this->form_validation->run() == true) {
                    $dados = array(
                        'cep' => $this->input->post('cep'),
                        'rua' => $this->input->post('rua'),
                        'num' => $this->input->post('num'),
                        'bairro' => $this->input->post('bairro'),
                        'cidade' => $this->input->post('cidade'),
                        'estado' => $this->input->post('estado'),
                        'complemento' => $this->input->post('complemento'),
                        'contato' => $this->input->post('contato'),
                        'fone' => $this->input->post('fone'),
                        'title' => $this->input->post('title'),
                    );
                   $this->db->update('enderecos', $dados, array('id' => $id));
                   $this->session->set_flashdata('successo', 'Endereço Atualizado Com sucesso!!!');
                    redirect('admin/etiqueta/');
                }else{
                   $this->session->set_flashdata('successo', validation_errors());
                   redirect('admin/etiqueta/');
                }
            }
        }
    }
    // public function emitir() {

    //   if( $_SERVER['REQUEST_METHOD']== 'POST' ) {
    //       $hash = md5( implode( $_POST ) );
    //       if(isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ) {
    //         redirect('admin/etiqueta/');
    //         exit;
    //       } else {
    //           $_SESSION['hash']  = $hash;
    //         if ($this->input->post()) {
    //             $this->form_validation->set_rules('altura', 'altura', 'trim|required');
    //             $this->form_validation->set_rules('largura', 'largura', 'trim|required');
    //             $this->form_validation->set_rules('comprimento', 'comprimento', 'trim|required');
    //             $this->form_validation->set_rules('peso', 'peso', 'trim|required');
    //             $this->form_validation->set_rules('servico', 'servico', 'trim');
    //             $this->form_validation->set_rules('valor', 'valor', 'trim');
    //             $this->form_validation->set_rules('dest_title', 'dest_title', 'trim');
    //             $this->form_validation->set_rules('dest_rua', 'dest_rua', 'trim|required');
    //             $this->form_validation->set_rules('dest_num', 'dest_num', 'trim');
    //             $this->form_validation->set_rules('dest_complemento', 'dest_complemento', 'trim');
    //             $this->form_validation->set_rules('dest_bairro', 'dest_bairro', 'trim|required');
    //             $this->form_validation->set_rules('dest_cep', 'dest_cep', 'trim|required');
    //             $this->form_validation->set_rules('dest_cidade', 'dest_cidade', 'trim|required');
    //             $this->form_validation->set_rules('dest_estado', 'dest_estado', 'trim|required');
    //             if ($this->form_validation->run() == true) {
    //                 $remetente = $this->db->where('id', $this->input->post('remetente'))->get('enderecos')->row();
    //                 $dados = array(
    //                     'remetente' => $remetente,
    //                     'altura' => $this->input->post('altura'),
    //                     'user_id' => $this->session->userdata('user_id'),
    //                     'largura' => $this->input->post('largura'),
    //                     'comprimento' => $this->input->post('comprimento'),
    //                     'peso' => $this->input->post('peso'),
    //                     'servico' => $this->input->post('servico'),
    //                     'quant' => 1,
    //                     'adicional' => $this->input->post('adicional'),///'025'
    //                     'valor' => $this->input->post('valor'),
    //                     'diamentro' => $this->input->post('diamentro'),
    //                     'dest_title' => $this->input->post('dest_title'),
    //                     'dest_rua' => $this->input->post('dest_rua'),
    //                     'dest_num' => $this->input->post('dest_num'),
    //                     'dest_complemento' => $this->input->post('dest_complemento'),
    //                     'dest_bairro' => $this->input->post('dest_bairro'),
    //                     'dest_cep' => $this->input->post('dest_cep'),
    //                     'dest_cidade' => $this->input->post('dest_cidade'),
    //                     'dest_estado' => $this->input->post('dest_estado'),
    //                     'dest_nfe' => $this->input->post('dest_nfe'),
    //                     'pedido_id' => rand(),
    //                     'dt_emissao' => date('d-m-Y H:i:s'),
    //                 );
    //                 $params = $this->helper($dados);
    //                 var_dump($params);
    //                 exit;
    //                 $phpSigep = new PhpSigep\Services\SoapClient\Real();
    //                 $logoFile = 'assets/image/logosigep.png';
    //                 $layoutChancela = array('pac');
    //                 $pdf = new \PhpSigep\Pdf\CartaoDePostagem2018($params, $IdPlp, $logoFile, $layoutChancela);
    //                 if (!file_exists("sigep/".date('m'))) {mkdir('sigep/'.date('m'), 0777, true);}
    //                 $file = "sigep/".date('m').'/'.rand().".pdf";
    //                 $pdf->render('F', $file);// I = mostra na tela   F = salvar na pasta
    //                 $dados['remetente'] = $this->input->post('remetente');
    //                 $dados['codigo'] = $params->getEncomendas()[0]->getEtiqueta()->getEtiquetaComDv();
    //                 $dados['sem_dev'] = $params->getEncomendas()[0]->getEtiqueta()->getEtiquetaSemDv();
    //                 $dados['caminho'] = $file;
    //                 $this->db->insert('etiquetas', $dados);
    //                 header("Content-type:application/pdf");
    //                 readfile($file);
    //             }else{
    //                 echo validation_errors();
    //             }
    //         }
    //       }
    //    }
    // }





    public function helper($dados){

        $dimensao = new \PhpSigep\Model\Dimensao();
        $dimensao->setAltura($dados['altura']);
        $dimensao->setLargura($dados['largura']);
        $dimensao->setComprimento($dados['comprimento']);
        $dimensao->setDiametro($dados['diametro']);
        $dimensao->setTipo(\PhpSigep\Model\Dimensao::TIPO_PACOTE_CAIXA);

        $destinatario = new \PhpSigep\Model\Destinatario();
        $destinatario->setNome($dados['dest_title']);
        $destinatario->setLogradouro($dados['dest_rua']);
        $destinatario->setNumero($dados['dest_num']);
        $destinatario->setComplemento($dados['dest_complemento']);
        $destino = new \PhpSigep\Model\DestinoNacional();
        $destino->setBairro($dados['dest_bairro']);
        $destino->setCep($dados['dest_cep']);
        $destino->setCidade($dados['dest_cidade']);
        $destino->setUf($dados['dest_estado']);

        $destino->setNumeroNotaFiscal($dados['dest_nfe']);
        $destino->setNumeroPedido($dados['pedido_id']);

        $servicoAdicional = new \PhpSigep\Model\ServicoAdicional();
        $servicoAdicional->setCodigoServicoAdicional($dados['adicional']);
        $servicoAdicional->setValorDeclarado($dados['valor']);

        $remetente = new \PhpSigep\Model\Remetente();
        $remetente->setNome($dados['remetente']->title);
        $remetente->setLogradouro($dados['remetente']->rua);
        $remetente->setNumero($dados['remetente']->num);
        $remetente->setComplemento($dados['remetente']->complemento);
        $remetente->setBairro($dados['remetente']->bairro);
        $remetente->setCep($dados['remetente']->cep);
        $remetente->setUf($dados['remetente']->estado);
        $remetente->setCidade($dados['remetente']->cidade);
        $remetente->setTelefone($dados['remetente']->fone);
        $params = new \PhpSigep\Model\SolicitaEtiquetas();
        $params->setQtdEtiquetas($dados['quant']);
        $params->setServicoDePostagem(new \PhpSigep\Model\ServicoDePostagem($dados['servico']));
        $params->setAccessData(new \PhpSigep\Model\AccessDataHomologacao());
        $phpSigep = new PhpSigep\Services\SoapClient\Real();
        $phpSigep = $phpSigep->solicitaEtiquetas($params);
        $busca = $phpSigep->getResult();
        if ($phpSigep->getErrorCode() != null) {
            echo "<p style='color:red;'>".$phpSigep->getErrorMsg()."</p>";
            exit;
        }
        $et = array();
        foreach ($busca as $v) {
            $etiqueta = new \PhpSigep\Model\Etiqueta();
            $etiqueta->setEtiquetaSemDv($v->getEtiquetaSemDv());
            $encomenda = new \PhpSigep\Model\ObjetoPostal();
            $encomenda->setServicosAdicionais(array($servicoAdicional));
            $encomenda->setDestinatario($destinatario);
            $encomenda->setDestino($destino);
            $encomenda->setDimensao($dimensao);
            $encomenda->setEtiqueta($etiqueta);
            $encomenda->setPeso($dados['peso']);// 500 gramas
            $encomenda->setServicoDePostagem(new \PhpSigep\Model\ServicoDePostagem($dados['servico']));//41068
            $et[] = $encomenda;
        }
        $plp = new \PhpSigep\Model\PreListaDePostagem();
        $plp->setAccessData(new \PhpSigep\Model\AccessDataHomologacao());
        $plp->setEncomendas($et);
        $plp->setRemetente($remetente);
        return $plp;
    }

}
