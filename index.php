<!DOCTYPE html>
<?php

session_start();

if (!isset($_SESSION['id']) && !isset($_SESSION['guest'])) {
	header("location: login.php");
	exit;
}

$nameToDisplay = isset($_SESSION['guest']) ? $_SESSION['guest'] : $_SESSION['name'];
?>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no" />
	<meta charset="UTF-8" />
	<link rel="shortcut icon" href="favicon.ico">
	<script type="text/javascript" src="speedtest.js"></script>
	<script type="text/javascript">
		function I(i) {
			return document.getElementById(i);
		}
		//INITIALIZE SPEEDTEST
		var s = new Speedtest(); //create speedtest object
		s.setParameter("telemetry_level", "basic"); //enable telemetry

		var meterBk = /Trident.*rv:(\d+\.\d+)/i.test(navigator.userAgent) ? "#EAEAEA" : "#80808040";
		var dlColor = "#6060AA",
			ulColor = "#616161";
		var progColor = meterBk;

		//CODE FOR GAUGES
		function drawMeter(c, amount, bk, fg, progress, prog) {
			var ctx = c.getContext("2d");
			var dp = window.devicePixelRatio || 1;
			var cw = c.clientWidth * dp,
				ch = c.clientHeight * dp;
			var sizScale = ch * 0.0055;
			if (c.width == cw && c.height == ch) {
				ctx.clearRect(0, 0, cw, ch);
			} else {
				c.width = cw;
				c.height = ch;
			}
			ctx.beginPath();
			ctx.strokeStyle = bk;
			ctx.lineWidth = 24 * sizScale; // Thickness of the line
			ctx.arc(c.width / 2, c.height - 58 * sizScale, c.height / 1.5 - ctx.lineWidth, -Math.PI * 1.1, Math.PI * 0.1); // Increased arc diameter
			ctx.stroke();
			ctx.beginPath();
			ctx.strokeStyle = fg;
			ctx.lineWidth = 24 * sizScale; // Thickness of the line
			ctx.arc(c.width / 2, c.height - 58 * sizScale, c.height / 1.5 - ctx.lineWidth, -Math.PI * 1.1, amount * Math.PI * 1.2 - Math.PI * 1.1); // Increased arc diameter
			ctx.stroke();
			if (typeof progress !== "undefined") {
				ctx.fillStyle = prog;
				ctx.fillRect(c.width * 0.3, c.height - 16 * sizScale, c.width * 0.4 * progress, 4 * sizScale);
			}
		}

		function mbpsToAmount(s) {
			return 1 - (1 / (Math.pow(1.3, Math.sqrt(s))));
		}

		function format(d) {
			d = Number(d);
			if (d < 10) return d.toFixed(2);
			if (d < 100) return d.toFixed(1);
			return d.toFixed(0);
		}

		//UI CODE
		var uiData = null;

		function startStop() {
			if (s.getState() == 3) {
				//speedtest is running, abort
				s.abort();
				data = null;
				// I("startStopBtn").className = "";
				initUI();
			} else {
				//test is not running, begin
				// I("startStopBtn").className = "running";
				I("shareArea").style.display = "none";
				s.onupdate = function(data) {
					uiData = data;
				};
				s.onend = function(aborted) {
					// I("startStopBtn").className = "";
					updateUI(true);
					if (!aborted) {
						//if testId is present, show sharing panel, otherwise do nothing
						try {
							var testId = uiData.testId;
							if (testId != null) {
								var shareURL = window.location.href.substring(0, window.location.href.lastIndexOf("/")) + "/results/?id=" + testId;
								I("resultsImg").src = shareURL;
								I("resultsURL").value = shareURL;
								I("testId").innerHTML = testId;
								I("shareArea").style.display = "";
							}
						} catch (e) {}
					}
				};
				s.start();
			}
		}
		//this function reads the data sent back by the test and updates the UI
		function updateUI(forced) {
			if (!forced && s.getState() != 3) return;
			if (uiData == null) return;


			var status = uiData.testState;
			I("ip").textContent = uiData.clientIp;
			I("dlText").textContent = (status == 1 && uiData.dlStatus == 0) ? "..." : format(uiData.dlStatus);

			// I("dlText2").textContent = (status == 1 && uiData.dlStatus == 0) ? "..." : format(uiData.dlStatus);

			if (status == 1) {
				I("dlText2").textContent = (status == 1 && uiData.dlStatus == 0) ? "..." : format(uiData.dlStatus);
				drawMeter(I("dlMeter"), mbpsToAmount(Number(uiData.dlStatus * (status == 1 ? oscillate() : 1))), meterBk, dlColor, Number(uiData.dlProgress), progColor);
			} else if (status == 3) {
				drawMeter(I("dlMeter"), mbpsToAmount(Number(uiData.ulStatus * (status == 3 ? oscillate() : 1))), meterBk, ulColor, Number(uiData.ulProgress), progColor);
				I("dlText2").textContent = (status == 1 && uiData.dlStatus == 0) ? "..." : format(uiData.ulStatus);
				//drawMeter(I("ulMeter"), mbpsToAmount(Number(uiData.ulStatus * (status == 3 ? oscillate() : 1))), meterBk, ulColor, Number(uiData.ulProgress), progColor);
			} else if(status == 4){
				drawMeter(I("dlMeter"), mbpsToAmount(Number(0 * (status == 3 ? oscillate() : 1))), meterBk, ulColor, Number(0), progColor);
				I("dlText2").textContent = '0.00';
			} 
			console.log(status);
			I("ulText").textContent = (status == 3 && uiData.ulStatus == 0) ? "..." : format(uiData.ulStatus);
			// I("ulText2").textContent = (status == 3 && uiData.ulStatus == 0) ? "..." : format(uiData.ulStatus);


			I("pingText").textContent = format(uiData.pingStatus);
			I("jitText").textContent = format(uiData.jitterStatus);
		}

		function oscillate() {
			return 1 + 0.02 * Math.sin(Date.now() / 100);
		}
		//update the UI every frame
		window.requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRequestAnimationFrame || (function(callback, element) {
			setTimeout(callback, 1000 / 60);
		});

		function frame() {
			requestAnimationFrame(frame);
			updateUI();
		}
		frame(); //start frame loop
		//function to (re)initialize UI
		function initUI() {
			drawMeter(I("dlMeter"), 0, meterBk, dlColor, 0);
			drawMeter(I("ulMeter"), 0, meterBk, ulColor, 0);
			I("dlText").textContent = "";
			I("ulText").textContent = "";
			I("pingText").textContent = "";
			I("jitText").textContent = "";
			I("ip").textContent = "";
		}
	</script>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="./dashboard.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
	<style type="text/css">
		#test {
			margin-top: 2em;
			margin-bottom: 12em;
		}

		div.testArea {

			width: 16em;
			height: 12.5em;
			position: relative;
			box-sizing: border-box;
		}

		div.testArea2 {
			display: inline-block;
			width: 14em;
			height: 7em;
			position: relative;
			box-sizing: border-box;
			text-align: center;
		}

		div.testArea div.testName {
			position: absolute;
			top: 2.5em;
			left: 0;
			width: 100%;
			font-size: 1.4em;
			z-index: 9;
		}

		div.testArea2 div.testName {
			display: block;
			text-align: center;
			font-size: 1.4em;
		}

		div.testArea div.meterText {
			position: absolute;
			top: 4em;
			bottom: 1.55em;
			left: 0;
			width: 100%;
			font-size: 2.5em;
			z-index: 9;
		}

		div.testArea2 div.meterText {
			display: inline-block;
			font-size: 2.5em;
		}

		div.meterText:empty:before {
			content: "0.00";
		}

		div.testArea div.unit {
			position: absolute;
			top: 15em;
			bottom: 2em;
			left: 0;
			width: 100%;
			z-index: 9;
		}

		div.testArea2 div.unit {
			display: inline-block;
		}

		div.testArea canvas {
			position: absolute;
			top: 80px;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 1;
		}

		div.testGroup {
			display: block;
			margin: 0 auto;
		}

		#shareArea {
			width: 95%;
			max-width: 40em;
			margin: 0 auto;
			margin-top: 2em;
		}

		#shareArea>* {
			display: block;
			width: 100%;
			height: auto;
			margin: 0.25em 0;
		}

		#privacyPolicy {
			position: fixed;
			top: 2em;
			bottom: 2em;
			left: 2em;
			right: 2em;
			overflow-y: auto;
			width: auto;
			height: auto;
			box-shadow: 0 0 3em 1em #000000;
			z-index: 999999;
			text-align: left;
			background-color: #FFFFFF;
			padding: 1em;
		}

		a.privacy {
			text-align: center;
			font-size: 0.8em;
			color: #808080;
			padding: 0 3em;
		}

		div.closePrivacyPolicy {
			width: 100%;
			text-align: center;
		}

		div.closePrivacyPolicy a.privacy {
			padding: 1em 3em;
		}

		@media all and (max-width:40em) {
			body {
				font-size: 0.8em;
			}
		}

		.transition-view {
			transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
			opacity: 0;
			transform: translateY(30px);
		}

		.visible {
			opacity: 1;
			transform: translateY(0px);
		}

		#newView {
			display: none;

		}
	</style>
	<title>LibreSpeed Example</title>
</head>

<body>
	<div class="bg-gradient h-full text-white min-h-screen flex gap-4">
		<!-- SideBar -->
		<div class="flex flex-col justify-between items-start gap-4 pl-8 py-20 sticky left-0 top-0 h-full">
			<div>
				<div class="bg-glass rounded-2xl flex gap-4 items-center p-4 min-w-[250px] max-w-[280px]">

					<img class="border-2 w-[70px] h-[70px]  rounded-2xl" src="./assets/person.jpeg" alt="">

					<div class="flex items-center gap-2 font-semibold text-ellipsis overflow-hidden">
						<p>Hi, </p>
						<p><?php echo $nameToDisplay; ?></p>
					</div>
				</div>

				<div class="bg-glass rounded-2xl p-8 w-full mt-16">
					<ul class="flex flex-col gap-8">
						<li><button class="bg-gradient py-4 px-16 mx-auto flex items-center justify-center rounded-2xl border-2 text-sm w-[200px]"><a href="index.php"><img src="./assets/Home Page.png" alt="home" class="inline-block h-4"> Home</a></button></li>
						<li> <button class="py-4 mx-auto flex items-center justify-center text-sm"><a href="history.php"><img src="./assets/Time Machine.png" alt="about us" class="inline-block h-4"> History</a></button></li>
						<li><button class="py-4 mx-auto flex items-center justify-center text-sm"><a href="about.php" class=""><img src="./assets/Information.png" alt="about us" class="inline-block h-4"> About Us</a></button></li>
					</ul>
				</div>
			</div>


			<button class="bg-glass rounded-2xl p-4 mt-32 w-full mb-8"> <a href="logout.php"> <img src="./assets/Logout Rounded Left.png" alt="logout" class="inline-block h-8"> Log out</a></button>
		</div>


		<!-- Content -->
		<div class="flex justify-center w-full flex-col items-center">
			<div class="box flex hover:scale-90 flex-col items-center justify-center cursor-pointer" id="startButton" onclick="startStop()">
				<p class="gradient-green font-bold text-6xl">START</p>
			</div>
			<div id="newView" class="transition-view hidden min-w-[800px]">
				<div class="flex h-full gap-4 items-center justify-center">

					<div class="testGroup flex flex-col items-center justify-center">
						<div class="testArea flex justify-center w-full right-0">
							<div class="testName text-center">Speed</div>
							<canvas id="dlMeter" class="meter"></canvas>
							<div id="dlText2" class="meterText text-center"></div>
							<div class="unit text-center">Mbps</div>
						</div>


						<div class="testArea">
							<div class="testName"></div>
							<canvas id="ulMeter" class="meter hidden"></canvas>
							<div id="ulText2" class="meterText hidden"></div>
						</div>
					</div>


					<div class="grid grid-cols-2 gap-6">
						<div>
							<div class="bg-[#FFFFFF] min-w-[180px] p-4 rounded-2xl">
								<div class="w-full h-5 bg-gray-200 rounded-full dark:bg-gray-700">
									<div class="h-5 bg-gradient-3  rounded-full " style="width: 45%"></div>
								</div>
								<p class="text-lg text-[#0F8C8C] font-bold mt-2 mb-1">UPLOAD</p>
								<p id="ulText" class="text-4xl text-[#1B5058] font-bold tracking-widest">

								</p>
								<p class="text-md text-[#0F8C8C] font-semibold text-right">
									Mbps
								</p>

							</div>

						</div>
						<div>
							<div class="bg-[#FFFFFF] min-w-[180px] p-4 rounded-2xl">
								<div class="w-full h-5 bg-gray-200 rounded-full dark:bg-gray-700">
									<div class="h-5 bg-gradient-3  rounded-full " style="width: 45%"></div>
								</div>
								<p class="text-lg text-[#0F8C8C] font-bold mt-2 mb-1">DOWNLOAD</p>
								<p id="dlText" class="text-4xl text-[#1B5058] font-bold tracking-widest">
								</p>
								<p class="text-md text-[#0F8C8C] font-semibold text-right">
									Mbps
								</p>

							</div>

						</div>
						<div>
							<div class="bg-[#FFFFFF] min-w-[180px] p-4 rounded-2xl">
								<div class="w-full h-5 bg-gray-200 rounded-full dark:bg-gray-700">
									<div class="h-5 bg-gradient-3  rounded-full " style="width: 45%"></div>
								</div>
								<p class="text-lg text-[#0F8C8C] font-bold mt-2 mb-1">PING</p>
								<p id="pingText" class="text-4xl text-[#1B5058] font-bold tracking-widest">
								</p>
								<p class="text-md text-[#0F8C8C] font-semibold text-right">
									Ms
								</p>

							</div>

						</div>
						<div>
							<div class="bg-[#FFFFFF] min-w-[180px] p-4 rounded-2xl">
								<div class="w-full h-5 bg-gray-200 rounded-full dark:bg-gray-700">
									<div class="h-5 bg-gradient-3  rounded-full " style="width: 45%"></div>
								</div>
								<p class="text-lg text-[#0F8C8C] font-bold mt-2 mb-1">JITTER</p>
								<p id="jitText" class="text-4xl text-[#1B5058] font-bold tracking-widest">

								</p>
								<p class="text-md text-[#0F8C8C] font-semibold text-right">
									Mbps
								</p>
							</div>

						</div>
					</div>

				</div>

				<button id="startStopBtn" onclick="startStop()" class="transition-transform hover:opacity-75 hover:scale-90 mt-16 bg-[#0F5E61] py-4 !w-full rounded-2xl font-semibold">
					Test Again
				</button>

			</div>
		</div>
	</div>

	<div id="testWrapper" class="hidden">
		<div id="startStopBtn" onclick="startStop()"></div><br />
		<a class="privacy" href="#" onclick="I('privacyPolicy').style.display=''">Privacy</a>
		<div id="test">
			<div class="testGroup">
				<div class="testArea2">
					<div class="testName">Ping</div>
					<div id="pingText" class="meterText" style="color:#AA6060"></div>
					<div class="unit">ms</div>
				</div>
				<div class="testArea2">
					<div class="testName">Jitter</div>
					<div id="jitText" class="meterText" style="color:#AA6060"></div>
					<div class="unit">ms</div>
				</div>
			</div>

			<div id="ipArea">
				<span id="ip"></span>
			</div>
			<div id="shareArea" style="display:none">
				<h3>Share results</h3>
				<p>Test ID: <span id="testId"></span></p>
				<input type="text" value="" id="resultsURL" readonly="readonly" onclick="this.select();this.focus();this.select();document.execCommand('copy');alert('Link copied')" />
				<img src="" id="resultsImg" />
			</div>
		</div>
		<a href="https://github.com/librespeed/speedtest">Source code</a>
		<a href="logout.php">logout</a>
	</div>

	<div id="privacyPolicy" style="display:none">
		<h2>Privacy Policy</h2>
		<p>This HTML5 speed test server is configured with telemetry enabled.</p>
		<h4>What data we collect</h4>
		<p>
			At the end of the test, the following data is collected and stored:
		<ul>
			<li>Test ID</li>
			<li>Time of testing</li>
			<li>Test results (download and upload speed, ping and jitter)</li>
			<li>IP address</li>
			<li>ISP information</li>
			<li>Approximate location (inferred from IP address, not GPS)</li>
			<li>User agent and browser locale</li>
			<li>Test log (contains no personal information)</li>
		</ul>
		</p>
		<h4>How we use the data</h4>
		<p>
			Data collected through this service is used to:
		<ul>
			<li>Allow sharing of test results (sharable image for forums, etc.)</li>
			<li>To improve the service offered to you (for instance, to detect problems on our side)</li>
		</ul>
		No personal information is disclosed to third parties.
		</p>
		<h4>Your consent</h4>
		<p>
			By starting the test, you consent to the terms of this privacy policy.
		</p>
		<h4>Data removal</h4>
		<p>
			If you want to have your information deleted, you need to provide either the ID of the test or your IP
			address. This is the only way to identify your data, without this information we won't be able to comply
			with your request.<br /><br />
			Contact this email address for all deletion requests: <a href="mailto:PUT@YOUR_EMAIL.HERE">TO BE FILLED BY
				DEVELOPER</a>.
		</p>
		<br /><br />
		<div class="closePrivacyPolicy">
			<a class="privacy" href="#" onclick="I('privacyPolicy').style.display='none'">Close</a>
		</div>
		<br />
	</div>

	<script type="text/javascript">
		setTimeout(function() {
			initUI()
		}, 100);
	</script>

	<script>
		window.onload = function() {
			var canvas = document.getElementById('gaugeCanvas');
			var ctx = canvas.getContext('2d');

			function drawGauge(value) {
				var x = canvas.width / 2;
				var y = canvas.height / 2;
				var radius = 150;
				var startAngle = 0.7 * Math.PI;
				var endAngle = 2.3 * Math.PI;

				// Clear the canvas
				ctx.clearRect(0, 0, canvas.width, canvas.height);

				// Draw the background
				ctx.beginPath();
				ctx.arc(x, y, radius, startAngle, endAngle, false);
				ctx.lineWidth = 20;
				ctx.strokeStyle = '#333';
				ctx.stroke();

				// Draw the active part
				var activeEndAngle = startAngle + (endAngle - startAngle) * (value / 100);
				ctx.beginPath();
				ctx.arc(x, y, radius, startAngle, activeEndAngle, false);
				ctx.lineWidth = 20;
				ctx.strokeStyle = 'cyan';
				ctx.stroke();

				// Draw the text
				ctx.font = '30px Arial';
				ctx.fillStyle = 'cyan';
				ctx.textAlign = 'center';
				ctx.fillText(value.toFixed(2) + ' Mbps', x, y + 10);
			}

			// Initial draw
			drawGauge(6.84);

			// Update the gauge randomly (for demonstration)
			setInterval(function() {
				drawGauge(Math.random() * 100);
			}, 2000);
		};
	</script>

	<script>
		document.getElementById('startButton').addEventListener('click', function() {
			var startView = document.getElementById('startButton');
			var newView = document.getElementById('newView');

			// Hide the start button and show the new view
			startView.style.display = 'none'; // Hide start view permanently
			newView.style.display = 'block'; // Make newView block to start transition

			// Delay is required to allow display change to register before starting opacity transition
			setTimeout(function() {
				newView.classList.add('visible'); // Add visibility class after a slight delay
			}, 10); // Delay should be very short to kickstart the transition
		});
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>