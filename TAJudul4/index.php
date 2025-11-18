<?php
session_start();
$db_file = 'data.json';

// Cek file database
if (!file_exists($db_file)) file_put_contents($db_file, '[]');
$contacts = json_decode(file_get_contents($db_file), true);

// Proses Hapus
if (isset($_GET['act']) && $_GET['act'] == 'delete') {
    $id_target = $_GET['id'];
    // Filter data (menghapus berdasarkan ID)
    $new_data = array_filter($contacts, function($c) use ($id_target) {
        return $c['id'] != $id_target;
    });
    
    file_put_contents($db_file, json_encode(array_values($new_data), JSON_PRETTY_PRINT));
    $_SESSION['info'] = "Data berhasil dihapus dari buku telepon.";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Telepon Digital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="navbar">
        <h1>App Buku Telepon</h1>
    </div>

    <div class="main-wrapper">
        <?php if (isset($_SESSION['info'])): ?>
            <div class="flash-msg">
                <?= $_SESSION['info']; ?>
            </div>
            <?php unset($_SESSION['info']); ?>
        <?php endif; ?>

        <div class="section-header">
            <h2>Daftar Kontak</h2>
            <a href="tambah.php" class="btn btn-primary">Input Baru</a>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th width="20%">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contacts)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px;">
                            <i>Belum ada data kontak tersimpan.</i>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contacts as $idx => $row): ?>
                    <tr>
                        <td><?= $idx + 1; ?>.</td>
                        <td><strong><?= htmlspecialchars($row['nama']); ?></strong></td>
                        <td style="color: #666;"><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['hp']); ?></td>
                        <td>
                            <a href="edit.php?uid=<?= $row['id']; ?>" class="btn btn-warning">Ubah</a>
                            <a href="index.php?act=delete&id=<?= $row['id']; ?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>