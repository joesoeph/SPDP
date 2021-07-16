<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class UserRoles extends Parent_Controller {

	protected $arrAccessMenu;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Users_model','ListDataModel','AuthModel'));
		$this->arrAccessMenu = $this->session->userdata('access_menu')[7];
	}

	public function index()
	{
		$this->Content = 'content/UserRoleList';
		$arrData['AddCss'] = [
								'assets/css/datatables/dataTables.bootstrap.css', 
								'assets/css/datepicker/datepicker3.css'
							 ];
		$arrData['AddJsHeader'] = '';
		$arrData['AddJsFooter'] = [
									'assets/js/jquery.dataTables.min.js',
									'assets/js/plugins/datepicker/bootstrap-datepicker.js'
								  ];
		$arrData['JsInit'] = '';

		$this->Layouts($arrData);	
	}

	public function ListData(){
	    $sql = "SELECT a.* FROM  roles a WHERE a.Active <> 0";

	    $column_order = array(
	      'a.RoleName', 
	      'a.RoleDesc',
	      'a.RoleName'
	    );
	    
	    $column_search = array(
	      'a.RoleName', 
	      'a.RoleDesc'
	    ); 
	    $order = array('a.RoleId' => 'ASC');

		$list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
	    $data = array();
	    foreach ($list as $val) {
	        $row = array();
	        $row[] = $val->RoleName;
	        $row[] = $val->RoleDesc;
	        $row[] = '<a href="javascript:formModal(\''.$val->RoleId.'\');">
	        			<i class="glyphicon glyphicon-pencil"></i></a>
	                    &nbsp;
	                  <a href="'.base_url('UserRoles/Delete/'.$val->RoleId).'" onclick="javasciprt: return confirm(\'Anda yakin ?\')">
	                  	<i class="glyphicon glyphicon-remove"></i></a>';
	        $data[] = $row;
	    }

        $Result = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->ListDataModel->count_all($sql),
                    "recordsFiltered" => $this->ListDataModel->count_filtered($sql, $column_search, $column_order, $order),
                    "data" => $data,
        );
	    //keluarin pake json format
	    echo json_encode($Result);
	}

	function Store($id = NULL){
		$res = FALSE;
        $this->_rules();

        if($id){ // store update
        	$arrAccessMenu = $this->session->userdata('access_menu');
	        if($this->arrAccessMenu['Update']){
	        	if ($this->form_validation->run() == FALSE) {
		            $msg = 'Data tidak lengkap';
		        } else {
		            $data = array(
					   	'RoleName' => $this->input->post('RoleName', TRUE),
					    'RoleDesc' => $this->input->post('RoleDesc', TRUE)
		          	);

		            $this->Users_model->UpdateUserRoles($id, $data);
		            for($i=1; $i<=$this->input->post('TotalMenu', TRUE); $i++){
			            
			            $data = array(
			            			'Write' => ($this->input->post('Write'.$i, TRUE) == 'on' ? 1 : 0),
			            			'Read' => ($this->input->post('Read'.$i, TRUE) == 'on' ? 1 : 0),
			            			'Update' => ($this->input->post('Update'.$i, TRUE) == 'on' ? 1 : 0),
			            			'Delete' => ($this->input->post('Delete'.$i, TRUE) == 'on' ? 1 : 0)
			            		);

			            $this->AuthModel->updateAccessMenu($id, $this->input->post('MenuId'.$i, TRUE), $data);
		            }
		            $res = TRUE;
		            $msg = 'Data updated';
		        }
		    } else {
	      		$msg = 'You dont have access update';
	    	}
        }else{ // strore Write new
        	$arrAccessMenu = $this->session->userdata('access_menu');
	        if($this->arrAccessMenu['Write']){
	        	if ($this->form_validation->run() == FALSE) {
		            $msg = 'Data tidak lengkap';
		        } else {
		            $data = array(
					   	'RoleName' => $this->input->post('RoleName', TRUE),
					    'RoleDesc' => $this->input->post('RoleDesc', TRUE),
					    'Active'   => 1
		          	);

		            $this->Users_model->InsertUserRoles($data);
		            $RoleId = $this->db->insert_id();
		            for($i=1; $i<=$this->input->post('TotalMenu', TRUE); $i++){
			            
			            $data = array(
			            			'RoleId' => $RoleId,
			            			'MenuId' => $this->input->post('MenuId'.$i, TRUE),
			            			'Write' => ($this->input->post('Write'.$i, TRUE) == 'on' ? 1 : 0),
			            			'Read' => ($this->input->post('Read'.$i, TRUE) == 'on' ? 1 : 0),
			            			'Update' => ($this->input->post('Update'.$i, TRUE) == 'on' ? 1 : 0),
			            			'Delete' => ($this->input->post('Delete'.$i, TRUE) == 'on' ? 1 : 0)
			            		);

			            $this->AuthModel->insertAccessMenu($data);
		            }
		            $res = TRUE;
		            $msg = 'Data saved';
		        }
		    } else {
	      		$msg = 'You dont have access insert data';
	    	}
        }
    	echo json_encode(array('res' => $res, 'msg' => $msg));
	}

	public function _rules()
    {
    	$this->form_validation->set_rules('RoleName', 'RoleName', 'trim|required');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function Delete($id)
    {
    	$res = FALSE;
        if($this->arrAccessMenu['Delete']){
	        $row = $this->Users_model->UserRolesById($id);
	        if ($row) {
				$data = array(
				'Active' => 0
				);

				var_dump($this->Users_model->UpdateUserRoles($id, $data)); exit();
				$msg = 'Data deleted';
		    	$res = TRUE;
	        } else {
	        	$msg = 'Records not found';
	        }
      	} else {
      		$msg = 'You dont have access delete data';
      	}
    	echo json_encode(array('res' => $res, 'msg' => $msg));
    }

    function FormModal(){
    	$id = $this->input->post('id', TRUE);

    	if($id){
    		$Row = $this->Users_model->UserRolesById($id);
			$Data = array(
			    'Button' => '',
			    'Action' => site_url('UserRoles/Store/'.$id),
			    'RoleId' => set_value('RoleId', $Row->RoleId),
			    'RoleName' => set_value('RoleName', $Row->RoleName),
			    'RoleDesc' => set_value('RoleDesc', $Row->RoleDesc)
			);
			$disabled = "disabled";
    	}else{
    		$Data = array(
			    'Button' => 'Simpan',
			    'Action' => site_url('UserRoles/Store'),
			    'RoleId' => set_value('RoleId'),
			    'RoleName' => set_value('RoleName'),
			    'RoleDesc' => set_value('RoleDesc')
			);
			$disabled = "";
    	}

    	// ambil data menu
		$Menu = $this->AuthModel->getMenu();
		$ParentMenu = array();
		foreach ($Menu as $val) {
			$ParentMenu[$val->MenuId] = $this->AuthModel->getParentMenu($val->MenuId);
		}
		//////////////////////////////////

		// jika data akses tidak ada maka buat data kosong
		if(!$this->AuthModel->getMenuAccess($Data['RoleId'])){
			foreach ($Menu as $val) {
				$ArrAccessMenu[$val->MenuId] = array(
		                                  'Read' => 0,
		                                  'Write' => 0,
		                                  'Update' => 0,
		                                  'Delete' => 0
		                                  );
				$_ParentMenu = $this->AuthModel->getParentMenu($val->MenuId);
				if($_ParentMenu){
					foreach ($_ParentMenu as $value) {
						$ArrAccessMenu[$value->MenuId] = array(
		                                  'Read' => 0,
		                                  'Write' => 0,
		                                  'Update' => 0,
		                                  'Delete' => 0
		                                  );
					}
				}
			}	
		}else{
			// cek akses menu berdasarkan RoleId 
			$AccessMenu = $this->AuthModel->getMenuAccess($Data['RoleId']);
			$ArrAccessMenu = array();
			foreach ($AccessMenu as $val) {
				$ArrAccessMenu[$val->MenuId] = array(
			                                  'Read' => $val->Read,
			                                  'Write' => $val->Write,
			                                  'Update' => $val->Update,
			                                  'Delete' => $val->Delete
			                                  );
			}
			//////////////////////////////////
		}

    	$arrAccessMenu = $this->session->userdata('access_menu');
        if($this->arrAccessMenu['Read']){
    		echo '
			<form name="formModal" action="'.$Data['Action'].'" method="post" class="form-horizontal" name="formDivision">
                <div class="row">
                  <div class="col-md-12">
                    <div class="section">
                      <div class="section-body">
                        <div class="col-md-12">
                          <div class="section">
                            <div class="section-body">

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label class="col-md-3 control-label">Role Name</label>
                                  <div class="col-md-8">
                                    <input type="text" class="form-control" name="RoleName" id="RoleName" placeholder="Role Name" value="'.$Data['RoleName'].'">
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label class="col-md-3 control-label">Descriptions</label>
                                  <div class="col-md-8">
                                    <textarea class="form-control" name="RoleDesc" id="RoleDesc" placeholder="Descriptions">'.$Data['RoleDesc'].'</textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-12">
                              	<table class="table table-hover">
				                    <thead>
				                        <tr>
				                            <th>Menu</th>
				                            <th class="text-center">C</th>
				                            <th class="text-center">R</th>
				                            <th class="text-center">U</th>
				                            <th class="text-center">D</th>
				                        </tr>
				                    </thead>
				                    <tbody>';
				                    	$i = 0;
				               			foreach ($Menu as $val) {
							                $i++;
							                echo '
							                    <tr>';
						                      	echo '<td>
						                      			<i class="'.$val->MenuIcon.'"></i> 
						                      			'.$val->MenuText.'
						                      			<input type="hidden" name="MenuId'.$i.'" value="'.$val->MenuId.'"/>
						                      		</td>';
						                      	echo '<td align="center"><input type="checkbox" name="Write'.$i.'" '.($ArrAccessMenu[$val->MenuId]['Write'] ? "checked" : "unchecked").'></td>';
						                      	echo '<td align="center"><input type="checkbox" name="Read'.$i.'" '.($ArrAccessMenu[$val->MenuId]['Read'] ? "checked" : "unchecked").'></td>';
						                      	echo '<td align="center"><input type="checkbox" name="Update'.$i.'" '.($ArrAccessMenu[$val->MenuId]['Update'] ? "checked" : "unchecked").'></td>';
						                      	echo '<td align="center"><input type="checkbox" name="Delete'.$i.'" '.($ArrAccessMenu[$val->MenuId]['Delete'] ? "checked" : "unchecked").'></td>';
							                echo '</tr>';
							                // load parent menu
					                      	if($ParentMenu[$val->MenuId]){
					                            foreach ($ParentMenu[$val->MenuId] as $value) {
					                            	$i++;
						                            echo '<tr>';
						                            	echo '<td>
						                            			&nbsp;&nbsp;&nbsp;&nbsp;
						                            			<i class="'.$value->MenuIcon.'"></i> 
						                            			'.$value->MenuText.'
						                            			<input type="hidden" name="MenuId'.$i.'" value="'.$value->MenuId.'"/>
						                            		</td>';
								                      	echo '<td align="center"><input type="checkbox" name="Write'.$i.'" '.($ArrAccessMenu[$value->MenuId]['Write'] ? "checked" : "unchecked").'></td>';
								                      	echo '<td align="center"><input type="checkbox" name="Read'.$i.'" '.($ArrAccessMenu[$value->MenuId]['Read'] ? "checked" : "unchecked").'></td>';
								                      	echo '<td align="center"><input type="checkbox" name="Update'.$i.'" '.($ArrAccessMenu[$value->MenuId]['Update'] ? "checked" : "unchecked").'></td>';
								                      	echo '<td align="center"><input type="checkbox" name="Delete'.$i.'" '.($ArrAccessMenu[$value->MenuId]['Delete'] ? "checked" : "unchecked").'></td>';
						                            echo '</tr>';
					                            }
					                      	}
							            }
							            echo '<input type="hidden" name="TotalMenu" value="'.$i.'"/>';
				               echo'</tbody>
				                </table>
                              </div>
                          
                          </div>

                          <div class="form-footer">
                            <div class="form-group">
                              <div class="col-md-12">
                              	<span id="status"></span>
                              	<a href="javascript: saveData();" id="btnSave" class="btn btn-default pull-right"><i class="fa fa-save"></i>  Save</a>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </form>
            <script type="text/javascript">
            	$("#RoleId, #Active").selectpicker("refresh");
            	$("#Username").on({
				  keydown: function(e) {
				    if (e.which === 32)
				      return false;
				  },
				  change: function() {
				    this.value = this.value.replace(/\s/g, "");
				  }
				});
            </script>';
        } else {
        	echo '<div class="alert alert-warning">You dont have access</div>';
        }
    }

}
/* End of file UserRoles.php */
/* Location: ./application/controllers/UserRoles.php */
