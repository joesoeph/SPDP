<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends Parent_Controller
{

	protected $arrAccessMenu;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->library('form_validation');
		$this->arrAccessMenu = $this->session->userdata('access_menu')[6];
    }

    public function index()
    {
      $this->Content = 'content/users_list';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      if($this->session->userdata('role') != 1){
        redirect(site_url('Users/update/'.$this->session->userdata('user_id')));
      } else {
        $Datas['ArrData'] = $this->Users_model->get_all();
      }
      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/users_form';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->Users_model->get_by_id($id);
      if ($row) {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('Users/create_action'),
          		'name' => $row->name,
          		'username' => $row->username,
          		'email' => $row->email,
          		'password' => $row->password,
          		'role' => $row->role,
              'JabatanId' => $row->JabatanId,
              'TtdHard' => $row->TtdHard,
              'CreatedDate' => $row->CreatedDate,
          		'CreatedByUserId' => $row->CreatedByUserId,
          		'LastChangedDate' => $row->LastChangedDate,
          		'LastChangedByUserId' => $row->LastChangedByUserId,
          		'DeletedDate' => $row->DeletedDate,
          		'DeletedUserId' => $row->DeletedUserId,
          		'activation' => $row->activation,
          	);
          $Datas['DataJabatan'] = $this->Users_model->getDataJabatan($id);
          $Datas['DataRole'] = $this->Users_model->RoleSelected($id, 'users', 'id');
          $this->Layouts($Datas);
      } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('users'));
      }
    }

    public function create()
    {
      $this->Content = 'content/users_form';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $Datas['ArrData'] = array(
          'button' => 'Create',
          'action' => site_url('Users/create_action'),
    	    'id' => set_value('id'),
    	    'name' => set_value('name'),
    	    'username' => set_value('username'),
    	    'email' => set_value('email'),
    	    'password' => set_value('password'),
    	    'role' => set_value('role'),
          'JabatanId' => set_value('JabatanId'),
          'TtdHard' => set_value('TtdHard'),
          'CreatedByUserId' => '',
          'CreatedDate' => '',
          'LastChangedDate' => '',
          'LastChangedByUserId' => '',
          'DeletedUserId' => '',
          'DeletedDate' => '',
    	    'activation' => set_value('activation'),
    	);

      $Datas['DataJabatan'] = $this->Users_model->getDataJabatan();
      $Datas['DataRole'] = $this->Users_model->RoleSelected('', 'users', 'id');

    $this->Layouts($Datas);
    }

    public function create_action()
    {
      $this->_rules();

      if ($this->form_validation->run() == FALSE) {
        $this->create();
      } else {
        if (empty($_FILES['TtdHard']['name'])) {
          $data = array(
          		'name' => $this->input->post('name',TRUE),
          		'username' => $this->input->post('username',TRUE),
          		'email' => $this->input->post('email',TRUE),
          		'password' => md5($this->input->post('password',TRUE)),
          		'role' => $this->input->post('role',TRUE),
              'JabatanId' => $this->input->post('JabatanId',TRUE),
              'CreatedDate' => date("Y-m-d H:i:s"),
              'CreatedByUserId' => $this->session->userdata('user_id')
    	    );
          $this->Users_model->insert($data);
        } else {
          $config['upload_path'] = './upload/ttd';
          $config['allowed_types'] = '*';
          $config['file_name'] = 'LPS - '.$uniq1 = uniqid().$uniq2 = uniqid().".png";
          $this->load->library('upload', $config);

          if ($this->upload->do_upload('TtdHard')) {
              $data = array(
            		'name' => $this->input->post('name',TRUE),
            		'username' => $this->input->post('username',TRUE),
            		'email' => $this->input->post('email',TRUE),
            		'password' => md5($this->input->post('password',TRUE)),
            		'role' => $this->input->post('role',TRUE),
                'JabatanId' => $this->input->post('JabatanId',TRUE),
                'TtdHard' => $this->upload->data()['orig_name'],
                'CreatedDate' => date("Y-m-d H:i:s"),
                'CreatedByUserId' => $this->session->userdata('user_id')
      	    );
            $this->Users_model->insert($data);
          } else {
            echo $this->upload->display_errors('<p>', '</p>');
          }
        }

        $this->session->set_flashdata('message', 'Data disimpan');
      }

    }

    public function update($id)
    {
      $this->Content = 'content/users_form';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->Users_model->get_by_id($id);

      if ($row) {
        $Datas['ArrData'] = array(
          'button' => 'Perbarui',
          'action' => site_url('Users/update_action/'.$id),
      		'id' => set_value('id', $row->id),
      		'name' => set_value('name', $row->name),
      		'username' => set_value('username', $row->username),
      		'email' => set_value('email', $row->email),
      		'password' => set_value('password', $row->password),
      		'role' => set_value('role', $row->role),
          'JabatabId' => set_value('JabatanId', $row->role),
          'TtdHard' => set_value('TtdHard', $row->role),
          'CreatedByUserId' => $row->CreatedByUserId,
          'CreatedDate' => $row->CreatedDate,
          'LastChangedDate' => $row->LastChangedDate,
          'LastChangedByUserId' => $row->LastChangedByUserId,
          'DeletedUserId' => $row->DeletedUserId,
          'DeletedDate' => $row->DeletedDate,
      		'activation' => set_value('activation', $row->activation),
	      );

        $Datas['DataJabatan'] = $this->Users_model->getDataJabatan($id);
        $Datas['DataRole'] = $this->Users_model->RoleSelected($id, 'users', 'id');

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('users'));
      }

    }

    public function update_action($id)
    {
        $this->_rules();


        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $config['upload_path'] = './upload/ttd';
            $config['allowed_types'] = '*';
            $config['file_name'] = 'LPS - '.$uniq1 = uniqid().$uniq2 = uniqid().".png";

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('TtdHard')) {
              $data = array(
            		'name' => $this->input->post('name',TRUE),
            		'username' => $this->input->post('username',TRUE),
            		'email' => $this->input->post('email',TRUE),
            		'activation' => 'Active',
            		'role' => $this->input->post('role',TRUE),
                'JabatanId' => $this->input->post('JabatanId',TRUE),
                'LastChangedDate' => date("Y-m-d H:i:s"),
                'LastChangedByUserId' => $this->session->userdata('user_id'),
              );
            } else {
              $userfile = $this->upload->data();
              $data = array(
            		'name' => $this->input->post('name',TRUE),
            		'username' => $this->input->post('username',TRUE),
            		'email' => $this->input->post('email',TRUE),
            		'activation' => 'Active',
            		'role' => $this->input->post('role',TRUE),
                'JabatanId' => $this->input->post('JabatanId',TRUE),

                'LastChangedDate' => date("Y-m-d H:i:s"),
                'LastChangedByUserId' => $this->session->userdata('user_id'),
              );
            }

          echo 'berhasil';

          $this->Users_model->update($id, $data);
          $this->session->set_flashdata('message', 'Data diperbarui');
          // redirect(site_url('users'));
        }
    }

    public function delete($Id)
    {
      if($this->arrAccessMenu['Delete']){
        $row = $this->Users_model->get_by_id($Id);

        if ($row) {
          $data = array(
            'DeletedDate' => date('Y-m-d H:i:s'),
            'DeletedUserId' => $this->session->userdata('user_id')
          );

          $this->Users_model->update($row->id, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('Users'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Users'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Users'));
      }
    }

    public function _rules()
    {
    	$this->form_validation->set_rules('name', 'name', 'trim|required');
    	$this->form_validation->set_rules('username', 'username', 'trim|required');
    	$this->form_validation->set_rules('email', 'email', 'trim|required');
    	$this->form_validation->set_rules('password', 'password', 'trim|required');
    	$this->form_validation->set_rules('role', 'role', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
      $this->form_validation->set_rules('JabatanId', 'jabatanid', 'trim|required');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-13 12:01:35 */
/* http://harviacode.com */
