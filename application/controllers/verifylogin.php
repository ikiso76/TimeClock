<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('user_model','',TRUE);
 }

 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
   $menu=$this->user_model->get_menu();
   $data['users']=$this->user_model->get_users();
   $data['title']="ServisTimeClock :: Log in";
   $data['menu']=$menu['menu'];
   $data['username']=$menu['username'];
   if ($this->session->flashdata('login'))
               $data['reply']= $this->session->flashdata('login');  
           else
               $data['reply']= "";  
   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
   
   if (isset($_SERVER['HTTP_REFERER'])&&substr($_SERVER['HTTP_REFERER'], 0,12)==substr(base_url(), 0,12) && strpos($_SERVER['HTTP_REFERER'], '/work'))
           $redirect=str_replace(base_url(),'',$_SERVER['HTTP_REFERER']);
   else        
            $redirect=null;
   if($this->form_validation->run() == FALSE )
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('login_view', $data);
   }
   else
   {
       if ($redirect)
        redirect($redirect);
     //Go to private area
       else
        redirect('/home/homepage', 'refresh');
   }

 }
 function admin()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
   $menu=$this->user_model->get_menu();
   $data['reply']= ""; 
   $data['users']=$this->user_model->get_admin_users();
   $data['title']="ServisTimeClock :: Admin Log in";
   $data['menu']=$menu['menu'];
   $data['username']=$menu['username'];
   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

   if($this->form_validation->run() == FALSE )
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('login_view', $data);
   }
   else
   {
     //Go to private area
     redirect('work', 'refresh');
   }

 }

 function check_database($password)
 {
    //Field validation succeeded.  Validate against database
    $username = $this->input->post('username');
    if ($username !="")
        //query the database
        $result = $this->user_model->login($username, $password);
    else 
        $result = FALSE;
   if($result)
   {
     $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
         'id' => $row->id_korisnik,
         'name' => $row->ime,
       	 'username' => $row->username,
         'id_grupa' => $row->id_grupa     
       );
       $this->session->set_userdata('logged_in', $sess_array);
     }
     return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', 'Invalid username or password');
     return false;
   }
 }
}
?>
