<!-- Saya Muhammad Muhammad Fadlul Hafiizh [2209889] mengerjakan soal tp3 dalam mata kuliah DPBO.
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan, Aamiin  -->
<?php
// include semua file yang dibutuhkan
include('config/db.php');
include('classes/DB.php');
include('classes/Template.php');
include('classes/Pilot.php');

$pilot = new Pilot($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$pilot->open();//koneksikan ke database
$pilot->getPilot();//ambil semua data pilot
$btn_add = '<a href="form_pilot.php" class="btn btn-success ms-auto">Tambah Pilot</a>';

//set navbar dengan elemen active di halaman pilot
$nav = '<li class="nav-item">
<a class="nav-link" aria-current="page" href="index.php">Jadwal Penerbangan</a>
</li>
<li class="nav-item">
<a class="nav-link" aria-current="page" href="pesawat.php">Daftar Pesawat</a>
</li>
<li class="nav-item">
<a class="nav-link active" aria-current="page" href="#">Daftar Pilot</a>
</li>';
//buat header table
$tbl_header = '
    <tr>
        <th>No</th>
        <th>Foto</th>
        <th>Nama Pilot</th>
        <th>Aksi</th>
    </tr>
';
$tbl_data = '';
$no = 1;
while ($div = $pilot->getResult()) { //fetch semua data pilot menjadi array lalu loop dan parsing ke html
    $tbl_data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td><img class="img-thumbnail" style="width:100px;" src="'. $div['foto'] .'"></td>
    <td>' . $div['nama_pilot'] . '</td>
    <td style="font-size: 22px;">
        <a href="form_pilot.php?id=' . $div['id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>
        
        <a href="pilot.php?hapus=' . $div['id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
    </td>
    </tr>';
    $no++;
}

//bila ada request untuk menghapus data
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    if($id > 0){//id yang ingin dihapus tidak lebih kecil dari 0
        $resp = $pilot->deletePilot($id); //hapus data pilot berdasarkan id yang ada pada paramter
        if($resp != "error"){
            echo "<script>
                        alert('Data pilot berhasil dihapus');
                        document.location.href = 'pilot.php';
                    </script>";
        }else{//bila error tampilkan alert bahwa data pilot digunakan pada jadwal penerbangan
            echo "<script>
            alert('Data pilot digunakan pada jadwal penerbangan, tidak dapat dihapus!');
            </script>";
        }
    }
}

//render tampilan dengan data
$home = new Template("templates/skintable.html");
$home->replace('DATA_NAV', $nav);
$home->replace('DATA_TITLE', "Pilot");
$home->replace('DATA_BTN_ADD', $btn_add);
$home->replace('DATA_HEADER_TABLE', $tbl_header);
$home->replace('DATA_TABLE', $tbl_data);
$home->write();
