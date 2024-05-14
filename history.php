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
            background: linear-gradient(to right, #cce4f7, #ffffff);
            color: #000;
        }

        .custom-row {
            background-color: #00474b;
            color: #ffffff;
        }

        .custom-row:nth-child(odd) {
            background-color: #00383a;
        }

        .custom-row:hover {
            background-color: #002f2e;
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
    <div class="bg-gradient h-screen text-white flex gap-4 p-12">

        <div class="flex flex-col gap-4">

            <div class="bg-glass rounded-2xl flex gap-4 items-center p-6">

                <img class="border-2 w-[70px] h-[70px]  rounded-2xl" src="./assets/person.jpeg" alt="">

                <div class="font-semibold">
                    <p>Hi, </p>
                    <p><?php echo $_SESSION['name'] ?></p>
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

        <div class="w-full max-w-4xl h-90 overflow-y-auto">
            <div class="overflow-hidden rounded-lg shadow-lg">
                <table class="min-w-full divide-y divide-gray-200">
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
                    <tbody class="text-center">
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($data)) {
                        ?>
                            <tr class="custom-row">
                                <td class="py-2 px-4"><?php echo $no++ ?></td>
                                <td class="py-2 px-4">
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
                                <td class="py-2 px-4"><?php echo $row['ping']; ?></td>
                                <td class="py-2 px-4"><?php echo $row['jitter']; ?></td>
                                <td class="py-2 px-4"><?php echo  $row['ul']; ?></td>
                                <td class="py-2 px-4"><?php echo $row['dl']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>