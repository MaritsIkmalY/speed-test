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

    if (!isset($_SESSION['id']) && !isset($_SESSION['guest'])) {
        header("Location: login.php");
        exit;
    }

    $nameToDisplay = isset($_SESSION['guest']) ? $_SESSION['guest'] : $_SESSION['name'];

    if (isset($_SESSION['guest'])) {
        $data = isset($_COOKIE['userData']) ? unserialize($_COOKIE['userData']) : array();
    } else {
        $query = 'SELECT * FROM speedtest_users WHERE user_id = "' . $_SESSION['id'] . '"';
        $result = mysqli_query($connect, $query);
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    ?>

    <div class="bg-gradient h-full text-white min-h-screen flex gap-4">
        <!-- SideBar -->
        <div class="flex flex-col justify-between items-start gap-4 pl-8 py-20 sticky left-0 top-0 h-full">
            <div>
                <div class="bg-glass rounded-2xl flex gap-4 items-center p-4 min-w-[250px] max-w-[280px]">
                    <img class="border-2 w-[70px] h-[70px] rounded-2xl" src="./assets/person.jpeg" alt="">
                    <div class="flex items-center gap-2 font-semibold text-ellipsis overflow-hidden">
                        <p>Hi, </p>
                        <p><?= $nameToDisplay ?></p>
                    </div>
                </div>
                <div class="bg-glass rounded-2xl p-8 w-full mt-16">
                    <ul class="flex flex-col gap-8">
                        <li><button class="py-4 mx-auto flex items-center justify-center text-sm"><a href="index.php"><img src="./assets/Home Page.png" alt="home" class="inline-block h-4"> Home</a></button></li>
                        <li><button class="bg-gradient py-4 px-16 mx-auto flex items-center justify-center rounded-2xl border-2 text-sm"><a href="history.php"><img src="./assets/Time Machine.png" alt="about us" class="inline-block h-4"> History</a></button></li>
                        <li><button class="py-4 mx-auto flex items-center justify-center text-sm"><a href="about.php" class=""><img src="./assets/Information.png" alt="about us" class="inline-block h-4"> About Us</a></button></li>
                    </ul>
                </div>
            </div>
            <button class="bg-glass rounded-2xl p-4 mt-32 w-full mb-8"><a href="logout.php"><img src="./assets/Logout Rounded Left.png" alt="logout" class="inline-block h-8"> Log out</a></button>
        </div>

        <!-- Content -->
        <div class="flex justify-center w-3/4 flex-col items-center">
            <div class="w-full max-w-7xl h-90 overflow-y-auto mt-10 max-h-[80vh]">
                <div class="overflow-hidden rounded-lg shadow-lg">
                    <table class="min-w-full divide-y rounded-md">
                        <thead>
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
                            foreach ($data as $row) {
                                ?>
                                <tr class="hover:bg-[#C6FEFE] hover:text-black hover:font-bold rounded-2xl">
                                    <td class="py-10 px-4"><?php echo $no++; ?></td>
                                    <td class="py-10 px-4">
                                        <div>
                                            <?php
                                            $timestamp = $row['timestamp'];
                                            $unixTimestamp = strtotime($timestamp);
                                            $formattedTime = date('h:i A', $unixTimestamp);
                                            echo $formattedTime;
                                            ?>
                                        </div>
                                        <div class="text-xs">
                                            <?php
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
