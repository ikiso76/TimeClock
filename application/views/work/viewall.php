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
                                                <ul>
				   		<?php  
						if (count($works)>1){  
			   			foreach($works as $work):
					   		
                                                        if ($work['id_status_servis']==2)
							{
								$workLink= '<a href='.base_url().'work/finish_work_action/?id='.$work['id_nalog'] .'&uid='.$work['id_korisnik'] .'>Zatvori</a> ';
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
							<p><?php echo 'Nalog-'.$work['id_dokument'].'::'.$work['vozilo_itm'].'::'.$work['registracija'].'   '.$work['status'] .'  <span>'.$workLink.'</span></a>'.'  <span>'.$deLink.'</span></a>';?>  </p>
							</li>
                                                
					        <?php endforeach;?>
                                                </ul>
					  
		    			<?php } /*
                                        else if (count($works)==1) {
                                             if ($works[0]['id_status_servis']==2)
							{
								$workLink= '<a href='.base_url().'work/finish_work_action/?id='.$works[0]['id_nalog'] .'&uid='.$works[0]['id_korisnik'] .'>Zatvori</a> ';
							} else
                                                                $workLink= ' ';
					                if ($canDel!=0)
							{
								$deLink= '<a href=/work/del_work/?id='.$works[0]['id_dokument'] .'>Ukloni</a>';
							} else {
								$deLink= ' ';
							}
							echo '<li><p>';
							echo ''.$works[0]['broj_dokumenta'].'   '.$works[0]['status'] .'  <span>'.$workLink.'</span></a>'.'  <span>'.$deLink.'</span></a>';
							echo '  </p></li>';
                                                        
                                        }*/
                                        else 
                                            echo 'Nemate Radjenih Servisa';
                                        ?>
                                        </section>
                                        </div>
                                        <div class="5u 12u(medium)">

                                        </div>
			</div>		
       </div>
   </div>  
   <?php $this->load->view('footer.php'); ?>