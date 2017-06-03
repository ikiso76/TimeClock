<?php $this->load->view('header.php'); ?>
<div id="features-wrapper">
	<div class="container">
						<div class="row">
							<div class="7u 12u(medium)">
								<h3><?php echo $header;?></h3>
                                                                <?php     if ($reply!="") 
                                                                                echo '<h4>'.$reply.'</h4>';
                                                                            else
                                                                                echo ''; ?>
							</div>
							<div class="5u 12u(medium)">
								
							</div>
						</div>
            		<div class="row">
                      <div class="7u 12u(medium)">
						<!-- Box -->
					<section class="box feature">
						<p>This website is created for mobile enthusiasts that have interest in time management for service operations. 
                                                </p>
						<p>Enjoy your visit!</p>
					 <ul>
                                             <li>
							<p><?php echo 'Za pokretanje ili zavrsavanje radnog naloga izaberite link <a href='.base_url().'work/>Servis</a> ';?>  </p>
					     </li>
				   		<?php  
                                                
						if (count($works)>0){  
                                                    echo 'Postoje servisi koji nisu zaustavljeni';
			   			foreach($works as $work):
					   		if ($work['id_status_servis']==1)
							{
								$workLink= '<a href='.base_url().'work/stop_work_action/?id='.$work['id_nalog'] .'&uid='.$work['id_korisnik'] .'>Zaustavi</a> ';
							} else
                                                                $workLink= ' ';
					                if ($canDel!=0)
							{
								$deLink= '<a href=/work/del_work/?id='.$work['id_dokument'] .'>Ukloni</a>';
							} else {
								$deLink= ' ';
							}
							?>
							<li>
							<p><?php echo 'Nalog-'.$work['id_dokument'].' :: '.$work['vozilo_itm'].' :: '.$work['registracija'] .'  <span>'.$workLink.'</span></a>'.'  <span>'.$deLink.'</span></a>';?>  </p>
							</li>
                                                
					        <?php endforeach;?>
                                                </ul>
					  
		    			<?php } ?>	
						
                                        </section>
                                        </div>
                                        <div class="5u 12u(medium)">

                                        </div>
			</div>		
       </div>
   </div>  
   <?php $this->load->view('footer.php'); ?>
