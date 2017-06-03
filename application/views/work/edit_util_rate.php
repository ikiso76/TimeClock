<?php $this->load->view('header.php'); ?>
 <div class="main">
	<span class="shadow-top"><?php echo $username; ?>
		<?php // $_SERVER['REQUEST_URI'] ?>  
		</span>
				<!-- shell -->
	<div class="shell">
		<div class="container">
			
					<div class="widget">
						<h3><?php echo $header;?></h3>
<?php echo validation_errors(); ?>
				   		<?php
						if (isset($facts)){
			   			echo form_open('calculation/edit_util_rate?name='.str_replace(' ', '_',  $name)); ?>
					   		<?php foreach($facts as $fact):?>
					   		<p>
					                    <label for="<?=$fact['param_name'];?>" class="uname"><?=$fact['param_name'];?> </label><br>
					                    <input id="<?=$fact['param_id'];?>" name="<?=$fact['param_id'];?>"
					                    value="<?=$fact['param_value'];?>" required="required" type="text" />
					        </p>
					        <?php endforeach;?>
			                <p class="login button">
			                    <input id="updparam" name="updparam" type="submit" value="Update" />
			                </p>
					   </form>
		    			<?php }?>
			 		</div>
         </div>			
       </div>
   </div>  
   <?php $this->load->view('footer.php'); ?>