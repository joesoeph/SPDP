<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Seqproyek extends Parent_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Seqproyek_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/seqproyekList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $Datas['ArrData'] = $this->Seqproyek_model->get_all();

      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/seqproyekForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->Seqproyek_model->get_by_id($id);
      if ($row) {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('seqproyek/create_action'),
		'ProyekSeqId' => $row->ProyekSeqId,
		'ProyekId' => $row->ProyekId,
		'VendorId' => $row->VendorId,
	);
          $this->Layouts($Datas);
      } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('seqproyek'));
      }
    }

    public function create()
    {
      $this->Content = 'content/seqproyekForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $Datas['ArrData'] = array(
          'button' => 'Create',
          'action' => site_url('seqproyek/create_action'),
	    'ProyekSeqId' => set_value('ProyekSeqId'),
	    'ProyekId' => set_value('ProyekId'),
	    'VendorId' => set_value('VendorId'),
	);$this->Layouts($Datas);
    }

    public function create_action()
    {
      $this->_rules();

      if ($this->form_validation->run() == FALSE) {
          $this->create();
      } else {
        $data = array(
		'ProyekId' => $this->input->post('ProyekId',TRUE),
		'VendorId' => $this->input->post('VendorId',TRUE),
	    );

          $this->seqproyek_model->insert($data);
          $this->session->set_flashdata('message', 'Data disimpan');
          redirect(site_url('seqproyek'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/seqproyekForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->seqproyek_model->get_by_id($id);

      if ($row) {
        $Datas['ArrData'] = array(
                              'button' => 'Update',
                              'action' => site_url('seqproyek/update_action/'.$id),
		'ProyekSeqId' => set_value('ProyekSeqId', $row->ProyekSeqId),
		'ProyekId' => set_value('ProyekId', $row->ProyekId),
		'VendorId' => set_value('VendorId', $row->VendorId),
	    );
        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('seqproyek'));
      }

    }

    public function update_action($id)
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('ProyekSeqId', TRUE));
        } else {
            $data = array(
		'ProyekId' => $this->input->post('ProyekId',TRUE),
		'VendorId' => $this->input->post('VendorId',TRUE),
	    );

            $this->Seqproyek_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('seqproyek'));
        }
    }

    public function delete($id)
    {
      $row = $this->Seqproyek_model->get_by_id($id);

      if ($row) {
        $data = array(
                  'DeletedDate' => date('Y-m-d H:i:s'),
                  'DeletedUserId' => $this->session->userdata('user_id')
                );

        $this->Seqproyek_model->update($row->ProyekSeqId, $data);

        $this->session->set_flashdata('message', 'Data telah dihapus');
        redirect(site_url('seqproyek'));
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('seqproyek'));
      }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('ProyekId', 'proyekid', 'trim|required');
	$this->form_validation->set_rules('VendorId', 'vendorid', 'trim|required');

	$this->form_validation->set_rules('ProyekSeqId', 'ProyekSeqId', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function report()
    {
      $data = [];
        //load the view and saved it into $html variable
        $html=$this->load->view('report/agrrement', $data, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = "output_pdf_name.pdf";

        //load mPDF library
        $this->load->library('m_pdf');

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
/*
    public function report()
    {
      $this->load->library('pdf');

      global $title;
      $fpdf = new PDF('P', 'cm', 'A4');
      $title = 'Disposisi';
      $fpdf->SetTitle($title);
      $fpdf->AliasNbPages();
      $fpdf->AddPage();
      $fpdf->Ln();
      $fpdf->SetTextColor(0, 0, 0);
      $fpdf->setFont('Arial', 'B', 11);
      $fpdf->Text(7, 1, 'PT. PEMBANGUNAN PERUMAHAN (PERSERO)');

      $fpdf->setFont('Arial', '', 9);
      $fpdf->SetY(1.5);
      $fpdf->SetX(7);
      $fpdf->Cell(3.5, 1, 'DIVISI (DIVISION)', '', 0, '');
      $fpdf->Cell(5, 1, ':', '', 0, '');
      $fpdf->SetY(2);
      $fpdf->SetX(7);
      $fpdf->Cell(3.5, 1, 'PROYEK (PROJECT)', '', 0, '');
      $fpdf->Cell(5, 1, ':', '', 0, '');
      $fpdf->SetY(2.5);
      $fpdf->SetX(7);
      $fpdf->Cell(3.5, 1, 'ALAMAT (ADDRESS)', '', 0, '');
      $fpdf->Cell(5, 1, ':', '', 0, '');

      $fpdf->setFont('Arial', 'BU', 11);
      $fpdf->Text(7.6, 4.5, 'SURAT PERJANJIAN PENGANGKUTAN');
      $fpdf->setFont('Arial', 'B', 10);
      $fpdf->Text(8.4, 5, '(TRANSPORTATION AGREEMENT)');

      $fpdf->setFont('Arial', 'B', 10);
      $fpdf->Text(8, 6, 'Kontrak No.');

      $fpdf->setFont('Arial', '', 10);
      $fpdf->SetX(1);
      $fpdf->SetY(7);
      $fpdf->MultiCell(5, 0.5, "1. Kepada\n    (To)", 'LRTB', 1, '');
      $fpdf->SetY(7);
      $fpdf->SetX(6);
      $fpdf->setFont('Arial', 'B', 10);
      $fpdf->MultiCell(8, 0.5, ": ", 'LRTB', 1, '');
      $fpdf->SetY(7);
      $fpdf->SetX(13);
      $fpdf->setFont('Arial', '', 10);
      $fpdf->MultiCell(1, 0.5, "2", 'LRTB', 1, '');
      $fpdf->SetY(7);
      $fpdf->SetX(14);
      $fpdf->MultiCell(3, 0.5, "2. Tanggal\n    (Date)", 'LRTB', 1, '');
      $fpdf->SetY(7);
      $fpdf->SetX(16);
      $fpdf->MultiCell(5, 0.5, ":", 'LRTB', 1, '');
      $fpdf->Ln();
      $fpdf->MultiCell(5, 0.5, "3. Alamat Kontrak\n   (Subcontractor's Address)", 'LRTB', 1, '');
      $fpdf->MultiCell(5, 0.5, "3. Alamat Kontrak\n   (Subcontractor's Address)", 'LRTB', 1, '');

      $fpdf->Output();
    }
*/
}

/* End of file Seqproyek.php */
/* Location: ./application/controllers/Seqproyek.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-13 14:07:26 */
/* http://harviacode.com */
