<?php
// Tentukan jumlah data per halaman
$dataPerHalaman = 3;

// Ambil halaman saat ini dari URL, jika tidak ada maka default ke halaman 1
$halamanSaatIni = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$awalData = ($halamanSaatIni - 1) * $dataPerHalaman;

// Query untuk mendapatkan jumlah total data
$sqlTotal = "SELECT COUNT(*) AS total FROM gallery";
$hasilTotal = $conn->query($sqlTotal);
$totalData = $hasilTotal->fetch_assoc()['total'];
$totalHalaman = ceil($totalData / $dataPerHalaman);

// Function to build pagination URL
function buildPaginationUrl($page) {
    $queryParams = $_GET;
    $queryParams['halaman'] = $page;
    return '?' . http_build_query($queryParams);
}

// Query untuk mendapatkan data sesuai pagination
$sql = "SELECT * FROM gallery ORDER BY tanggal DESC LIMIT $awalData, $dataPerHalaman";
$hasil = $conn->query($sql);

$no = $awalData + 1;
while ($row = $hasil->fetch_assoc()) {
    // Konten tabel seperti pada kode Anda sebelumnya
}
?>

<div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Gallery
    </button>
    <!-- Awal Modal Tambah-->
    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Gallery</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Tambah-->
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="">Tanggal</th>
                        <th class="">Gambar</th>
                        <th class="w-25">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM gallery ORDER BY tanggal DESC LIMIT $awalData, $dataPerHalaman";
                    $hasil = $conn->query($sql);

                    $no = $awalData + 1;
                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <br>pada : <?= $row["tanggal"] ?>
                                <br>oleh : <?= $row["username"] ?>
                            </td>
                            <td>
                                <?php if ($row["gambar"] != '' && file_exists('img/' . $row["gambar"])): ?>
                                    <img src="img/<?= $row["gambar"] ?>" width="100" 
                                        class="img-thumbnail" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalGambarBesar" 
                                        onclick="tampilkanGambarBesar('img/<?= $row["gambar"] ?>')">
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                                <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>

                                <!-- Awal Modal Edit -->
                                <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Gallery</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="formGroupExampleInput2" class="form-label">Ganti Gambar</label>
                                                        <input type="file" class="form-control" name="gambar">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                                        <?php
                                                        if ($row["gambar"] != '') {
                                                            if (file_exists('img/' . $row["gambar"] . '')) {
                                                        ?>
                                                                <br><img src="img/<?= $row["gambar"] ?>" width="100">
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir Modal Edit -->

                                <!-- Awal Modal Hapus -->
                                <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Gallery</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus artikel "<strong><?= $row["judul"] ?></strong>"?</label>
                                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                        <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                                                    <input type="submit" value="hapus" name="hapus" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir Modal Hapus -->

                            </td>   
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <!-- Bootstrap pagination -->
            <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <!-- First Page -->
                <li class="page-item <?php echo $halamanSaatIni == 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo buildPaginationUrl(1); ?>">First</a>
                </li>
                
                <!-- Previous Page -->
                <li class="page-item <?php echo $halamanSaatIni == 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo buildPaginationUrl($halamanSaatIni - 1); ?>">«</a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $totalHalaman; $i++): ?>
                <li class="page-item <?php echo $i == $halamanSaatIni ? 'active' : ''; ?>">
                    <a class="page-link" href="<?php echo buildPaginationUrl($i); ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>

                <!-- Next Page -->
                <li class="page-item <?php echo $halamanSaatIni == $totalHalaman ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo buildPaginationUrl($halamanSaatIni + 1); ?>">»</a>
                </li>
                
                <!-- Last Page -->
                <li class="page-item <?php echo $halamanSaatIni == $totalHalaman ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo buildPaginationUrl($totalHalaman); ?>">Last</a>
                </li>
            </ul>
            </nav>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan gambar besar -->
<div class="modal fade" id="modalGambarBesar" tabindex="-1" aria-labelledby="modalGambarBesarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGambarBesarLabel">Gambar Besar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="gambarBesar" src="" class="img-fluid" alt="Gambar besar">
            </div>
        </div>
    </div>
</div>


<?php
include "upload_foto.php";

//jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    //jika ada file yang dikirim  
    if ($nama_gambar != '') {
		    //panggil function upload_foto untuk cek spesifikasi file yg dikirimkan user
		    //function ini memiliki 2 keluaran yaitu status dan message
        $cek_upload = upload_foto($_FILES["gambar"]);

				//cek status true/false
        if ($cek_upload['status']) {
		        //jika true maka message berisi nama file gambar
            $gambar = $cek_upload['message'];
        } else {
		        //jika true maka message berisi pesan error, tampilkan dalam alert
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=gallery';
            </script>";
            die;
        }
    }

		//cek apakah ada id yang dikirimkan dari form
    if (isset($_POST['id'])) {
        //jika ada id,    lakukan update data dengan id tersebut
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            //jika tidak ganti gambar
            $gambar = $_POST['gambar_lama'];
        } else {
            //jika ganti gambar, hapus gambar lama
            unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $conn->prepare("UPDATE gallery 
                                SET 
                                gambar = ?,
                                tanggal = ?,
                                username = ?
                                WHERE id = ?");

        $stmt->bind_param("sssi", $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
		    //jika tidak ada id, lakukan insert data baru
        $stmt = $conn->prepare("INSERT INTO gallery (gambar,tanggal,username)
                                VALUES (?,?,?)");

        $stmt->bind_param("sss", $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}

//jika tombol hapus diklik
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        //hapus file gambar
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id =?");

    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<script>
    function tampilkanGambarBesar(gambar) {
        document.getElementById("gambarBesar").src = gambar;
    }
</script>