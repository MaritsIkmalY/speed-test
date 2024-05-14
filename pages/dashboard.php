<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./dashboard.css">
    <title>Dashboard</title>
</head>

<body>
    <div class="bg-gradient h-full text-white min-h-screen flex gap-4">

        <!-- SideBar -->

        <div class="flex flex-col justify-between items-start gap-4 pl-8 py-20 sticky left-0 top-0 h-full">
            <div>
                <div class="bg-glass rounded-2xl flex gap-4 items-center p-4 min-w-[250px] max-w-[250px]">

                    <img class="border-2 w-[70px] h-[70px]  rounded-2xl" src="../assets/person.jpeg" alt="">

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
            <div class="box flex flex-col items-center justify-center cursor-pointer">
                <p class="gradient-green font-bold text-6xl">START</>
            </div>
        </div>
    </div>
</body>

</html>