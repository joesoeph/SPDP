<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Download extends Parent_Controller
{

    function __construct()
    {
        parent::__construct();
    }

		public function filename($name = NULL) {
			$this->load->helper('download');
			$data = file_get_contents(base_url("/uploads/" . $name));
			force_download($name, $data);
		}
}
