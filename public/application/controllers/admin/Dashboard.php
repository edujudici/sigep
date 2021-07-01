<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
    }


	public function index()
	{
        if ( ! $this->ion_auth->logged_in() OR !$this->ion_auth->is_acesso('user_panel'))
        {
            $this->session->set_flashdata('error', "Não tem permissão para fazer isso!!!");
            redirect('', 'refresh');
        }
        else
        {
            /* Title Page */
            $this->page_title->push(lang('menu_dashboard'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            if ($this->ion_auth->is_admin()) {
                $this->data['plp']       = $this->db->get('plp')->num_rows();
                $this->data['etiquetas']       = $this->db->get('etiquetas')->num_rows();
                $this->data['etiqueta']       = $this->db->join('enderecos', 'id = remetente')->get('etiquetas')->result();
            } else {
                $this->data['plp']       = $this->db->where('user_id', $this->session->userdata('user_id'))->get('plp')->num_rows();
                $this->data['etiquetas']       = $this->db->where('user_id', $this->session->userdata('user_id'))->get('etiquetas')->num_rows();
                $this->data['etiqueta']       = $this->db->where('user_id', $this->session->userdata('user_id'))->join('enderecos', 'id = remetente')->get('etiquetas')->result();
                $this->data['noadmin'] = 'hidden';
            }           
            
            $this->data['count_users']       = $this->dashboard_model->get_count_record('users');
            $this->data['count_groups']      = $this->dashboard_model->get_count_record('groups');
            $this->data['disk_totalspace']   = $this->dashboard_model->disk_totalspace(DIRECTORY_SEPARATOR);
            $this->data['disk_freespace']    = $this->dashboard_model->disk_freespace(DIRECTORY_SEPARATOR);
            $this->data['disk_usespace']     = $this->data['disk_totalspace'] - $this->data['disk_freespace'];
            $this->data['disk_usepercent']   = $this->dashboard_model->disk_usepercent(DIRECTORY_SEPARATOR, FALSE);
            $this->data['memory_usage']      = $this->dashboard_model->memory_usage();
            $this->data['memory_peak_usage'] = $this->dashboard_model->memory_peak_usage(TRUE);
            $this->data['memory_usepercent'] = $this->dashboard_model->memory_usepercent(TRUE, FALSE);

            /* Load Template */
            $this->template->admin_render('admin/dashboard/index', $this->data);
        }
	}


}
