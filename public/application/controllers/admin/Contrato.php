<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contrato extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('admin/preferences_model');
        $this->lang->load('admin/preferences');

        $this->breadcrumbs->unshift(1, "Contrato", 'admin/contrato');
    }


	public function index()
	{
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', "Não tem permissão para fazer isso!!!");
            redirect('auth/login', 'refresh');
        }
        else
        {
            $this->data['pagetitle'] = "<h1>Contrato</h1>";
            $this->data['breadcrumb'] = '';
            $this->data['perf'] = $this->db->where('id', 1)->get('admin_preferences')->row();
            $this->template->admin_render('admin/prefs/index', $this->data);
        }
	}


	public function up_dados()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
            $this->session->set_flashdata('error', "Não tem permissão para fazer isso!!!");
			redirect('auth', 'refresh');
		}
        else
        {
            $data = array(
                'ambiente'  => $this->input->post('ambiente'),
                'usuario' => $this->input->post('usuario'),
                'senha' => $this->input->post('senha'),
                'numeroContrato' => $this->input->post('numeroContrato'),
                'cartaoPostagem' => $this->input->post('cartaoPostagem'),
                'codAdministrativo' => $this->input->post('codAdministrativo'),
                'cnpjEmpresa' => $this->input->post('cnpjEmpresa'),
                'anoContrato' => $this->input->post('anoContrato'),
                'diretoria' => $this->input->post('diretoria'),
                'ultimo_update' => date('d-m-Y H:i')
            );

            $this->preferences_model->update_interfaces('admin_preferences', $data);
             $this->session->set_flashdata('successo', "Dados Atualizados com sucesso!!!");
            redirect('admin/contrato/', 'refresh');
        }
	}


}
