<!DOCTYPE HTML>
<!--
	Verti by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title><?php  echo $title; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="<?php  echo $title; ?>assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="<?=base_url()?>assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="<?=base_url()?>assets/css/ie8.css" /><![endif]-->
                
                <!-- jQuery -->
                <script src="<?=base_url()?>assets/js/jquery.min.js"></script> 
<!--
                <!-- required plugins 
                <script type="text/javascript" src="/bs/assets/js/date.js"></script>
                <!--[if IE]><script type="text/javascript" src="/bs/assets/js/jquery.bgiframe.js"></script><![endif]

                <!-- jquery.datePicker.js 
                <script type="text/javascript" src="/bs/assets/js/jquery.datePicker.js"></script>
                <link href="<?php echo base_url();?>assets/css/datepickerJq.css" rel="stylesheet">
                <script type="text/javascript">
                    $(function()
                    {
                            $('.date-pick').datePicker().val(new Date().asString()).trigger('change');
                    });
                </script>
-->
        </head>
	<body class="homepage">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<header id="header" class="container">

						<!-- Logo -->
							<div id="logo">
								<!--<h1><a href="index.html">Verti</a></h1>
								<span>by HTML5 UP</span>--> 
                                                                 <a href="<?=base_url()?>">    <img src="<?=base_url()?>/images/logo69.png" alt="Logo Radulovic" style="width:250px;height:69px;"></a> 
							</div>

						<!-- Nav -->
							<nav id="nav">
								<ul>
									
                                                                            
                                                                            <?php 
                                                                               // echo ' <li class=""><span> <img src="'.base_url().'/images/logoh56.png" href='.base_url().' alt="Logo Radulovic" style="width:122px;height:56px;"> ::  </span></li>';
                                                                           // echo ' <li class=""><span><a href='.base_url().'>Radulovic Group</a></span></li>';
                                                                                    foreach($menu as $m):
                                                                                        if ($_SERVER['REQUEST_URI']==$m['link']) {
                                                                                                $klasa='active';
                                                                                        } else {
                                                                                                $klasa='';
                                                                                        }	
                                                                                    ?>

                                                                                    <?php //echo '<a href='.$m['link'].' class='.$klasa.'>'.$m['name'].'</a>';
                                                                                                    echo ' <li class='.$klasa.'><span><a href='.$m['link'].'>'.$m['name'].'</a></span></li>';
                                                                                    ?>

                                                                            <?php endforeach;?>
                                                                 
									
								</ul>
							</nav>

					</header>
				</div> <!-- END header-wrapper-->
<!-- footer END page-wrapper-->
              