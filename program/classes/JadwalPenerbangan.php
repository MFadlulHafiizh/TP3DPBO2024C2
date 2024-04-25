<?php

class JadwalPenerbangan extends DB{
    function getJadwal($keyword=null, $sort=null){
        $order = $sort == "tertinggi" ? 'DESC' : 'ASC';
        $query = "SELECT jadwal_penerbangan.*, pesawat.kapasitas, pesawat.foto FROM jadwal_penerbangan JOIN pesawat ON jadwal_penerbangan.pesawat_id = pesawat.id";
        if($keyword != ""){
            $query .= " WHERE jadwal_penerbangan.tujuan like '%$keyword%'";
        }
        $query .= " ORDER BY harga $order";
        return $this->execute($query);
    }
    function getJadwalById($id){
        $query = "SELECT jadwal_penerbangan.*, pesawat.kapasitas, pesawat.nama_pesawat, pesawat.foto, pilot.nama_pilot, pilot.foto FROM jadwal_penerbangan 
        JOIN pesawat ON jadwal_penerbangan.pesawat_id = pesawat.id 
        JOIN pilot ON jadwal_penerbangan.pilot_id = pilot.id 
        WHERE jadwal_penerbangan.id=$id";
        return $this->execute($query);
    }
    function search($keyword, $sort=null){
        $order = $sort == "tertinggi" ? 'DESC' : 'ASC';
        $query = "SELECT jadwal_penerbangan.*, pesawat.kapasitas, pesawat.foto FROM jadwal_penerbangan JOIN pesawat ON jadwal_penerbangan.pesawat_id = pesawat.id
            WHERE jadwal_penerbangan.tujuan like '%$keyword%' ORDER BY harga $order
        ";
    }
    function addJadwal($data){
        $tujuan = $data['tujuan'];
        $tanggal = $data['tanggal'];
        $waktu = $data['waktu'];
        $pesawat_id = $data['pesawat_id'];
        $pilot_id = $data['pilot_id'];
        $harga = $data['harga'];
        $query = "INSERT INTO jadwal_penerbangan VALUES('', '$tujuan', $harga, '$tanggal', '$waktu', $pilot_id, $pesawat_id)";

        $this->executeAffected($query);
    }
    function updateJadwal($id, $data){
        $tujuan = $data['tujuan'];
        $tanggal = $data['tanggal'];
        $waktu = $data['waktu'];
        $pesawat_id = $data['pesawat_id'];
        $pilot_id = $data['pilot_id'];
        $harga = $data['harga'];

        $query = "UPDATE jadwal_penerbangan SET 
        tujuan = '$tujuan', 
        harga = $harga, 
        tanggal = '$tanggal', 
        waktu = '$waktu', 
        pilot_id = $pilot_id,
        pesawat_id = $pesawat_id
        WHERE id=$id";

        $this->executeAffected($query);
    }
    function deleteJadwal($id){
        $query = "DELETE FROM jadwal_penerbangan WHERE id = $id";
        $this->executeAffected($query);
    }
}