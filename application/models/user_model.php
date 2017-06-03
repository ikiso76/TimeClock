<?php
	Class User_model extends CI_Model
	{
	public function __construct()
	{
		$this->load->database();
	}
	// this is check for standard login
	 function login($username, $password)
	 {
             /*
	   $this -> db -> select('id_ak, ime, sifra');
	   $this -> db -> from('radnik');
	   $this -> db -> where('id_ak', $username);
	   //$this -> db -> where('password', MD5($password)); //md5 ecript
           $this -> db -> where('sifra',$password);
	   $this -> db -> limit(1);
	 
	   $query = $this -> db -> get();
	 */
           $selquery = "select k.id_korisnik, ime, prezime, username, password, email, id_grupa from korisnik k 
                        left join korisnik_grupa g on g.id_korisnik=k.id_korisnik 
                        where (id_grupa in(10021,10022,1) or k.id_korisnik=9999) and k.id_korisnik= ".$username." and password = '".$password."'";
                        
           $query=$this->db->query($selquery);
	   if($query -> num_rows() == 1)
	   {
	     return $query->result();
	   }
	   else
	   {
	     return false;
	   }
	 }
	 
	 //we will make for all other logins login function
	 
	 // we check if exist user with same mail
	 function fblogin($email)
	 {
	 	$this -> db -> select('id, name,username, password');
	 	$this -> db -> from('user');
	 	$this -> db -> where('email', $email);
	 	//$this -> db -> where('user_type', 'facebook');
	 	$this -> db -> limit(1);
	 
	 	$query = $this -> db -> get();
	 
	 	if($query -> num_rows() == 1)
	 	{
	 		return $query->result();
	 	}
	 	else
	 	{
	 		return false;
	 	}
	 }
	 
	 //linked in does not support mail so we check username and type to be linked in
	 function lnlogin($username)
	 {
	 	$this -> db -> select('id, name,username, password');
	 	$this -> db -> from('user');
	 	$this -> db -> where('username', $username);
	 	$this -> db -> where('user_type', 'linkedin');
	 	$this -> db -> limit(1);
	 
	 	$query = $this -> db -> get();
	 
	 	if($query -> num_rows() == 1)
	 	{
	 		return $query->result();
	 	}
	 	else
	 	{
	 		return false;
	 	}
	 }
	 
	 // to get all information of some user based on his username
	 function get_user($user)
	 {
	 	$this->db->where('username',$user);
	 	$query = $this->db->get('user');
	 
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
	 }
	 
          // to get all information of some user based on his username
	 function get_users()
	 {
	 	//$query = $this->db->get('radnik');
                $selquery = "select k.id_korisnik, ime, prezime, username, password, email, id_grupa from korisnik k 
                        left join korisnik_grupa g on g.id_korisnik=k.id_korisnik 
                        where (id_grupa in(10021,10022))";
                        
           $query=$this->db->query($selquery);
	 
		if($query->num_rows()!==0)
		{
			return $query->result_array();
		}
		else
			return FALSE;
	 }
         function get_admin_users()
	 {
	 	//$query = $this->db->get('radnik');
                $selquery = "select k.id_korisnik, ime, prezime, username, password, email, id_grupa from korisnik k 
                        left join korisnik_grupa g on g.id_korisnik=k.id_korisnik 
                        where (id_grupa in(1) or k.id_korisnik=9999)";
                        
           $query=$this->db->query($selquery);
	 
		if($query->num_rows()!==0)
		{
			return $query->result_array();
		}
		else
			return FALSE;
	 }
         
	 // for saving calculations we will need user id
	 function getUserId($user)
	 {
	 	$query = $this->db->query('SELECT id_korisnik FROM korisnik where username ="'.$user.'"');
		
	 
	 	if($query->num_rows()!==0)
	 	{
	 		return $query->result_array();
	 	}
	 	else
	 		return FALSE;
	 }

	 // check if user is admin
	function admin_user($user)
	{
	 	//$this->db->where('username',$user);
	 	//$this->db->where('id_ak','9998');
	 	//$query = $this->db->get('radnik');
        $selquery = "select k.id_korisnik, ime, prezime, username, password, email, id_grupa from korisnik k 
                        left join korisnik_grupa g on g.id_korisnik=k.id_korisnik 
                        where (id_grupa in(1) or k.id_korisnik=9999) and username='".$user."'";
                        
        $query=$this->db->query($selquery);
	 
		if($query->num_rows()!==0)
		{
			return $query->result_array();
		}
		else
			return FALSE;
	}
	 
	 //build the menu based on that user is logged and check if is admin
	 function get_menu()
	 {	 	
	 	if($this->session->userdata('logged_in') )
	 	{ 		
	 		$session_data=$this->session->userdata('logged_in' );
	 		$result['username'] = $session_data['username'];
                        $result['name'] = 'Hello '.$session_data['name'].'!';
	 		$result['admin'] = 0;
	 		$result['userid'] = $session_data['id'];
                        $result['id_grupa'] = $session_data['id_grupa'];
	 		$result['menu'] = array (
				 				
				 				array (
						 				'name'=>'History',
						 				'link'=>base_url().'knjiga/manage',
				 						'klasa'=>''
				 					)/*,				 				
				 				array (
				 					'name'=>'Add User',
				 					'link'=>'/user/add_new_user',
				 					'klasa'=>''
				 				)*/
	 						);
	 		if($this->user_model->admin_user($session_data['username'])) {
	 			$result['admin'] = 1;
	 			$addFact = array (
	 							'name'=>'Add User',
	 							'link'=>base_url().'user/add_new_user',
	 							'klasa'=>''
	 					);
	 			array_push($result['menu'], $addFact);
	 			

	 		}
	 		$logout = array (
	 				'name'=>'Log Out',
	 				'link'=>base_url().'home/logout',
	 				'klasa'=>''
	 		);
	 		array_push($result['menu'],$logout);
	 		
	 		 
	 	}
	 	else {
	 		$result['admin'] = -1;
	 		$result['username'] = 'Please Log in for all option';
	 		$result['userid'] = '';
	 		$result['menu'] = array (
	 							array ('name'=>'Log In',
	 									'link'=> base_url().'verifylogin',
	 									'klasa'=>''
	 									)
	 						);		
	 	}
	 	return $result;
	 }

	 //add user, default form
	 function add_new_user($name,$username,$password,$email)
	 {	
	 	if( $this->get_user($name)==FALSE )
	 	{
	 		$data = array(
	 				'name'    => $name,
					'username'    => $username,
	 				'password'  => $password,
	 				'email'=> $email,
	 				'group_id'=>1,
	 				'user_type'=>''
	 		);
	 		$this->db->insert('user',$data);
	 		return true;
	 	}
	 }

	//if we create login from other site
	//we don't need password, but we record user id there
	function add_new_user_type($name,$username,$password,$email,  $type)
	{	
		if( $this->get_user($name)==FALSE )
		{
			$data = array(
					'name'    => $name,
					'username'    => $username,
					'password'  => $password,
					'email'=> $email,
					'group_id'=>1,
					'user_type'=> $type
			);
			$this->db->insert('user',$data);
			return true;
		}
	}
	
	 
}	
?>