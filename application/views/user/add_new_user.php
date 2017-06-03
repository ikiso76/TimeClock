<?php $this->load->view('header.php'); ?>
 <div class="main">
	<span class="shadow-top">
		<?php // $_SERVER['REQUEST_URI'] ?>  
		</span>
				<!-- shell -->
	<div class="shell">
		<div class="container">
			
			<div class="widget">
			   <?php echo validation_errors(); ?>
			   <?php echo form_open('user/add_new_user'); ?>
			   
				    <p>
	                    <label for="name" class="uname" > Your first and last name </label><br>
	                    <input id="name" name="name" required="required" type="text" placeholder="myname"/>
	                </p>
	
	                <p>
	                    <label for="username" class="uname" > Your username </label><br>
	                    <input id="username" name="username" required="required" type="text" placeholder="myusername"/>
	                </p>
	                <p>
	                    <label for="password" class="youpasswd" > Your password </label><br>
	                    <input id="password" name="password" required="required" type="password" placeholder="eg. Str0ngPass" />
	                </p>
	                <p> 
	                    <label for="emailsignup" class="youmail"  > Your email</label><br>
	                    <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="mysupermail@mail.com"/> 
	                </p>
	             
	                <p class="login button">
	                    <input type="submit" value="Add user" />
	                </p>
       
  				 </form>
			 </div>
         </div>			
       </div>
   </div>  
   <?php $this->load->view('footer.php'); ?>