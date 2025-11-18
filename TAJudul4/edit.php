<?php
session_start();
$uid = $_GET['uid']; // Menggunakan 'uid' bukan 'id' biar beda dikit
$db_file = 'data.json';
$contacts = json_decode(file_get_contents($db_file), true);

// Cari Index Data
$target_idx = -1;
$data_found = null;

foreach ($contacts as $key => $val) {
    if ($val['id'] == $uid) {
        $target_idx = $key;
        $data_found = $val;
        break;
    }
}

// Proses Update
if (isset($_POST['update_contact']) && $target_idx !== -1) {
    $contacts[$target_idx]['nama']  = $_POST['fullname'];
    $contacts[$target_idx]['email'] = $_POST['email_addr'];
    $contacts[$target_idx]['hp']    = $_POST['phone_num'];

    file_put_contents($db_file, json_encode($contacts, JSON_PRETTY_PRINT));
    
    $_SESSION['info'] = "Perubahan data berhasil disimpan.";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Ubah Data</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="navbar"><h1>App Buku Telepon</h1></div>

    <div class="main-wrapper" style="max-width: 500px;">
        <div class="section-header">
            <h2>Perbarui Data</h2>
        </div>

        <?php if($data_found): ?>
        <form method="post">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="fullname" class="input-control" value="<?= $data_found['nama']; ?>" required>
            </div>

            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email_addr" class="input-control" value="<?= $data_found['email']; ?>" required>
            </div>

            <div class="form-group">
                <label>Nomor Handphone</label>
                <input type="text" name="phone_num" class="input-control" value="<?= $data_found['hp']; ?>" required>
            </div>

            <br>
            <button type="submit" name="update_contact" class="btn btn-primary" style="width: 100%;">Simpan Perubahan</button>
            <div style="margin-top: 10px; text-align: center;">
                <a href="index.php" style="color: #777; text-decoration: none;">Batal</a>
            </div>
        </form>
        <?php else: ?>
            <p style="text-align:center; color:red;">Data tidak ditemukan.</p>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        <?php endif; ?>
    </div>
</body>
</html>