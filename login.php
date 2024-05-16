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
    <?php
    include 'connect.php';

    if (isset($_POST['submit'])) {
        $email    = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);

        $data = mysqli_query($connect, 'SELECT * FROM users WHERE email = "' . $email . '"')->fetch_assoc();

        if (empty($data)) {
            $error = 'Email tidak terdaftar!';
        } else {
            if (!password_verify($password, $data['password'])) {
                $error = 'Kata sandi salah!';
            } else {
                $_SESSION['name'] = $data['name'];
                $_SESSION['id'] = $data['id'];
                header('Location: index.php');
                exit();
            }
        }
    }
    ?>
    <div class="bg-gradient w-full flex flex-col items-center h-screen justify-center bg-green-900 overflow-y-hidden">
        <div class="w-fit flex border-2 rounded-top-left rounded-bottom-right">

            <div class="bg-[#F8F2EA] px-10 py-20 rounded-inherit">
                <div class="bg-login w-[370px] h-[370px] rounded-3xl"></div>
            </div>

            <div class="flex flex-col gap-4 px-12 pt-24 pb-32 bg-glass rounded-bottom-right">
                <div class="text-white">
                    <h1 class="text-4xl font-semibold">Welcome</h1>
                    <p class="text-lg font-medium mt-1">Please login into your account</p>
                </div>
                <div class="col-md-12" style="margin-bottom: 6px;">
                    <?php
                    if (!empty($error)) {
                        echo '<b>Warning:</b> <span style="color:red;">' . $error . '</span>';
                    }
                    ?>
                </div>

                <form class="flex flex-col gap-6 mt-8" method="POST">
                    <div class="input-container p-4">
                        <img src="./assets/people.png" alt="User Icon">
                        <input type="email" placeholder="Email" name="email">
                    </div>
                    <div class="input-container p-4">
                        <img src="./assets/lock.png" alt="Lock Icon">
                        <input type="password" placeholder="Password" name="password">
                    </div>

                    <button type="submit" name="submit" class="bg-[#0F5E61] py-3 text-white border-2 rounded-2xl mt-6"> Login</button>
                </form>
            </div>
        </div>
    </div>

    <img src="./assets/Group 14.png" alt="Bottom Left Image" class="bottom-left-image">
    <img src="./assets/3D abstract colorful form.png" alt="Bottom Right Image" class="bottom-right-image">
</body>

</html>