<?php $this->load->view('header.php'); ?>
<div id="features-wrapper">
	<div class="container">
						<div class="row">
							<div class="7u 12u(medium)">
					
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

                                                echo '   '.$page['name'];

                                                echo '</form>';
						?>
                                            </section>
                                        </div> 
                                        
                                        
                                               
			 		
         </div>		<!-- END row-->	
       </div> <!-- END container-->
    </div><!-- END features-wrapper-->
   <?php $this->load->view('footer.php'); ?>
