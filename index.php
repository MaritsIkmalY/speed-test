<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script type="text/javascript" src="speedtest.js"></script>
    <script>
        // Initialize speed test object
        var s = new Speedtest();
        s.setParameter("telemetry_level", "basic");

        // Update UI with speed test data
        s.onupdate = function (data) {
            // Update download text and meter
            document.getElementById("dlText").textContent = (data.dlStatus != null) ? format(data.dlStatus) : "...";
            drawMeter(document.getElementById("dlMeter"), mbpsToAmount(Number(data.dlStatus)), meterBk, dlColor, Number(data.dlProgress), progColor);

            // Update upload text and meter
            document.getElementById("ulText").textContent = (data.ulStatus != null) ? format(data.ulStatus) : "...";
            drawMeter(document.getElementById("ulMeter"), mbpsToAmount(Number(data.ulStatus)), meterBk, ulColor, Number(data.ulProgress), progColor);

            // Update ping text
            document.getElementById("pingText").textContent = (data.pingStatus != null) ? format(data.pingStatus) : "...";

            // Update jitter text
            document.getElementById("jitText").textContent = (data.jitterStatus != null) ? format(data.jitterStatus) : "...";
        };

        // Start the speed test
        s.start();

    </script>

    <title>Dashboard</title>
    <style>
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
</head>

<body>
    <div class="bg-gradient h-full text-white min-h-screen flex gap-4">
        <!-- SideBar -->
        <div class="flex flex-col justify-between items-start gap-4 pl-8 py-20 sticky left-0 top-0 h-full">
            <div>
                <div class="bg-glass rounded-2xl flex gap-4 items-center p-4 min-w-[250px] max-w-[250px]">
                    <img class="border-2 w-[70px] h-[70px] rounded-2xl" src="../assets/person.jpeg" alt="">
                    <div class="flex items-center gap-2 font-semibold text-ellipsis overflow-hidden">
                        <p>Hi, </p>
                        <p>Nicholaus</p>
                    </div>
                </div>
                <div class="bg-glass rounded-2xl p-8 w-full mt-16">
                    <ul class="flex flex-col gap-8">
                        <li>Home</li>
                        <li>History</li>
                        <li>About us</li>
                    </ul>
                </div>
            </div>
            <button class="bg-glass rounded-2xl p-4 mt-32 w-full mb-8">Log out</button>
        </div>

        <!-- Content -->
        <div class="flex justify-center w-full flex-col items-center">
            <div class="box flex hover:scale-90 flex-col items-center justify-center cursor-pointer" id="startButton">
                <p class="gradient-green font-bold text-6xl">START</p>
            </div>
            <div id="newView" class="transition-view hidden min-w-[800px]">
                <div class="flex gap-4 items-center justify-center">
                    <div>
                        <canvas id="gaugeCanvas" width="400" height="400"></canvas>
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

                <button
                    class="transition-transform hover:opacity-75 hover:scale-90 mt-16 bg-[#0F5E61] py-4 w-full rounded-2xl font-semibold">
                    Test Again
                </button>

            </div>
        </div>
    </div>

    <script>
        window.onload = function () {
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
            setInterval(function () {
                drawGauge(Math.random() * 100);
            }, 2000);
        };

    </script>

    <script>
        document.getElementById('startButton').addEventListener('click', function () {
            var startView = document.getElementById('startButton');
            var newView = document.getElementById('newView');

            // Hide the start button and show the new view
            startView.style.display = 'none'; // Hide start view permanently
            newView.style.display = 'block'; // Make newView block to start transition

            // Delay is required to allow display change to register before starting opacity transition
            setTimeout(function () {
                newView.classList.add('visible'); // Add visibility class after a slight delay
            }, 10); // Delay should be very short to kickstart the transition
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>