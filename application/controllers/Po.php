<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Po extends Parent_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('SppPo_model','GlobalModel','ListDataModel'));
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/poList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[5]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      }

      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/sppForm';
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

      $row = $this->SppPo_model->get_by_id($id);
      if ($row) {
        if(!$arrAccessMenu[5]['Read']){
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
              'DescriptionPrice' => $row->DescriptionPrice,
              'DescriptionTypePayment' => $row->DescriptionTypePayment,
              'DescriptionTerm' => $row->DescriptionTerm,
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
          $Datas['DataProyek'] = $this->SppPo_model->proyekPoSelected($id);
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Po'));
      }
    }

    //create PO
    public function create()
    {
      $this->Content = 'content/poForm';
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

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[5]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        //generate no urut
        $NoUrut = $this->SppPo_model->poLanstNuUrut();
        $NoUrut = str_pad($NoUrut[0]->NoUrut+1, 4, '0', STR_PAD_LEFT);

        $array_bulan = array(1=> "I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII", 9=>"IX", 10=>"X", 11=>"XI", 12=>"XII");
        $PoNo   = $NoUrut."/PO/PP-EPC/".$this->_strCodeAgreement."/".$array_bulan[date('n')]."/".date("Y");
        $DescriptionPrice = "<p>Unit Price </p> <p>Harga tidak termasuk PPN & termasuk PPh material </p><p>Harga tidak termasuk Bobok Beton (Civil Works)</p>";
        $DescriptionTypePayment = "<p>Reguler T/T</p>
                                    <p>- 40% Down Payment</p>
                                    <p>- 50% Material on Site</p>
                                    <p>- 10% After Installation</p>";
        $DescriptionTerm = "<p>Apabila Barang yang dikirim tidak sesuai dengan pesanan dan kerusakan akibat Delivery, 
                                maka barang tersebut ditolak dan harus diganti
                                dengan yang sesuai tanpa memungut biaya apapun juga dari PT. PP (Persero).<p>
                                <p>Denda keterlambatan pekerjaan 1/1000 dari nilai kontrak, maksimum 5%</p>";
                                
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('Po/create_action/'),
            'attribute' => '',
            'PoId' => set_value('PoId'),
            'VendorId' => set_value('VendorId'),
            'NoUrut' => $NoUrut,
            'PoNo' => set_value('PoNo', $PoNo),
            'PoDate' => date("Y-m-d"),
            'SendTo' => set_value('SendTo'),
            'ReceiveDate' => set_value('ReceiveDate'),
            'ProyekId' => set_value('ProyekId'),
            'DescriptionPrice' => set_value('DescriptionPrice', $DescriptionPrice),
            'DescriptionTypePayment' => set_value('DescriptionTypePayment', $DescriptionTypePayment),
            'DescriptionTerm' => set_value('DescriptionTerm', $DescriptionTerm),
            'SuplierCode' => set_value('SuplierCode'),
            'TotalAmount' => set_value('TotalAmount'),
            'WithPpn' => set_value('WithPpn'),
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
        $Datas['DataRequest'] = '';
        $Datas['DataVendor'] = $this->SppPo_model->vendorSelected();
        $Datas['DataProyek']  = $this->SppPo_model->proyekPoSelected();
      }

      $this->Layouts($Datas);
    }

    //update PO
    public function update($PoId)
    {
      if($this->SppPo_model->get_po_by_id($PoId)){
        $this->Content = 'content/poForm';
        $Datas['AddCss'] = [
          'assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css',
          'assets/signature/css/signature-pad.css'
        ];
        $Datas['AddJsHeader'] = [
          'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/vendor/tinymce/tinymce.min.js'
        ];
        $Datas['AddJsFooter'] = [
          'assets/vendor/input-mask/js/inputmask.js',
          'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
          'assets/vendor/input-mask/js/jquery.inputmask.js',
          'assets/signature/js/signature_pad.js', 
          'assets/signature/js/app.js'
        ];

        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[5]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $DataPo = $this->SppPo_model->get_po_by_id($PoId);                                
          if($DataPo){
            $attribute = ($DataPo->LockDate) ? "disabled" : "";

            $Datas['ArrData'] = array(
                'button' => 'Perbarui',
                'attribute' => $attribute,
                'action' => site_url('Po/update_action/'.$PoId),
                'PoId' => set_value('PoId', $DataPo->PoId),
                'VendorId' => set_value('VendorId', $DataPo->VendorId),
                'NoUrut' => set_value('NoUrut', $DataPo->NoUrut),
                'PoNo' => set_value('PoNo', $DataPo->PoNo),
                'PoDate' => set_value('PoDate', $DataPo->PoDate),
                'SendTo' => set_value('SendTo', $DataPo->SendTo),
                'ProyekId' => set_value('ProyekId', $DataPo->ProyekId),
                'ReceiveDate' => set_value('ReceiveDate', $DataPo->ReceiveDate),
                'DescriptionPrice' => set_value('DescriptionPrice', $DataPo->DescriptionPrice),
                'DescriptionTypePayment' => set_value('DescriptionTypePayment', $DataPo->DescriptionTypePayment),
                'DescriptionTerm' => set_value('DescriptionTerm', $DataPo->DescriptionTerm),
                'SuplierCode' => set_value('SuplierCode', $DataPo->SuplierCode),
                'TotalAmount' => set_value('TotalAmount', $DataPo->TotalAmount),
                'WithPpn' => set_value('WithPpn', $DataPo->WithPpn),
                'LockDate' => set_value('LockDate', $DataPo->LockDate),
                'Approval1' => set_value('Approval1', $DataPo->Approval1),
                'Approval1Status' => set_value('Approval1Status', $DataPo->Approval1Status),
                'Approval1Date' => set_value('Approval1Date', $DataPo->Approval1Date),
                'Approval1Note' => set_value('Approval1Note', $DataPo->Approval1Note),
                'Approval2' => set_value('Approval2', $DataPo->Approval2),
                'Approval2Status' => set_value('Approval2Status', $DataPo->Approval2Status),
                'Approval2Date' => set_value('Approval2Date', $DataPo->Approval2Date),
                'Approval2Note' => set_value('Approval2Note', $DataPo->Approval2Note),
                'Approval1Ttd' => set_value('Approval1Ttd', $DataPo->Approval1Ttd),
                'Approval2Ttd' => set_value('Approval2Ttd', $DataPo->Approval2Ttd),
                'CreatedDate' => $DataPo->CreatedDate,
                'CreatedByUserId' => $DataPo->CreatedByUserId,
                'LastChangedDate' => $DataPo->LastChangedDate,
                'LastChangedByUserId' => $DataPo->LastChangedByUserId,
                'DeletedDate' => $DataPo->DeletedDate,
                'DeletedUserId' => $DataPo->DeletedUserId,
            );

            $Datas['DataApproval1'] = $this->SppPo_model->approvalPo1Selected($PoId);
            $Datas['DataApproval2'] = $this->SppPo_model->approvalPo2Selected($PoId);
            $Datas['DataRequest'] = $this->SppPo_model->getRequestPo($PoId);
            $Datas['DataVendor'] = $this->SppPo_model->vendorSelected($PoId);
            $Datas['DataProyek']  = $this->SppPo_model->proyekPoSelected($PoId);
            $Datas['DataVerifycationStatus']  = $this->GlobalModel->agreementVerifycationStatus($PoId);
          }
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Po'));
      }
    }

    public function create_action()
    {
      // var_dump($_POST);exit();
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[5]['Write']){
        $this->po_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create($SppId);
        } else {
            $PoId = uniqid();
            $PoId.= uniqid();

            // $DataSpp = $this->SppPo_model->get_by_id($SppId);

            $data = array(
              'PoId' => $PoId,
          		'VendorId' => $this->input->post('VendorId',TRUE),
          		'PoDate' => $this->input->post('PoDate',TRUE),
              'NoUrut' => $this->input->post('NoUrut',TRUE),
          		'PoNo' => $this->input->post('PoNo',TRUE),
          		'ReceiveDate' => $this->input->post('ReceiveDate',TRUE),
              'SendTo' => $this->input->post('SendTo',TRUE),
          		'SuplierCode' => $this->input->post('SuplierCode',TRUE),
              'TotalAmount' => $this->input->post('TotalAmount',TRUE),
              'WithPpn' => $this->input->post('WithPpn',TRUE),
              'DescriptionPrice' => $this->input->post('DescriptionPrice',TRUE),
              'DescriptionTypePayment' => $this->input->post('DescriptionTypePayment',TRUE),
              'DescriptionTerm' => $this->input->post('DescriptionTerm',TRUE),
          		'ProyekId' => $this->input->post('ProyekId',TRUE),
              'Approval1' => $this->input->post('Approval1',TRUE),
              'Approval2' => $this->input->post('Approval2',TRUE),
          		'CreatedDate' => date("Y-m-d H:i:s"),
          		'CreatedByUserId' => $this->session->userdata('user_id')
        	  );

            $exst = $this->GlobalModel->getDataByWhere('trnpo', array('NoUrut' => $this->input->post('NoUrut',TRUE)));
            if($exst){
              $this->session->set_flashdata('message', 'No urut sudah digunakan');
              redirect(site_url('Po/create/'.$exst->SppId));
            }else{

              for ($i=1; $i <= $this->input->post('TotalItem', TRUE); $i++) {
                // if($this->input->post("Check".$i)){
                if($this->input->post("QuantityPo".$i) && ($this->input->post("Price".$i) > 0)){
                  $dataRequest = array(
                    'PoId' => $PoId,
                    'Sort'  => $i,
                    'QuantityPo' => $this->input->post("QuantityPo".$i),
                    'Price' => $this->input->post("Price".$i),
                    'Amount' => $this->input->post("Amount".$i),
                  );
                  $this->SppPo_model->updateRequestSpp($this->input->post("Id".$i), $dataRequest);
                }
              }

              $this->SppPo_model->insertPo($data);
              
              $this->session->set_flashdata('message', 'Data disimpan');
              redirect(site_url('Po/update/'.$PoId));
            }
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Po'));
      }
    }

    public function update_action($SppId)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[5]['Update']){
        $PoId = $this->input->post('PoId',TRUE);
        $Approval1 = ($this->input->post('Approve1') ? 1 : 0);
        $Approval1Date = ($this->input->post('Approve1') ? date("Y-m-d H:i:s") : NULL);
        $data = array(
      		'PoDate' => $this->input->post('PoDate',TRUE),
      		'ReceiveDate' => $this->input->post('ReceiveDate',TRUE),
          'DescriptionPrice' => $this->input->post('DescriptionPrice',TRUE),
          'DescriptionTypePayment' => $this->input->post('DescriptionTypePayment',TRUE),
          'DescriptionTerm' => $this->input->post('DescriptionTerm',TRUE),
          'SendTo' => $this->input->post('SendTo',TRUE),
      		'SuplierCode' => $this->input->post('SuplierCode',TRUE),
          'TotalAmount' => $this->input->post('TotalAmount',TRUE),
          'WithPpn' => $this->input->post('WithPpn',TRUE),
          'Approval1' => $this->input->post('Approval1',TRUE),
          'Approval2' => $this->input->post('Approval2',TRUE),
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

        for ($i=1; $i <= $this->input->post('TotalItem', TRUE); $i++) {
          if($this->input->post("QuantityPo".$i) && ($this->input->post("Price".$i) > 0)){
            $dataRequest = array(
              'PoId' => $PoId,
              'Sort'  => $i,
              'QuantityPo' => $this->input->post("QuantityPo".$i),
              'Price' => $this->input->post("Price".$i),
              'Amount' => $this->input->post("Amount".$i),
            );
            $this->SppPo_model->updateRequestSpp($this->input->post("Id".$i), $dataRequest);
          }
        }

        // for ($i=1; $i <= 15; $i++) {
        //   if($this->input->post("QuantityPo".$i) && ($this->input->post("Price".$i) > 0)){
        //     $dataRequest = array(
        //       'Sort'  => $i,
        //       'QuantityPo' => $this->input->post("QuantityPo".$i),
        //       'Price' => $this->input->post("Price".$i),
        //       'Amount' => $this->input->post("Amount".$i),
        //     );
        //   }else{
        //     $dataRequest = array(
        //       'PoId' => NULL,
        //       'QuantityPo' => $this->input->post("QuantitySpp".$i),
        //       'Price' => 0,
        //       'Amount' => 0,
        //     );
        //   }
        //   $this->SppPo_model->updateRequestSpp($this->input->post("Id".$i), $dataRequest);
        // }
        // var_dump($data);exit;
        $this->SppPo_model->updatePo($PoId, $data);
        $data = $this->SppPo_model->get_po_by_id($PoId);
        if($data->Approval1Status == 2 || $data->Approval2Status == 2) $this->SppPo_model->updateSeqRequestSppPoTolak($PoId);
        
        
        $this->session->set_flashdata('message', 'Data diperbarui');
        redirect(site_url('Po/update/'.$SppId));
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Po'));
      }
    }
    ///////////

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[5]['Delete']){
        $row = $this->SppPo_model->get_by_id($id);

        if ($row) {
          $data = array(
            'DeletedDate' => date('Y-m-d H:i:s'),
            'DeletedUserId' => $this->session->userdata('user_id')
          );

          $this->SppPo_model->update($row->SppId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('Po'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Po'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Po'));
      }
    }

    public function po_rules()
    {
      $this->form_validation->set_rules('VendorId', 'Vendor', 'trim|required');
    	$this->form_validation->set_rules('ProyekId', 'Proyek', 'trim|required');
    	$this->form_validation->set_rules('PoNo', 'Nomor PO', 'trim|required');
    	$this->form_validation->set_rules('PoDate', 'Tanggal PO', 'trim|required');

    	$this->form_validation->set_rules('PoId', 'PO ID', 'trim');
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
                      x.NoUrut, x.PoId, x.PoNo, x.PoDate, x.Approval1Status as ApprovalPo1Status, 
                      x.Approval2Status as ApprovalPo2Status, x.CreatedByUserId as PoCreateBy, x.CreatedDate, x.ReceiveDate,
                      u.name, a.ProyekName, a.ProyekCode, y.Status, z.VendorId, z.VendorName, x.TotalAmount,
                      (select sum(Amount) from seqrequestspp where PoId = x.PoId) as NK, x.LockDate
                  FROM trnpo x LEFT JOIN users u ON x.CreatedByUserId=u.id
                  LEFT JOIN trnproyek a ON x.ProyekId=a.ProyekId
                  LEFT JOIN seqagreementstatus y ON x.PoId = y.AgreementId
                  LEFT JOIN mstvendor z on x.VendorId = z.VendorId
                  WHERE x.DeletedDate IS NULL ";
                  //if($this->session->userdata('verifycator')){
                    //$sql.=" AND x.LockDate IS NOT NULL";
                  //}

        $column_order = array( 
          'x.NoUrut',
          'x.NoUrut',
          'x.PoDate',
          'z.VendorName',
          'x.CreatedDate', 
          'u.name',
          'x.LockDate',
          'x.Approval1Status',
          'x.Approval2Status',
          'x.NoUrut',
        );
        
        $column_search = array(
          'x.NoUrut',
          'x.PoDate',
          'z.VendorName',
          'x.CreatedDate', 
          'u.name',
          'x.LockDate',
          'x.Approval1Status',
          'x.Approval2Status',
        ); 
        $order = array('x.NoUrut' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        $no = 0;
        foreach ($list as $val) {
          $row = array();
          $no++;
          $row[] = $no;
          $row[] = $val->NoUrut;
          $row[] = $val->PoDate;
          $row[] = $val->VendorName;
          $row[] = $val->name;
          $row[] = number_format($val->NK, 0, '.', ',');
           $row[] = date("d M Y", strtotime($val->LockDate));

          if ($val->Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="PO Diterima"></i>';
            } else if ($val->Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="PO Ditolak"></i>';
            } else if ($val->Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi PO"></i>';
            }else{
              $row[] = '';
            };
            
            if ($val->ApprovalPo1Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="PO Diterima"></i>';
            } else if ($val->ApprovalPo1Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="PO Ditolak"></i>';
            } else if ($val->ApprovalPo1Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi PO"></i>';
            }else{
              $row[] = '';
            };
            
            if ($val->ApprovalPo2Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="PO Diterima"></i>';
            } else if ($val->ApprovalPo2Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="PO Ditolak"></i>';
            } else if ($val->ApprovalPo2Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi PO"></i>';
            }else{
              $row[] = '';
            };
          
          $action = '';
           if($val->ApprovalPo1Status != 0 && $val->ApprovalPo2Status != 0){
              $action.= '<a href="#" id="print" onclick="javascript:modalPrintPo(\''.$val->PoId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak PO"></i>
                      </a>';
              $action.= '  ';
            }

          if($val->PoId){
            $action.= anchor(site_url('Po/update/'.$val->PoId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'Edit Po'));
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

  public function Report($PoId = NULL){
    $this->load->library('m_pdf');
    if(!$PoId){
      show_404();
    }

    $DataPo      = $this->SppPo_model->getDetailPo($PoId);
    $DataRequest = $this->SppPo_model->getRequestPo($PoId);
    $SeqSppPo    = $this->SppPo_model->getSppByProyekId(NULL, $PoId);
    $DataVerifycator = $this->GlobalModel->agreementVerifycationStatus($PoId);
    
    ob_start();
      $this->load->view('report/po',array('DataPo' => $DataPo, 'DataRequest' => $DataRequest, 'SeqSppPo' => $SeqSppPo, 'DataVerifycator' => $DataVerifycator));
      $html = ob_get_contents();
    ob_end_clean();

    $pdf = new mPDF('utf-8', 'A4');
    $pdf->AddPage('P');
    $pdf->WriteHtml($html);
    $pdf->Output('Spp.pdf', 'I');
  }

  public function LoadSpp($PoId = NULL)
  {
    $ProyekId = $this->input->post("ProyekId", TRUE);
    $DataSpp = $this->SppPo_model->getSppByProyekId($ProyekId, $PoId);
    if($DataSpp == NULL){
      $DataSpp = $this->SppPo_model->getSppByProyekId($ProyekId, NULL);
    }
    echo json_encode(array('DataSpp' => $DataSpp, 'TotalSpp' => count($DataSpp)));
  }

  public function loadSppItem()
  {
    $SppId = $this->input->post("SppId", TRUE);
    $PoId = $this->input->post("PoId", TRUE);
    $DataRequest = $this->SppPo_model->getRequestSppPo($SppId);
    if($PoId){
      $this->SppPo_model->setNullRequestSppPoByPoId($PoId);
    }
    
    echo json_encode($DataRequest);
  }

  function Ttd(){
    $PoId = $this->input->post('PoId', TRUE);
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
    $res = $this->SppPo_model->updatePo($PoId, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';

    if ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      $data    = $this->SppPo_model->get_po_by_id($PoId);
      $subject = "Pemberitahuan PO";
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi PO baru dengan No. ".$data->PoNo." diminta untuk direvisi oleh approver $Approval.
      ";
      $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnpo', array('PoId' => $PoId), array('LockDate' => NULL));
      // $this->SppPo_model->setNullRequestSppPoByPoId($PoId);
      // send email
    }

  }

  function TtdVerifycator(){
    $PoId = $this->input->post('PoId', TRUE);
    $JabatanId = $this->session->userdata('jabatanid');
    $data = array(
      'Ttd' => $this->input->post('Ttd'),
      'Status' => $this->input->post('ApprovalStatus', TRUE),
      'StatusByUserId' => $this->session->userdata('user_id'),
      'Note' => $this->input->post('ApprovalNote', TRUE),
      'StatusDate' => date("Y-m-d H:i:s")
    );
    
    $res = $this->GlobalModel->updateAgreementStatus($PoId, $JabatanId, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';

    $data    = $this->SppPo_model->get_po_by_id($PoId);
    $subject = "Pemberitahuan PO";
    if($this->input->post('ApprovalStatus', TRUE) == 1){
      // send email
      $to_v = $this->SppPo_model->email_to_verificator($data->Approval1, $data->Approval2);
        
      $to = '';
      foreach ($to_v as $k) 
      {
          $to .= $k['email'].',';
      }

      $set_message = "
        Informasi PO baru dengan No. ".$data->PoNo." menunggu untuk approve.
      ";
      $this->_send_email($to, $set_message, $subject);
      // send email
    }elseif ($this->input->post('ApprovalStatus', TRUE) == 2) {
      // send email
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi PO baru dengan No. ".$data->PoNo." ditolak oleh diverifikator.
      ";
      $this->_send_email($to, $set_message, $subject);
      // send email
    }elseif ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi PO baru dengan No. ".$data->PoNo." diminta untuk direvisi oleh verifikator.
      ";
      $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnpo', array('PoId' => $PoId), array('LockDate' => NULL));
      // $this->SppPo_model->setNullRequestSppPoByPoId($PoId);
      // send email
    }
  }

  function LockPo(){
    $arrAccessMenu = $this->session->userdata('access_menu');
    if(!$arrAccessMenu[5]['Update']){
      $this->session->set_flashdata('message', 'Anda tidak punya akses');
    } else {
      $PoId = $this->input->post('PoId', TRUE);
      $data = array(
        'LockDate' => date("Y-m-d H:i:s"),
        'LockByUserId' => $this->session->userdata('user_id')
      );
      $res = $this->SppPo_model->updatePo($PoId, $data);

      // send email
      $data    = $this->SppPo_model->get_po_by_id($PoId);
      $subject = "Pemberitahuan PO";

      if ($data->Approval1Status == 3) {
        $to = $this->GlobalModel->getEmailById($data->Approval1);
        $to = $to->email;
        $set_message = "
          Informasi PO baru dengan No. ".$data->PoNo." telah direvisi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('trnpo', array('PoId' => $PoId), array('Approval1Status' => NULL, 'Approval1Note' => NULL, 'Approval1Ttd' => NULL, 'Approval1Date' => NULL));
      }elseif ($data->Approval2Status == 3) {
        $to = $this->GlobalModel->getEmailById($data->Approval2);
        $to = $to->email;
        $set_message = "
          Informasi PO baru dengan No. ".$data->PoNo." telah direvisi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('trnpo', array('PoId' => $PoId), array('Approval2Status' => NULL, 'Approval2Note' => NULL, 'Approval2Ttd' => NULL, 'Approval2Date' => NULL));
      }else{
        $to_v2 = $this->GlobalModel->email_verificator($PoId);
        $to = "";
        foreach ($to_v2 as $k) 
        {
            $to .= $k['email'].',';
        }
        $set_message = "
          Informasi PO baru dengan No. ".$data->PoNo." menunggu untuk diverifikasi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('seqagreementstatus', array('AgreementId' => $PoId), array('Status' => NULL, 'StatusDate' => NULL, 'StatusByUserId' => NULL, 'Note' => NULL, 'Ttd' => NULL));
      }
      // send email

      $this->session->set_flashdata('message', 'Data dikunci');
    }
  }

}

/* End of file PO.php */
/* Location: ./application/controllers/SppPo.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-23 07:26:43 */
/* http://harviacode.com */
