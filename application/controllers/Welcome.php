<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function test()
	{
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
	}
	
	public function send_email()
	{
// 	    $this->load->dbutil();
// 		$backup = $this->dbutil->backup();

// 		$this->load->helper('file');
		$getFilename = 'BackupDatabase_'.date('Y-m-d').'.zip';
// 		if (! write_file('./tmp_backup/'.$getFilename, $backup)) {
// 		    echo "error create file";
// 		} else {
		    $pathFile = './upload/' . $getFilename;
		    
		    if (file_exists($pathFile)) {
		        $this->load->library('email');
        		$this->email->from('system-backup@pp.com', 'System Scheduler');
        		$this->email->to('a.syakur14@gmail.com');
        // 		$this->email->cc('muhammadzainuddin.jay@gmail.com');
        
        		$this->email->subject('Database Backup Scheduler ' . date("Y-d-m"));
        		$this->email->message('Testing email with backup file');
        		$this->email->attach($pathFile);
                // $this->email->attach('https://s.aolcdn.com/dims-shared/dims3/GLOB/crop/1920x1018+0+0/resize/660x350!/format/jpg/quality/85/https://s.aolcdn.com/hss/storage/midas/75c95d5fdb4726f4be275dafa52d4b12/203843781/XMEN-FACTS-INTRO.jpg');
        
        		if (! $this->email->send()) {
        			//  Generate Error
        			echo '<pre>';
        			print_r($this->email->print_debugger(array('headers')));
        		} else {
        			//  Send Message Success
        			echo "check your email";
        		}
		    } else {
		        echo "file not found";
		    }
// 		}
	}
}
