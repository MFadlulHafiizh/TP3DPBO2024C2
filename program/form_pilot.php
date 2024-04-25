<!-- Saya Muhammad Muhammad Fadlul Hafiizh [2209889] mengerjakan soal tp3 dalam mata kuliah DPBO.
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan, Aamiin  -->

<?php
// include semua file yang dibutuhkan
include('config/db.php');
include('classes/DB.php');
include('classes/Template.php');
include('classes/Pilot.php');

$pilot = new Pilot($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);//instansiasi class pilot
$pilot->open();//koneksikan ke database
$editedData = null;
$id = null;
$mode = "Tambah";
if (isset($_GET['id'])) {//bila ada parameter id pada url (mode edit)
    $mode = "Edit";
    $id = $_GET['id'];
    if($id > 0){
        $pilot->getPilotById($id);//ambil data pesawat berdasarkan id pada parameter url
        $editedData = $pilot->getResult();//fetch data
    }
}
//default input type file dengan atribut required
$input_file = '<div class="mb-3">
<label for="foto" class="form-label">Foto Pilot</label>
<input type="file" required class="form-control" name="foto" id="foto">
</div>';
if($mode == "Edit"){//bila mode edit elemen input file tidak lagi required
    $input_file = '<div class="mb-3">
    <label for="foto" class="form-label">Foto Pilot</label>
    <input type="file" class="form-control" name="foto" id="foto">
    </div>';
}
//buat elemen form sesuai data pilot
$mainForm = $input_file . '
    <div class="mb-3">
        <label for="nama_pilot" class="form-label">Nama Pilot</label>
        <input type="text" required class="form-control" name="nama_pilot" id="nama_pilot" value="'. @$editedData['nama_pilot'] .'">
    </div>';

if(isset($_POST['btn_simpan'])){//bila da request dari btn_simpan
    if($mode == "Edit"){//cek mode nya apakah edit atau tambah data
        $pilot->updatePilot($id, $_POST, $_FILES);//lakukan update data
        //tampilkan alert dan redirect ke pilot.php
        echo "<script>
                    alert('Data pilot berhasil diperbaharui');
                    document.location.href = 'pilot.php';
                </script>";
    }else{
        $pilot->addPilot($_POST, $_FILES);//lakukan tambah data
        //tampilkan alert dan redirect ke pilot.php
        echo "<script>
                    alert('Berhasil menambahkan data pilot!');
                    document.location.href = 'pilot.php';
                </script>";
    }
}
//set navbar dengan elemen active di halaman pilot
$nav = '<li class="nav-item">
<a class="nav-link" aria-current="page" href="index.php">Jadwal Penerbangan</a>
</li>
<li class="nav-item">
<a class="nav-link" aria-current="page" href="pesawat.php">Daftar Pesawat</a>
</li>
<li class="nav-item">
<a class="nav-link active" aria-current="page" href="pilot.php">Daftar Pilot</a>
</li>';
//render tampilan dengan data
$home = new Template("templates/skinform.html");
$home->replace('MODE_FORM', $mode);
$home->replace('DATA_NAV', $nav);
$home->replace('MAIN_FORM', $mainForm);
$home->write();