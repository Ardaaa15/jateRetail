<?php
@ob_start();
session_start();
require 'config.php';

if (isset($_POST['daftar'])) {
    $nama = strip_tags($_POST['nama']);
    $user = strip_tags($_POST['user']);
    $pass = strip_tags($_POST['pass']);

    // Cek apakah username sudah dipakai
    $cek = $config->prepare("SELECT * FROM login WHERE user = ?");
    $cek->execute([$user]);
    if ($cek->rowCount() > 0) {
        echo '<script>alert("Username sudah digunakan.");history.go(-1);</script>';
        exit;
    }

    // Insert ke tabel member
    $sql_member = "INSERT INTO member (nm_member, alamat_member, telepon, email, gambar, nik) VALUES (?, '', '', '', '', '')";
    $stmt_member = $config->prepare($sql_member);
    $stmt_member->execute([$nama]);
    $id_member = $config->lastInsertId();

    // Insert ke tabel login
    $sql_login = "INSERT INTO login (user, pass, id_member) VALUES (?, md5(?), ?)";
    $stmt_login = $config->prepare($sql_login);
    $stmt_login->execute([$user, $pass, $id_member]);

    echo '<script>alert("Registrasi Berhasil, silakan login.");window.location="login.php";</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Jate Retail</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h4 class="h4 text-gray-900 mb-4"><b>Register Jate Retail</b></h4>
                        </div>
                        <form method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="nama" placeholder="Full Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="user" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" name="pass" placeholder="Password" required>
                            </div>
                            <button class="btn btn-primary btn-block" name="daftar" type="submit">
                                <i class="fa fa-user-plus"></i> DAFTAR
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <small>Sudah punya akun? <a href="login.php">Login di sini</a></small>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="sb-admin/vendor/jquery/jquery.min.js"></script>
<script src="sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="sb-admin/js/sb-admin-2.min.js"></script>
</body>
</html>
