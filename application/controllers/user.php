<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->model('user_model'); 
	 }

	// main  =  user must be logged
	 function index()
	 {
	 	
	 	$menu=$this->user_model->get_menu();
	   $data['title']="Welcome! Please log in";	
	   $data['menu']=$menu['menu'];
	   $data['username']=$menu['username'];
	   $this->load->helper(array('form'));
	   $this->load->view('login_view',$data);
	 }
	 
	 function login()
	 {
	 	$this->load->helper(array('form'));
		
	 	$menu=$this->user_model->get_menu();
	 
	 	$data['menu']=$menu['menu'];
	 	$data['username']=$menu['username'];
	 	$this->load->view('login_view',$data);
	 }
	 
	 public function add_new_user()
	 {
	 	//$data['title'] = 'Add new user';
	 
	 	$menu=$this->user_model->get_menu();
	 	$data['title']="Add New User";
	 	$data['menu']=$menu['menu'];
	 	$data['username']=$menu['username'];
	 	$this->load->helper('form');
		$this->load->helper('html');      
		//$this->load->model('User_model');
	
	 	$this->load->library(array('form_validation'));
	 
	 	// set validation rules
	 	
	 	$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
	 	$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|is_unique[user.username]');
	 	$this->form_validation->set_rules('password', 'Password', 'min_length[4]|trim|required|xss_clean');
	 	$this->form_validation->set_rules('emailsignup', 'Email', 'valid_email|required');
	 	
	 	 
	 
	 	if ($this->form_validation->run() == FALSE)
	 	{
	 		//if not valid
	 		$this->load->view('user/add_new_user',$data);
	 	}
	 	else
	 	{
	 		
	 		/* this is simple, we can add this way but is better thru the model
	 		$dataIns['name'] = $this->input->post('name');
	 		$dataIns['username'] = $this->input->post('username');
	 		$dataIns['password'] = MD5($this->input->post('password'));
	 		$dataIns['email'] = $this->input->post('emailsignup');
	 		$dataIns['group_id'] = 1;
	
			$this->db->insert('user',$dataIns);
	 		*/
	 		if ( !$this->user_model->add_new_user($this->input->post('name'),$this->input->post('username'),MD5($this->input->post('password')),$this->input->post('emailsignup')) ) {
	 			echo 'Invalid account';
	 			return false;
	 		}
	 		else {
	 			$sess_array = array();
	 			$sess_array = array(
	 						'id' => $this->db->insert_id(),
	 						'name' => $this->input->post('name'),
	 						'username' => $this->input->post('username')
	 				);
	 				$this->session->set_userdata('logged_in', $sess_array);
	 		
	 		
	 		$this->session->set_flashdata('add_new_user', '1 new user added!');
	 		}
	 		redirect ('/home/homepage');;
	 	}
	 }
	
	 
	 
 
}

?>