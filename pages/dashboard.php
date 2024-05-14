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
    <div class="bg-gradient h-screen text-white flex gap-4 p-12">

        <div class="flex flex-col gap-4">

            <div class="bg-glass rounded-2xl flex gap-4 items-center p-6">

                <img class="border-2 w-[70px] h-[70px]  rounded-2xl" src="../assets/person.jpeg" alt="">

                <div class="font-semibold">
                    <p>Hi, </p>
                    <p>Nico</p>
                </div>
            </div>

            <div class="bg-glass rounded-2xl p-4">
                <ul class="flex flex-col gap-4">
                    <li>Home</li>
                    <li>History</li>
                    <li>About us</li>
                </ul>
            </div>

            <button class="bg-glass rounded-2xl p-4 mt-20">Log out</button>
        </div>

        <div>

            Content

        </div>
    </div>
</body>

</html>