<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Spk extends Parent_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Spk_model','GlobalModel','ListDataModel'));
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/spkList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[27]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      }
      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/spkForm';
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'assets/vendor/tinymce/tinymce.min.js'
      ];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js'
      ];

      $row = $this->Spk_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[27]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('Spk/create_action'),
              'SpkId' => $row->SpkId,
              'SpkNo' => $row->SpkNo,
              'ProyekId' => $row->ProyekId,
              'SpkNoUrut' => $row->SpkNoUrut,
              'DateSpk' => $row->DateSpk,
              'Foreman' => $row->Foreman,
              'Address' => $row->Address,
              'WorkType' => $row->WorkType,
              'WorkPlace' => $row->WorkPlace,
              'TotalValue' => $row->TotalValue,
              'Giver1' => $row->Giver1,
              'Giver2' => $row->Giver2,
              'Term' => $row->Term,
              'Approval1Status' =>  $row->Approval1Status,
              'Approval1Date' =>  $row->Approval1Date,
              'Approval1Note' =>  $row->Approval1Note,
              'Approval2Status' =>  $row->Approval2Status,
              'Approval2Date' =>  $row->Approval2Date,
              'Approval2Note' =>  $row->Approval2Note,
              'CreatedDate' => $row->CreatedDate,
              'CreatedByUserId' => $row->CreatedByUserId,
              'LastChangedDate' => $row->LastChangedDate,
              'LastChangedByUserId' => $row->LastChangedByUserId,
              'DeletedDate' => $row->DeletedDate,
              'DeletedUserId' => $row->DeletedUserId,
          );

          $Datas['Giver1'] = $this->Spk_model->giver1Selected($id);
          $Datas['Giver2'] = $this->Spk_model->giver2Selected($id);
          $Datas['SeqSpk'] = $this->Spk_model->getSeqSpk($id);
          $Datas['DataProyek']  = $this->Spk_model->proyekSelected($id);
        }
        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Spk'));
      }
    }

    public function create()
    {
      $this->Content = 'content/spkForm';
      $Datas['AddCss'] = [
        'assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'
      ];
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
      if(!$arrAccessMenu[27]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        //generate no urut
        $SpkNoUrut = $this->Spk_model->spkLanstNoUrut();
        $SpkNoUrut = str_pad($SpkNoUrut[0]->SpkNoUrut+1, 4, '0', STR_PAD_LEFT);
        $array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $SpkNo     = $SpkNoUrut."/EPC/PP-".$this->_strProyekCode."/".$array_bulan[date('n')]."/".date("Y");
        $Term      = "<p>1. Opnam pembayaran sesuai dengan progress dilapangan (Berita Acara Lapangan)</p>
                      <p>2. Lokasi harus selalu bersih dan rapih/housekeeping</p>
                      <p>3. Bersedia kerja lembur</p>
                      <p>4. Pekerjaan sesuai RKS, Shop Drawing dan bisa diterima oleh PT.PP (Persero) Tbk dan owner (PLN).</p>
                      <p>5. Harga Satuan tersebut sudah termasuk :</p>
                      <ul style='list-style-type:none'>
                        <li>a. Alat bantu/peralatan, listrik kerja, bahan bakar dan genset</li>
                        <li>b. Mobilisasi dan demobilisasi peralatan dan pekerja ke site serta penginapan pekerja</li>
                        <li>c. PPh dan pajak lainnya.</li>
                      </ul>
                      <p>6. APD (Alat Pelindung Diri) disediakan oleh Pemborong dan wajib digunakan selama berada dilingkungan proyek.</p>
                      <p>7. Berkas penagihan 100% dimasukkan setelah progress pekerjaan mencapai 100% dan dinyatakan dalam Berita Acara Penyelesaian dan Serah Terima Pekerjaan</p>
                      <p>8. Pembayaran dilakukan dengan sistem reguler T/T (telegraphic transfer) :</p>
                      <ul style='list-style-type:none'>
                        <li>a. 5% Site Mobilization</li>
                        <li>b. 90% Sesuai Progres Pekerjaan Lapangan (Berita acara ditandatangani kedua belah pihak)</li>
                        <li>c. 5% Retensi dibayarkan setelah waktu pemeliharaan selesai (12 bulan) dan menyerahkan BAST kedua.</li>
                      </ul>
                      <p>9. Pembayaran maksimal 60 (enam puluh) hari kelender setelah invoice masuk lengkap dan benar dan akan dipotong Pph 4%</p>
                      <p>10. Pelaksanaan pekerjaan sampai dengan tanggal 15 Juni 2016</p>";

        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'attribute' => '',
            'action' => site_url('Spk/create_action'),
            'SpkId' => set_value('SpkId'),
            'SpkNo' => set_value('SpkNo', $SpkNo),
            'ProyekId' => set_value('ProyekId'),
            'SpkNoUrut' => $SpkNoUrut,
            'DateSpk' => set_value('DateSpk'),
            'Foreman' => set_value('Foreman'),
            'Address' => set_value('Address'),
            'WorkType' => set_value('WorkType'),
            'WorkPlace' => set_value('WorkPlace'),
            'TotalValue' => set_value('TotalValue'),
            'Giver1' => set_value('Giver1'),
            'Giver2' => set_value('Giver2'),
            'Term' => set_value('Term', $Term),
            'LockDate' => set_value('LockDate'),
            'Approval1Status' => set_value('Approval1Status'),
            'Approval1Date' => set_value('Approval1Date'),
            'Approval1Note' => set_value('Approval1Note'),
            'Approval2Status' => set_value('Approval2Status'),
            'Approval2Date' => set_value('Approval2Date'),
            'Approval2Note' => set_value('Approval2Note'),
            'CreatedDate' => '',
            'CreatedByUserId' => '',
            'LastChangedDate' => '',
            'LastChangedByUserId' => '',
            'DeletedDate' => '',
            'DeletedUserId' => '',
        );

        $Datas['Giver1'] = $this->Spk_model->giver1Selected();
        $Datas['Giver2'] = $this->Spk_model->giver2Selected();
        $Datas['SeqSpk'] = $this->Spk_model->getSeqSpk();
        $Datas['DataProyek']  = $this->Spk_model->proyekSelected();
      }

      $this->Layouts($Datas);
    }

    public function create_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[27]['Write']){
        $this->spk_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $SpkId = uniqid();
            $SpkId.= uniqid();
            
            $TotalValue = explode(".",($this->input->post('TotalValue', TRUE)));
            $TotalValue = str_replace(",","",($TotalValue[0]));

            $data = array(
                'SpkId' => $SpkId,
                'SpkNo' => $this->input->post('SpkNo', TRUE),
                'ProyekId' => $this->input->post('ProyekId', TRUE),
                'SpkNoUrut' => $this->input->post('SpkNoUrut', TRUE),
                'DateSpk' => $this->input->post('DateSpk', TRUE),
                'Foreman' => $this->input->post('Foreman', TRUE),
                'Address' => $this->input->post('Address', TRUE),
                'WorkType' => $this->input->post('WorkType', TRUE),
                'WorkPlace' => $this->input->post('WorkPlace', TRUE),
                'TotalValue' => $TotalValue,
                'Giver1' => $this->input->post('Giver1', TRUE),
                'Giver2' => $this->input->post('Giver2', TRUE),
                'Term' => $this->input->post('Term', TRUE),
                'CreatedDate' => date("Y-m-d H:i:s"),
                'CreatedByUserId' => $this->session->userdata('user_id')
            );

            // var_dump($data);exit();
            $exst = $this->GlobalModel->getDataByWhere('trnspk', array('SpkNoUrut' => $this->input->post('SpkNoUrut',TRUE)));
            if($exst){
              $this->session->set_flashdata('message', 'No urut sudah digunakan');
              redirect(site_url('Spk/update/'.$exst->SpkId));
            }else{
              for ($i=1; $i <= $_POST['row']; $i++) {
                if(
                    $_POST['WbsCode'][$i] || $_POST['Working'][$i] || $_POST['Unit'][$i] ||
                    $_POST['Volume'][$i] || $_POST['UnitPrice'][$i] || $_POST['TotalAmount'][$i]
                  ){
                    
                    $UnitPrice = explode(".",($_POST['UnitPrice'][$i]));
                    $UnitPrice = str_replace(",","",($UnitPrice[0]));
                    
                    $UnitAmount = explode(".",($_POST['TotalAmount'][$i]));
                    $UnitAmount = str_replace(",","",($UnitAmount[0]));
                      
                    $dataRequest = array(
                      'SpkId' => $SpkId,
                      'Sort'  => $i,
                      'WbsCode' => $_POST["WbsCode"][$i],
                      'Volume' => $_POST["Volume"][$i],
                      'Unit' => $_POST["Unit"][$i],
                      'Working' => $_POST["Working"][$i],
                      'UnitPrice' => $UnitPrice,
                      'TotalAmount' => $UnitAmount,
                    );
                    $this->Spk_model->insertSeqSpk($dataRequest);
                  }
              }

              $this->Spk_model->insert($data);
              // send email
              // $subject = "Pemberitahuan SPK Baru";
              // $this->send_email($data, $subject);
              
              $this->session->set_flashdata('message', 'Data disimpan');
              redirect(site_url('Spk/update/'.$SpkId));
            }
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Spk'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/spkForm';
      $Datas['AddCss'] = [
        'assets/signature/css/signature-pad.css', 
        'assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'
      ];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'assets/vendor/tinymce/tinymce.min.js',
      ];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js',
        'assets/signature/js/signature_pad.js', 
        'assets/signature/js/app.js'
      ];

      $row = $this->Spk_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[27]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $attribute = ($row->LockDate) ? "disabled" : "";

          $Datas['ArrData'] = array(
              'button' => 'Perbarui',
              'attribute' => $attribute,
              'action' => site_url('Spk/update_action/'.$id),
              'SpkId' => set_value('SpkId', $row->SpkId),
              'SpkNo' => set_value('SpkNo', $row->SpkNo),
              'ProyekId' => set_value('ProyekId', $row->ProyekId),
              'SpkNoUrut' => set_value('SpkNoUrut', $row->SpkNoUrut),
              'DateSpk' => set_value('DateSpk', $row->DateSpk),
              'Foreman' => set_value('Foreman', $row->Foreman),
              'Address' => set_value('Address', $row->Address),
              'WorkType' => set_value('WorkType', $row->WorkType),
              'WorkPlace' => set_value('WorkPlace', $row->WorkPlace),
              'TotalValue' => set_value('TotalValue', $row->TotalValue),
              'Giver1' => set_value('Giver1', $row->Giver1),
              'Giver2' => set_value('Giver2', $row->Giver2),
              'Term' => set_value('Term', $row->Term),
              'LockDate' => set_value('LockDate', $row->LockDate),
              'Approval1Status' => set_value('Approval1Status', $row->Approval1Status),
              'Approval1Date' => set_value('Approval1Date', $row->Approval1Date),
              'Approval1Note' => set_value('Approval1Note', $row->Approval1Note),
              'Approval2Status' => set_value('Approval2Status', $row->Approval2Status),
              'Approval2Date' => set_value('Approval2Date', $row->Approval2Date),
              'Approval2Note' => set_value('Approval2Note', $row->Approval2Note),
              'Approval1Ttd' => set_value('Approval1Ttd', $row->Approval1Ttd),
              'Approval2Ttd' => set_value('Approval2Ttd', $row->Approval2Ttd),
              'CreatedDate' => set_value('CreatedDate', $row->CreatedDate),
              'CreatedByUserId' => set_value('CreatedByUserId', $row->CreatedByUserId),
              'LastChangedDate' => set_value('LastChangedDate', $row->LastChangedDate),
              'LastChangedByUserId' => set_value('LastChangedByUserId', $row->LastChangedByUserId),
              'DeletedDate' => set_value('DeletedDate', $row->DeletedDate),
              'DeletedUserId' => set_value('DeletedUserId', $row->DeletedUserId),
          );

          $Datas['Giver1'] = $this->Spk_model->giver1Selected($id);
          $Datas['Giver2'] = $this->Spk_model->giver2Selected($id);
          $Datas['SeqSpk'] = $this->Spk_model->getSeqSpk($id);
          $Datas['DataProyek']  = $this->Spk_model->proyekSelected($id);
          $Datas['DataVerifycationStatus']  = $this->GlobalModel->agreementVerifycationStatus($id);
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Spk'));
      }

    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[27]['Update']){
        $this->spk_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $TotalValue = explode(".",($this->input->post('TotalValue', TRUE)));
            $TotalValue = str_replace(",","",($TotalValue[0]));
            
            $data = array(
                'SpkNo' => $this->input->post('SpkNo', TRUE),
                'ProyekId' => $this->input->post('ProyekId', TRUE),
                'SpkNoUrut' => $this->input->post('SpkNoUrut', TRUE),
                'DateSpk' => $this->input->post('DateSpk', TRUE),
                'Foreman' => $this->input->post('Foreman', TRUE),
                'Address' => $this->input->post('Address', TRUE),
                'WorkType' => $this->input->post('WorkType', TRUE),
                'WorkPlace' => $this->input->post('WorkPlace', TRUE),
                'TotalValue' => $TotalValue,
                'Giver1' => $this->input->post('Giver1', TRUE),
                'Giver2' => $this->input->post('Giver2', TRUE),
                'Term' => $this->input->post('Term', TRUE),
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

            $this->Spk_model->deleteSeqSpk($id);
            for ($i=1; $i <= $_POST['row']; $i++) {
              if(
                  $_POST['WbsCode'][$i] || $_POST['Working'][$i] || $_POST['Unit'][$i] ||
                  $_POST['Volume'][$i] || $_POST['UnitPrice'][$i] || $_POST['TotalAmount'][$i]
                ){
                    $UnitPrice = explode(".",($_POST['UnitPrice'][$i]));
                    $UnitPrice = str_replace(",","",($UnitPrice[0]));
                    
                    $UnitAmount = explode(".",($_POST['TotalAmount'][$i]));
                    $UnitAmount = str_replace(",","",($UnitAmount[0]));
                    
                  $dataRequest = array(
                    'SpkId' => $id,
                    'Sort'  => $i,
                    'WbsCode' => $_POST["WbsCode"][$i],
                    'Volume' => $_POST["Volume"][$i],
                    'Unit' => $_POST["Unit"][$i],
                    'Working' => $_POST["Working"][$i],
                    'UnitPrice' => $UnitPrice,
                    'TotalAmount' => $UnitAmount,
                  );
                  $this->Spk_model->insertSeqSpk($dataRequest);
                }
            }

            $this->Spk_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('Spk/update/'.$id));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Spk'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[27]['Delete']){
        $row = $this->Spk_model->get_by_id($id);

        if ($row) {
          $data = array(
            'DeletedDate' => date('Y-m-d H:i:s'),
            'DeletedUserId' => $this->session->userdata('user_id')
          );

          $this->Spk_model->update($row->SpkId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('Spk'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Spk'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Spk'));
      }
    }

    public function spk_rules()
    {
      $this->form_validation->set_rules('ProyekId', 'project', 'trim|required');
      $this->form_validation->set_rules('SpkNo', 'spk number', 'trim|required');

      $this->form_validation->set_rules('SpkId', 'spkid', 'trim');
      $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function ListData(){
        $sql = "SELECT a.*, b.ProyekName, b.ProyekCode, c.name, y.Status,
                    (select sum(TotalAmount) from seqspk where SpkId = a.SpkId ) NK
                  FROM trnspk a LEFT JOIN trnproyek b ON a.ProyekId=b.ProyekId 
                  LEFT JOIN users c ON a.CreatedByUserId=c.id
                  LEFT JOIN seqagreementstatus y ON a.SpkId = y.AgreementId
                WHERE a.DeletedDate IS NULL";
                //if($this->session->userdata('verifycator')){
                //  $sql.=" AND a.LockDate IS NOT NULL";
                //}

        $column_order = array( 
          'a.SpkNo',
          'a.SpkNo',
          'a.DateSpk',
          'a.Foreman', 
          'c.name',
          'a.TotalValue',
          'a.SpkNo',
          'a.Approval1Status',
          'a.Approval2Status',
          'a.SpkNo'
        );
        
        $column_search = array(
          'a.SpkNo',
          'a.DateSpk',
          'a.Foreman', 
          'c.name',
          'a.TotalValue',
          'a.Approval1Status',
          'a.Approval2Status',
        ); 

        $order = array('a.SpkNo' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        $no = 0;
        foreach ($list as $val) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $val->SpkNoUrut;
            $row[] = date("d F Y", strtotime($val->DateSpk));
            $row[] = $val->Foreman;
            $row[] = $val->name;
            $row[] = number_format($val->NK, 0, '.', ',');

            if ($val->Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="SPK Diterima"></i>';
            } else if ($val->Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="SPK Ditolak"></i>';
            } else if ($val->Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi SPK"></i>';
            }else{
              $row[] = '';
            };
            
            if ($val->Approval1Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="SPK Diterima"></i>';
            } else if ($val->Approval1Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="SPK Ditolak"></i>';
            } else if ($val->Approval1Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi SPK"></i>';
            }else{
              $row[] = '';
            };
            
            if ($val->Approval2Status == 1) {
              $row[] = '<i class="glyphicon glyphicon-ok" title="SPK Diterima"></i>';
            } else if ($val->Approval2Status == 2) {
              $row[] = '<i class="glyphicon glyphicon-remove" title="SPK Ditolak"></i>';
            } else if ($val->Approval2Status == 3) {
              $row[] = '<i class="glyphicon glyphicon-pencil" title="Revisi SPK"></i>';
            }else{
              $row[] = '';
            };
            
            if($val->Approval1Status == 1 && $val->Approval2Status == 1) {
              $row[] = '<a href="#" id="print" onclick="javascript:modalPrint(\''.$val->SpkId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak SPK"></i>
                      </a>
                      '.anchor(site_url('Spk/update/'.$val->SpkId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'Edit SPK'));
            }else{
              $row[] = anchor(
                        site_url('Spk/update/'.$val->SpkId),
                        '<i class="glyphicon glyphicon-pencil"></i>',
                        array('title'=>'Edit SPK'));
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

  public function Report($SpkId = NULL){
    $this->load->library('m_pdf');
    if(!$SpkId){
      show_404();
    }

    $DataSpk = $this->Spk_model->getDetailSpk($SpkId);
    $DataRequest = $this->Spk_model->getSeqSpk($SpkId);
    $DataVerifycator = $this->GlobalModel->agreementVerifycationStatus($SpkId);
    
    ob_start();
      $this->load->view('report/spk',array('DataSpk' => $DataSpk, 'DataRequest' => $DataRequest, 'DataVerifycator' => $DataVerifycator));
      $html = ob_get_contents();
    ob_end_clean();

    $pdf = new mPDF('utf-8', 'A4');
    $pdf->AddPage('P');
    $pdf->WriteHtml($html);
    $pdf->Output('SPK.pdf', 'I');
  }

  function Ttd(){
    $SpkId = $this->input->post('SpkId', TRUE);
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
    
    $res = $this->Spk_model->update($SpkId, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';
    if ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      $data    = $this->Spk_model->get_by_id($SpkId);
      $subject = "Pemberitahuan SPK";
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi SPK baru dengan No. ".$data->SpkNo." diminta untuk direvisi oleh approver $Approval.
      ";
      $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnspk', array('SpkId' => $SpkId), array('LockDate' => NULL));
      // send email
    }
  }

  function TtdVerifycator(){
    $SpkId = $this->input->post('SpkId', TRUE);
    $JabatanId = $this->session->userdata('jabatanid');
    $data = array(
      'Ttd' => $this->input->post('Ttd'),
      'Status' => $this->input->post('ApprovalStatus', TRUE),
      'StatusByUserId' => $this->session->userdata('user_id'),
      'Note' => $this->input->post('ApprovalNote', TRUE),
      'StatusDate' => date("Y-m-d H:i:s")
    );
    
    $res = $this->GlobalModel->updateAgreementStatus($SpkId, $JabatanId, $data);
    if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';

    $data    = $this->Spk_model->get_by_id($SpkId);
    $subject = "Pemberitahuan SPK";
    if($this->input->post('ApprovalStatus', TRUE) == 1){
      // send email
      $to_v = $this->Spk_model->email_to_verificator($data->Giver1, $data->Giver2);
        
      $to = '';
      foreach ($to_v as $k) 
      {
          $to .= $k['email'].',';
      }
      
      $set_message = "
        Informasi SPK baru dengan No. ".$data->SpkNo." menunggu untuk approve.
      ";
      $this->_send_email($to, $set_message, $subject);
      // send email
    }elseif ($this->input->post('ApprovalStatus', TRUE) == 2) {
      // send email
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi SPK baru dengan No. ".$data->SpkNo." ditolak oleh verifikator.
      ";
      $this->_send_email($to, $set_message, $subject);
      // send email
    }elseif ($this->input->post('ApprovalStatus', TRUE) == 3) {//status revisi
      // send email
      $to = $this->GlobalModel->getEmailById($data->LockByUserId);
        
      $to = $to->email;

      $set_message = "
        Informasi SPK baru dengan No. ".$data->SpkNo." diminta untuk direvisi oleh verifikator.
      ";
      $this->_send_email($to, $set_message, $subject);
      $this->GlobalModel->globalUpdate('trnspk', array('SpkId' => $SpkId), array('LockDate' => NULL));
      // send email
    }
  }

  function LockSpk(){
    $arrAccessMenu = $this->session->userdata('access_menu');
    if(!$arrAccessMenu[27]['Update']){
      $this->session->set_flashdata('message', 'Anda tidak punya akses');
    } else {
      $SpkId = $this->input->post('SpkId', TRUE);
      $data = array(
        'LockDate' => date("Y-m-d H:i:s"),
        'LockByUserId' => $this->session->userdata('user_id')
      );
      $res = $this->Spk_model->update($SpkId, $data);

      // send email
      $data    = $this->Spk_model->get_by_id($SpkId);
      $subject = "Pemberitahuan SPK";

      if ($data->Approval1Status == 3) {
        $to = $this->GlobalModel->getEmailById($data->Giver1);
        $to = $to->email;
        $set_message = "
          Informasi SPK baru dengan No. ".$data->SpkNo." telah direvisi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('trnspk', array('SpkId' => $SpkId), array('Approval1Status' => NULL, 'Approval1Note' => NULL, 'Approval1Ttd' => NULL, 'Approval1Date' => NULL));
      }elseif ($data->Approval2Status == 3) {
        $to = $this->GlobalModel->getEmailById($data->Giver2);
        $to = $to->email;
        $set_message = "
          Informasi SPK baru dengan No. ".$data->SpkNo." telah direvisi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('trnspk', array('SpkId' => $SpkId), array('Approval2Status' => NULL, 'Approval2Note' => NULL, 'Approval2Ttd' => NULL, 'Approval2Date' => NULL));
      }else{
        $to_v2 = $this->GlobalModel->email_verificator($SpkId);
        $to = "";
        foreach ($to_v2 as $k) 
        {
            $to .= $k['email'].',';
        }
        $set_message = "
          Informasi SPK baru dengan No. ".$data->SpkNo." menunggu untuk diverifikasi.
        ";
        $this->_send_email($to, $set_message, $subject);
        $this->GlobalModel->globalUpdate('seqagreementstatus', array('AgreementId' => $SpkId), array('Status' => NULL, 'StatusDate' => NULL, 'StatusByUserId' => NULL, 'Note' => NULL, 'Ttd' => NULL));
      }
      // send email

      $this->session->set_flashdata('message', 'Data dikunci');
    }
  }
}

/* End of file Spk.php */
/* Location: ./application/controllers/Spk.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-23 07:26:43 */
/* http://harviacode.com */
