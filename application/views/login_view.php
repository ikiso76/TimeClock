<?php $this->load->view('header.php'); ?>
<div id="features-wrapper">
	<div class="container">
            <div class="row">
							<div class="7u 12u(medium)">
								<h3><?php echo "Log In";?></h3>
                                                                <?php     if ($reply!="") 
                                                                                echo '<h4>'.$reply.'</h4>';
                                                                            else
                                                                                echo ''; ?>
							</div>
							<div class="5u 12u(medium)"> 
                                                          <!--
                                                            <label for="date2" class="date2" >Date 2:</label>
                                                            <input name="date2" id="date2" class="date-pick" >
                                                          -->
			 
							</div>
	</div>
	<div class="row">		
					
						
  
					   <?php echo validation_errors(); ?>
					   <?php echo form_open('verifylogin'); ?>
					
					                <p> <!--
					                    <label for="username" class="uname" > Your username </label><br>
					                    <input id="username" name="username" required="required" type="text" placeholder="myusername"/>
					                -->
                                                        <label for="username" class="username"  >Korisnik  </label>
                                                        <select name="username">
                                                            <option value="">Izaberi</option>
                                                            <?php foreach($users as $user):?>
                                                            <option value="<?=$user['id_korisnik'];?>" ><?=$user['username'];?>   </option>
                                                            <?php endforeach;?>
                                                        </select>
                                                        </p>
					                <p>
					                    <label for="password" class="youpasswd" > Your password </label>
					                    <input id="password" name="password" required="required" type="password" placeholder="eg. MyP@ssw0rd" />
					                </p>
					               
					               
					                <p class="login button">
					                    <input type="submit" value="Login" />
					                </p>
					          
					         
					   </form>
					   <br>
         			
         </div>		<!-- END row-->	
       </div> <!-- END container-->
    </div><!-- END features-wrapper--> 
   <?php $this->load->view('footer.php'); ?>