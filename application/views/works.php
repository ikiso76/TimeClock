<?php $this->load->view('header.php'); ?>
<div id="features-wrapper">
	<div class="container">
                <div class="row">
                        <div class="7u 12u(medium)">
                                <?php echo '<h4>'. $name.'</h4>';//.$action;//.$grupaid;//.$admin; 
                                if ($reply!="") 
                                    echo '<h4>'.$reply.'</h4>';
                                else
                                    echo '';
                                ?>
                            <h3><?php echo $header;?></h3>
                        </div>
                        <div class="5u 12u(medium)">								
                        </div>
                </div>
		<div class="row">
                        <div class="4u 12u(medium)">

					<!-- Box -->
                                <section class="box feature">
                                        <?php
                                        echo '<label for="RadniNalog" > Radni nalog </label>';
                                        echo form_open('/work/');

                                        if (count($MyOrder)>0){
                                         echo'<p>';
                                         //echo '<label for="RadniNalog" > Radni nalog </label>';
                                              echo '<select name="RadniNalog" onchange="submit()">
                                                    <option value="">Izaberite</option>';
                                                    foreach($MyOrder as $order):
                                                         //if (( $order['id_status_servis']==1 && $userid!=$order['id_korisnik'] ) || ($order['id_status_servis']==3 )){
                                                        if ($order['id_status_servis']==3 ){
                                                            if ( $admin!="1")
                                                                continue; 
                                                        }
                                                            if (($order['id_dokument'] == $thisOrder['id_dokument']))
                                                                $sel = 'selected="selected"';
                                                            else 
                                                                $sel = '';
                                                            echo '<option value="'.$order['id_dokument'].'" '.$sel.' >'.$order['vozilo_itm'].'::'.$order['registracija'].'::Nalog-'.$order['id_dokument'].'</option>';
                                                    endforeach;  
                                                echo '</select>';

                                                echo'<br></p>';

                                                if ((!empty($orderStatus['id_status_servis']) && ($orderStatus['id_status_servis']==1 && $userid==$orderStatus['id_korisnik']) )|| $thisOrder['id_dokument']==0) {
                                                    echo '<p class="button alt"><input type="submit"  onclick="this.disabled=true;" name="Action" value="Start" /><h4>';

                                                    if ($thisOrder['id_dokument']==0) 
                                                         echo ''.'</h4></p>';
                                                    else
                                                        echo ' Zapoceto: '.$orderStatus['updated'].'</h4></p>';
                                                }
                                                else 
                                                    echo'<p class="button icon fa-arrow-circle-right"><input type="submit" name="Action" value="Start" /></p>';
                                                echo'<br>';
                                                if (!empty($orderStatus['id_status_servis']) && $orderStatus['id_status_servis']==1)    
                                                      echo'<p class="button"><input type="submit" name="Action2" value="Stop" /></p>';
                                                else 
                                                    echo'<p class="button alt"><input type="submit"  onclick="this.disabled=true;" name="Action2" value="Stop" /><h4>';
                                                if (!empty($orderStatus['updated']) && $orderStatus['id_status_servis']==2) 
                                                    echo ' Zavrseno: '.$orderStatus['updated'].'</h4></p>';                                                            
                                                else
                                                   echo ''.'</h4></p>'; 

                                                if (!empty($orderStatus['id_status_servis']) && $orderStatus['id_status_servis']==2)    
                                                      echo'<p class="button icon fa-arrow-circle-right"><input type="submit" name="Action3" value="Kraj" /></p>';
                                                else 
                                                   echo'<p class="button alt"><input type="submit" onclick="this.disabled=true;" name="Action3" value="Kraj" /></p>';

                                        }else {
                                                echo 'NO services';
                                                }
                                        echo '</form>';
                                        ?>
                                    </section>
                            </div> 
                                        
                            <?php
                                    if ($thisOrderData){

                                            echo '<div class="4u 12u(medium)"><section class="box feature">';
                                            echo'<p>';
                                            echo '<label for="model">Model</label><br>';
                                            echo $thisOrderData[0]['vozilo_itm'];
                                            //echo '<input id="model" name="model" type="text" value = "'.$thisOrderData[0]['vozilo_itm'].'" disabled/>';
                                            echo'</p>';
                                            echo '</section></div>';
                                    }    

                                    if ($thisOrderData){
                                            echo ' <div class="4u 12u(medium)"><section class="box feature">';
                                            echo'<p>';
                                            echo '<label for="registracija"> Registracija </label><br>';                                                       
                                            //echo '<input id="registracija" name="registracija" type="text" value = "'.$thisOrderData[0]['registracija'].'" disabled/>';
                                            echo $thisOrderData[0]['registracija'];
                                            echo'</p>';
                                            echo '</section></div>';
                                    }         
                            ?>
	 		
         </div>		<!-- END row-->	
       </div> <!-- END container-->
    </div><!-- END features-wrapper-->
   <?php $this->load->view('footer.php'); ?>
