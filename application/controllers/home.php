<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   	$this->load->model('work_model');
	   	$this->load->model('user_model');
	 }
		
	 //main page for this controler
	 function index()
	 {
	   if($this->session->userdata('logged_in'))
	   {
	   		// get data for page
	     	$session_data = $this->session->userdata('logged_in');
	     	$data['username'] = $session_data['username'];
	     	$data['id'] = $session_data['id'];
	     	//$this->load->view('home_view', $data);
	     	$menu=$this->user_model->get_menu();
	     $data['reply']= ""; 
		   	$data['menu']=$menu['menu'];
		   	$data['username']=$menu['username'];
		   	
		   	
			   	redirect ('/home/homepage');
		
		  
	   }
	   else
	   {
	     //If no session, redirect to login page
	     redirect('verifylogin', 'refresh');
	   }
	 }

	 function logout()
	 {
	   $this->session->unset_userdata('logged_in');
	   session_destroy();
	   redirect('verifylogin', 'refresh');
	 }

	 
	//name explain everything :)
	function homepage()
	{
		if($this->session->userdata('logged_in'))
		{
			//$session_data = $this->session->userdata('logged_in');
			$menu=$this->user_model->get_menu();
	
			$data['menu']=$menu['menu'];
			$data['username']=$menu['username'];
                        
			$data['works']=$this->work_model->get_work_opened($menu['userid']);
			$data['header']='Welcome to time clocking';
			$data['reply']= "";  
                        if ($this->session->flashdata('works'))
                            $data['reply']= $this->session->flashdata('works');  
                        
                        if($menu['admin']>0) 
                                $data['canDel']=1;
                          else
                                $data['canDel']=0;
			$data['title']=$data['username'].' - Welcome';
                        
                        $MyWork=$this->work_model->get_work_opened($menu['userid']);
		   	
		   	// if user enter some data redirect him to see it else redirect him to homepage
		   	if (count($MyWork)>0 || $menu['admin']==1) {
		   		
		   	} else {
			   	redirect ('work');
		   	}
			
			$this->load->view('welcome_message',$data);
		} else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		 
	
	}
        //stop ation
	 public function stop_work_action()
	 {
	 	 $this->work_model->finish_work($this->input->get('id'),$this->input->get('uid'));
                 $this->session->set_flashdata('works', 'akcija zaustavljena!');
	 	 //redirect('/work/closed');
                 redirect(str_replace(base_url(),'',$_SERVER['HTTP_REFERER']));
	 }
	
	// get all my calculations
	function services()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$menu=$this->user_model->get_menu();
	
			$data['menu']=$menu['menu'];
			$data['username']=$menu['username'];
			$data['id'] = $session_data['id'];
			$MyCalc=$this->work_model->get_last_calc_this_user($data['id']);
			$data['name']= $MyCalc[0]['name'];
			$data['calc']=$this->work_model->get_calc_this_user($data['id']);
			$data['header']='My services';
			if($menu['admin']>0)
				$data['canDel']=1;
			else
				$data['canDel']=0;
			$data['title']='Display My services';
			$this->load->helper(array('form'));
			$this->load->view('calculations',$data);
		} else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
		 
	
	}
	
	
}
?>