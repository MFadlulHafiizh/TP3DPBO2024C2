<!-- Saya Muhammad Muhammad Fadlul Hafiizh [2209889] mengerjakan soal tp3 dalam mata kuliah DPBO.
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan, Aamiin  -->

<?php
// include semua file yang dibutuhkan
include('config/db.php');
include('classes/DB.php');
include('classes/Template.php');
include('classes/Pesawat.php');

$pesawat = new Pesawat($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); //instansiasi class pesawat
$pesawat->open();//koneksikan ke database
$editedData = null;
$id = null;
$mode = "Tambah";
if (isset($_GET['id'])) {//bila ada parameter id pada url (mode edit)
    $mode = "Edit";
    $id = $_GET['id'];
    if($id > 0){
        $pesawat->getPesawatById($id); //ambil data pesawat berdasarkan id pada parameter url
        $editedData = $pesawat->getResult(); //fetch data
    }
}

//default input type file dengan atribut required
$input_file = '<div class="mb-3">
<label for="foto" class="form-label">Foto Pesawat</label>
<input type="file" required class="form-control" name="foto" id="foto">
</div>';
if($mode == "Edit"){ //bila mode edit elemen input file tidak lagi required
    $input_file = '<div class="mb-3">
    <label for="foto" class="form-label">Foto Pesawat</label>
    <input type="file" class="form-control" name="foto" id="foto">
    </div>';
}

//buat elemen form sesuai data pesawat
$mainForm = $input_file . '
    <div class="mb-3">
        <label for="nama_pesawat" class="form-label">Nama Pesawat</label>
        <input type="text" required class="form-control" name="nama_pesawat" id="nama_pesawat" value="'. @$editedData['nama_pesawat'] .'">
    </div>
    <div class="mb-3">
        <label for="kapasitas" class="form-label">Kapasitas</label>
        <input type="number" required class="form-control" name="kapasitas" id="kapasitas" placeholder="...Orang" value="'. @$editedData['kapasitas'] .'">
    </div>';

if(isset($_POST['btn_simpan'])){//bila da request dari btn_simpan
    if($mode == "Edit"){//cek mode nya apakah edit atau tambah data
        $pesawat->updatePesawat($id, $_POST, $_FILES);//lakukan update data
        //tampilkan alert dan redirect ke pesawat.php
        echo "<script>
                    alert('Data pesawat berhasil diperbaharui');
                    document.location.href = 'pesawat.php';
                </script>";
    }else{
        $pesawat->addPesawat($_POST, $_FILES);//lakukan tambah data
        //tampilkan alert dan redirect ke pesawat.php
        echo "<script>
                    alert('Berhasil menambahkan data pesawat!');
                    document.location.href = 'pesawat.php';
                </script>";
    }
}
//set navbar dengan elemen active di halaman pesawat
$nav = '<li class="nav-item">
<a class="nav-link" aria-current="page" href="index.php">Jadwal Penerbangan</a>
</li>
<li class="nav-item">
<a class="nav-link active" aria-current="page" href="pesawat.php">Daftar Pesawat</a>
</li>
<li class="nav-item">
<a class="nav-link" aria-current="page" href="pilot.php">Daftar Pilot</a>
</li>';
$pesawat->close();
//render tampilan dengan data
$home = new Template("templates/skinform.html");
$home->replace('MODE_FORM', $mode);
$home->replace('DATA_NAV', $nav);
$home->replace('MAIN_FORM', $mainForm);
$home->write();