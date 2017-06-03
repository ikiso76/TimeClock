<?php
	Class Work_model extends CI_Model
	{
	public function __construct()
	{
		$this->load->database();
	}

	 // if we need some specific calculation
	 function get_work_status($order)
	 {
	 	$this->db->where('id_nalog',$order);
                $this->db->order_by('updated', 'desc');
                $this->db->order_by('id_status_servis', 'desc');
                $this->db->limit(1);
	 	$query = $this->db->get('timing.servis');
	 
		if($query->num_rows()!=0)
		{
			return $query->result_array();
		}
		else
			return FALSE;
	 }
	 
	 // for 1st page we need last calculation
	 function get_last_work_this_user($user)
	 {
	 	$this->db->where('id_korisnik',$user);
	 	$this->db->order_by('updated desc');
	 	$this->db->limit(1);
	 	$query = $this->db->get('timing.servis');
	 
	 	if($query->num_rows()!=0)
	 	{
	 		return $query->result_array();
	 	}
	 	else
	 		return FALSE;
	 }
         
         // if we need closed  service for loged user
	function get_work_closed($user =null)
	 {
	 	if ($user)
                    $selLimit = " and s.id_korisnik=".$user;        
                else 
                    $selLimit="";
	 	$selquery = "with last_state as (
						select 
							id_nalog,
							max(id_servis) as sid
						 from timing.Servis
						Group by id_nalog
					),
					zatvoreni as (
						select 
							s.id_nalog as nid,
							sid, 
							updated as zakljucan,
							s.id_status_servis as stanje 
						from timing.Servis s
						join last_state ls on (ls.sid = s.id_servis)
						where s.id_status_servis in (2,3)),
					otvoren as (
						select  row_number() over (partition by nid order by updated)  as rb,
							nid,  s.id_servis as aid, sid, updated as otvoren, zakljucan, stanje 
						from timing.Servis s
						join zatvoreni z on (z.nid = s.id_nalog)
						where s.id_status_servis in (1)
					),
					zatvoren as (
						select  row_number() over (partition by nid order by updated)  as rb,
							nid,  s.id_servis as aid, sid, updated as zatvoren 
						from timing.Servis s
						join zatvoreni z on (z.nid = s.id_nalog)
						where s.id_status_servis in (2)
					)
					select 
							coalesce(v.reg_oznaka,coalesce((select fa.vrednost from fin_atribut fa,fin_atribut_cvor fac 
															where fa.id_fin_atribut_cvor=fac.id_fin_atribut_cvor and fac.id_atribut=16507 
															and fa.id_ak=( vozilo.id_ak  )  ),'')) as registracija,
							coalesce((select model from artikal where id_ak=vozilo.id_ak),'') as vozilo_naziv,
							coalesce(kp.naziv,(select naziv from analitika where id_ak=vozilo.id_ak)) as vozilo_itm,
							
							s.nid as id_nalog,  otvoren,  zatvoren, (DATE_PART('day', zatvoren -otvoren)  * 24 + DATE_PART('hour', zatvoren -otvoren))||' sati' as satima , vreme, aid as id_servis, 
							minuta,
							s.id_korisnik,zakljucan, s.id_status_servis,
							
							d.id_dokument, 
							id_def_dokumenta, 
							datum,
							broj_dokumenta,
							napomena,
							dl.id_grupa
					from dokument d
					join  (	select  nid, min(otvoren) as otvoren,  max(zatvoren) as zatvoren, sum(vreme) as vreme,sum(minutama) as minuta, -- sum(satima) as satima,  sum(minutama) as minuta
						id_korisnik,zakljucan, id_status_servis,max(aid) as aid
						from (
							select
								o.nid,  otvoren,  zatvoren, (DATE_PART('day', zatvoren -otvoren)  * 24 + DATE_PART('hour', zatvoren -otvoren))||' sati' as satima ,(zatvoren-otvoren)::interval as vreme, z.aid, age(otvoren,zatvoren) as t,
								(DATE_PART('day',zatvoren - otvoren) * 24 +   DATE_PART('hour',zatvoren - otvoren)) * 60 + DATE_PART('minute', zatvoren - otvoren) as minutama,
								s.id_korisnik,zakljucan, o.stanje as id_status_servis
							
							from timing.Servis s
							join otvoren  o on (o.aid = s.id_servis)
							left join zatvoren z on (z.nid = s.id_nalog and o.rb=z.rb) )xxx
						group by nid,zakljucan, id_status_servis,id_korisnik
						) s on s.nid=d.id_dokument
					join rm_dokument rmd on (rmd.id_dokument=d.id_dokument)
					left outer join analitika vozilo on (vozilo.id_ak=rmd.id_ak_porudzbina)
					left outer join vozilo v on (v.id_ak=vozilo.id_ak)
					left outer join kp_model kp on (kp.id_model=v.id_model)
										
					left join timing.def_lokacija dl on dl.id_def=d.id_def_dokumenta		
				   where d.id_def_dokumenta in (31915,31716) and id_def_stanja in (25103) and d.datum > (localtimestamp - '3 month'::interval)  ".$selLimit;   
                    
                    $query=$this->db->query($selquery);
                    
                    if($query->num_rows()>0){
                            return $query->result_array();
                    }
	 }
         
          // if we need closed  service for loged user
	function get_work_opened($user =null)
	 {
	 	if ($user)
                    $selLimit = " and s.id_korisnik=".$user;        
                else 
                    $selLimit="";
	 	$selquery = " select 
                                coalesce(v.reg_oznaka,coalesce((select fa.vrednost from fin_atribut fa,fin_atribut_cvor fac 
                                                                where fa.id_fin_atribut_cvor=fac.id_fin_atribut_cvor and fac.id_atribut=16507 
                                                                and fa.id_ak=( vozilo.id_ak  )  ),'')) as registracija,
                                coalesce((select model from artikal where id_ak=vozilo.id_ak),'') as vozilo_naziv,
                                coalesce(kp.naziv,(select naziv from analitika where id_ak=vozilo.id_ak)) as vozilo_itm,
                                 s.*,
                                d.id_dokument, 
                                id_def_dokumenta, 
                                datum,
                                broj_dokumenta,
                                napomena,
                                dl.id_grupa,
                                ss.name as status
                                from dokument d
                                join rm_dokument rmd on (rmd.id_dokument=d.id_dokument)
                                left outer join analitika vozilo on (vozilo.id_ak=rmd.id_ak_porudzbina)
                                left outer join vozilo v on (v.id_ak=vozilo.id_ak)
                                left outer join kp_model kp on (kp.id_model=v.id_model)
                                left join  (select xs.id_nalog, ls.id_status_servis,brIzmena, ls.updated, najstanje, ls.id_korisnik,ls.id_servis
                                                 from (select gs.id_nalog, count(*) as  brIzmena,max (updated) as updated, max(id_status_servis) as najstanje 
                                                         from timing.servis gs 
                                                         group by 1 ) xs
                                                 join timing.servis ls on (ls.id_nalog=xs.id_nalog and ls.updated=xs.updated)
                                                 ) s on s.id_nalog=d.id_dokument	                
                                left join timing.def_lokacija dl on dl.id_def=d.id_def_dokumenta		
                                left join timing.status_servis ss on ss.id_status_servis=s.id_status_servis
                               where d.id_def_dokumenta in (31915,31716) and id_def_stanja in (25103)  and s.id_status_servis in (1)".$selLimit;   
                    
                    $query=$this->db->query($selquery);
                    
                    if($query->num_rows()>0){
                            return $query->result_array();
                    }
	 }
         
         // if we need one specific order 
	function get_this_order($id =null)
	 {
	 	if ($id)
                    $selLimit = " and d.id_dokument=".$id;        
                else 
                    $selLimit="";
	 	$selquery = " select 
                                coalesce(v.reg_oznaka,coalesce((select fa.vrednost from fin_atribut fa,fin_atribut_cvor fac 
                                                                where fa.id_fin_atribut_cvor=fac.id_fin_atribut_cvor and fac.id_atribut=16507 
                                                                and fa.id_ak=( vozilo.id_ak  )  ),'')) as registracija,
                                coalesce((select model from artikal where id_ak=vozilo.id_ak),'') as vozilo_naziv,
                                coalesce(kp.naziv,(select naziv from analitika where id_ak=vozilo.id_ak)) as vozilo_itm,
                                 s.*,
                                d.id_dokument, 
                                id_def_dokumenta, 
                                datum,
                                broj_dokumenta,
                                napomena,
                                dl.id_grupa
                                from dokument d
                                join rm_dokument rmd on (rmd.id_dokument=d.id_dokument)
                                left outer join analitika vozilo on (vozilo.id_ak=rmd.id_ak_porudzbina)
                                left outer join vozilo v on (v.id_ak=vozilo.id_ak)
                                left outer join kp_model kp on (kp.id_model=v.id_model)
                                left join  (select xs.id_nalog, ls.id_status_servis,brIzmena, ls.updated, najstanje, ls.id_korisnik,ls.id_servis
                                                 from (select gs.id_nalog, count(*) as  brIzmena,max (updated) as updated, max(id_status_servis) as najstanje 
                                                         from timing.servis gs 
                                                         group by 1 ) xs
                                                 join timing.servis ls on (ls.id_nalog=xs.id_nalog and ls.updated=xs.updated)
                                                 ) s on s.id_nalog=d.id_dokument	                
                                left join timing.def_lokacija dl on dl.id_def=d.id_def_dokumenta		
                               where d.id_def_dokumenta in (31915,31716)  ".$selLimit;   
                    
                    $query=$this->db->query($selquery);
                    
                    if($query->num_rows()>0){
                            return $query->result_array();
                    }
	 }
         
	 // if we need  service for loged user
	function get_work_this_user($user)
	 {
	 	if ($user)
                    $selLimit = " and s.id_korisnik=".$user;        
                else 
                    $selLimit=" and s.id_korisnik=-5";
	 	$selquery = " select 
                                coalesce(v.reg_oznaka,coalesce((select fa.vrednost from fin_atribut fa,fin_atribut_cvor fac 
                                                                where fa.id_fin_atribut_cvor=fac.id_fin_atribut_cvor and fac.id_atribut=16507 
                                                                and fa.id_ak=( vozilo.id_ak  )  ),'')) as registracija,
                                coalesce((select model from artikal where id_ak=vozilo.id_ak),'') as vozilo_naziv,
                                coalesce(kp.naziv,(select naziv from analitika where id_ak=vozilo.id_ak)) as vozilo_itm,
                                 s.*,
                                d.id_dokument, 
                                id_def_dokumenta, 
                                datum,
                                broj_dokumenta,
                                napomena,
                                dl.id_grupa,
                                ss.name as status
                                from dokument d
                                join rm_dokument rmd on (rmd.id_dokument=d.id_dokument)
                                left outer join analitika vozilo on (vozilo.id_ak=rmd.id_ak_porudzbina)
                                left outer join vozilo v on (v.id_ak=vozilo.id_ak)
                                left outer join kp_model kp on (kp.id_model=v.id_model)
                                left join  (select xs.id_nalog, ls.id_status_servis,brIzmena, ls.updated, najstanje, ls.id_korisnik,ls.id_servis
                                                 from (select gs.id_nalog, count(*) as  brIzmena,max (updated) as updated, max(id_status_servis) as najstanje 
                                                         from timing.servis gs 
                                                         group by 1 ) xs
                                                 join timing.servis ls on (ls.id_nalog=xs.id_nalog and ls.updated=xs.updated)
                                                 ) s on s.id_nalog=d.id_dokument	                
                                left join timing.def_lokacija dl on dl.id_def=d.id_def_dokumenta
                                left join timing.status_servis ss on ss.id_status_servis=s.id_status_servis
                               where d.id_def_dokumenta in (31915,31716)  and d.datum > (localtimestamp - '3 month'::interval)  ".$selLimit;   
                    
                    $query=$this->db->query($selquery);
	 
		if($query->num_rows()!==0)
		{
			return $query->result_array();
		}
		else
			return FALSE;
	 }
	 
	 // if we need  number of services for loged user
	 function num_work_this_user($user)
	 {
	 	$this->db->where('id_korisnik',$user);
	 	$query = $this->db->get('servis');
                $this->db->query('SELECT id_nalog, id_korisnik, max(id_status_servis) 
				  FROM  timing.servis
				 where id_korisnik = '.$user. 
                                ' group by id_nalog, id_korisnik');
	 	if($query->num_rows()!=0)
	 	{
	 		return TRUE;
	 	}
	 	else
	 		return FALSE;
	 }
	 
         // sve promene jednog naloga
         function get_work_history($order)
	 {
	 	
                $query=$this->db->query('SELECT id_nalog, id_korisnik, id_status_servis, updated 
				  FROM  timing.servis
				  where id_nalog = '.$order. 
                                ' order by updated desc, id_status_servis');
	 	if($query->num_rows()>0){
			return $query->result_array();
		}
	 }
         
         // sve promene jednog nalozi
         function get_orders($idgrupa)
	 {
                if ($idgrupa==1 or $idgrupa=='')
                    $selLimit="";                           
                else 
                    $selLimit = " and dl.id_grupa=".$idgrupa; 
	 	$selquery = "select 
                                coalesce(v.reg_oznaka,coalesce((select fa.vrednost from fin_atribut fa,fin_atribut_cvor fac 
                                                                where fa.id_fin_atribut_cvor=fac.id_fin_atribut_cvor and fac.id_atribut=16507 
                                                                and fa.id_ak=( vozilo.id_ak  )  ),'')) as registracija,
                                coalesce((select model from artikal where id_ak=vozilo.id_ak),'') as vozilo_naziv,
                                coalesce(kp.naziv,(select naziv from analitika where id_ak=vozilo.id_ak)) as vozilo_itm,
                                d.id_dokument, 
                                id_def_dokumenta, 
                                datum,
                                broj_dokumenta,
                                napomena,
                                dl.id_grupa,
                                 s.*
                                from dokument d
                                join rm_dokument rmd on (rmd.id_dokument=d.id_dokument)
                                left outer join analitika vozilo on (vozilo.id_ak=rmd.id_ak_porudzbina)
                                left outer join vozilo v on (v.id_ak=vozilo.id_ak)
                                left outer join kp_model kp on (kp.id_model=v.id_model)
                                left join  (select xs.id_nalog, ls.id_status_servis,brIzmena, ls.updated, najstanje, ls.id_korisnik
                                                 from (select gs.id_nalog, count(*) as  brIzmena,max (updated) as updated, max(id_status_servis) as najstanje 
                                                         from timing.servis gs 
                                                         group by 1 ) xs
                                                 join timing.servis ls on (ls.id_nalog=xs.id_nalog and ls.updated=xs.updated)
                                                 ) s on s.id_nalog=d.id_dokument	
                               left join timing.def_lokacija dl on dl.id_def=d.id_def_dokumenta		
                               where d.id_def_dokumenta in (31915,31716) and id_def_stanja in (25103)  and d.datum > (localtimestamp - '3 month'::interval)  ".$selLimit;
                        
                $query=$this->db->query($selquery);
	 	if($query->num_rows()>0){
			return $query->result_array();
		}
	 }
	 // we never use but who know :), may be for admin panel
	 function getAllWorks()
	 {
		$query=$this->db->get('timing.servis');
		if($query->num_rows()>0){
			return $query->result_array();
		}
	}
	
         // add new servis by current user
	function start_work($order,$id)
	{
	$orderStatus=	$this->get_work_status($order);		
        if( $this->get_work_status($order)==FALSE || $orderStatus[0]['id_status_servis']==2 )
		{	
			$orderStatus=	$this->get_work_status($order);
			$today = date("Y-m-d H:i:s",time());
			$data = array(
				'id_korisnik'    => $id,
				'id_nalog'    => $order,
                                'id_status_servis'    => 1,
				'updated'  => $today
			);
			
			$this->db->insert('timing.servis',$data);
			
			
		}
        }
        
         // stop servis by current user
	function stop_work($order,$id)
	{
		$orderStatus=	$this->get_work_status($order);
		if( $this->get_work_status($order)!=FALSE && $orderStatus[0]['id_status_servis']==1)
		{	
			
			$today = date("Y-m-d H:i:s",time());
			$data = array(
				'id_korisnik'    => $id,
				'id_nalog'    => $order,
                                'id_status_servis'    => 2,
				'updated'  => $today
			);
			
			$this->db->insert('timing.servis',$data);
			
			
		}
        }
        
         // stop servis by current user
	function finish_work($order,$id)
	{
		$orderStatus=	$this->get_work_status($order);	
		if( $this->get_work_status($order)!=FALSE && $orderStatus[0]['id_status_servis']==2 )
		{	
			
			$today = date("Y-m-d H:i:s",time());
			$data = array(
				'id_korisnik'    => $id,
				'id_nalog'    => $order,
                                'id_status_servis'    => 3,
				'updated'  => $today
			);
			
			$this->db->insert('timing.servis',$data);
			
			
		}
        }
        
	// calculate util _rate
	function get_util_rate($name)
	{
		// calculate util rate with exact params
		 $query = $this->db->query('SELECT
		 		round( (
		 				(SELECT round( (
		 						sum( (CASE WHEN input_type != "input" THEN coalesce(cp.param_value,0) ELSE 0 END ) ) ) , 2) AS hours
		 						FROM parameter p
		 						join calc_params cp on (cp.param_id=p.id)
		 						join calculation c on (cp.calc_id=c.id and c.name="'.$name.'") where type_param="params")
		 		/ coalesce(cp.param_value,0) *100
		 		), 2) as util_rate
						
		 		FROM parameter p
		 		join calc_params cp on (cp.param_id=p.id)
		 		join calculation c on (cp.calc_id=c.id and c.name="'.$name.'")
		 		WHERE type_param="params" and input_type = "input"');
		
	
			if($query->num_rows()>0){
				return $query->result_array();
			}
	}
	
}	
?>