<!DOCTYPE html>
<!-- <html manifest="ticktock.appcache"> -->
<html>
<head>

	<meta charset="utf-8">
	<title>Tick-Tock!</title>
	<meta name="mobile-web-app-capable" content="yes">


	<!-- <meta name="viewport" content="width=device-width"> -->
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> -->

	<meta name="viewport" content="width=device-width, initial-scale=0.6, user-scalable=no">
	<!-- <meta name="viewport" content="width=800px, initial-scale=1.0"> -->

	<link rel="manifest" href="manifest.json">

	<link rel="shortcut icon" type="image/x-icon" href="/user_scream.ico">
	<link rel="icon" type="image/x-icon" href="/user_scream.ico">
	<!-- <link rel="icon" sizes="192x192" href="/icon.png"> -->



	<!-- The main CSS file -->
	<link href="./assets/css/planets.css" rel="stylesheet">
	<link href="./assets/css/style.css" rel="stylesheet">
	<link href="./assets/css/highscraper.css" rel="stylesheet">
	<link href="./assets/css/astral.css" rel="stylesheet">
	<link href="./assets/css/weather.css" rel="stylesheet">
	<link href="./assets/css/style2.css" rel="stylesheet">
	<link href="./assets/css/slideout.css" rel="stylesheet">

	<link href="//fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">


	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="./assets/js/astral.js"></script>

	<!-- JavaScript Includes -->
	<!-- // <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script> -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
	<script src="./assets/js/script.js"></script>

	<script type="text/javascript">
		var timer_counter = -1;
		var _scale = <?= isset($_GET['scale']) ? round($_GET['scale'], 2) : 1; ?>;
		var clock_scale_h = <?= isset($_GET['scale']) ? round($_GET['scale'], 2) : 1; ?>;
		var clock_scale_v = <?= isset($_GET['scale']) ? round($_GET['scale'], 2) : 1; ?>;

	</script>

<?php if (isset($_GET['scale'])): ?>
	<script type="text/javascript">
		$(function(){
			var _scale = <?= isset($_GET['scale']) ? round($_GET['scale'], 2) : 1; ?>;
			var clock_scale_h = <?= isset($_GET['scale']) ? round($_GET['scale'], 2) : 1; ?>;
			var clock_scale_v = <?= isset($_GET['scale']) ? round($_GET['scale'], 2) : 1; ?>;
			// setTimeout(function(){
				$('#clock').css('-webkit-transform', 'scale('+_scale+', '+_scale+') translateZ(0)');
			// }, 125);
		});
	</script>
<?php endif; ?>

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>

<body>

	<script src="./assets/js/slideout.js"></script>
	<script>
		slideout = null;
		$(function(){
			slideout = new Slideout({
				'panel': document.getElementById('panel'),
				'menu': document.getElementById('menu'),
				// 'padding': 256,
				'padding': 333,
				'tolerance': 70
			});
		});
	</script>
	<style type="text/css">
		#menu, #menu a {
			/* ... */
			font-family: 'Lato', Calibri, Arial, sans-serif;
			font-family: 'Roboto';
			color: #f9f9f9;
		}
		#menu ul.menu-list li:first-child > a {
			box-shadow: inset 0 -1px rgba(0,0,0,0.2), inset 0 1px rgba(0,0,0,0.2);
		}
		#menu ul.menu-list li > a {
			display: block;
			padding: 0.7em 1em 0.7em 1.8em;
			outline: none;
			box-shadow: inset 0 -1px rgba(0,0,0,0.2);
			text-shadow: 0 0 1px rgba(255,255,255,0.1);
			font-size: 1.4em;
			-webkit-transition: background 0.3s, box-shadow 0.3s;
			-moz-transition: background 0.3s, box-shadow 0.3s;
			transition: background 0.3s, box-shadow 0.3s;
		}
	</style>



	<!--
		Pretty slideout menu examples:
		  - https://mango.github.io/slideout/
	-->
	<nav id="menu">
		<header>
			<h2>Alarm Clock Menu</h2>
		</header>
		<ul class="menu-list">
			<li><a href="#" onclick="slideout.close();" class="alarm-button">Set Alarm</a></li>
			<li><a href="#" onclick="slideout.close();" class="timer-button">Set Timer</a></li>
			<li><a href="#" onclick="setTimeout(function(){
					_scale += 0.1;
					$('#clock').css('transform', 'scale(' + _scale + ', ' + _scale + ') rotate(0deg) translateZ(0px)');
					$('#clock').css('-webkit-transform', 'scale(' + _scale + ', ' + _scale + ') rotate(0deg) translateZ(0px)');
					return false;
				}, 10);">Scale &plus;</a></li>
			<li><a href="#" onclick="setTimeout(function(){
					_scale -= 0.1;
					$('#clock').css('transform', 'scale(' + _scale + ', ' + _scale + ') rotate(0deg) translateZ(0px)');
					$('#clock').css('-webkit-transform', 'scale(' + _scale + ', ' + _scale + ') rotate(0deg) translateZ(0px)');
					return false;
				}, 10);">Scale &minus;</a></li>
			<!-- <li><a href="#" onclick="" class="switch-theme button">Switch Theme</a></li> -->
			<li><a href="#" onclick="
					location.search = 'scale=' + Math.round(_scale*100)/100<?=isset($_GET['skip'])?" + '&skip'":'';?> + Math.random();
					return false;">Reload &#x21bb;</a></li>
			<li><a href="#" onclick="eval( prompt('Please type-in JavaScript source code') );">Eval JS </a></li>
			<li><a href="#" onclick=""></a></li>
			<li><a href="#" onclick=""></a></li>
			<li><a href="#" onclick=""></a></li>
		</ul>
	</nav>



	<!-- Let all begin -->
	<style type="text/css">
		#panel .items .item,
		#panel .items .item2,
		.main-container .toggle-menu {
			/* ... */
			position: fixed;
			top: 0px;
			left: 0px;
			opacity: 0.5;
			z-index: 15;
			margin: 65px;
		}
		#panel .items .item2 { left: 70px; }
		#panel .messages-log {
			position: fixed;
			bottom: 10px;
			left: 65px;
			z-index: 14;
		}

		.sunny { top: -82px; }
		.cloudy { top: -28px; }
		.rainy { top: -28px; }
		.snowy { top: -32px; }
		.rainbow { top: -48px; }
		.starry { top: 34px; }
		.stormy { top: -30px; }

	</style>

	<main id="panel" class="main-container">


	<div class="messages-log">
		<pre>
[i] Started, logging in... OK
---------------------------------------
[*] STARRED: 1 people online !!
---------------------------------------
[i] Search: 137 matches
[-] Page #1: found 10 people (10 total)
[-] Page #2: found 10 people (20 total)
[-] Page #3: found 10 people (30 total)
[i] Search: finished
[-] Fresh profile, message sent (1 total)
[-] Fresh profile, message sent (2 total)
[-] Fresh profile, message sent (3 total)

[!] cURL error 18: See http://curl.haxx.se/libcurl/c/libcurl-errors.html
		</pre>
		<!-- <p> [i] Application started</p> -->
		<!-- <p> [i] </p> -->
	</div>

		<header>


			<div class="items">
				<!-- weather anim -->
				<div class="weather-container">
					<?php require_once './_current_weather.php'; ?>
				</div>
				&nbsp;
				<!-- hamburger menu -->
				<div class="toggle-menu">
					<button class="cmn-toggle-switch cmn-toggle-switch__mini" onclick="slideout.toggle();">
						<span>toggle menu</span>
					</button>
				</div>
			</div>
			<script type="text/javascript">
				(function() {
					"use strict";
					var toggles = document.querySelectorAll(".cmn-toggle-switch");
					for (var i = toggles.length - 1; i >= 0; i--) {
						var toggle = toggles[i];
						toggleHandler(toggle);
					};
					function toggleHandler(toggle) {
						toggle.addEventListener( "click", function(e) {
							e.preventDefault();
							(this.classList.contains("active") === true) ? 
								this.classList.remove("active") : this.classList.add("active");
						});
					}
				})();
			</script>

		</header>






		<!--
			YouTube API Reference:
			  - https://developers.google.com/youtube/iframe_api_reference
		-->
		<div class="video-holder"<?php if (isset($_GET['skip'])) echo ' style="display: none;"'; ?>>
			<!--
				http://www.youtube.com/watch?v=P2x3-b6JEj8&list=RDEpjcgOz_uQ0
				http://www.youtube.com/watch?v=o6XWMvaqzRY&list=RDEpjcgOz_uQ0
				http://www.youtube.com/watch?v=RovRsMnn9wA&list=RDEpjcgOz_uQ0
				http://www.youtube.com/watch?v=hu5ymjkgrBU&list=RDEpjcgOz_uQ0	UMF

				http://www.youtube.com/watch?v=NEdJeOAUtco	Polska
				http://www.youtube.com/watch?v=gGy1lEXSmf0	Polska

				http://www.youtube.com/watch?v=KAmCY60yx1Y
			-->
			<iframe src="https://www.youtube.com/embed/KAmCY60yx1Y?enablejsapi=1&amp;list=RDEpjcgOz_uQ0"
				allowfullscreen style="width: 100%; height: 70%;" id="video-alarm" frameborder="0"></iframe>
			<button class="preload">&rarr; Preload the video &larr;</button>
			<button class="dismiss" onclick="
					// $('#video-alarm').css('height', '100%');

					$(this).css('position', 'fixed');
					$(this).css('left', '0px');
					$(this).css('bottom', '0px');
					$(this).css('z-index', '1');
					$(this).css('font-size', '2em');
					$(this).css('height', '15%');

					// player.pauseVideo();
					// $('.video-holder').hide();
					// $('.video-holder').animate({ opacity: 1 }, 5000);
					// $('.weather-container').animate({ opacity: 0 }, 1);
					// $('.weather-container').animate({ opacity: 1 }, 5000);
				">&rarr; Pause the video &larr;</button>
		</div>







		<!-- Solar System decoration -->
		<div class="solar-container">
			<div class="solar-syst">
				<div class="sun"></div>
				<div class="mercury"></div>
				<div class="venus"></div>
				<div class="earth"></div>
				<div class="mars"></div>
				<div class="jupiter"></div>
				<div class="saturn"></div>
				<div class="uranus"></div>
				<div class="neptune"></div>
				<div class="pluto"></div>
				<div class="asteroids-belt"></div>
			</div>
		</div>





		<!-- Astral decoration 
		<div class="astral-wrapper">
			<div class="astral-container"></div>
		</div>
		<!-- -->



		<!-- the Clock -->
		<div id="clock" class="dark">
		<!-- <div id="clock" class="light"> -->
			<div class="display">
				<div class="weekdays"></div>
				<!-- <div class="ampm"></div> -->
				<div class="alarm"></div>
				<div class="digits"></div>
			</div>
		</div>




		<!-- Buttons panel -->
		<style type="text/css">
		.button-holder, .button-holder * {
			opacity: 0.90;
		}
		.button-holder div {
			display: inline-block;
			/*width: 110px;*/
			margin: 0px auto;
			padding: 0px 20px;
			border-radius: 30px;

			background: #C0C0C0;
			background: #808080;
			background: #272E38;
			box-shadow: 0px 0px 8px 0px rgba(186, 186, 186, 1);
			box-shadow: 0px 0px 5px 0px rgba(73, 73, 73, 1);
			opacity: 0.85;
			opacity: 1;
		}
		.button-holder div a { color: #1E4D59; font-size: 150%; }
		.button-holder div a:hover { color: #2593AB; }
		.button-holder div span {
			color: rgba(19, 27, 38, 0.39);
			font-size: 80%;
			vertical-align: text-top;
		}
		</style>


		<?php /*
		<!-- Buttons panel -->
		<div class="button-holder">
			<a id="switch-theme" class="switch-theme button">Switch Theme</a>
			<a class="timer-button"></a>
			<a class="alarm-button"></a>
			<br><br><br>
			<div>
				<!-- <a href="#" onclick=" ">&#x23f0;</a> -->
				<!-- <span>&nbsp;&nbsp;|&nbsp;&nbsp;</span> -->
				<a href="#" onclick="setTimeout(function(){
						_scale += 0.1;
						$('#clock').css('transform', 'scale(' + _scale + ', ' + _scale + ') rotate(0deg) translateZ(0px)');
						$('#clock').css('-webkit-transform', 'scale(' + _scale + ', ' + _scale + ') rotate(0deg) translateZ(0px)');
						return false;
					}, 10);">&plus;</a>
				<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
				<a href="#" onclick="alert('B00M!'); return false;">!!</a>
				<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
				<a href="#" onclick="
						location.search = 'scale=' + Math.round(_scale*100)/100<?=isset($_GET['skip'])?" + '&skip'":'';?> + Math.random();
						return false;">&#x21bb;</a>
				<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
				<a href="#" onclick="setTimeout(function(){
						_scale -= 0.1;
						$('#clock').css('transform', 'scale(' + _scale + ', ' + _scale + ') rotate(0deg) translateZ(0px)');
						$('#clock').css('-webkit-transform', 'scale(' + _scale + ', ' + _scale + ') rotate(0deg) translateZ(0px)');
						return false;
					}, 10);">&minus;</a>
				<!-- <span>&nbsp;&nbsp;|&nbsp;&nbsp;</span> -->
				<!-- <a href="#" onclick=" ">&#x23f0;</a> -->
			</div>
		</div>
		*/ ?>







		<style type="text/css">
			#timer-dialog span,
			#alarm-dialog span {
				font-size: 1.25em;
				display: inline-block;
			}
		</style>


		<!-- The dialog is hidden with css -->
		<div class="overlay">
			<div id="timer-dialog">
				<h2>Set timer to</h2>
					<label class="hours">
						Hours
						<input type="number" value="00" min="0" max="23" />
					</label>
					<span>:</span>
					<label class="minutes">
						Minutes
						<input type="number" value="00" min="0" max="59" />
					</label>
					<span>:</span>
					<label class="seconds">
						Seconds
						<input type="number" value="00" min="0" max="59" />
					</label>
				<div class="button-holder">
					<a id="timer-set" class="button blue">Set</a>
					<a id="timer-clear" class="button red">Clear</a>
				</div>
				<a class="close"></a>
			</div>
		</div>





		<style type="text/css">



/* Spin Buttons modified */
input[type="number"].mod::-webkit-outer-spin-button, 
input[type="number"].mod::-webkit-inner-spin-button {
    -webkit-appearance: none;
    background: #FFF url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAKUlEQVQYlWNgwAT/sYhhKPiPT+F/LJgEsHv37v+EMGkmkuImoh2NoQAANlcun/q4OoYAAAAASUVORK5CYII=) no-repeat center center;
    width: 1em;
    border-left: 1px solid #BBB;
    opacity: .5; /* shows Spin Buttons per default (Chrome >= 39) */
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
}
input[type="number"].mod::-webkit-inner-spin-button:hover,
input[type="number"].mod::-webkit-inner-spin-button:active{
    box-shadow: 0 0 2px #0CF;
    opacity: .8;
}

/* Override browser form filling */
input:-webkit-autofill {
    background: black;
    color: red;
}


		</style>



		<!-- The dialog is hidden with css -->
		<div class="overlay">
			<div id="alarm-dialog">
				<h2>Set alarm at</h2>
					<label class="hours">
						Hours
						<input type="number" name="hours" value="07" min="0" max="23" step="1" />
					</label>
					<span>:</span>
					<label class="minutes">
						Minutes
						<input type="number" name="minutes" value="30" min="0" max="59" step="1" />
					</label>
				<div class="button-holder">
					<a id="alarm-set" class="button blue">Set</a>
					<a id="alarm-clear" class="button red">Clear</a>
				</div>
				<a class="close"></a>
			</div>
		</div>



		<!-- The dialog is hidden with css -->
		<div class="overlay">
			<div id="time-is-up">
				<h2>Time's up!</h2>
				<div class="button-holder">
					<a class="button blue">Close</a>
				</div>
			</div>
		</div>




		<!-- Video preload dialog (required for mobile use!) -->
		<audio id="alarm-ring" preload>
			<source src="./assets/audio/ticktac.mp3" type="audio/mpeg" />
			<source src="./assets/audio/ticktac.ogg" type="audio/ogg" />
		</audio>








		<!-- Rest the JavaScript -->
		<script type="text/javascript">

			/*
				YouTube API Reference:
				  - https://developers.google.com/youtube/iframe_api_reference
			*/


			// Inject YouTube API script
			var tag = document.createElement('script');
			tag.src = "//www.youtube.com/player_api";
			//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			var player;
			function onYouTubePlayerAPIReady() {
				// create the global player from the specific iframe (#video)
				player = new YT.Player('video-alarm', {
					events: {
						// call this function when player is ready to use
						'onReady': onPlayerReady
					}
				});
			}



			function onPlayerReady(event) {
				$('.weather-container').css('opacity', 0);
				player.playVideo();
				setTimeout(function(){
					player.pauseVideo();
					$('.weather-container').animate({ opacity: 1 }, 5000);
				}, 125);<?php if (isset($_GET['skip'])) echo "
				$('.preload').trigger('click');"; ?>
			}



			// Push the start button
			$('.preload').on('click', function(e){
				e.preventDefault();
				try {
					$('.weather-container').css('opacity', 0);
					if (player) player.playVideo();
					setTimeout(function(){
						if (player) player.pauseVideo();
						if (player) $('.weather-container').css('opacity', 0);
						if (player) $('.weather-container').animate({ opacity: 1 }, 5000);
						$('.video-holder').hide( 250 );
						setTimeout(function(){
							$('.video-holder button.preload').hide( 0 );
							//$('.video-holder #video-alarm').css( 'height', '95%' );
							if (player) player.pauseVideo();

							setInterval(function(){
		console.log( '_________________________________________________________________________________________________________' );
		console.log( 'Now, will check the weather...' );
								$.ajax({
										url: "./_current_weather.php?json=" + Math.random(),
										dataType: "json",
								}).done(function( current_weather ) {
		console.log( 'Current weather code:' + $('.weather-container').html().trim() );
		console.log( 'Fresh weather code:' + current_weather.html.trim() );
		console.log( 'Is the weather is new? ' + (current_weather.html.trim() != $('.weather-container').html().trim()) );
									if ( current_weather.html.trim() != $('.weather-container').html().trim() ) {
		///*///
		console.log(
			'_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-' + 
				'The weather has just changed! Yay!   ' + 
			'_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-_-+**+-' );
		///*///
										$('.weather-container').animate({ opacity: 0 }, 5000);
										setTimeout(function(){
											$('.weather-container').html( current_weather.html.trim() ).animate({ opacity: 1 }, 5000);
										}, 5000);
									} // else console.log( 'The weather hasn`t changed' );
								});
							}, 7*60*1000); // Check the weather every 20 mins
							$('#video-alarm').css('height', '100%');
						}, 350);
					}, 125);
				} catch(e){}
			});
		</script>



		<script type="text/javascript">
			/*
				$(function(){
					// Astral animation (canvas)
					$('.astral-container').astral();
					// Background color clock
					$('body').on('load', function() {
						setInterval(function(){ dotime();}, 1000);
					});
				});

				function dotime(){
					$("body").css({"transition": "all 0.8s", "-webkit-transition": "all 0.8s"});
					var d = new Date();
					var hours = d.getHours();
					var mins = d.getMinutes();
					var secs = d.getSeconds();
					if (hours < 10) {hours = "0" + hours};
					if (mins < 10){mins = "0" + mins};
					if (secs < 10){secs = "0" + secs};
					hours.toString();
					mins.toString();
					secs.toString();
					var hex = "#" + hours + mins + secs;
					$("#t").html(hours +" : "+ mins +" : "+ secs);
					$("#h").html(hex);
					document.body.style.background = hex;
				}
			//*/
		</script>


	</main>

</body>
</html>