<?php
session_start();

if (isset($_POST['save_contact'])) {
    $db_file = 'data.json';
    if (!file_exists($db_file)) file_put_contents($db_file, '[]');
    
    $current_data = json_decode(file_get_contents($db_file), true);

    $input = [
        'id'    => time(), // ID unik dari timestamp
        'nama'  => $_POST['fullname'],
        'email' => $_POST['email_addr'],
        'hp'    => $_POST['phone_num']
    ];

    $current_data[] = $input;
    file_put_contents($db_file, json_encode($current_data, JSON_PRETTY_PRINT));

    $_SESSION['info'] = "Kontak baru sukses disimpan!";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Entri Kontak</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="navbar"><h1>App Buku Telepon</h1></div>

    <div class="main-wrapper" style="max-width: 500px;">
        <div class="section-header">
            <h2>Entri Data Baru</h2>
        </div>

        <form method="post">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="fullname" class="input-control" placeholder="Contoh: Daffa Ramadhan" required>
            </div>

            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email_addr" class="input-control" placeholder="nama@email.com" required>
            </div>

            <div class="form-group">
                <label>Nomor Handphone</label>
                <input type="text" name="phone_num" class="input-control" placeholder="08xxxxxxxx" required>
            </div>

            <br>
            <button type="submit" name="save_contact" class="btn btn-primary" style="width: 100%;">Simpan Kontak</button>
            <div style="margin-top: 10px; text-align: center;">
                <a href="index.php" style="color: #777; text-decoration: none;">Batal & Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>