<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Refund extends Parent_Controller
{

		protected $arrAccessMenu;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Refund_model','GlobalModel','ListDataModel'));
        $this->load->library('form_validation');
				$this->arrAccessMenu = $this->session->userdata('access_menu')[10];
    }

    public function index()
    {
      $this->Content = 'content/refundList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      
      if(!$this->arrAccessMenu['Read']){
        $this->Content = 'errors/dontHaveAccess';
      }

      $this->Layouts($Datas);
    }

    public function read($Id)
    {
      $this->Content = 'content/refundForm';
      $Datas['AddCss'] = ['assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'assets/vendor/tinymce/tinymce.min.js'
      ];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js'
      ];

      $row = $this->Refund_model->getById($Id);
      
      if ($row) {
        if(!$this->arrAccessMenu['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => set_value('Refund/create_action'),
          		'RefundId' => $row->RefundId,
							'ProofSpendId' => $row->ProofSpendId,
							'RefundNo' => $row->RefundNo,
							'RefundDate' => $row->RefundDate,
							'NoUrut' => $row->NoUrut,
							'NoUrutReimburse' => $row->NoUrutReimburse,
							'ReimburseNo' => $row->ReimburseNo,
							'ReimbursePaidTo' => $row->ReimbursePaidTo,
							'TotalAmount' => $row->TotalAmount,
							'Classification' => $row->Classification,
							'CreatorTtd' => $row->CreatorTtd,
							'Recipient' => $row->Recipient,
							'RecipientTtd' => $row->RecipientTtd,
							'Approval1' => $row->Approval1,
							'Approval1Status' => $row->Approval1Status,
							'Approval1Date' => $row->Approval1Date,
							'Approval1Note' => $row->Approval1Note,
							'Approval1Ttd' => $row->Approval1Ttd,
							'Approval2' => $row->Approval2,
							'Approval2Status' => $row->Approval2Status,
							'Approval2Date' => $row->Approval2Date,
							'Approval2Note' => $row->Approval2Note,
							'Approval2Ttd' => $row->Approval2Ttd,
							'Approval3' => $row->Approval3,
							'Approval3Status' => $row->Approval3Status,
							'Approval3Date' => $row->Approval3Date,
							'Approval3Note' => $row->Approval3Note,
							'Approval3Ttd' => $row->Approval3Ttd,
							'LockDate' => $row->LockDate,
							'LockByUserId' => $row->LockByUserId,
							'CreatedDate' => $row->CreatedDate,
							'CreatedByUserId' => $row->CreatedByUserId,
							'LastChangedDate' => $row->LastChangedDate,
							'LastChangedByUserId' => $row->LastChangedByUserId,
							'DeletedDate' => $row->DeletedDate,
							'DeletedUserId' => $row->DeletedUserId
          );

          $Datas['DataApproval1'] = $this->Refund_model->approval1Selected($Id);
          $Datas['DataApproval2'] = $this->Refund_model->approval2Selected($Id);
          $Datas['DataApproval3'] = $this->Refund_model->approval3Selected($Id);
          $Datas['DataRecipient'] = $this->Refund_model->recipientSelected($Id);
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Refund'));
      }
    }

    public function create()
    {
      $this->Content = 'content/refundForm';
      $Datas['AddCss'] = ['assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'assets/vendor/tinymce/tinymce.min.js'
      ];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js'
      ];

      
      if(!$this->arrAccessMenu['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        //generate no urut
        $NoUrut = $this->Refund_model->lastNoUrut();
        $NoUrut = str_pad($NoUrut[0]->NoUrut+1, 4, '0', STR_PAD_LEFT);

				// PDS(no)/bilan/tahun
        $array_bulan = array(1=> "I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII", 9=>"IX", 10=>"X", 11=>"XI", 12=>"XII");
        $RefundNo   = "PDS" . $NoUrut . "/".$array_bulan[date('n')]."/".date("Y");
                                
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('Refund/create_action/'),
            'attribute' => '',
						'RefundId' => set_value('RefundId'),
						'ProofSpendId' => set_value('ProofSpendId'),
						'RefundDate' => set_value('RefundDate'),
						'NoUrut' => set_value('NoUrut', $NoUrut),
						'RefundNo' => set_value('RefundNo', $RefundNo),
						'TotalAmount' => set_value('TotalAmount'),
						'Classification' => set_value('Classification'),
						'CreatorTtd' => set_value('CreatorTtd'),
						'Approval1' => set_value('Approval1'),
						'Approval1Status' => set_value('Approval1Status'),
						'Approval1Date' => set_value('Approval1Date'),
						'Approval1Note' => set_value('Approval1Note'),
						'Approval1Ttd' => set_value('Approval1Ttd'),
						'Approval2' => set_value('Approval2'),
						'Approval2Status' => set_value('Approval2Status'),
						'Approval2Date' => set_value('Approval2Date'),
						'Approval2Note' => set_value('Approval2Note'),
						'Approval2Ttd' => set_value('Approval2Ttd'),
						'Approval3' => set_value('Approval3'),
						'Approval3Status' => set_value('Approval3Status'),
						'Approval3Date' => set_value('Approval3Date'),
						'Approval3Note' => set_value('Approval3Note'),
						'Approval3Ttd' => set_value('Approval3Ttd'),
						'LockDate' => set_value('LockDate'),
						'LockByUserId' => set_value('LockByUserId'),
						'Attachment' => set_value('Attachment'),
						'CreatedDate' => set_value('CreatedDate'),
						'CreatedByUserId' => set_value('CreatedByUserId'),
						'LastChangedDate' => set_value('LastChangedDate'),
						'LastChangedByUserId' => set_value('LastChangedByUserId'),
						'DeletedDate' => set_value('DeletedDate'),
						'DeletedUserId' => set_value('DeletedUserId')
        );

        $Datas['DataProofSpend'] = $this->Refund_model->proofSpendSelected();
        $Datas['DataApproval1'] = $this->Refund_model->approval1Selected();
        $Datas['DataApproval2'] = $this->Refund_model->approval2Selected();
        $Datas['DataApproval3'] = $this->Refund_model->approval3Selected();
        $Datas['DataRequest'] = "";
      }

      $this->Layouts($Datas);
    }
		
    public function update($Id)
    {
      $this->Content = 'content/refundForm';
      $Datas['AddCss'] = ['assets/signature/css/signature-pad.css'];
      $Datas['AddJsHeader'] = ['assets/signature/js/signature_pad.js'];
      $Datas['AddJsFooter'] = [];

      $row = $this->Refund_model->getById($Id);

      if ($row) {
        if(!$this->arrAccessMenu['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $disabled = ($row->LockDate) ? "disabled" : ""; 

          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'action' => site_url('Refund/update_action/'.$Id),
            'attribute' => $disabled,
						'RefundId' => set_value('RefundId', $Id),
						'ProofSpendId' => set_value('ProofSpendId', $row->ProofSpendId),
						'RefundDate' => set_value('RefundDate', $row->RefundDate),
						'NoUrut' => set_value('NoUrut', $row->NoUrut),
						'RefundNo' => set_value('RefundNo', $row->RefundNo),
						'TotalAmount' => set_value('TotalAmount', $row->TotalAmount),
						'Classification' => set_value('Classification', $row->Classification),
						'CreatorTtd' => set_value('CreatorTtd', $row->CreatorTtd),
						'Approval1' => set_value('Approval1', $row->Approval1),
						'Approval1Status' => set_value('Approval1Status', $row->Approval1Status),
						'Approval1Date' => set_value('Approval1Date', $row->Approval1Date),
						'Approval1Note' => set_value('Approval1Note', $row->Approval1Note),
						'Approval1Ttd' => set_value('Approval1Ttd', $row->Approval1Ttd),
						'Approval2' => set_value('Approval2', $row->Approval2),
						'Approval2Status' => set_value('Approval2Status', $row->Approval2Status),
						'Approval2Date' => set_value('Approval2Date', $row->Approval2Date),
						'Approval2Note' => set_value('Approval2Note', $row->Approval2Note),
						'Approval2Ttd' => set_value('Approval2Ttd', $row->Approval2Ttd),
						'Approval3' => set_value('Approval3', $row->Approval3),
						'Approval3Status' => set_value('Approval3Status', $row->Approval3Status),
						'Approval3Date' => set_value('Approval3Date', $row->Approval3Date),
						'Approval3Note' => set_value('Approval3Note', $row->Approval3Note),
						'Approval3Ttd' => set_value('Approval3Ttd', $row->Approval3Ttd),
						'LockDate' => set_value('LockDate', $row->LockDate),
						'LockByUserId' => set_value('LockByUserId', $row->LockByUserId),
						'Attachment' => set_value('Attachment', $row->Attachment),
						'CreatedDate' => set_value('CreatedDate', $row->CreatedDate),
						'CreatedByUserId' => set_value('CreatedByUserId', $row->CreatedByUserId),
						'LastChangedDate' => set_value('LastChangedDate', $row->LastChangedDate),
						'LastChangedByUserId' => set_value('LastChangedByUserId', $row->LastChangedByUserId),
						'DeletedDate' => set_value('DeletedDate', $row->DeletedDate),
						'DeletedUserId' => set_value('DeletedUserId', $row->DeletedUserId),
          );

					$Datas['DataProofSpend'] = $this->Refund_model->proofSpendSelected($Id);
					$Datas['DataApproval1'] = $this->Refund_model->approval1Selected($Id);
          $Datas['DataApproval2'] = $this->Refund_model->approval2Selected($Id);
          $Datas['DataApproval3'] = $this->Refund_model->approval3Selected($Id);
          $Datas['DataRequest'] = $this->Refund_model->getRequest($Id);
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Refund'));
      }
    }

    public function create_action()
    {
			if($this->arrAccessMenu['Write']){
				$this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
						$RefundId = uniqid().uniqid();

						if($_FILES['Attachment']['name']) {
							$newName = 'refund_attachment_' . time() . '_' . $_FILES["Attachment"]['name'];
							$config['upload_path'] = './upload/';
							$config['allowed_types'] = 'jpg|jpeg|png|pdf';
							$config['max_size'] = 2000;
							$config['overwrite'] = TRUE;
							$config['file_name'] = $newName;
							$this->load->library('upload', $config);
	
							if (!$this->upload->do_upload('Attachment')) 
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', $error['error']);
								redirect(site_url('Refund'));
							}
						}

            $data = array(
              'RefundId' => $RefundId,
							'ProofSpendId' => $this->input->post('ProofSpendId', TRUE),
							'RefundDate' => $this->input->post('RefundDate', TRUE),
							'NoUrut' => $this->input->post('NoUrut', TRUE),
							'RefundNo' => $this->input->post('RefundNo', TRUE),
							'TotalAmount' => $this->input->post('TotalAmount', TRUE),
							'Classification' => $this->input->post('Classification', TRUE),
							'CreatorTtd' => $this->input->post('CreatorTtd', TRUE),
							'Approval1' => $this->input->post('Approval1', TRUE),
							'Approval2' => $this->input->post('Approval2', TRUE),
							'Approval3' => $this->input->post('Approval3', TRUE),
							'CreatedDate' => date("Y-m-d H:i:s"),
          		'CreatedByUserId' => $this->session->userdata('user_id'),
        	  );

						if($_FILES["Attachment"]['name']) {
							$dwata['Attachment'] = $newName;
						}

            $exst = $this->GlobalModel->getDataByWhere('trnrefund', array('NoUrut' => $this->input->post('NoUrut',TRUE)));
            if($exst){
              $this->session->set_flashdata('message', 'No urut sudah digunakan');
              redirect(site_url('Refund/update/'.$exst->RefundId));
            }else{
              for ($i=1; $i <= $_POST['row']; $i++) {
                if($_POST["Spesification"][$i]){

									$Price = explode(".",($_POST['Price'][$i]));
									$Price = str_replace(",","",($Price[0]));

									$Amount = explode(".",($_POST['Amount'][$i]));
									$Amount = str_replace(",","",($Amount[0]));

                  $dataRequest = array(
                    'RefundId' => $RefundId,
                    'Sort'  => $i,
                    'Spesification' => $_POST["Spesification"][$i],
                    'Quantity' => $_POST["Quantity"][$i],
                    'Price' => $Price,
                    'Amount' => $Amount,
                  );
                  $this->Refund_model->insertRequest($dataRequest);
                }
              }
              $this->Refund_model->insert($data);

              $this->session->set_flashdata('message', 'Data disimpan');
              redirect(site_url('Refund/update/'.$RefundId));
            }
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Refund'));
      }
    }

    public function update_action($Id)
    {
      if($this->arrAccessMenu['Update']){

				if($_FILES['Attachment']['name']) {
					$newName = 'refund_attachment_' . time() . '_' . $_FILES["Attachment"]['name'];
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = 'jpg|jpeg|png|pdf';
					$config['max_size'] = 2000;
					$config['overwrite'] = TRUE;
					$config['file_name'] = $newName;
					$this->load->library('upload', $config);
	
					if (!$this->upload->do_upload('Attachment')) 
					{
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('message', $error['error']);
						redirect(site_url('Refund'));
					}
				}

        $data = array(
					'RefundId' => $Id,
					'ProofSpendId' => $this->input->post('ProofSpendId', TRUE),
					'RefundDate' => $this->input->post('RefundDate', TRUE),
					'NoUrut' => $this->input->post('NoUrut', TRUE),
					'RefundNo' => $this->input->post('RefundNo', TRUE),
					'TotalAmount' => $this->input->post('TotalAmount', TRUE),
					'Classification' => $this->input->post('Classification', TRUE),
					'Approval1' => $this->input->post('Approval1', TRUE),
					'Approval2' => $this->input->post('Approval2', TRUE),
					'Approval3' => $this->input->post('Approval3', TRUE),
          'LastChangedDate' => date("Y-m-d H:i:s"),
          'LastChangedByUserId' => $this->session->userdata('user_id')
    	  );

				if($_FILES['Attachment']['name']) {
					$data['Attachment'] = $newName;
				}

        if($this->input->post('Approval1Status',TRUE)){
          $data['Approval1Status'] = $this->input->post('Approval1Status',TRUE);
          $data['Approval1Date'] = date("Y-m-d H:i:s");
          $data['Approval1Note'] = $this->input->post('Approval1Note');
        }

        if($this->input->post('Approval2Status',TRUE)){
          $data['Approval2Status'] = $this->input->post('Approval2Status',TRUE);
          $data['Approval2Date'] = date("Y-m-d H:i:s");
          $data['Approval2Note'] = $this->input->post('Approval2Note');
        }

        if($this->input->post('Approval3Status',TRUE)){
          $data['Approval3Status'] = $this->input->post('Approval3Status',TRUE);
          $data['Approval3Date'] = date("Y-m-d H:i:s");
          $data['Approval3Note'] = $this->input->post('Approval3Note');
        }

				$this->Refund_model->deleteSeq($Id);
        for ($i=1; $i <= $_POST['row']; $i++) {
					if($_POST["Spesification"][$i]){

						$Price = explode(".", ($_POST['Price'][$i]));
						$Price = str_replace(",", "", ($Price[0]));

						$Amount = explode(".", ($_POST['Amount'][$i]));
						$Amount = str_replace(",", "", ($Amount[0]));

						$dataRequest = array(
							'RefundId' => $Id,
							'Sort'  => $i,
							'Spesification' => $_POST["Spesification"][$i],
							'Quantity' => $_POST["Quantity"][$i],
							'Price' => $Price,
							'Amount' => $Amount,
						);
						$this->Refund_model->insertRequest($dataRequest);
					}
				}
        $this->Refund_model->update($Id, $data);
        
        $this->session->set_flashdata('message', 'Data diperbarui');
        redirect(site_url('Refund/update/' . $Id));
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Refund'));
      }
    }

    public function delete($Id)
    {
      if($this->arrAccessMenu['Delete']){
        $row = $this->Refund_model->getById($Id);

        if ($row) {
          $data = array(
            'DeletedDate' => date('Y-m-d H:i:s'),
            'DeletedUserId' => $this->session->userdata('user_id')
          );

          $this->Refund_model->update($row->RefundId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('Refund'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Refund'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Refund'));
      }
    }

    public function ListData(){
        $sql = "SELECT a.*, b.name CreatedBy
								FROM trnrefund a 
								JOIN users b ON a.CreatedByUserId = b.id
								WHERE a.DeletedDate IS NULL ";

        $column_order = array( 
          'RefundNo',
          'RefundNo',
          'RefundDate',
          'CreatedBy',
          'LockDate',
          'Approval1Status',
          'Approval2Status',
          'Approval3Status',
        );
        
        $column_search = array(
          'RefundNo',
          'RefundDate',
          'b.name',
          'LockDate',
          'Approval1Status',
          'Approval2Status',
          'Approval3Status',
        ); 

        $order = array('NoUrut' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        $no = 0;
        foreach ($list as $val) {
          $row = array();
          $no++;
          $row[] = $no;
          $row[] = $val->RefundNo;
          $row[] = $val->RefundDate;
          $row[] = $val->CreatedBy;
					$row[] = $val->LockDate ? date("d M Y", strtotime($val->LockDate)) : 'N/A';
            
					if ($val->Approval1Status == 1) {
						$row[] = '<i class="glyphicon glyphicon-ok" title="Diterima"></i>';
					} else if ($val->Approval1Status == 2) {
						$row[] = '<i class="glyphicon glyphicon-remove" title="Ditolak"></i>';
					} else if ($val->Approval1Status == 3) {
						$row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi"></i>';
					}else{
						$row[] = '';
					};
					
					if ($val->Approval2Status == 1) {
						$row[] = '<i class="glyphicon glyphicon-ok" title="Diterima"></i>';
					} else if ($val->Approval2Status == 2) {
						$row[] = '<i class="glyphicon glyphicon-remove" title="Ditolak"></i>';
					} else if ($val->Approval2Status == 3) {
						$row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi"></i>';
					}else{
						$row[] = '';
					};
					
					if ($val->Approval3Status == 1) {
						$row[] = '<i class="glyphicon glyphicon-ok" title="Diterima"></i>';
					} else if ($val->Approval3Status == 2) {
						$row[] = '<i class="glyphicon glyphicon-remove" title="Ditolak"></i>';
					} else if ($val->Approval3Status == 3) {
						$row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi"></i>';
					}else{
						$row[] = '';
					};
          
          $action = '';
           if($val->Approval1Status != 0 && $val->Approval2Status != 0 && $val->Approval3Status != 0){
              $action.= '<a href="#" id="print" onclick="javascript:modalPrint(\''.$val->RefundId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak"></i>
                      </a>';
              $action.= '  ';
            }

          if($val->RefundId){
            $action.= anchor(site_url('Refund/update/'.$val->RefundId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'Edit'));
          }

          $row[] = $action;
          
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

  public function Report($Id = NULL){
    $this->load->library('m_pdf');
    if(!$Id){
      show_404();
    }

    $DataDetail = $this->Refund_model->getDetail($Id);
    $DataRequests = $this->Refund_model->getRequest($Id);
    
    ob_start();
      $this->load->view('report/refund',array('DataDetail' => $DataDetail, 'DataRequests' => $DataRequests));
      $html = ob_get_contents();
    ob_end_clean();

    $pdf = new mPDF('utf-8', 'A4');
    $pdf->AddPage('P');
    $pdf->WriteHtml($html);
    $pdf->Output('PDS-A04-' . date('Y-m-d H i s') . '.pdf', 'I');
  }

  function Ttd(){
    $Id = $this->input->post('Id', TRUE);
    $Ttd = $this->input->post('Ttd');
    $Approval = $this->input->post('Approval', TRUE);
    $ApprovalStatus = $this->input->post('ApprovalStatus', TRUE);
    $ApprovalNote = $this->input->post('ApprovalNote', TRUE);
    $data = array(
      'Approval'.$Approval.'Ttd' => $Ttd,
      'Approval'.$Approval.'Status' => $ApprovalStatus,
      'Approval'.$Approval.'Note' => $ApprovalNote,
      'Approval'.$Approval.'Date' => date("Y-m-d H:i:s")
    );
    $res = $this->Refund_model->update($Id, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';

    if ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      // $data    = $this->Refund_model->get_po_by_id($Id);
      // $subject = "Pemberitahuan PO";
      // $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      // $to = $to->email;

      // $set_message = "
      //   Informasi PO baru dengan No. ".$data->PoNo." diminta untuk direvisi oleh approver $Approval.
      // ";
      // $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnrefund', array('RefundId' => $Id), array('LockDate' => NULL));
      // $this->Refund_model->setNullRequestSppPoById($Id);
      // send email
    }

  }

  function TtdNonApproval(){
    $Id = $this->input->post('Id', TRUE);
    $Ttd = $this->input->post('Ttd');
    $Type = $this->input->post('Type', TRUE);

		if($Type === 'recipient') {
			$data = ['RecipientTtd' => $Ttd];
		} else {
			$data = ['CreatorTtd' => $Ttd];
		}

    $res = $this->Refund_model->update($Id, $data);
    if($res) echo 'Simpan tandatangan sukses'; else echo 'Simpan tandatangan gagal';
  }

  function Lock(){
    if(!$this->arrAccessMenu['Update']){
      $this->session->set_flashdata('message', 'Anda tidak punya akses');
    } else {
      $ProofSpendId = $this->input->post('Id', TRUE);
      $data = array(
        'LockDate' => date("Y-m-d H:i:s"),
        'LockByUserId' => $this->session->userdata('user_id')
      );
      $res = $this->Refund_model->update($ProofSpendId, $data);

      // // send email
      // $data    = $this->Refund_model->get_po_by_id($BudgetRequestId);
      // $subject = "Pemberitahuan PO";

      // if ($data->Approval1Status == 3) {
      //   $to = $this->GlobalModel->getEmailById($data->Approval1);
      //   $to = $to->email;
      //   $set_message = "
      //     Informasi PO baru dengan No. ".$data->PoNo." telah direvisi.
      //   ";
      //   $this->_send_email($to, $set_message, $subject);
      //   $this->GlobalModel->globalUpdate('trnpo', array('BudgetRequestId' => $BudgetRequestId), array('Approval1Status' => NULL, 'Approval1Note' => NULL, 'Approval1Ttd' => NULL, 'Approval1Date' => NULL));
      // }elseif ($data->Approval2Status == 3) {
      //   $to = $this->GlobalModel->getEmailById($data->Approval2);
      //   $to = $to->email;
      //   $set_message = "
      //     Informasi PO baru dengan No. ".$data->PoNo." telah direvisi.
      //   ";
      //   $this->_send_email($to, $set_message, $subject);
      //   $this->GlobalModel->globalUpdate('trnpo', array('BudgetRequestId' => $BudgetRequestId), array('Approval2Status' => NULL, 'Approval2Note' => NULL, 'Approval2Ttd' => NULL, 'Approval2Date' => NULL));
      // }else{
      //   $to_v2 = $this->GlobalModel->email_verificator($BudgetRequestId);
      //   $to = "";
      //   foreach ($to_v2 as $k) 
      //   {
      //       $to .= $k['email'].',';
      //   }
      //   $set_message = "
      //     Informasi PO baru dengan No. ".$data->PoNo." menunggu untuk diverifikasi.
      //   ";
      //   $this->_send_email($to, $set_message, $subject);
      //   $this->GlobalModel->globalUpdate('seqagreementstatus', array('AgreementId' => $BudgetRequestId), array('Status' => NULL, 'StatusDate' => NULL, 'StatusByUserId' => NULL, 'Note' => NULL, 'Ttd' => NULL));
      // }
      // // send email

      $this->session->set_flashdata('message', 'Data dikunci');
    }
  }

	private function _rules()
	{
		// $this->form_validation->set_rules('TotalAmount', 'Total Jumlah', 'trim|required');
		$this->form_validation->set_rules('NoUrut', 'Proyek', 'trim|required');
		// $this->form_validation->set_rules('BudgetRequestNo', 'Nomor Berkas', 'trim|required');
		// $this->form_validation->set_rules('BudgetRequestDate', 'Tanggal Berkas', 'trim|required');
		// $this->form_validation->set_rules('Approval1', 'approval1', 'trim|required');
		// $this->form_validation->set_rules('Approval2', 'approval2', 'trim|required');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

}
