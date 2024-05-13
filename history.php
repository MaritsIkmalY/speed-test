<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php
        include 'connect.php';

        if(!isset($_SESSION['id'])) {
            header('Location: login.php');
        }

        $data = mysqli_query($connect, 'SELECT * FROM speedtest_users WHERE user_id = "'.$_SESSION['id'].'"');
    ?>

    <table>
        <thead>
            <tr>
            <th>No</th>
            <th>download</th>
            <th>upload</th>
            <th>ping</th>
            <th>jitter</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while($row = mysqli_fetch_assoc($data)) {
            ?>
            <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['dl']; ?></td>
            <td><?php echo $row['ul']; ?></td>
            <td><?php echo $row['ping']; ?></td>
            <td><?php echo $row['jitter']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>