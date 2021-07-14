<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerifikasiInvoice extends Parent_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('VerifikasiInvoice_model');
	}

	public function index()
	{
		$this->Content = 'content/ListView'; // url content yang akan diload\
		// jika ada plugin tambahan untuk page ini masukan didalam array
		$Datas['AddCss'] = [];
		$Datas['AddJsHeader'] = [];
		$Datas['AddJsFooter'] = [];
		//==============================================================//

		//$Datas['ArrData'] = $this->PPH_model->get_all(); // data hasil proses masukan ke array ini untuk dirender di view, index 'ArrData' bisa dirubah

		$this->Layouts($Datas); // Layouts adalah template dashboard admin
	}

	public function create()
	{
		$this->Content = 'content/FormView'; // url content yang akan diload\
		// jika ada plugin tambahan untuk page ini masukan didalam array
		$Datas['AddCss'] = [];
		$Datas['AddJsHeader'] = [];
		$Datas['AddJsFooter'] = [
			'assets/plugin/jFileUpload/js/vendor/jquery.ui.widget.js',
			'assets/plugin/jFileUpload/js/jquery.iframe-transport.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-process.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-validate.js',
		];
		//==============================================================//

		$Datas['ArrData'] = array(
			'button' => 'Simpan',
			'action' => site_url('VerifikasiInvoice/save'),
		);

		$this->Layouts($Datas); // Layouts adalah template dashboard admin
	}

	public function save()
	{
		echo "TODO INSERT TABLE DETAIL";
	}

	public function loadVerifikasiUpload()
	{
		$type = trim($this->input->post('tipe_proyek'));

		switch ($type) {
			case 'SUPPLIER':
				$this->supplierFormVerifikasi();
				break;

			case 'SUBKONTRAKTOR':
				$this->subkontraktorFormVerifikasi();
				break;

			case 'UPAH':
				$this->upahFormVerifikasi();
				break;

			case 'ALAT':
				$this->alatFormVerifikasi();
				break;

			case 'BTL':
				$this->btlFormVerifikasi();
				break;

			default:
				echo "no defined";
				break;
		}
	}

	public function supplierFormVerifikasi()
	{
		$this->Content = 'content/supplierFormVerifikasiView'; // url content yang akan diload\
		// jika ada plugin tambahan untuk page ini masukan didalam array
		$Datas['AddCss'] = [];
		$Datas['AddJsHeader'] = [];
		$Datas['AddJsFooter'] = [
			'assets/plugin/jFileUpload/js/vendor/jquery.ui.widget.js',
			'assets/plugin/jFileUpload/js/jquery.iframe-transport.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-process.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-validate.js',
		];
		//==============================================================//

		$Datas['ArrData'] = array(
			'button' => 'Simpan',
			'action' => site_url('VerifikasiInvoice/save'),
		);

		$this->Layouts($Datas); // Layouts adalah template dashboard admin
	}

	public function subkontraktorFormVerifikasi()
	{
		//$this->load->view('content/subkontraktorFormVerifikasiView');

		$this->Content = 'content/subkontraktorFormVerifikasiView'; // url content yang akan diload\
		// jika ada plugin tambahan untuk page ini masukan didalam array
		$Datas['AddCss'] = [];
		$Datas['AddJsHeader'] = [];
		$Datas['AddJsFooter'] = [
			'assets/plugin/jFileUpload/js/vendor/jquery.ui.widget.js',
			'assets/plugin/jFileUpload/js/jquery.iframe-transport.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-process.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-validate.js',
		];
		//==============================================================//

		$Datas['ArrData'] = array(
			'button' => 'Simpan',
			'action' => site_url('VerifikasiInvoice/save'),
		);

		$this->Layouts($Datas); // Layouts adalah template dashboard admin
	}

	public function upahFormVerifikasi()
	{
		//$this->load->view('content/upahFormVerifikasiView');

		$this->Content = 'content/upahFormVerifikasiView'; // url content yang akan diload\
		// jika ada plugin tambahan untuk page ini masukan didalam array
		$Datas['AddCss'] = [];
		$Datas['AddJsHeader'] = [];
		$Datas['AddJsFooter'] = [
			'assets/plugin/jFileUpload/js/vendor/jquery.ui.widget.js',
			'assets/plugin/jFileUpload/js/jquery.iframe-transport.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-process.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-validate.js',
		];
		//==============================================================//

		$Datas['ArrData'] = array(
			'button' => 'Simpan',
			'action' => site_url('VerifikasiInvoice/save'),
		);

		$this->Layouts($Datas); // Layouts adalah template dashboard admin
	}

	public function alatFormVerifikasi()
	{
		//$this->load->view('content/alatFormVerifikasiView');

		$this->Content = 'content/alatFormVerifikasiView'; // url content yang akan diload\
		// jika ada plugin tambahan untuk page ini masukan didalam array
		$Datas['AddCss'] = [];
		$Datas['AddJsHeader'] = [];
		$Datas['AddJsFooter'] = [
			'assets/plugin/jFileUpload/js/vendor/jquery.ui.widget.js',
			'assets/plugin/jFileUpload/js/jquery.iframe-transport.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-process.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-validate.js',
		];
		//==============================================================//

		$Datas['ArrData'] = array(
			'button' => 'Simpan',
			'action' => site_url('VerifikasiInvoice/save'),
		);

		$this->Layouts($Datas); // Layouts adalah template dashboard admin
	}

	public function btlFormVerifikasi()
	{
		//$this->load->view('content/btlFormVerifikasiView');

		$this->Content = 'content/btlFormVerifikasiView'; // url content yang akan diload\
		// jika ada plugin tambahan untuk page ini masukan didalam array
		$Datas['AddCss'] = [];
		$Datas['AddJsHeader'] = [];
		$Datas['AddJsFooter'] = [
			'assets/plugin/jFileUpload/js/vendor/jquery.ui.widget.js',
			'assets/plugin/jFileUpload/js/jquery.iframe-transport.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-process.js',
			'assets/plugin/jFileUpload/js/jquery.fileupload-validate.js',
		];
		//==============================================================//

		$Datas['ArrData'] = array(
			'button' => 'Simpan',
			'action' => site_url('VerifikasiInvoice/save'),
		);

		$this->Layouts($Datas); // Layouts adalah template dashboard admin
	}

}

/* End of file VerifikasiInvoice.php */
/* Location: ./application/controllers/VerifikasiInvoice.php */
