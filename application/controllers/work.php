<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class work extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->model('user_model'); 
	   $this->load->model('work_model');
	 }
	
	
	 function index()
	 {
	 
             if(!$this->session->userdata('logged_in') ){
	 	redirect ('/verifylogin/');
                $this->session->set_flashdata('login', 'Morate biti prijavljeni za tu akciju');
             }
           $this->load->helper(array('form','html'));
	   $this->load->library(array('form_validation'));
           
	   $menu=$this->user_model->get_menu();
	   $data['menu']=$menu['menu'];
	   $data['username']=$menu['username'];
           $data['name']=$menu['name'];
           $data['userid']=$menu['userid'];
           $data['admin']=$menu['admin'];
           $data['header']= "Pokreni Akciju";
           $data['title']= "ServisTimeClock :: Pokreni Akciju";
           if ($this->session->flashdata('works'))
               $data['reply']= $this->session->flashdata('works');  
           else
               $data['reply']= "";  
           $userid=$menu['userid'];
           $data['grupaid']=$menu['id_grupa'];
           /*if ($menu['admin']==0)
                $MyOrder=$this->work_model->get_orders($userid);
           else 
                $MyOrder=$this->work_model->get_orders(0);
           */
           $MyOrder=$this->work_model->get_orders($menu['id_grupa']);
	   $data['MyOrder']= $MyOrder;
           if ($this->input->post('Action'))
                $action = $this->input->post('Action');
           else 
                $action = "";
           
           $data['action']= $action;
           
           $SubmitOrder=$this->session->flashdata('id_nalog');
           
           if ($this->input->post('RadniNalog')!='')
                $thisOrder = $this->input->post('RadniNalog');
           elseif ($SubmitOrder)
               $thisOrder = $SubmitOrder;
            else {
                $thisOrder = NULL;
            }
           if ($thisOrder){
               $data['thisOrder']= array('id_dokument'=>$thisOrder, 'selected' => 'selected="selected"');
               $data['thisOrderData']= $this->work_model->get_this_order($thisOrder);
           }
           else {
               $data['thisOrder']= array('id_dokument'=>0, 'selected' =>'');
               $data['thisOrderData']= null;
           }
           $orderStatus=  $this->work_model->get_work_status($thisOrder);
           $data['orderStatus']= array('id_dokument'=>0);
           
           if ($orderStatus)
                $data['orderStatus']= $orderStatus[0];
           
            if ($this->input->post('Action') == "Start")	{
                      $this->work_model->start_work($thisOrder,$userid);
	 	      $this->session->set_flashdata('works', 'To, majstore! Ajde da se radi.');
                      $this->session->set_flashdata('id_nalog', $this->input->post('RadniNalog'));
                      redirect('/work/');
            }
            if ($this->input->post('Action2') == "Stop")	{
                  $this->work_model->stop_work($thisOrder,$userid);
                  $this->session->set_flashdata('works', 'Bravo! Ala si ga opravio! :)');
	 	  $this->session->set_flashdata('id_nalog', $this->input->post('RadniNalog'));
                  redirect('/work/');
            }
            
            if ($this->input->post('Action3') == "Kraj")	{
                  $this->work_model->finish_work($thisOrder,$userid);
                  $this->session->set_flashdata('works', 'iii gotovo ... Bravo! :)');
	 	  $this->session->set_flashdata('id_nalog', $this->input->post('RadniNalog'));
                      redirect('/work/');
            }
           $this->load->view('works',$data);	
	 }
	 
	
	 //delete ation
	 public function del_work_action()
	 {
	 	$this->db->where('id_servis', $this->input->get('id'));
                $this->session->set_flashdata('rem', 'Otvoren!');
	 	$this->db->delete('timing.servis');
	 	redirect('/work/closed');
	 
	 }
         
         //stop ation
	 public function stop_work_action()
	 {
             if(!$this->session->userdata('logged_in') ){
	 	redirect ('/verifylogin/');
                $this->session->set_flashdata('login', 'Morate biti prijavljeni za tu akciju');
             }
             
	 	 $this->work_model->stop_work($this->input->get('id'),$this->input->get('uid'));
                 $this->session->set_flashdata('rem', 'akcija zaustavljena!');
	 	 //redirect('/work/closed');
                 redirect(str_replace(base_url(),'',$_SERVER['HTTP_REFERER']));
	 }
         
         //finish ation
	 public function finish_work_action()
	 {
	 	 $this->work_model->finish_work($this->input->get('id'),$this->input->get('uid'));
                 $this->session->set_flashdata('rem', 'finished!');
	 	 //redirect('/work/closed');
                 redirect(str_replace(base_url(),'',$_SERVER['HTTP_REFERER']));
	 }
         
         //delete work -- all actions 
	 public function del_work()
	 {
	 	$this->db->where('id_nalog', $this->input->get('id_nalog'));
	 	$this->db->delete('timing.servis');
                $this->session->set_flashdata('rem', 'Sve obrisano!');
	 	redirect(str_replace(base_url(),'',$_SERVER['HTTP_REFERER']));
	 
	 }

	 //view all work
	 public function viewall()
	 {
	 	$this->load->helper(array('form','html'));
                $this->load->library(array('form_validation'));
           
                $menu=$this->user_model->get_menu();
	 	$data['title']="View Services for ". $menu['username'];
	 	$data['header']="View Services for ". $menu['username'];
	 	$data['menu']=$menu['menu'];
	 	$data['username']=$menu['username'];
                if($menu['admin']>0) 
                        $data['canDel']=1;
                  else
                        $data['canDel']=0; 
                $data['works']=$this->work_model->get_work_this_user($menu['userid']);
                
		if ($this->session->flashdata('rem'))
                    $data['reply']= $this->session->flashdata('rem');  
                else
                    $data['reply']= ""; 
	 	
	 	$this->load->view('work/viewall',$data);
	 }
         
          //view all work
	 public function closed()
	 {
	 	$this->load->helper(array('form','html'));
                $this->load->library(array('form_validation'));
           
                $menu=$this->user_model->get_menu();
	 	$data['title']="View finished Services";
	 	$data['header']="View finished Services";
	 	$data['menu']=$menu['menu'];
	 	$data['username']=$menu['username'];
                if($menu['admin']>0) 
                        $data['canDel']=1;
                  else
                        $data['canDel']=0; 
                $data['works']=$this->work_model->get_work_closed();
                
		if ($this->session->flashdata('rem'))
                    $data['reply']= $this->session->flashdata('rem');  
                else
                    $data['reply']= ""; 
	 	
	 		
	 		
	 		
	 	
	 	
	 	
	 	$this->load->view('work/closed',$data);
	 }
         
         //view some work
	 public function view()
	 {
	 	$menu=$this->user_model->get_menu();
	 	$data['title']="View Service";
	 	$data['header']="View Service";
	 	$data['menu']=$menu['menu'];
	 	$data['username']=$menu['username'];
		
	 	if($this->input->get('id_nalog') != ""){
	 		$data['have_name']="";
	 		$data['name']=str_replace('_', ' ',  $this->input->get('name'));
	 		
	 		
	 		
	 	
	 	
	 	} else {
	 		$data['have_name']="Mora se izabrati neki servis";
	 	}
	 	$this->load->view('work/view',$data);
	 }	 

	 
	// edit parameters for calculate util_rate
	 public function edit_util_rate()
	 {
	 	$this->load->model('user_model');
	 	$this->load->helper(array('form','html'));
	 	$this->load->library(array('form_validation'));
	 	$menu=$this->user_model->get_menu();
	 	$data['menu']=$menu['menu'];
	 	$data['username']=$menu['username'];
	 	$data['name']=str_replace('_', ' ',  $this->input->get('name'));
	 	$this->load->model('parameter_model');
	 	$data['facts']=$this->parameter_model->getCalcParams($data['name']);
	 
	 	$data['header']='Update data for calculate util rate';
	 
	 	$data['title']='Update data for calculate util rate';
                $this->form_validation->set_message('greater_than[0]', '%s mora biti veci od 0');
	 	foreach($data['facts'] as $f):
	 		$this->form_validation->set_rules( $f['param_id'], $f['param_name'],'greater_than[0]|required|xss_clean');
	 	endforeach;
	 	
	 	
	 	if ($this->form_validation->run() == FALSE )
	 	{
	 		//if not valid
	 		$this->load->view('calculation/edit_util_rate',$data);
	 		
	 		
	 	}  else {
		 	$postdata=array();
		 	$postdata=$this->input->post();
		 	$updatestring='';
		 	foreach($postdata as $key => $value):
		 	if ($key != 'updparam'){
		 		$this->calculation_model->update_parameter_value($key,$value,$data['name']);
		 	}
		 	endforeach;
		 	redirect ('calculation/view_util_rate?name='.$this->input->get('name'));
	 	}

	 }
	

	 // view result for calculate able_to_meet_SLA and user want to see number of agents
	 public function view_able_to_meet_sla_graph()
	 {
	 	$this->load->model('user_model');
	 	$this->load->helper(array('form','html'));
	 	$this->load->library(array('form_validation'));
	 	$menu=$this->user_model->get_menu();
	 	$data['menu']=$menu['menu'];
	 	$data['username']=$menu['username'];
	 	$data['name']=str_replace('_', ' ',  $this->input->get('name'));
	 
	 	$data['title']='Number of agent to meet SLA';
	 
	 	$msla = $this->calculation_model->get_able_meet_sla($data['name']);// how meny agents meet my SLA
	 	$data['mSt'] =$msla['St'];//
	 	$data['mGivenSt'] =$msla['GivenSt'];//
	 	$data['mNumOfAgents'] =$msla['NumOfAgents'];//
	 	$data['mRecNumOfAgents'] =$msla['RecNumOfAgents'];//
	 	$data['mG10ivenSt'] =$msla['G10ivenSt'];//
	 	$data['m10NumOfAgents'] =$msla['10NumOfAgents'];//
	 	$data['m10RecNumOfAgents'] =$msla['10RecNumOfAgents'];//
	 	$data['mGivenSt10'] =$msla['GivenSt10'];//
	 	$data['mNumOfAgents10'] =$msla['NumOfAgents10'];//
	 	$data['mRecNumOfAgents10'] =$msla['RecNumOfAgents10'];//
	 	$data['result'] = 'In order to meet your SLA, you will need at least  '. $data['mNumOfAgents']. ' agents, but recommended number of agents is '.$data['mRecNumOfAgents'];
	 
	 	$this->load->view('calculation/view_agent_to_meet_sla',$data);
	 
	 }


}

?>