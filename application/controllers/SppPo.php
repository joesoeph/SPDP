<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SppPo extends Parent_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->model(array('SppPo_model','GlobalModel','ListDataModel'));
      $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/sppPoList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[4]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      }

      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/sppForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->SppPo_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[4]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
             $Datas['ArrData'] = array(
                'button' => '',
                'action' => site_url('SppPo/create_action'),
            		'SppId' => $row->SppId,
            		'Dvo' => $row->Dvo,
            		'Cb' => $row->Cb,
                'NoUrut' => $row->NoUrut,
                'SppNo' => $row->SppNo,
                'ProyekId' => $row->ProyekId,
            		'Applicant' => $row->Applicant,
            		'SendTo' => $row->SendTo,
            		'UsedDate' => $row->UsedDate,
            		'Approval1' => $row->Approval1,
                'Approval1Status' => $row->Approval1Status,
                'Approval1Date' => $row->Approval1Date,
                'Approval1Note' => $row->Approval1Note,
                'Approval2' => $row->Approval2,
                'Approval2Status' => $row->Approval2Status,
                'Approval2Date' => $row->Approval2Date,
                'Approval2Note' => $row->Approval2Note,
            		'CreatedDate' => $row->CreatedDate,
            		'CreatedByUserId' => $row->CreatedByUserId,
            		'LastChangedDate' => $row->LastChangedDate,
            		'LastChangedByUserId' => $row->LastChangedByUserId,
            		'DeletedDate' => $row->DeletedDate,
            		'DeletedUserId' => $row->DeletedUserId,
            );

            $Datas['DataApproval1'] = $this->SppPo_model->approval1Selected($id);
            $Datas['DataApproval2'] = $this->SppPo_model->approval2Selected($id);
            $Datas['DataRequest'] = $this->SppPo_model->getRequestSpp($id);
            $Datas['DataProyek'] = $this->SppPo_model->proyekSelected($id);
          }

          $this->Layouts($Datas);
      } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('SppPo'));
      }
    }

    public function create()
    {
      $this->Content = 'content/sppForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //generate no urut
      $NoUrut = $this->SppPo_model->sppLanstNuUrut();
      $NoUrut = str_pad($NoUrut[0]->NoUrut+1, 4, '0', STR_PAD_LEFT);
      $SppNo  = $NoUrut."/SPP/".$this->_strProyekCode."/EPC/PP/".date("Y");

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[4]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('SppPo/create_action'),
            'attribute' => '',
      	    'SppId' => set_value('SppId'),
      	    'Dvo' => set_value('Dvo'),
      	    'Cb' => set_value('Cb'),
      	    'NoUrut' => $NoUrut,
            'SppNo' => set_value('SppNo', $SppNo),
            'ProyekId' => set_value('ProyekId'),
      	    'Applicant' => set_value('Applicant'),
      	    'SendTo' => set_value('SendTo'),
            'UsedDate' => set_value('UsedDate'),
      	    'LockDate' => set_value('LockDate'),
      	    'Approval1' => set_value('Approval1'),
            'Approval1Status' => set_value('Approval1Status'),
            'Approval1Date' => set_value('Approval1Date'),
            'Approval1Note' => set_value('Approval1Note'),
            'Approval2' => set_value('Approval2'),
            'Approval2Status' => set_value('Approval2Status'),
            'Approval2Date' => set_value('Approval2Date'),
            'Approval2Note' => set_value('Approval2Note'),
      	    'CreatedDate' => set_value('CreatedDate'),
      	    'CreatedByUserId' => set_value('CreatedByUserId'),
      	    'LastChangedDate' => set_value('LastChangedDate'),
      	    'LastChangedByUserId' => set_value('LastChangedByUserId'),
      	    'DeletedDate' => set_value('DeletedDate'),
      	    'DeletedUserId' => set_value('DeletedUserId'),
      	);

        $Datas['DataApproval1'] = $this->SppPo_model->approval1Selected();
        $Datas['DataApproval2'] = $this->SppPo_model->approval2Selected();
        $Datas['DataRequest'] = "";
        $Datas['DataProyek']  = $this->SppPo_model->proyekSelected();
      }

      $this->Layouts($Datas);
    }

    public function create_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[4]['Write']){
        $this->spp_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $SppId = uniqid();
            $SppId.= uniqid();
            $data = array(
              'SppId' => $SppId,
          		'Dvo' => $this->input->post('Dvo',TRUE),
          		'Cb' => $this->input->post('Cb',TRUE),
              'NoUrut' => $this->input->post('NoUrut',TRUE),
          		'SppNo' => $this->input->post('SppNo',TRUE),
              'ProyekId' => $this->input->post('ProyekId',TRUE),
          		'Applicant' => $this->input->post('Applicant',TRUE),
          		'SendTo' => $this->input->post('SendTo',TRUE),
          		'UsedDate' => $this->input->post('UsedDate',TRUE),
          		'Approval1' => $this->input->post('Approval1'),
              'Approval2' => $this->input->post('Approval2'),
          		'CreatedDate' => date("Y-m-d H:i:s"),
          		'CreatedByUserId' => $this->session->userdata('user_id')
        	  );

            $exst = $this->GlobalModel->getDataByWhere('trnspp', array('NoUrut' => $this->input->post('NoUrut',TRUE)));
            if($exst){
              $this->session->set_flashdata('message', 'No urut sudah digunakan');
              redirect(site_url('SppPo/update/'.$exst->SppId));
            }else{
              for ($i=1; $i <= 15; $i++) {
                if($this->input->post("ResourceCode".$i)){
                  $id = uniqid().uniqid();
                  $dataRequest = array(
                    'Id' => $id,
                    'SppId' => $SppId,
                    'Sort'  => $i,
                    'ResourceCode' => $this->input->post("ResourceCode".$i),
                    'QuantitySpp' => $this->input->post("QuantitySpp".$i),
                    'Unit' => $this->input->post("Unit".$i),
                    'Item' => $this->input->post("Jb".$i),
                    'Spesification' => $this->input->post("Spesification".$i),
                    'WorkFor' => $this->input->post("WorkFor".$i),
                  );
                  $this->SppPo_model->insertRequestSpp($dataRequest);
                }
              }

              $this->SppPo_model->insert($data);

              $this->session->set_flashdata('message', 'Data disimpan');
              redirect(site_url('SppPo/update/'.$SppId));
            }
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('SppPo'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/sppForm';
      $Datas['AddCss'] = ['assets/signature/css/signature-pad.css'];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = ['assets/signature/js/signature_pad.js', 'assets/signature/js/app.js'];

      $row = $this->SppPo_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[4]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $disabled = ($row->LockDate) ? "disabled" : ""; 

          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'action' => site_url('SppPo/update_action/'.$id),
            'attribute' => $disabled,
            'SppId' => set_value('SppId', $row->SppId),
            'Dvo' => set_value('Dvo', $row->Dvo),
            'Cb' => set_value('Cb', $row->Cb),
            'NoUrut' => set_value('NoUrut', $row->NoUrut),
            'SppNo' => set_value('SppNo', $row->SppNo),
            'ProyekId' => set_value('ProyekId', $row->ProyekId),
            'Applicant' => set_value('Applicant', $row->Applicant),
            'SendTo' => set_value('SendTo', $row->SendTo),
            'UsedDate' => set_value('UsedDate', $row->UsedDate),
            'LockDate' => set_value('LockDate', $row->LockDate),
            'Approval1' => set_value('Approval1', $row->Approval1),
            'Approval1Status' => set_value('Approval1Status', $row->Approval1Status),
            'Approval1Date' => set_value('Approval1Date', $row->Approval1Date),
            'Approval1Note' => set_value('Approval1Note', $row->Approval1Note),
            'Approval2' => set_value('Approval2', $row->Approval2),
            'Approval2Status' => set_value('Approval2Status', $row->Approval2Status),
            'Approval2Date' => set_value('Approval2Date', $row->Approval2Date),
            'Approval2Note' => set_value('Approval2Note', $row->Approval2Note),
            'Approval1Ttd' => set_value('Approval1Ttd', $row->Approval1Ttd),
            'Approval2Ttd' => set_value('Approval2Ttd', $row->Approval2Ttd),
            'CreatedByUserId' => $row->CreatedByUserId,
            'CreatedDate' => $row->CreatedDate,
            'LastChangedDate' => $row->LastChangedDate,
            'LastChangedByUserId' => $row->LastChangedByUserId,
            'DeletedUserId' => $row->DeletedUserId,
            'DeletedDate' => $row->DeletedDate,
          );

          $Datas['DataApproval1'] = $this->SppPo_model->approval1Selected($id);
          $Datas['DataApproval2'] = $this->SppPo_model->approval2Selected($id);
          $Datas['DataRequest'] = $this->SppPo_model->getRequestSpp($id);
          $Datas['DataProyek']  = $this->SppPo_model->proyekSelected($id);
          $Datas['DataVerifycationStatus']  = $this->GlobalModel->agreementVerifycationStatus($id);
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('SppPo'));
      }

    }

    public function update_action($SppId)
    {

      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[4]['Update']){
        $Approval = ($this->input->post('Approve') ? 1 : 0);
        $ApprovalDate = ($this->input->post('Approve') ? date("Y-m-d H:i:s") : NULL);
        $data = array(
        	'Dvo' => $this->input->post('Dvo',TRUE),
        	'Cb' => $this->input->post('Cb',TRUE),
        	'Applicant' => $this->input->post('Applicant',TRUE),
        	'SendTo' => $this->input->post('SendTo',TRUE),
        	'UsedDate' => $this->input->post('UsedDate',TRUE),
          'Approval1' => $this->input->post('Approval1'),
          'Approval2' => $this->input->post('Approval2'),
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

        $this->SppPo_model->deleteRequestSpp($SppId);
        for ($i=1; $i <= 15; $i++) {
          if($this->input->post("ResourceCode".$i)){
            $id = uniqid().uniqid();
            $dataRequest = array(
              'Id' => $id,
              'SppId' => $SppId,
              'Sort' => $i,
              'ResourceCode' => $this->input->post("ResourceCode".$i),
              'QuantitySpp' => $this->input->post("QuantitySpp".$i),
              'Unit' => $this->input->post("Unit".$i),
              'Item' => $this->input->post("Jb".$i),
              'Spesification' => $this->input->post("Spesification".$i),
              'WorkFor' => $this->input->post("WorkFor".$i),
            );
            $this->SppPo_model->insertRequestSpp($dataRequest);
          }
        }

        $this->SppPo_model->update($SppId, $data);

        $this->session->set_flashdata('message', 'Data diperbarui');
        redirect(site_url('SppPo/update/'.$SppId));
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('SppPo'));
      }
    }

    public function spp_rules()
    {
    	$this->form_validation->set_rules('Dvo', 'dvo', 'trim|required');
    	$this->form_validation->set_rules('Cb', 'cb', 'trim|required');
      $this->form_validation->set_rules('NoUrut', 'no urut', 'trim|required');
    	$this->form_validation->set_rules('SppNo', 'spp number', 'trim|required');
      $this->form_validation->set_rules('ProyekId', 'project', 'trim|required');
    	$this->form_validation->set_rules('Applicant', 'pemohon', 'trim|required');
      $this->form_validation->set_rules('Approval1', 'approval1', 'trim|required');
      $this->form_validation->set_rules('Approval2', 'approval2', 'trim|required');
    	// $this->form_validation->set_rules('UsedDate', 'used date', 'trim|required');

    	$this->form_validation->set_rules('SppId', 'SppId', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "trnspp.xls";
        $judul = "trnspp";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
      	xlsWriteLabel($tablehead, $kolomhead++, "Dvo");
      	xlsWriteLabel($tablehead, $kolomhead++, "Cb");
      	xlsWriteLabel($tablehead, $kolomhead++, "NoUrut");
      	xlsWriteLabel($tablehead, $kolomhead++, "ProyekId");
      	xlsWriteLabel($tablehead, $kolomhead++, "SendTo");
      	xlsWriteLabel($tablehead, $kolomhead++, "UsedDate");
      	xlsWriteLabel($tablehead, $kolomhead++, "Approval");
      	xlsWriteLabel($tablehead, $kolomhead++, "ApprovalDate");
      	xlsWriteLabel($tablehead, $kolomhead++, "CreatedDate");
      	xlsWriteLabel($tablehead, $kolomhead++, "CreatedByUserId");
      	xlsWriteLabel($tablehead, $kolomhead++, "LastChangedDate");
      	xlsWriteLabel($tablehead, $kolomhead++, "LastChangedByUserId");
      	xlsWriteLabel($tablehead, $kolomhead++, "DeletedDate");
      	xlsWriteLabel($tablehead, $kolomhead++, "DeletedUserId");

	      foreach ($this->SppPo_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->Dvo);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->Cb);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->NoUrut);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ProyekId);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->SendTo);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->UsedDate);
      	    xlsWriteNumber($tablebody, $kolombody++, $data->Approval);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ApprovalDate);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->CreatedDate);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->CreatedByUserId);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->LastChangedDate);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->LastChangedByUserId);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->DeletedDate);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->DeletedUserId);

      	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function ListData(){
        $sql = "SELECT
                      z.SppId, z.NoUrut as SppNoUrut, z.UsedDate as SppUsedDate, h.ProyekName as SppProyekName, z.Approval1Status as ApprovalSpp1Status,
                      z.Approval2Status as ApprovalSpp2Status, z.CreatedByUserId as SppCreateBy, u.name as SppCreatedByName, z.CreatedDate as SppCreatedDate,
                      x.PoId, x.NoUrut as PoNoUrut, x.PoDate, x.Approval1Status as ApprovalPo1Status, x.Approval2Status as ApprovalPo2Status, 
                      x.CreatedByUserId as PoCreateBy, y.Status, z.LockDate
                  FROM trnspp z LEFT JOIN trnpo x ON z.SppId=x.SppId
                  LEFT JOIN users u ON z.CreatedByUserId=u.id
                  JOIN trnproyek h ON z.ProyekId = h.ProyekId
                  LEFT JOIN seqagreementstatus y ON z.SppId = y.AgreementId
                  WHERE z.DeletedDate IS NULL ";
                  //if($this->session->userdata('verifycator')){
                    //$sql.=" AND z.LockDate IS NOT NULL";
                  //}

        $column_order = array( 
          'z.NoUrut',
          'z.UsedDate', 
          'h.ProyekName',
          'z.LockDate',
          'u.name',
          'z.NoUrut',
          'z.Approval1Status',
          'z.Approval2Status',
          'z.NoUrut'
        );
        
        $column_search = array(
          'z.NoUrut',
          'z.UsedDate', 
          'h.ProyekName',
          'z.LockDate',
          'u.name',
        ); 
        $order = array('z.NoUrut' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        foreach ($list as $val) {
            
            $row = array();
            $row[] = $val->SppNoUrut;
            $row[] = $val->SppUsedDate;
            $row[] = $val->SppProyekName;
            $row[] = $val->SppCreatedByName;
            $row[] = date("d M Y", strtotime($val->LockDate));
            
            if ($val->Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="SPP Diterima"></i>';
            } else if ($val->Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="SPP Ditolak"></i>';
            } else if ($val->Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi SPP"></i>';
            }else{
              $row[] = '';
            };
            
            if ($val->ApprovalSpp1Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="SPP Diterima"></i>';
            } else if ($val->ApprovalSpp1Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="SPP Ditolak"></i>';
            } else if ($val->ApprovalSpp1Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi SPP"></i>';
            }else{
              $row[] = '';
            };
            
            if ($val->ApprovalSpp2Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="SPP Diterima"></i>';
            } else if ($val->ApprovalSpp2Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="SPP Ditolak"></i>';
            } else if ($val->ApprovalSpp2Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi SPP"></i>';
            }else{
              $row[] = '';
            };
            
            if($val->ApprovalSpp1Status == 1 && $val->ApprovalSpp2Status == 1) {
              $row[] = '<a href="#" id="print" onclick="javascript:modalPrintSpp(\''.$val->SppId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak SPP"></i>
                      </a>
                      '.anchor(site_url('SppPo/update/'.$val->SppId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'Edit SPP'));
            }else{
              $row[] = anchor(
                        site_url('SppPo/update/'.$val->SppId),
                        '<i class="glyphicon glyphicon-pencil"></i>',
                        array('title'=>'Edit SPP'));
            }
            
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

  public function Report($SppId = NULL){
    $this->load->library('m_pdf');
    if(!$SppId){
      show_404();
    }

    $DataSpp = $this->SppPo_model->getDetailSpp($SppId);
    $DataRequest = $this->SppPo_model->getRequestSpp($SppId);
    $DataVerifycator = $this->GlobalModel->agreementVerifycationStatus($SppId);

    ob_start();
      $this->load->view('report/spp',array('DataSpp' => $DataSpp, 'DataRequest' => $DataRequest, 'DataVerifycator' => $DataVerifycator));
      $html = ob_get_contents();
    ob_end_clean();

    $pdf = new mPDF('utf-8', 'A4');
    $pdf->AddPage('P');
    $pdf->WriteHtml($html);
    $pdf->Output('Spp.pdf', 'I');
  }

  function Ttd(){
    $SppId = $this->input->post('SppId', TRUE);
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
    
    $res = $this->SppPo_model->update($SppId, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';

    if ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      $data    = $this->SppPo_model->get_by_id($SppId);
      $subject = "Pemberitahuan SPP";
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi SPP baru dengan No. ".$data->SppNo." diminta untuk direvisi oleh approver $Approval.
      ";
      $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnspp', array('SppId' => $SppId), array('LockDate' => NULL));
      // send email
    }
  }

  function TtdVerifycator(){
    $SppId = $this->input->post('SppId', TRUE);
    $JabatanId = $this->session->userdata('jabatanid');
    $data = array(
      'Ttd' => $this->input->post('Ttd'),
      'Status' => $this->input->post('ApprovalStatus', TRUE),
      'StatusByUserId' => $this->session->userdata('user_id'),
      'Note' => $this->input->post('ApprovalNote', TRUE),
      'StatusDate' => date("Y-m-d H:i:s")
    );
    
    $res = $this->GlobalModel->updateAgreementStatus($SppId, $JabatanId, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';

    $data    = $this->SppPo_model->get_by_id($SppId);
    $subject = "Pemberitahuan SPP";
    if($this->input->post('ApprovalStatus', TRUE) == 1){
      // send email
      $to_v = $this->SppPo_model->email_to_verificator($data->Approval1, $data->Approval2);
        
      $to = '';
      foreach ($to_v as $k) 
      {
          $to .= $k['email'].',';
      }

      $set_message = "
        Informasi SPP baru dengan No. ".$data->SppNo." menunggu untuk approve.
      ";
      $this->_send_email($to, $set_message, $subject);
      // send email
    }elseif ($this->input->post('ApprovalStatus', TRUE) == 2) {
      // send email
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi SPP baru dengan No. ".$data->SppNo." ditolak oleh verifikator.
      ";
      $this->_send_email($to, $set_message, $subject);
      // send email
    }elseif ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi SPP baru dengan No. ".$data->SppNo." diminta untuk direvisi oleh verifikator.
      ";
      $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnspp', array('SppId' => $SppId), array('LockDate' => NULL));
      // send email
    }
  }

  function LockSpp(){
    $arrAccessMenu = $this->session->userdata('access_menu');
    if(!$arrAccessMenu[4]['Update']){
      $this->session->set_flashdata('message', 'Anda tidak punya akses');
    } else {
      $SppId = $this->input->post('SppId', TRUE);
      $data = array(
        'LockDate' => date("Y-m-d H:i:s"),
        'LockByUserId' => $this->session->userdata('user_id')
      );
      $res = $this->SppPo_model->update($SppId, $data);

      // send email
      $data    = $this->SppPo_model->get_by_id($SppId);
      $subject = "Pemberitahuan SPP";

      if ($data->Approval1Status == 3) {
        $to = $this->GlobalModel->getEmailById($data->Approval1);
        $to = $to->email;
        $set_message = "
          Informasi SPP baru dengan No. ".$data->SppNo." telah direvisi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('trnspp', array('SppId' => $SppId), array('Approval1Status' => NULL, 'Approval1Note' => NULL, 'Approval1Ttd' => NULL, 'Approval1Date' => NULL));
      }elseif ($data->Approval2Status == 3) {
        $to = $this->GlobalModel->getEmailById($data->Approval2);
        $to = $to->email;
        $set_message = "
          Informasi SPP baru dengan No. ".$data->SppNo." telah direvisi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('trnspp', array('SppId' => $SppId), array('Approval2Status' => NULL, 'Approval2Note' => NULL, 'Approval2Ttd' => NULL, 'Approval2Date' => NULL));
      }else{
        $to_v2 = $this->GlobalModel->email_verificator($SppId);
        $to = "";
        foreach ($to_v2 as $k) 
        {
            $to .= $k['email'].',';
        }
        $set_message = "
          Informasi SPP baru dengan No. ".$data->SppNo." menunggu untuk diverifikasi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('seqagreementstatus', array('AgreementId' => $SppId), array('Status' => NULL, 'StatusDate' => NULL, 'StatusByUserId' => NULL, 'Note' => NULL, 'Ttd' => NULL));
      }
      // send email


      $this->session->set_flashdata('message', 'Data dikunci');
    }
  }

}

/* End of file SppPo.php */
/* Location: ./application/controllers/SppPo.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-23 07:26:43 */
/* http://harviacode.com */
