<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
             $this->load->model('user_model'); 
	    $this->load->model('work_model');
            if($this->session->userdata('logged_in'))
	   {
	   		// get data for page
	     	$session_data = $this->session->userdata('logged_in');
	     	$data['username'] = $session_data['username'];
	     	$data['id'] = $session_data['id'];
	     	//$this->load->view('home_view', $data);
	     	$menu=$this->user_model->get_menu();
	    
		   	$data['menu']=$menu['menu'];
		   	$data['username']=$menu['username'];
                        
		   	$MyWork=$this->work_model->get_work_opened($menu['userid']);
		   	
		   	// if user enter some data redirect him to see it else redirect him to homepage
		   	if (count($MyWork)>0 || $menu['admin']==1) {
		   		redirect ('/home/homepage');
		   	} else {
			   	redirect ('work');
		   	}
                        
	   }
	   else
	   {
	     //If no session, redirect to login page
	     redirect('verifylogin', 'refresh');
	   }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */