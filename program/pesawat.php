<!-- Saya Muhammad Muhammad Fadlul Hafiizh [2209889] mengerjakan soal tp3 dalam mata kuliah DPBO.
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan, Aamiin  -->
<?php
// include semua file yang dibutuhkan
include('config/db.php');
include('classes/DB.php');
include('classes/Template.php');
include('classes/Pesawat.php');

$pesawat = new Pesawat($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$pesawat->open();//koneksikan ke database
$pesawat->getPesawat();//ambil semua data pesawat
$btn_add = '<a href="form_pesawat.php" class="btn btn-success ms-auto">Tambah Pesawat</a>'; //tombol untuk spesifik mengarah ke form tambah pesawat

//set navbar dengan elemen active di halaman pesawat
$nav = '<li class="nav-item">
<a class="nav-link" aria-current="page" href="index.php">Jadwal Penerbangan</a>
</li>
<li class="nav-item">
<a class="nav-link active" aria-current="page" href="#">Daftar Pesawat</a>
</li>
<li class="nav-item">
<a class="nav-link" aria-current="page" href="pilot.php">Daftar Pilot</a>
</li>';
//buat header table
$tbl_header = '
    <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Nama Pesawat</th>
        <th>Kapasitas</th>
        <th>Aksi</th>
    </tr>
';

$tbl_data = '';
$no = 1;
while ($div = $pesawat->getResult()) { //fetch semua data pesawat menjadi array lalu loop dan parsing ke html
    $tbl_data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td><img class="img-thumbnail" style="width:100px;" src="'. $div['foto'] .'"></td>
    <td>' . $div['nama_pesawat'] . '</td>
    <td>' . $div['kapasitas'] . '</td>
    <td style="font-size: 22px;">
        <a href="form_pesawat.php?id=' . $div['id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>
        
        <a href="pesawat.php?hapus=' . $div['id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
    </td>
    </tr>';
    $no++;
}

//bila ada request untuk menghapus data
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    if($id > 0){ //id yang ingin dihapus tidak lebih kecil dari 0
        $resp = $pesawat->deletePesawat($id); //hapus data pesawat berdasarkan id yang ada pada paramter
        if($resp != "error"){ //bila return nya tidak error tampilkan alert dan redirect
            echo "<script>
                        alert('Data pesawat berhasil dihapus');
                        document.location.href = 'pesawat.php';
                    </script>";
        }else{//bila error tampilkan alert bahwa data pesawat digunakan pada jadwal penerbangan
            echo "<script>
            alert('Data pesawat digunakan pada jadwal penerbangan, tidak dapat dihapus!');
            </script>";
        }
    }
}
//render tampilan dengan data
$home = new Template("templates/skintable.html");
$home->replace('DATA_NAV', $nav);
$home->replace('DATA_TITLE', "Pesawat");
$home->replace('DATA_BTN_ADD', $btn_add);
$home->replace('DATA_HEADER_TABLE', $tbl_header);
$home->replace('DATA_TABLE', $tbl_data);
$home->write();