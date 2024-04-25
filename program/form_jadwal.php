<!-- Saya Muhammad Muhammad Fadlul Hafiizh [2209889] mengerjakan soal tp3 dalam mata kuliah DPBO.
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan, Aamiin  -->

<?php
// include semua file yang dibutuhkan
include('config/db.php');
include('classes/DB.php');
include('classes/Template.php');
include('classes/Pilot.php');
include('classes/Pesawat.php');
include('classes/JadwalPenerbangan.php');

$jadwal = new JadwalPenerbangan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); //instansiasi class jadwalpenerbangan
$jadwal->open(); //koneksikan ke database
$editedData = null;
$id = null;
$mode = "Tambah";
$btn_delete = "";
if (isset($_GET['id'])) { //bila ada parameter id pada url (mode edit)
    $mode = "Edit";
    $btn_delete = '<button type="submit" name="btn_delete" class="btn btn-danger me-3">Hapus</button>';
    $id = $_GET['id'];
    if($id > 0){
        $jadwal->getJadwalById($id); //ambil data jadwal penerbangan berdasarkan id pada parameter url
        $editedData = $jadwal->getResult(); //fetch data
    }
}

//instansiasi class pilot dan pesawat lalu ambil semua datanya yang nanti akan digunakan pada dropdown form
$listPilot = new Pilot($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$listPesawat = new Pesawat($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$listPilot->open();
$listPesawat->open();
$listPilot->getPilot();
$listPesawat->getPesawat();

$optPilot = "";
$optPesawat = "";

//memasukan data pilot dan pesawat pada tag elemen option untuk disimpan didalam select
while ($row = $listPilot->getResult()){
    $selected = "";
    if($mode == "Edit"){ //bila mode edit maka set selected item sesuai data yang di edit
        $selected = $editedData['pilot_id'] == $row['id'] ? 'selected' : '';
    }
    $optPilot .= '<option '. $selected .' value="'. $row['id'] .'">'. $row['nama_pilot'] .'</option>';
}
while ($row = $listPesawat->getResult()){
    $selected = "";
    if($mode == "Edit"){//bila mode edit maka set selected item sesuai data yang di edit
        $selected = $editedData['pesawat_id'] == $row['id'] ? 'selected' : '';
    }
    $optPesawat .= '<option '. $selected .' value="'. $row['id'] .'">'. $row['nama_pesawat'] .'</option>';
}
//buat elemen form sesuai data jadwal penerbangan
$mainForm = '
    <div class="mb-3">
        <label for="tujuan" class="form-label">Tujuan</label>
        <input type="text" required class="form-control" name="tujuan" id="tujuan" placeholder="Masukan tujuan penerbangan" value="'. @$editedData['tujuan'] .'">
    </div>
    <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal Keberangkatan</label>
        <input type="date" required class="form-control" name="tanggal" id="tanggal" value="'. @$editedData['tanggal'] .'">
    </div>
    <div class="mb-3">
        <label for="tujuan" class="form-label">Pesawat</label>
        <select name="pesawat_id" required id="" class="form-select">
            '. $optPesawat .'
        </select>
    </div>
    <div class="mb-3">
        <label for="tujuan" class="form-label">Pilot</label>
        <select name="pilot_id" required id="" class="form-select">
        '. $optPilot .'
        </select>
    </div>
    <div class="mb-3">
        <label for="waktu" class="form-label">Waktu Keberangkatan</label>
        <input type="time" required class="form-control" name="waktu" id="waktu" value="'. @$editedData['waktu'] .'">
    </div>
    <div class="mb-3">
        <label for="harga" class="form-label">Harga Tiket</label>
        <input type="number" required class="form-control" name="harga" id="harga" placeholder="Rp." value="'. @$editedData['harga'] .'">
    </div>';

if(isset($_POST['btn_simpan'])){ //bila da request dari btn_simpan
    if($mode == "Edit"){//cek mode nya apakah edit atau tambah data
        $jadwal->updateJadwal($id, $_POST); //lakukan update data
        //tampilkan alert dan redirect ke index
        echo "<script>
                    alert('Data penerbangan berhasil diperbaharui');
                    document.location.href = 'index.php';
                </script>";
    }else{
        $jadwal->addJadwal($_POST); //lakukan tambah data
        //tampilkan alert dan redirect ke index
        echo "<script>
                    alert('Berhasil menambahkan data jadwal penerbangan!');
                    document.location.href = 'index.php';
                </script>";
    }
}

if(isset($_POST['btn_delete'])){ //bila ada request dari tombol delete
    $jadwal->deleteJadwal($id); //hapus jadwal penerbangan
    //tampilkan alert dan redirect ke index
    echo "<script>
                    alert('Data penerbangan berhasil dihapus!');
                    document.location.href = 'index.php';
                </script>";
}

//set navbar dengan elemen active di halaman jadwal penerbangan
$nav = '<li class="nav-item">
<a class="nav-link active" aria-current="page" href="index.php">Jadwal Penerbangan</a>
</li>
<li class="nav-item">
<a class="nav-link" aria-current="page" href="pesawat.php">Daftar Pesawat</a>
</li>
<li class="nav-item">
<a class="nav-link" aria-current="page" href="pilot.php">Daftar Pilot</a>
</li>';
$jadwal->close();
$listPilot->close();
$listPesawat->close();

//render tampilan dengan data
$home = new Template("templates/skinform.html");
$home->replace('MODE_FORM', $mode);
$home->replace('DATA_NAV', $nav);
$home->replace('MAIN_FORM', $mainForm);
$home->replace('DATA_BTN_HAPUS', $btn_delete);
$home->write();