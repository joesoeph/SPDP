<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Parent_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('GlobalModel','ListDataModel'));
        $this->load->library('form_validation');
    }
    public function index () {
        $this->Content = 'content/dashboard'; // url content yang akan diload

        // jika ada plugin tambahan untuk page ini masukan didalam array
        $Datas['AddCss'] = [];
        $Datas['AddJsHeader'] = [];
        $Datas['AddJsFooter'] = [];
        //==============================================================//

        $Datas['ArrData'] = []; // data hasil proses masukan ke array ini untuk dirender di view index 'ArrData' bisa dirubah
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }


}
