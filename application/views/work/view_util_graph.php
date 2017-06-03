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

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript">
		$(function () {
					
				    $('#container').highcharts({
					
					    chart: {
					        type: 'gauge',
					        plotBackgroundColor: null,
					        plotBackgroundImage: null,
					        plotBorderWidth: 0,
					        plotShadow: false
					    },
					    
					    title: {
					        text: 'Utilization rate'
					    },
					    
					    pane: {
					        startAngle: -150,
					        endAngle: 150,
					        background: [{
					            backgroundColor: {
					                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
					                stops: [
					                    [0, '#FFF'],
					                    [1, '#333']
					                ]
					            },
					            borderWidth: 0,
					            outerRadius: '109%'
					        }, {
					            backgroundColor: {
					                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
					                stops: [
					                    [0, '#333'],
					                    [1, '#FFF']
					                ]
					            },
					            borderWidth: 1,
					            outerRadius: '107%'
					        }, {
					            // default background
					        }, {
					            backgroundColor: '#DDD',
					            borderWidth: 0,
					            outerRadius: '105%',
					            innerRadius: '103%'
					        }]
					    },
					       
					    // the value axis
					    yAxis: {
					        min: 0,
					        max: 100,
					        
					        minorTickInterval: 'auto',
					        minorTickWidth: 1,
					        minorTickLength: 10,
					        minorTickPosition: 'inside',
					        minorTickColor: '#666',
					
					        tickPixelInterval: 30,
					        tickWidth: 2,
					        tickPosition: 'inside',
					        tickLength: 10,
					        tickColor: '#666',
					        labels: {
					            step: 2,
					            rotation: 'auto'
					        },
					        title: {
					            text: '%'
					        },
					        plotBands: [{
					            from: 0,
					            to: 40,
					            color: '#DF5353' // red
					        }, {
					            from: 40,
					            to: 60,
					            color: '#DDDF0D' // yellow
					        }, {
					            from: 60,
					            to: 80,
					            color: '#55BF3B' // green

					        }, {
					            from: 80,
					            to: 90,
					            color: '#DDDF0D' // yellow <?php  //echo $seriesdata; ?>
					        }, {
					            from: 90,
					            to: 100,
					            color: '#DF5353' // red
					        }]        
					    },
					
					    series: [{
					        name: 'UtilizationRate',
					        data: [80],
					        tooltip: {
					            valueSuffix: ' %'
					        }
					    }]
					
					}, 
					// Add some life
					function (chart) {
						if (!chart.renderer.forExport) {
						    setInterval(function () {
						        var point = chart.series[0].points[0],
						            newVal,
						            inc = 2;
						        
						        newVal = point.y + inc;
						        if (newVal < 0 || newVal > 100) {
						            newVal = point.y - inc;
							    point.update(newVal+2);
						        }
						        
						        point.update(newVal-2);
						        
						    }, 3000);
						}
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
		<span class="shadow-top"><?php echo $username; ?>
			<?php // $_SERVER['REQUEST_URI'] ?>  
			</span>
					<!-- shell -->
		<div class="shell">
			<div id="container" style=" margin: 0 auto"></div>
		</div>
	</div>	
	</div>	
   <?php $this->load->view('footer.php'); ?>
