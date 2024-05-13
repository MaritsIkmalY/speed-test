<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Speed Test</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <?php
  include "connect.php";

  if (isset($_POST['submit'])) {
    $email    = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);
    $name     = strip_tags($_POST['name']);
    $timestamp = date('Y-m-d H:i:s');
    $messages = [];

    if (empty($email) || empty($password) || empty($name)) {
      $messages[] = 'Silahkan isi data yang diperlukan!';
    } else {
      $insert = mysqli_query($connect, 'INSERT INTO `users`(`email`, `name`, `password`, `timestamp`) VALUES("' . $email . '","' . $name . '", "' . password_hash($password, PASSWORD_BCRYPT) . '" , "' . $timestamp . '")');
      if ($insert) {
        header('location: index.php');
        exit;
      } else {
        $messages[] = 'Pendaftaran gagal!';
      }
    }
  }
  ?>
  <div class="container">
    <div class="row" style="margin: 100px auto;width: 400px;">
      <div class="col-md-12" style="margin-bottom: 6px;">
        <?php
        if (!empty($messages)) {
          foreach ($messages as $message) {
            echo '<b>Warning:</b> <span style="color:red;">' . $message . '</span>';
          }
        }
        ?>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header bg-success text-white">
            <div class="text-center">
              <b>Pendaftaran Akun</b>
            </div>
          </div>
          <div class="card-body">
            <form method="POST">
              <div class="mb-3">
                <label class="form-label">
                  Email
                </label>
                <input type="email" name="email" value="" class="form-control" placeholder="Silahkan masukkan email..." required>
              </div>
              <div class="mb-3">
                <label class="form-label">
                  Nama
                </label>
                <input type="text" name="name" value="" class="form-control" placeholder="Silahkan masukkan nama" required>
              </div>
              <div class="mb-3">
                <label class="form-label">
                  Kata Sandi
                </label>
                <input type="password" name="password" value="" class="form-control" placeholder="Silahkan masukkan kata sandi..." required>
              </div>
              <div class="mb-12">
                <button type="submit" name="submit" class="btn btn-success" style="width: 100%;">
                  Daftar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>