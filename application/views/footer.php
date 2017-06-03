
			<!-- Footer -->
				<div id="footer-wrapper">
					<footer id="footer" class="container">
						
						<div class="row">
							<div class="12u">
								<div id="copyright">
									<ul class="menu">
                                                                            
				<?php foreach($menu as $m):
						
					?>
					
					<?php //echo '<a href='.$m['link'].' class='.$klasa.'>'.$m['name'].'</a>';
							echo ' <li ><a href='.$m['link'].'>'.$m['name'].'</a></li>';
					?>
					
				<?php endforeach;?>
				
										<li>&copy; Untitled. All rights reserved</li><!--<li>Design: <a href="http://html5up.net">HTML5 UP</a></li>-->
									</ul>
								</div>
							</div>
						</div>
					</footer>
				</div>

			
		</div> <!--  END page-wrapper-->

		<!-- Scripts -->
                <!--
<script src='/bs/assets/js/prettify.js'></script>
                <script src='/bs/assets/js/jquery.js'></script>
                <script src='/bs/assets/js/bootstrap-datepicker.js'></script>
                <script src='/bs/assets/js/bootstrap.js'></script>
                <script>
                if (top.location != location) {
                     top.location.href = document.location.href ;
                }
		$(function(){
			window.prettyPrint && prettyPrint();
                $('#dp3').datepicker();
                });
                </script> 
                -->
		<!-- 	<script src="<?=base_url()?>assets/js/jquery.min.js"></script> -->
			<script src="<?=base_url()?>assets/js/jquery.dropotron.min.js"></script>
			<script src="<?=base_url()?>assets/js/skel.min.js"></script>
			<script src="<?=base_url()?>assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="<?=base_url()?>assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="<?=base_url()?>assets/js/main.js"></script>

	</body>
</html>