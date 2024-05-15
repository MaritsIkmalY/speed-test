<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./history.css">
    <title>Dashboard</title>
    <style>
        .custom-header {
            background: transparent;
            color: white;
        }

   
    </style>
</head>

<body>
    <?php
    include 'connect.php';

    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    }

    $data = mysqli_query($connect, 'SELECT * FROM speedtest_users WHERE user_id = "' . $_SESSION['id'] . '"');
    ?>
    <div class="bg-gradient h-full text-white min-h-screen flex gap-4">

        <!-- SideBar -->
        <div class="flex flex-col justify-between items-start gap-4 pl-8 py-20 sticky left-0 top-0 h-full">
            <div>
                <div class="bg-glass rounded-2xl flex gap-4 items-center p-4 min-w-[250px] max-w-[250px]">

                    <img class="border-2 w-[70px] h-[70px]  rounded-2xl" src="./assets/person.jpeg" alt="">

                    <div class="flex items-center gap-2 font-semibold text-ellipsis overflow-hidden">
                        <p>Hi, </p>
                        <p>Nicholaus</p>
                    </div>
                </div>

                <div class="bg-glass rounded-2xl p-8 w-full mt-16">
                    <ul class="flex flex-col gap-8">
                        <li><a href="/speed-test/index.php">Home</a></li>
                        <li class="bg-gradient p-4 rounded-2xl border-2">History</li>
                        <li>About us</li>
                    </ul>
                </div>
            </div>


            <button class="bg-glass rounded-2xl p-4 mt-32 w-full mb-8">Log out</button>
        </div>

        <!-- Content -->
        <div class="flex justify-center w-full flex-col items-center">
            <div class="w-full max-w-7xl h-90 overflow-y-auto mt-10 max-h-[80vh]">
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <table class="min-w-full divide-y outline-none border-none">
                        <thead class="outline-none border-none">
                            <tr class="custom-header text-center">
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Date/Time</th>
                                <th class="py-3 px-4">Ping<br>Ms</th>
                                <th class="py-3 px-4">Jitter<br>Ms</th>
                                <th class="py-3 px-4">Upload<br>Mbps</th>
                                <th class="py-3 px-4">Download<br>Mbps</th>
                            </tr>
                        </thead>
                        <tbody class="text-center bg-[#0F5E61]"> 
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($data)) {
                                ?>
                                <tr class="hover:bg-[#C6FEFE] hover:text-black hover:font-bold rounded-2xl">
                                    <td class="py-10 px-4"><?php echo $no++ ?></td>
                                    <td class="py-10 px-4">
                                        <div>
                                            <?php
                                            $timestamp = $row['timestamp'];
                                            $unixTimestamp = strtotime($timestamp);
                                            $formattedDate = date('h:i A', $unixTimestamp);
                                            echo $formattedDate;
                                            ?>
                                        </div>
                                        <div class="text-xs"><?php
                                        $timestamp = $row['timestamp'];
                                        $unixTimestamp = strtotime($timestamp);
                                        $formattedDate = date('d/m/Y', $unixTimestamp);
                                        echo $formattedDate;
                                        ?>
                                        </div>
                                    </td>
                                    <td class="py-10 px-4"><?php echo $row['ping']; ?></td>
                                    <td class="py-10 px-4"><?php echo $row['jitter']; ?></td>
                                    <td class="py-10 px-4"><?php echo $row['ul']; ?></td>
                                    <td class="py-10 px-4"><?php echo $row['dl']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</body>

</html>