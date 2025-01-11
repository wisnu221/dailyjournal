<?php
// Ambil ID user dari sesi
$user_id = $_SESSION['id'];

// Query untuk mengambil data user berdasarkan ID
$result = mysqli_query($conn, "SELECT foto FROM user WHERE id = '$user_id'");

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

// Simpan perubahan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $foto_nama = "";

    // Jika ada file foto yang diunggah
    if (!empty($_FILES["foto"]["name"])) {
        $foto_nama = basename($_FILES["foto"]["name"]);
        $target_file = "img/" . $foto_nama;

        // Pindahkan file ke folder img/
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Perbarui data foto di database
            $conn->query("UPDATE user SET foto = '$foto_nama' WHERE id = $user_id");
        } else {
            echo "Error uploading file.";
        }
    }

    // Jika password diisi, update password dengan enkripsi MD5
    if (!empty($password)) {
        $encrypted_password = md5($password); // Enkripsi menggunakan MD5
        $conn->query("UPDATE user SET password = '$encrypted_password' WHERE id = $user_id");
    }

    echo "Data berhasil diperbarui.";
}

// Ambil data user dari database
$result = $conn->query("SELECT foto FROM user WHERE id = $user_id");
$user = $result->fetch_assoc();
?>

<div class="container">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="password" class="form-label">Ganti Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Isi password baru jika ingin mengganti password saja">
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Ganti Foto Profil</label>
            <input type="file" id="foto" name="foto" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Profil Saat Ini</label><br>
            <?php if (!empty($user['foto'])): ?>
                <img src="img/<?= htmlspecialchars($user['foto']); ?>" alt="Foto Profil" class="img-thumbnail" width="150">
            <?php else: ?>
                <p>Belum ada foto profil.</p>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
