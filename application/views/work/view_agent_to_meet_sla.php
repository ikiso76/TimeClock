<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
	<title><?php  echo $title; ?></title>
	<link rel="shortcut icon" type="/image/x-icon" href="/css/images/favicon.ico" />
	<link rel="stylesheet" href="/css/style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/css/flexslider.css" type="text/css" media="all" />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css' />
	<script src="/js/jquery-1.8.0.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
		<script src="/js/modernizr.custom.js"></script>
	<![endif]-->
	<script src="/js/jquery.flexslider-min.js" type="text/javascript"></script>
	<script src="/js/functions.js" type="text/javascript"></script>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript">

	
	$(function () {
	    $('#container').highcharts({
	        chart: {
	            type: 'bar',
	            backgroundColor: '#FEFAFA'
	        },
	        title: {
	            text: 'Number of agents needed to meet SLA'
	        },
	        xAxis: {
	            categories: ['<?php  echo round(($mGivenSt+0.1)*100,0); ?> %','Given SLA (<?php  echo round($mGivenSt*100,0); ?> %)','<?php  echo round(($mGivenSt-0.1)*100,0); ?> %']
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Number of agents'
	            }
	        },
	        legend: {
	            backgroundColor: '#FEFAFA',
	            reversed: true
	        },
	        plotOptions: {
	            series: {
	                stacking: 'normal'
	            }
	        },
	        series: [{
	            name: 'Recommended aggent add-on',
	            data: [<?php  echo $mRecNumOfAgents10 - $mNumOfAgents10; ?>,<?php  echo $mRecNumOfAgents - $mNumOfAgents; ?>,<?php  echo $m10RecNumOfAgents - $m10NumOfAgents; ?>]
	        }, {
	            name: 'Calculated number',
	            data: [<?php  echo $mNumOfAgents10; ?>,<?php  echo $mNumOfAgents; ?>,<?php  echo $m10NumOfAgents; ?>]
	        }]
	    });
	});

		</script>
</head>
<body>
<script type="text/javascript" src="/js/highcharts.js"></script>
<script type="text/javascript" src="/js/highcharts-more.js"></script>
<script type="text/javascript" src="/js/exporting.js"></script>
 <div id="wrapper">
		
		<!-- top-nav -->
		<nav class="top-nav">
			<div class="shell">
			<a href="#" class="nav-btn"><?php  echo $title; ?><span></span></a>
				<span class="top-nav-shadow"></span>
				<ul>
				<?php foreach($menu as $m):
					if ($_SERVER['REQUEST_URI']==$m['link']) {
						$link_class='active';
					} else {
						$link_class='';
					}	
					?>
					
					<?php //echo '<a href='.$m['link'].' class='.$klasa.'>'.$m['name'].'</a>';
							echo ' <li class='.$link_class.'><span><a href='.$m['link'].'>'.$m['name'].'</a></span></li>';
					?>
					
				<?php endforeach;?>
				</ul>
			</div>
		</nav>

 <div class="main">
	<span class="shadow-top">
		<?php // $_SERVER['REQUEST_URI'] ?>  
		</span>
				<!-- shell -->
	<div class="shell">
	<h4><?php echo $result."<br>";?></h4>
		<div id="container" style="width: 400px; height: 400px; margin: 0 auto"></div>	
		<p><?php echo '<a href=/calculation/view?name='.str_replace(' ', '_',  $name) .'>Return to questions</a>';?></p>
	
       </div>
   </div>  
   <?php $this->load->view('footer.php'); ?>