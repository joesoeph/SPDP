<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
* Engine template
*/

class Parent_Controller extends CI_Controller
{

    public $_strTitleHtml = "PROXIS";
    public $_strProyekCode = "";
    public $_strProyekName = "";
    public $_strProyeAddress = "Jakarta Timur";
    public $_strCodeAgreement = "PROXIS";
    public $_strGoToUrl = "#";
    public $_strEmailFrom = "no-reply@mailinator.com";
    public $_strEmailFromAlias = "PROXIS";

    private $Template = array();
    private $Data = array( 'title' => 'PROXIS', 'ProyekName' => 'PROXIS');

    function __construct()
    {
      parent::__construct();
      if (!$this->pocnauth->isLogin()) {
  			redirect('auth');
  		} else {
        $this->load->model('ParentModel');
      }
    }

    function SingleLayouts($arrData)
    {
      if (!empty($arrData)) {
          $Title = $this->_strTitleHtml; //$this->ParentModel->valTitle();

          $arrMeta  = $this->ParentModel->arrMeta();
          $Meta     = '';
          foreach ($arrMeta as $Val) {
              $Meta .= meta($Val);
          }

          $arrCss = $this->ParentModel->arrCss2();
          $Css    = '';
          foreach ($arrCss as $Val) {
              $Css .= link_css($Val);
          }

          $arrJsHeader  = $this->ParentModel->arrJsHeader();
          $JsHeader     = '';
          foreach ($arrJsHeader as $Val) {
              $JsHeader .= link_js($Val);
          }

          $arrJsFooter  = $this->ParentModel->arrJsFooter();
          $JsFooter     = '';
          foreach ($arrJsFooter as $Val) {
              $JsFooter .= link_js($Val);
          }

          $this->Template['Title']    = $Title;
          $this->Template['Meta']     = $Meta;
          $this->Template['Css']      = $Css;
          $this->Template['JsHeader'] = $JsHeader;
          $this->Template['JsFooter'] = $JsFooter;

          $this->Template['Content']  = $this->load->view($this->Content, $arrData, true);

          $this->load->view('template/pageLayout', $this->Template);
      } else {
          show_404();
      }
    }

    function Layouts($arrData)
    {
        if (!empty($arrData)) {
            $Title = $this->_strTitleHtml; //$this->ParentModel->valTitle();

            $arrMeta  = $this->ParentModel->arrMeta();
            $Meta     = '';
            foreach ($arrMeta as $Val) {
                $Meta .= meta($Val);
            }

            $arrCss = $this->ParentModel->arrCss();
            $Css    = '';
            foreach ($arrCss as $Val) {
                $Css .= link_css($Val);
            }

            $arrJsHeader  = $this->ParentModel->arrJsHeader();
            $JsHeader     = '';
            foreach ($arrJsHeader as $Val) {
                $JsHeader .= link_js($Val);
            }

            $arrJsFooter  = $this->ParentModel->arrJsFooter();
            $JsFooter     = '';
            foreach ($arrJsFooter as $Val) {
                $JsFooter .= link_js($Val);
            }


            $this->Template['Title']    = $Title;
            $this->Template['Meta']     = $Meta;
            $this->Template['Css']      = $Css;
            $this->Template['JsHeader'] = $JsHeader;
            $this->Template['JsFooter'] = $JsFooter;
            $this->Template['Header']   = $this->load->view('template/header', $this->Data, true);
            $this->Template['SideBar']  = $this->load->view('template/sidebar', $this->Data, true);
            $this->Template['Content']  = $this->load->view($this->Content, $arrData, true);
            $this->Template['Footer']   = $this->load->view('template/footer', $this->Data, true);

            $this->load->view('template/dashboardLayout', $this->Template);
        } else {
            show_404();
        }
    }

    public function _send_email($to, $subject, $set_message)
    {
      $message = $set_message.$this->_strGoToUrl;
      $set_message = $set_message;
      $this->load->library('email');
      $this->email->set_newline("\r\n"); 
      $send_to = rtrim($to, ",");        
      $this->email->subject($subject);
      $this->email->message($set_message);
      $this->email->from($this->_strEmailFrom, $this->_strEmailFromAlias);
      $this->email->to($send_to);
      $status = "";
      if(!$this->email->send()) {
          $status = $this->email->print_debugger(); 
      } else {
          $status = "Message sent correctly!";
      } 
    }

}
