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
                      <div class="10u 12u(medium)">
						<!-- Box -->
					<section class="box feature">
                                                <ul>
				   		<?php  
						if (isset($works)){  
			   			foreach($works as $work):
					   		
                                                        if ($work['id_status_servis']!=2)
							{
								$workLink= '<a href='.base_url().'work/del_work_action/?id='.$work['id_servis'] .'>Obnovi</a>';
							} else {
								$workLink= '<a href='.base_url().'work/finish_work_action/?id='.$work['id_nalog'] .'&uid='.$work['id_korisnik'] .'>Zatvori</a> ';
							}
					                if ($canDel!=0)
							{
								$deLink= '<a href=/work/del_work/?id='.$work['id_nalog'] .'>Ukloni</a>'; //ovo ne bi trebalo ovde da stoji, da neko slucajno sve ne obrise
							} else {
								$deLink= ' ';
							}
							?>
							<li>
							<p><?php echo 'Nalog-'.$work['id_dokument'].'::'.$work['vozilo_itm'].'::'.$work['registracija'].'; Radjen ukupno: '.$work['vreme'].' od '.$work['otvoren'].' do '.$work['zatvoren'].'  <span>'.$workLink.'</span></a>'.'  <span>'.$deLink.'</span></a>';?>  </p>
							</li>
                                                
					        <?php endforeach;?>
                                                </ul>
					  
		    			<?php }?>
                                        </section>
                                        </div>
                                        <div class="2u 12u(medium)">

                                        </div>
			</div>		
       </div>
   </div>  
   <?php $this->load->view('footer.php'); ?>