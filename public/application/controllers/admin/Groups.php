<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('admin/groups');
		$this->lang->load('admin/preferences');
        /* Title Page :: Common */
        $this->page_title->push(lang('menu_security_groups'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_security_groups'), 'admin/groups');

    }


	public function index()
	{
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', "Não tem permissão para fazer isso!!!");
			redirect('', 'refresh');
        }
        else
        {
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->data['groups'] = $this->ion_auth->groups()->result();

            /* Load Template */
            $this->template->admin_render('admin/groups/index', $this->data);
        }
    }


	public function create()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_groups_create'), 'admin/groups/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Validate form input */
		$this->form_validation->set_rules('group_name', 'lang:create_group_validation_name_label', 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id)
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('admin/groups', 'refresh');
			}
		}
		else
		{
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('group_name')
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('description')
			);

            /* Load Template */
            $this->template->admin_render('admin/groups/create', $this->data);
		}
	}


	public function delete()
	{


        if ( ! $this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif ( ! $this->ion_auth->is_admin())
		{
            echo('Você deve ser um administrador para visualizar esta página.');
        }
        else 
        {
        	$id = $this->uri->segment(4);
        	$verifica = $this->db->where('group_id', $id)->get('users_groups')->result();
        	if (count($verifica) > 0) {
				$this->session->set_flashdata('error', "Este grupo não pode ser excluido pois está vinculado a outro usuario!!!");
        	} else {
				$this->session->set_flashdata('successo', "Excluirdo com Sucesso");
				$this->db->delete('groups', array('id' => $id));
        	}        	
			redirect('admin/groups', 'refresh');
        }
	}


	public function edit($id)
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin() OR ! $id OR empty($id))
		{
			redirect('auth', 'refresh');
		}

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_groups_edit'), 'admin/groups/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Variables */
		$group = $this->ion_auth->group($id)->row();

		/* Validate form input */
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && ! empty($_POST))
		{
			if ($this->form_validation->run() == TRUE)
			{
				$dados = array(
					'bgcolor' => $_POST['group_bgcolor'],
					'user_panel' => $_POST['user_panel'],
					'sidebar_form' => $_POST['sidebar_form'],
					'messages_menu' => $_POST['messages_menu'],
					'user_menu' => 1,
					'tasks_menu' => $_POST['tasks_menu'],
					'ctrl_sidebar' => $_POST['ctrl_sidebar'],
					'transition_page' => $_POST['transition_page'],
					'tags' => $_POST['tags'],
					'plp' => $_POST['plp'],
					'reports' => $_POST['reports'],
					'ban' => $_POST['ban'],
				);
				
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if ($group_update)
				{
					$this->session->set_flashdata('successo', $this->lang->line('edit_group_saved'));
                    $this->db->update('groups', $dados, 'id = '.$id);
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
				}

				redirect('admin/groups', 'refresh');
			}
		}

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['group']   = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'type'    => 'text',
			'name'    => 'group_name',
			'id'      => 'group_name',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
            'class'   => 'form-control',
			$readonly => $readonly
		);
		$this->data['group_description'] = array(
			'type'  => 'text',
			'name'  => 'group_description',
			'id'    => 'group_description',
			'value' => $this->form_validation->set_value('group_description', $group->description),
            'class' => 'form-control'
		);
		$this->data['group_bgcolor'] = array(
			'type'     => 'text',
			'name'     => 'group_bgcolor',
			'id'       => 'group_bgcolor',
			'value'    => $this->form_validation->set_value('group_bgcolor', $group->bgcolor),
			'data-src' => $group->bgcolor,
            'class'    => 'form-control'
		);

        /* Load Template */
        $this->template->admin_render('admin/groups/edit', $this->data);
	}
}
