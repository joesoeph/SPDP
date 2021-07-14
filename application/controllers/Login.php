<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Parent_Controller {

    public function index () {
        $this->Content = 'template/login';

        $Datas['AddCss'] = [];
        $Datas['AddJsHeader'] = [];
        $Datas['AddJsFooter'] = [];

        $this->SingleLayouts($Datas);
    }

}
