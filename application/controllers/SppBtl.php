<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SppBtl extends Parent_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('SppBtl_model','GlobalModel','ListDataModel'));
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/sppBtlList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[6]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      }
      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/sppBtlForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->SppBtl_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[6]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('SppBtl/create_action'),
          		'SppBtlId' => $row->SppBtlId,
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

          $Datas['DataApproval1'] = $this->SppBtl_model->approval1Selected($id);
          $Datas['DataApproval2'] = $this->SppBtl_model->approval2Selected($id);
          $Datas['DataRequest'] = $this->SppBtl_model->getRequestSppBtl($id);
          $Datas['DataProyek'] = $this->SppBtl_model->proyekSelected($id);
        }
        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('SppBtl'));
      }
    }

    public function create()
    {
      $this->Content = 'content/sppBtlForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[6]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        //generate no urut
        $NoUrut = $this->SppBtl_model->sppLanstNuUrut();
        $NoUrut = str_pad($NoUrut[0]->NoUrut+1, 4, '0', STR_PAD_LEFT);
        $SppNo  = $NoUrut."/SPPBTL/".$this->_strCodeAgreement."/EPC/PP/".date("Y");

        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'attribute' => '',
            'action' => site_url('SppBtl/create_action'),
      	    'SppBtlId' => set_value('SppBtlId'),
      	    'Dvo' => set_value('Dvo'),
      	    'Cb' => set_value('Cb'),
      	    'NoUrut' => $NoUrut,
            'SppNo' => $SppNo,
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

        $Datas['DataApproval1'] = $this->SppBtl_model->approval1Selected();
        $Datas['DataApproval2'] = $this->SppBtl_model->approval2Selected();
        $Datas['DataRequest'] = "";
        $Datas['DataProyek']  = $this->SppBtl_model->proyekSelected();
      }

      $this->Layouts($Datas);
    }

    public function create_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[6]['Write']){
        $this->spp_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $SppBtlId = uniqid();
            $SppBtlId.= uniqid();
            $data = array(
              'SppBtlId' => $SppBtlId,
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

            $exst = $this->GlobalModel->getDataByWhere('trnsppbtl', array('NoUrut' => $this->input->post('NoUrut',TRUE)));
            if($exst){
              $this->session->set_flashdata('message', 'No urut sudah digunakan');
              redirect(site_url('SppBtl/update/'.$exst->SppBtlId));
            }else{
              for ($i=1; $i <= 15; $i++) {
                if($this->input->post("ResourceCode".$i)){
                  $dataRequest = array(
                    'SppBtlId' => $SppBtlId,
                    'Sort'  => $i,
                    'ResourceCode' => $this->input->post("ResourceCode".$i),
                    'Quantity' => $this->input->post("Quantity".$i),
                    'Unit' => $this->input->post("Unit".$i),
                    'Item' => $this->input->post("Jb".$i),
                    'Spesification' => $this->input->post("Spesification".$i),
                    'WorkFor' => $this->input->post("WorkFor".$i),
                  );
                  $this->SppBtl_model->insertRequestSppBtl($dataRequest);
                  
                  // send email
                  // $subject = "Pemberitahuan SPP BTL Baru";
                  // $this->send_email($data, $subject);
                }
              }

              $this->SppBtl_model->insert($data);
              $this->session->set_flashdata('message', 'Data disimpan');
              redirect(site_url('SppBtl/update/'.$SppBtlId));
            }
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('SppBtl'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/sppBtlForm';
      $Datas['AddCss'] = ['assets/signature/css/signature-pad.css'];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = ['assets/signature/js/signature_pad.js', 'assets/signature/js/app.js'];

      $row = $this->SppBtl_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[6]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $attribute = ($row->LockDate) ? "disabled" : "";

          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'attribute' => $attribute,
            'action' => site_url('SppBtl/update_action/'.$id),
            'SppBtlId' => set_value('SppBtlId', $row->SppBtlId),
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

          $Datas['DataApproval1'] = $this->SppBtl_model->approval1Selected($id);
          $Datas['DataApproval2'] = $this->SppBtl_model->approval2Selected($id);
          $Datas['DataRequest'] = $this->SppBtl_model->getRequestSppBtl($id);
          $Datas['DataProyek']  = $this->SppBtl_model->proyekSelected($id);
          $Datas['DataVerifycationStatus']  = $this->GlobalModel->agreementVerifycationStatus($id);
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('SppBtl'));
      }

    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[6]['Update']){
        $this->spp_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $Approval = ($this->input->post('Approve') ? 1 : 0);
            $ApprovalDate = ($this->input->post('Approve') ? date("Y-m-d H:i:s") : NULL);
            $data = array(
            	'Dvo' => $this->input->post('Dvo',TRUE),
            	'Cb' => $this->input->post('Cb',TRUE),
            	'Applicant' => $this->input->post('Applicant',TRUE),
              'NoUrut' => $this->input->post('NoUrut',TRUE),
            	'SppNo' => $this->input->post('SppNo',TRUE),
            	'ProyekId' => $this->input->post('ProyekId',TRUE),
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

            $this->SppBtl_model->deleteRequestSppBtl($id);
            for ($i=1; $i <= 15; $i++) {
              if($this->input->post("ResourceCode".$i)){
                $dataRequest = array(
                  'SppBtlId' => $id,
                  'Sort' => $i,
                  'ResourceCode' => $this->input->post("ResourceCode".$i),
                  'Quantity' => $this->input->post("Quantity".$i),
                  'Unit' => $this->input->post("Unit".$i),
                  'Item' => $this->input->post("Jb".$i),
                  'Spesification' => $this->input->post("Spesification".$i),
                  'WorkFor' => $this->input->post("WorkFor".$i),
                );
                $this->SppBtl_model->insertRequestSppBtl($dataRequest);
              }
            }

            $this->SppBtl_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('SppBtl/update/'.$id));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('SppBtl'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[6]['Delete']){
        $row = $this->SppBtl_model->get_by_id($id);

        if ($row) {
          $data = array(
            'DeletedDate' => date('Y-m-d H:i:s'),
            'DeletedUserId' => $this->session->userdata('user_id')
          );

          $this->SppBtl_model->update($row->SppBtlId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('SppBtl'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('SppBtl'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('SppBtl'));
      }
    }

    public function spp_rules()
    {
    	$this->form_validation->set_rules('SppNo', 'number spp', 'trim|required');
    	$this->form_validation->set_rules('ProyekId', 'project', 'trim|required');
    	$this->form_validation->set_rules('Applicant', 'pemohon', 'trim|required');
      $this->form_validation->set_rules('Approval1', 'approval1', 'trim|required');
      $this->form_validation->set_rules('Approval2', 'approval2', 'trim|required');
    	$this->form_validation->set_rules('UsedDate', 'used date', 'trim|required');

    	$this->form_validation->set_rules('SppBtlId', 'SppBtlId', 'trim');
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

	      foreach ($this->SppBtl_model->get_all() as $data) {
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
        $sql = "SELECT a.*, b.name , c.ProyekName, y.Status
                FROM trnsppbtl a 
                LEFT JOIN users b ON a.CreatedByUserId=b.id 
                JOIN trnproyek c ON a.ProyekId = c.ProyekId
                LEFT JOIN seqagreementstatus y ON a.SppBtlId = y.AgreementId
                WHERE a.`DeletedDate` IS NULL";
                if($this->session->userdata('verifycator')){
                  $sql.=" AND a.LockDate IS NOT NULL";
                }

        $column_order = array( 
          'a.NoUrut',
          'a.UsedDate',
          'c.ProyekName',
          'a.CreatedDate', 
          'b.name',
          'a.NoUrut',
          'a.Approval1Status',
          'a.Approval2Status',
          'a.NoUrut',
        );
        
        $column_search = array(
          'a.NoUrut',
          'a.UsedDate',
          'c.ProyekName',
          'a.CreatedDate', 
          'b.name',
          'a.Approval1Status',
          'a.Approval2Status',
        ); 
        $order = array('a.NoUrut' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        foreach ($list as $val) {
            $row = array();
 
            $row[] = $val->NoUrut;
            $row[] = $val->UsedDate;
            $row[] = $val->ProyekName;
            $row[] = $val->name;
            $row[] = $val->CreatedDate;

            if ($val->Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="SPP BTL Diterima"></i>';
            } else if ($val->Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="SPP BTL Ditolak"></i>';
            } else if ($val->Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi SPP BTL"></i>';
            }else{
              $row[] = '';
            };
            
            if ($val->Approval1Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="SPP BTL Diterima"></i>';
            } else if ($val->Approval1Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="SPP BTL Ditolak"></i>';
            } else if ($val->Approval1Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi SPP BTL"></i>';
            }else{
              $row[] = '';
            };
            
            if ($val->Approval2Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="SPP BTL Diterima"></i>';
            } else if ($val->Approval2Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="SPP BTL Ditolak"></i>';
            } else if ($val->Approval2Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi SPP BTL"></i>';
            }else{
              $row[] = '';
            };
            
            if($val->Approval1Status == 1 && $val->Approval2Status == 1) {
              $row[] = '<a href="#" id="print" onclick="javascript:modalPrintSpp(\''.$val->SppBtlId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak SPP BTL"></i>
                      </a>
                      '.anchor(site_url('SppBtl/update/'.$val->SppBtlId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'Edit SPP BTL'));
            }else{
              $row[] = anchor(
                        site_url('SppBtl/update/'.$val->SppBtlId),
                        '<i class="glyphicon glyphicon-pencil"></i>',
                        array('title'=>'Edit SPP BTL'));
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
    
    
  public function Report($SppBtlId = NULL){
    $this->load->library('m_pdf');
    if(!$SppBtlId){
      show_404();
    }

    $DataSpp = $this->SppBtl_model->getDetailSppBtl($SppBtlId);
    $DataRequest = $this->SppBtl_model->getRequestSppBtl($SppBtlId);
    $DataVerifycator = $this->GlobalModel->agreementVerifycationStatus($SppBtlId);

    ob_start();
      $this->load->view('report/sppbtl',array('DataSpp' => $DataSpp, 'DataRequest' => $DataRequest, 'DataVerifycator' => $DataVerifycator));
      $html = ob_get_contents();
    ob_end_clean();

    $pdf = new mPDF('utf-8', 'A4');
    $pdf->AddPage('P');
    $pdf->WriteHtml($html);
    $pdf->Output('Spp.pdf', 'I');
  }

  function Ttd(){
    $SppBtlId = $this->input->post('SppBtlId', TRUE);
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
    
    $res = $this->SppBtl_model->update($SppBtlId, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';
    if ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      $data    = $this->SppBtl_model->get_by_id($SppBtlId);
      $subject = "Pemberitahuan SPP BTL";
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi SPP BTL baru dengan No. ".$data->SppNo." diminta untuk direvisi oleh approver $Approval.
      ";
      $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnsppbtl', array('SppBtlId' => $SppBtlId), array('LockDate' => NULL));
      // send email
    }
  }

  function TtdVerifycator(){
    $SppBtlId = $this->input->post('SppBtlId', TRUE);
    $JabatanId = $this->session->userdata('jabatanid');
    $data = array(
      'Ttd' => $this->input->post('Ttd'),
      'Status' => $this->input->post('ApprovalStatus', TRUE),
      'StatusByUserId' => $this->session->userdata('user_id'),
      'Note' => $this->input->post('ApprovalNote', TRUE),
      'StatusDate' => date("Y-m-d H:i:s")
    );
    
    $res = $this->GlobalModel->updateAgreementStatus($SppBtlId, $JabatanId, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';

    $data    = $this->SppBtl_model->get_by_id($SppBtlId);
    $subject = "Pemberitahuan SPP BTL";
    if($this->input->post('ApprovalStatus', TRUE) == 1){
      // send email
      $to_v = $this->SppBtl_model->email_to_verificator($data->Approval1, $data->Approval2);
        
      $to = '';
      foreach ($to_v as $k) 
      {
          $to .= $k['email'].',';
      }

      $set_message = "
        Informasi SPP BTL baru dengan No. ".$data->SppNo." menunggu untuk approve.
      ";
      $this->_send_email($to, $set_message, $subject);
      // send email
    }elseif ($this->input->post('ApprovalStatus', TRUE) == 2) {
      // send email
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi SPP BTL baru dengan No. ".$data->SppNo." ditolak oleh verifikator.
      ";
      $this->_send_email($to, $set_message, $subject);
      // send email
    }elseif ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi SPP BTL baru dengan No. ".$data->SppNo." diminta untuk direvisi oleh verifikator.
      ";
      $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnsppbtl', array('SppBtlId' => $SppBtlId), array('LockDate' => NULL));
      // send email
    }
  }

  function LockSppBtl(){
    $arrAccessMenu = $this->session->userdata('access_menu');
    if(!$arrAccessMenu[6]['Update']){
      $this->session->set_flashdata('message', 'Anda tidak punya akses');
    } else {
      $SppBtlId = $this->input->post('SppBtlId', TRUE);
      $data = array(
        'LockDate' => date("Y-m-d H:i:s"),
        'LockByUserId' => $this->session->userdata('user_id')
      );
      $res = $this->SppBtl_model->update($SppBtlId, $data);

      // send email
      $data    = $this->SppBtl_model->get_by_id($SppBtlId);
      $subject = "Pemberitahuan SPP BTL";

      if ($data->Approval1Status == 3) {
        $to = $this->GlobalModel->getEmailById($data->Approval1);
        $to = $to->email;
        $set_message = "
          Informasi SPP BTL baru dengan No. ".$data->SppNo." telah direvisi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('trnsppbtl', array('SppBtlId' => $SppBtlId), array('Approval1Status' => NULL, 'Approval1Note' => NULL, 'Approval1Ttd' => NULL, 'Approval1Date' => NULL));
      }elseif ($data->Approval2Status == 3) {
        $to = $this->GlobalModel->getEmailById($data->Approval2);
        $to = $to->email;
        $set_message = "
          Informasi SPP BTL baru dengan No. ".$data->SppNo." telah direvisi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('trnsppbtl', array('SppBtlId' => $SppBtlId), array('Approval2Status' => NULL, 'Approval2Note' => NULL, 'Approval2Ttd' => NULL, 'Approval2Date' => NULL));
      }else{
        $to_v2 = $this->GlobalModel->email_verificator($SppBtlId);
        $to = "";
        foreach ($to_v2 as $k) 
        {
            $to .= $k['email'].',';
        }
        $set_message = "
          Informasi SPP BTL baru dengan No. ".$data->SppNo." menunggu untuk diverifikasi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('seqagreementstatus', array('AgreementId' => $SppBtlId), array('Status' => NULL, 'StatusDate' => NULL, 'StatusByUserId' => NULL, 'Note' => NULL, 'Ttd' => NULL));
      }
      // send email

      $this->session->set_flashdata('message', 'Data dikunci');
    }
  }
}

/* End of file SppBtl.php */
/* Location: ./application/controllers/SppBtl.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-23 07:26:43 */
/* http://harviacode.com */
