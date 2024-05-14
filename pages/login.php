<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>

<body>
    <div class="w-full flex flex-col items-center h-screen justify-center bg-green-900">
        <div class="w-fit flex border-2 rounded-top-left rounded-bottom-right">

            <div class="bg-[#F8F2EA] px-10 py-20 rounded-inherit">
                <div class="bg-login w-[370px] h-[370px] rounded-3xl"></div>
            </div>

            <div class="flex flex-col gap-4 px-12 pt-24 pb-32 bg-glass rounded-bottom-right">
                <div class="text-white">
                    <h1 class="text-4xl font-semibold">Welcome</h1>
                    <p class="text-lg font-medium mt-1">Please login into your account</p>
                </div>

                <div class="flex flex-col gap-6 mt-8" method="POST">
                    <div class="input-container p-4">
                        <img src="../assets/people.png" alt="User Icon">
                        <input type="email" placeholder="Email" name="email">
                    </div>
                    <div class="input-container p-4">
                        <img src="../assets/lock.png" alt="Lock Icon">
                        <input type="password" placeholder="Password" name="password">
                    </div>

                    <button class="bg-[#0F5E61] py-3 text-white border-2 rounded-2xl mt-6">Login</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>