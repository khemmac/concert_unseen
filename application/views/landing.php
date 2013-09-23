<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Pragma" content="no-cache" />
	<title>Boostplus.co.th :: Concert Booking</title>

	<script type="text/javascript" src="<?= base_url('/js/lib/jquery.js') ?>"></script>

	<link href="<?= base_url('/css/style.css') ?>" type="text/css" rel="stylesheet" />
	<link href="<?= base_url('/css/menu.css') ?>" type="text/css" rel="stylesheet" />

	<style type="text/css">
		#member-sub-menu { display:none; }

		#container { background: transparent url("<?= base_url('images/landing/bg.png?v=2') ?>") no-repeat; }

		#content { background:none !important; top:0px !important; }

		#box { top:72px !important; left: 572px !important; }

		#footer { display:none !important; }
	</style>

	<script type="text/javascript" src="<?= base_url('js/lib/jcountdown/jquery.jcountdown.min.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url('js/lib/jcountdown/jcountdown.css') ?>" />
	<style type="text/css">
		.jCountdown .group .label{
			position:relative;
			left:50%;
			padding:0px;
			margin:0px 0px 0px -40px;
			width:80px;
		}
		div#box{ padding:11px;}
		#box_popup{ position: relative; border:2px solid #ffffff; z-index: 2; }
		#box_popup a.brn_close{position: absolute; right: 0px; top:0px;}
		.ctn-background {
		    background: none repeat scroll 0 0 #FFFFFF;
		    border: 2px solid #FFFFFF;
		    bottom: 0;
		    box-shadow: 0 0 3px #AAAAAA;
		    height: 746px;
		    left: 0;
		    opacity: 0.65;
		    position: absolute;
		    right: 0;
		    top: 0;
		    z-index: 1;
		    /*display: none;*/
		}
	</style>
	<script type="text/javascript">
	$(function(){

		$('.brn_close').click(function(){
			$(this).parent().hide();
			$('.ctn-background').hide();
		});

		var countdownBox = $("#countdown-box");
		countdownBox.jCountdown({
			timeText : '2013/10/20 00:00:00',//config date for count down
			timeZone : -7,
			style: "crystal", //flip,crystal
			color : "black",
			width : 0,
			textGroupSpace : 15,
			textSpace : 0,
			reflection : false,
			reflectionOpacity : 10,
			reflectionBlur : 0,
			dayTextNumber : 2,
			displayDay : true,
			displayHour : true,
			displayMinute : true,
			displaySecond : true,
			displayLabel : true,
			onFinish : function() {}
		});
		// fix ie7 bug
		if($.browser.msie && $.browser.version<=7){
			var intervalLebel = setInterval(function(){
				if(countdownBox.find('.label').length>0){
					$('.label').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
					clearInterval(intervalLebel);
				}
			}, 200);
		}

	});

	//how to render youtube
	//key from youtube is "_-xEV9f1xE0"
	//http://www.youtube.com/v/[key from youtube]?version=3&amp;hl=en_US&amp;rel=0

	</script>
</head>

<body>
	<div class="ctn-background"></div>
	<div id="container">
		<ul id="member-sub-menu">
			<li><a class="menu-logout" href="controller/form_member/logout"></a></li>
			<li><a class="menu-profile" href="register"></a></li>
		</ul>

		<div id="content-body" class="page-home">
			    <div id="content">
				    <div id="box">
				        <object width="355" height="292">
				            <param name="movie" value="http://www.youtube.com/v/YhLaDa3kb0c?autoplay=1&version=3&amp;hl=en_US&amp;rel=0">
				            </param>
				            <param name="allowFullScreen" value="true">
				            </param>
				            <param name="allowscriptaccess" value="always">
				            </param>
				            <param name="wmode" value="transparent">
				            </param>
				            <embed width="355" height="292" src="http://www.youtube.com/v/YhLaDa3kb0c?autoplay=1&version=3&amp;hl=en_US&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="transparent">
				            </embed>
			            </object>
				    </div>
				    <!--<div id="countdown-box" style="position:absolute; width:300px; height:75px; left:232px; top:577px;"> </div>-->
			    </div>

			    <!--visitor count-->
			    <div style="position:absolute; bottom:5px; left:10px;">
		            <!-- hitwebcounter Code START -->
		            <a href="javascript:void(0);">
		                <img src="http://hitwebcounter.com/counter/counter.php?page=5052066&style=0025&nbdigits=5&type=ip&initCount=0" title="k-pop fastival" Alt="Counter HTML Coding"   border="0" >
		            </a>
		            <br/>
		            <!-- hitwebcounter.com -->
		            <!--
		            <a href="http://www.hitwebcounter.com/" title="Welcome Hits"
		            target="_blank" style="font-family: Arial, Helvetica, sans-serif;
		            font-size: 10px; color: #6E6A68; text-decoration: none ;"><em>Welcome Hits</em>
		            </a>-->


		        </div>
			    <a href="https://www.facebook.com/boostplus?hc_location=stream" target="_blank" style="position:absolute; bottom:42px; left:6px; width:90px; height:31px;"></a>
		</div>

	<!--<span id="footer" style="position:absolute; bottom:20px; right:30px; display:block; width:207px; height:16px; background:transparent url('../images/common/foot-contact.png') no-repeat; text-indent:-9000px;">ติดต่อสอบถาม 02-938-5959</span>-->

	</div>
	<div style="position: absolute; top: 8%; left: 38%;"> <!--display: none;-->
		<div id="box_popup">
			<a href="javascript:void(0);" class="brn_close"> <img src="<?= base_url('images/pop_up/close_buttom.png') ?>" /> </a>
			<img src="<?= base_url('images/pop_up/pop-up.png') ?>" />
		</div>
	</div>
</body>
</html>
