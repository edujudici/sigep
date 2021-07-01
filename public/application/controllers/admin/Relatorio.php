<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Title Page :: Common */
        $this->page_title->push('Relatorio');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'relatorio', 'admin/relatorio');
    }


	public function index()
	{
		if ( ! $this->ion_auth->logged_in() OR !$this->ion_auth->is_acesso('reports'))
		{
            $this->session->set_flashdata('error', "Não tem permissão para fazer isso!!!");
            redirect('', 'refresh');
		}
        else
        { 
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            $this->data['plps'] = $this->db->where('user_id', $this->session->userdata('user_id'))->get('plp')->result();
            $this->data['etiqueta'] = $this->db->join('enderecos', 'enderecos.id = remetente')->order_by("id_etiquetas", "desc")->where('user_id', $this->session->userdata('user_id'))->get('etiquetas')->result();
            $this->template->admin_render('admin/relatorio/index', $this->data);
        }
	}
}
