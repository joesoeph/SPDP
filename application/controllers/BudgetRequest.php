<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BudgetRequest extends Parent_Controller
{

		protected $arrAccessMenu;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('BudgetRequest_model','GlobalModel','ListDataModel'));
        $this->load->library('form_validation');
				$this->arrAccessMenu = $this->session->userdata('access_menu')[8];
    }

    public function index()
    {
      $this->Content = 'content/budgetRequestList';
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
      $this->Content = 'content/BudgetRequest';
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

      $row = $this->BudgetRequest_model->getById($Id);
      
      if ($row) {
        if(!$this->arrAccessMenu['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('BudgetRequest/create_action'),
          		'BudgetRequestId' => $row->BudgetRequestId,
							'BudgetRequestNo' => $row->BudgetRequestNo,
							'NoUrut' => $row->NoUrut,
							'BudgetRequestDate' => $row->BudgetRequestDate,
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
							'LockDate' => $row->LockDate,
							'LockByUserId' => $row->LockByUserId,
							'CreatedDate' => $row->CreatedDate,
							'CreatedByUserId' => $row->CreatedByUserId,
							'LastChangedDate' => $row->LastChangedDate,
							'LastChangedByUserId' => $row->LastChangedByUserId,
							'DeletedDate' => $row->DeletedDate,
							'DeletedUserId' => $row->DeletedUserId
          );

          $Datas['DataApproval1'] = $this->BudgetRequest_model->approval1Selected($Id);
          $Datas['DataApproval2'] = $this->BudgetRequest_model->approval2Selected($Id);
          $Datas['DataRecipient'] = $this->BudgetRequest_model->recipientSelected($Id);
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('BudgetRequest'));
      }
    }

    public function create()
    {
      $this->Content = 'content/budgetRequestForm';
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
        $NoUrut = $this->BudgetRequest_model->lastNoUrut();
        $NoUrut = str_pad($NoUrut[0]->NoUrut+1, 4, '0', STR_PAD_LEFT);

				//CA( No)/bulan/tahun
        $array_bulan = array(1=> "I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII", 9=>"IX", 10=>"X", 11=>"XI", 12=>"XII");
        $BudgetRequestNo   = "CA" . $NoUrut . "/".$array_bulan[date('n')]."/".date("Y");
                                
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('BudgetRequest/create_action/'),
            'attribute' => '',
						'BudgetRequestId' => set_value('BudgetRequestId'),
						'BudgetRequestNo' => set_value('BudgetRequestNo', $BudgetRequestNo),
						'NoUrut' => $NoUrut,
						'BudgetRequestDate' => set_value('BudgetRequestDate'),
						'TotalAmount' => set_value('TotalAmount'),
						'Classification' => set_value('Classification'),
						'CreatorTtd' => set_value('CreatorTtd'),
						'Recipient' => set_value('Recipient'),
						'RecipientTtd' => set_value('RecipientTtd'),
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
						'LockDate' => set_value('LockDate'),
						'LockByUserId' => set_value('LockByUserId'),
						'Attachment' => set_value('Attachment'),
						'CreatedDate' => set_value('CreatedDate'),
						'CreatedByUserId' => set_value('CreatedByUserId'),
						'LastChangedDate' => set_value('LastChangedDate'),
						'LastChangedByUserId' => set_value('LastChangedByUserId'),
						'DeletedDate' => set_value('DeletedDate'),
						'DeletedUserId' => set_value('DeletedUserId'),
        );

        $Datas['DataApproval1'] = $this->BudgetRequest_model->approval1Selected();
        $Datas['DataApproval2'] = $this->BudgetRequest_model->approval2Selected();
        $Datas['DataRecipient'] = $this->BudgetRequest_model->recipientSelected();
        $Datas['DataRequest'] = "";
      }

      $this->Layouts($Datas);
    }
		
    public function update($Id)
    {
      $this->Content = 'content/budgetRequestForm';
      $Datas['AddCss'] = ['assets/signature/css/signature-pad.css'];
      $Datas['AddJsHeader'] = ['assets/signature/js/signature_pad.js'];
      $Datas['AddJsFooter'] = [];

      $row = $this->BudgetRequest_model->getById($Id);

      if ($row) {
        if(!$this->arrAccessMenu['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $disabled = ($row->LockDate) ? "disabled" : ""; 

          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'action' => site_url('BudgetRequest/update_action/'.$Id),
            'attribute' => $disabled,
						'BudgetRequestId' =>  set_value('BudgetRequestId', $row->BudgetRequestId),
						'BudgetRequestNo' =>  set_value('BudgetRequestNo', $row->BudgetRequestNo),
						'NoUrut' =>  set_value('NoUrut', $row->NoUrut),
						'BudgetRequestDate' =>  set_value('BudgetRequestDate', $row->BudgetRequestDate),
						'TotalAmount' =>  set_value('TotalAmount', $row->TotalAmount),
						'Classification' =>  set_value('Classification', $row->Classification),
						'CreatorTtd' =>  set_value('CreatorTtd', $row->CreatorTtd),
						'Recipient' =>  set_value('Recipient', $row->Recipient),
						'RecipientTtd' =>  set_value('RecipientTtd', $row->RecipientTtd),
						'Approval1' =>  set_value('Approval1', $row->Approval1),
						'Approval1Status' =>  set_value('Approval1Status', $row->Approval1Status),
						'Approval1Date' =>  set_value('Approval1Date', $row->Approval1Date),
						'Approval1Note' =>  set_value('Approval1Note', $row->Approval1Note),
						'Approval1Ttd' =>  set_value('Approval1Ttd', $row->Approval1Ttd),
						'Approval2' =>  set_value('Approval2', $row->Approval2),
						'Approval2Status' =>  set_value('Approval2Status', $row->Approval2Status),
						'Approval2Date' =>  set_value('Approval2Date', $row->Approval2Date),
						'Approval2Note' =>  set_value('Approval2Note', $row->Approval2Note),
						'Approval2Ttd' =>  set_value('Approval2Ttd', $row->Approval2Ttd),
						'LockDate' =>  set_value('LockDate', $row->LockDate),
						'LockByUserId' =>  set_value('LockByUserId', $row->LockByUserId),
						'Attachment' =>  set_value('Attachment', $row->Attachment),
						'CreatedDate' =>  set_value('CreatedDate', $row->CreatedDate),
						'CreatedByUserId' =>  set_value('CreatedByUserId', $row->CreatedByUserId),
						'LastChangedDate' =>  set_value('LastChangedDate', $row->LastChangedDate),
						'LastChangedByUserId' =>  set_value('LastChangedByUserId', $row->LastChangedByUserId),
						'DeletedDate' =>  set_value('DeletedDate', $row->DeletedDate),
						'DeletedUserId' =>  set_value('DeletedUserId', $row->DeletedUserId),
          );

          $Datas['DataApproval1'] = $this->BudgetRequest_model->approval1Selected($Id);
          $Datas['DataApproval2'] = $this->BudgetRequest_model->approval2Selected($Id);
          $Datas['DataRecipient'] = $this->BudgetRequest_model->recipientSelected($Id);
          $Datas['DataRequest'] = $this->BudgetRequest_model->getRequest($Id);
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('BudgetRequest'));
      }
    }

    public function create_action()
    {
			if($this->arrAccessMenu['Write']){
				$this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $BudgetRequestId = uniqid().uniqid();

						$TotalAmount = explode(".",($this->input->post('TotalAmount', TRUE)));
						$TotalAmount = str_replace(",","",($TotalAmount[0]));

            $data = array(
              'BudgetRequestId' => $BudgetRequestId,
          		'BudgetRequestNo' => $this->input->post('BudgetRequestNo',TRUE),
          		'NoUrut' => $this->input->post('NoUrut',TRUE),
          		'BudgetRequestDate' => $this->input->post('BudgetRequestDate',TRUE),
          		'TotalAmount' => $TotalAmount,
          		'Classification' => $this->input->post('Classification',TRUE),
          		'Approval1' => $this->input->post('Approval1',TRUE),
          		'Approval2' => $this->input->post('Approval2',TRUE),
          		'Recipient' => $this->input->post('Recipient',TRUE),
          		'CreatedDate' => date("Y-m-d H:i:s"),
          		'CreatedByUserId' => $this->session->userdata('user_id')
        	  );
						
            $exst = $this->GlobalModel->getDataByWhere('trnbudgetrequest', array('NoUrut' => $this->input->post('NoUrut',TRUE)));
            if($exst){
              $this->session->set_flashdata('message', 'No urut sudah digunakan');
              redirect(site_url('BudgetRequest/update/'.$exst->BudgetRequestId));
            }else{
              for ($i=1; $i <= $_POST['row']; $i++) {
                if($_POST["Spesification"][$i]){

									$Price = explode(".",($_POST['Price'][$i]));
									$Price = str_replace(",","",($Price[0]));

									$Amount = explode(".",($_POST['Amount'][$i]));
									$Amount = str_replace(",","",($Amount[0]));

                  $dataRequest = array(
                    'BudgetRequestId' => $BudgetRequestId,
                    'Sort'  => $i,
                    'Spesification' => $_POST["Spesification"][$i],
                    'Quantity' => $_POST["Quantity"][$i],
                    'Price' => $Price,
                    'Amount' => $Amount,
                  );
                  $this->BudgetRequest_model->insertRequest($dataRequest);
                }
              }
              $this->BudgetRequest_model->insert($data);

              $this->session->set_flashdata('message', 'Data disimpan');
              redirect(site_url('BudgetRequest/update/'.$BudgetRequestId));
            }
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('BudgetRequest'));
      }
    }

    public function update_action($Id)
    {
      if($this->arrAccessMenu['Update']){

				$TotalAmount = explode(".",($this->input->post('TotalAmount', TRUE)));
				$TotalAmount = str_replace(",","",($TotalAmount[0]));

        $data = array(
					'BudgetRequestId' => $Id,
					'BudgetRequestNo' => $this->input->post('BudgetRequestNo',TRUE),
					'NoUrut' => $this->input->post('NoUrut',TRUE),
					'BudgetRequestDate' => $this->input->post('BudgetRequestDate',TRUE),
					'TotalAmount' => $TotalAmount,
					'Classification' => $this->input->post('Classification',TRUE),
					'Approval1' => $this->input->post('Approval1',TRUE),
					'Approval2' => $this->input->post('Approval2',TRUE),
					'Recipient' => $this->input->post('Recipient',TRUE),
          'LastChangedDate' => date("Y-m-d H:i:s"),
          'LastChangedByUserId' => $this->session->userdata('user_id')
    	  );

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

				$this->BudgetRequest_model->deleteSeq($Id);
        for ($i=1; $i <= $_POST['row']; $i++) {
					if($_POST["Spesification"][$i]){

						$Price = explode(".", ($_POST['Price'][$i]));
						$Price = str_replace(",", "", ($Price[0]));

						$Amount = explode(".", ($_POST['Amount'][$i]));
						$Amount = str_replace(",", "", ($Amount[0]));

						$dataRequest = array(
							'BudgetRequestId' => $Id,
							'Sort'  => $i,
							'Spesification' => $_POST["Spesification"][$i],
							'Quantity' => $_POST["Quantity"][$i],
							'Price' => $Price,
							'Amount' => $Amount,
						);
						$this->BudgetRequest_model->insertRequest($dataRequest);
					}
				}
        $this->BudgetRequest_model->update($Id, $data);
        
        $this->session->set_flashdata('message', 'Data diperbarui');
        redirect(site_url('BudgetRequest/update/' . $Id));
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('BudgetRequest'));
      }
    }

    public function delete($Id)
    {
      if($this->arrAccessMenu['Delete']){
        $row = $this->BudgetRequest_model->getById($Id);

        if ($row) {
          $data = array(
            'DeletedDate' => date('Y-m-d H:i:s'),
            'DeletedUserId' => $this->session->userdata('user_id')
          );

          $this->BudgetRequest_model->update($row->BudgetRequestId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('BudgetRequest'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('BudgetRequest'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('BudgetRequest'));
      }
    }

    public function ListData(){
        $sql = "SELECT a.*, b.name CreatedBy, c.name RecipientBy
								FROM trnbudgetrequest a 
								JOIN users b ON a.CreatedByUserId = b.id
								JOIN users c ON a.Recipient = c.id
								WHERE a.DeletedDate IS NULL ";

        $column_order = array( 
          'BudgetRequestNo',
          'BudgetRequestNo',
          'BudgetRequestDate',
          'CreatedBy',
          'RecipientBy',
          'LockDate',
          'Approval1Status',
          'Approval2Status',
        );
        
        $column_search = array(
          'BudgetRequestNo',
          'BudgetRequestDate',
          'b.name',
          'c.name',
          'LockDate',
          'Approval1Status',
          'Approval2Status',
        ); 

        $order = array('NoUrut' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        $no = 0;
        foreach ($list as $val) {
          $row = array();
          $no++;
          $row[] = $no;
          $row[] = $val->BudgetRequestNo;
          $row[] = $val->BudgetRequestDate;
          $row[] = $val->CreatedBy;
          $row[] = $val->RecipientBy;
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
          
          $action = '';
           if($val->Approval1Status != 0 && $val->Approval2Status != 0){
              $action.= '<a href="#" id="print" onclick="javascript:modalPrint(\''.$val->BudgetRequestId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak"></i>
                      </a>';
              $action.= '  ';
            }

          if($val->BudgetRequestId){
            $action.= anchor(site_url('BudgetRequest/update/'.$val->BudgetRequestId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'Edit'));
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

    $DataDetail = $this->BudgetRequest_model->getDetail($Id);
    $DataRequests = $this->BudgetRequest_model->getRequest($Id);
    
    ob_start();
      $this->load->view('report/budgetRequest',array('DataDetail' => $DataDetail, 'DataRequests' => $DataRequests));
      $html = ob_get_contents();
    ob_end_clean();

    $pdf = new mPDF('utf-8', 'A4');
    $pdf->AddPage('P');
    $pdf->WriteHtml($html);
    $pdf->Output('CA-A02-' . date('Y-m-d H i s') . '.pdf', 'I');
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
    $res = $this->BudgetRequest_model->update($Id, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';

    if ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      // $data    = $this->BudgetRequest_model->get_po_by_id($Id);
      // $subject = "Pemberitahuan PO";
      // $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      // $to = $to->email;

      // $set_message = "
      //   Informasi PO baru dengan No. ".$data->PoNo." diminta untuk direvisi oleh approver $Approval.
      // ";
      // $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnbudgetrequest', array('BudgetRequestId' => $Id), array('LockDate' => NULL));
      // $this->BudgetRequest_model->setNullRequestSppPoById($Id);
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

    $res = $this->BudgetRequest_model->update($Id, $data);
    if($res) echo 'Simpan tandatangan sukses'; else echo 'Simpan tandatangan gagal';
  }

  function Lock(){
    if(!$this->arrAccessMenu['Update']){
      $this->session->set_flashdata('message', 'Anda tidak punya akses');
    } else {
      $BudgetRequestId = $this->input->post('Id', TRUE);
      $data = array(
        'LockDate' => date("Y-m-d H:i:s"),
        'LockByUserId' => $this->session->userdata('user_id')
      );
      $res = $this->BudgetRequest_model->update($BudgetRequestId, $data);

      // // send email
      // $data    = $this->BudgetRequest_model->get_po_by_id($BudgetRequestId);
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

	public function store_upload($Id)
	{
		if($this->arrAccessMenu['Update']){
			$newName = 'budget_request_attachment_' . $Id . '_' . $_FILES["Attachment"]['name'];
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
				redirect(site_url('BudgetRequest'));
			}

			if($_FILES["Attachment"]['name']) {
				$data['Attachment'] = $newName;
			}
			$this->BudgetRequest_model->update($Id, $data);

			$this->session->set_flashdata('message', 'Data disimpan');
			redirect(site_url('BudgetRequest/update/'.$Id));
		} else {
			$this->session->set_flashdata('message', 'Anda tidak punya akses');
			redirect(site_url('BudgetRequest'));
		}
	}

	public function delete_upload($Id)
	{
		if($this->arrAccessMenu['Delete']){
			$row = $this->BudgetRequest_model->getById($Id);

			if ($row) {
				$data['Attachment'] = NULL;

				unlink("./upload/$row->Attachment");

				$this->BudgetRequest_model->update($row->BudgetRequestId, $data);

				$this->session->set_flashdata('message', 'Data upload dihapus');
				redirect(site_url('BudgetRequest/Update/' . $Id));
			} else {
				$this->session->set_flashdata('message', 'Data upload tidak ditemukan');
				redirect(site_url('BudgetRequest/Update/' . $Id));
			}
		} else {
			$this->session->set_flashdata('message', 'Anda tidak punya akses');
			redirect(site_url('BudgetRequest/Update/' . $Id));
		}
	}

	private function _rules()
	{
		$this->form_validation->set_rules('TotalAmount', 'Total Jumlah', 'trim|required');
		$this->form_validation->set_rules('NoUrut', 'Proyek', 'trim|required');
		$this->form_validation->set_rules('BudgetRequestNo', 'Nomor Berkas', 'trim|required');
		$this->form_validation->set_rules('BudgetRequestDate', 'Tanggal Berkas', 'trim|required');
		$this->form_validation->set_rules('Approval1', 'approval1', 'trim|required');
		$this->form_validation->set_rules('Approval2', 'approval2', 'trim|required');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

}
