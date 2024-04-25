<!-- Saya Muhammad Muhammad Fadlul Hafiizh [2209889] mengerjakan soal tp3 dalam mata kuliah DPBO.
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan, Aamiin  -->
<?php
// include semua file yang dibutuhkan
include('config/db.php');
include('classes/DB.php');
include('classes/Template.php');
include('classes/JadwalPenerbangan.php');

$listPenerbangan = new JadwalPenerbangan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);//instansiasi class pilot
$listPenerbangan->open();//koneksikan ke database
$listPenerbangan->getJadwal();//ambil semua data jadwal penerbangan
$btn_reset_filter = ""; //button reset filter pada awalnya tidak ada namun akan dibuat bila ada request filter

//default elemen dropdown sorting by harga dan searching form
$filter_sort = '<option value="terendah">Harga Terendah</option>
<option value="tertinggi">Harga Tertinggi</option>';
$filter_search = '<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="cari" autocomplete="off">';
if(isset($_POST['btn-cari'])){ //bila ada request dengan name btn-cari (btn-cari diklik)
    $listPenerbangan->getJadwal($_POST['cari'], $_POST['sort_harga']); //ambil data jadwal berdasarkan request filter
    $btn_reset_filter = "<a href='index.php' class='btn btn-outline-danger'>Reset</a>"; //buat tombol reset filter
    //set selected item sesuai filter yang dipilih
    if($_POST['sort_harga'] == "terendah"){
        $filter_sort = '<option value="terendah" selected>Harga Terendah</option>
<option value="tertinggi">Harga Tertinggi</option>';
    }else{
        $filter_sort = '<option value="terendah">Harga Terendah</option>
        <option value="tertinggi" selected>Harga Tertinggi</option>';
    }
    //set value hasil search pada input form
    $filter_search = '<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="cari" autocomplete="off" value="'. $_POST['cari'] .'">';
}

$data = null;

while ($row = $listPenerbangan->getResult()) { //fetch data jadwal penerbangan dan parsing tiap row data
    $data .= '<div class="col-md-4 col-lg-3 py-2 px-2">
    <div class="card w-100">
        <a href="form_jadwal.php?id='. $row['id'] .'">
            <img src="'. $row['foto'] .'" class="card-img-top" style="height: 200px; object-fit:cover; object-position:center;" alt="...">
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td colspan="3" class="text-center">
                            <span class="badge text-bg-success mb-2">'. $row['tanggal'] .', '. $row['waktu'] .' WIB</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Tujuan</td>
                        <td>:</td>
                        <td>'. $row['tujuan'] .'</td>
                    </tr>
                    <tr>
                        <td>Kapasitas</td>
                        <td>:</td>
                        <td>'. $row['kapasitas'] .' Orang</td>
                    </tr>
                    <tr>
                        <td>Harga Tiket</td>
                        <td>:</td>
                        <td>Rp '. number_format($row['harga'],2,',','.') .'</td>
                    </tr>
                </table>
            </div>
        </a>
    </div>
</div>';
}
$listPenerbangan->close(); //close koneksi ke db

//render tampilan dengan data
$home = new Template("templates/skin.html");
$home->replace('DATA_PENERBANGAN', $data);
$home->replace('BTN_RESET_FILTER', $btn_reset_filter);
$home->replace('FILTER_SORT', $filter_sort);
$home->replace('FILTER_SEARCH', $filter_search);
$home->write();