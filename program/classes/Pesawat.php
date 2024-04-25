<?php

class Pesawat extends DB{
    function getPesawat(){
        $query = "SELECT * FROM pesawat";
        return $this->execute($query);
    }
    function getPesawatById($id){
        $query = "SELECT * FROM pesawat WHERE id=$id";
        return $this->execute($query);
    }
    function addPesawat($data, $file){
        $foto = null;
        if (!empty($file['foto']['name'])) {
            if(move_uploaded_file($file['foto']['tmp_name'], 'assets/pesawat/'.$file['foto']['name'])){
                $foto = "assets/pesawat/".$file['foto']['name'];
            }
        }
        $nama = $data['nama_pesawat'];
        $kapasitas = $data['kapasitas'];
        $query = "INSERT INTO pesawat VALUES('', '$nama', $kapasitas, '$foto')";
        return $this->executeAffected($query);
    }
    function updatePesawat($id, $data, $file){
        $foto = null;
        $addOnColumn = " ";
        if (!empty($file['foto']['name'])) {
            if(move_uploaded_file($file['foto']['tmp_name'], 'assets/pesawat/'.$file['foto']['name'])){
                $foto = "assets/pesawat/".$file['foto']['name'];
                $addOnColumn = " foto = '$foto',";
            }
        }
        $nama = $data['nama_pesawat'];
        $kapasitas = $data['kapasitas'];
        $query = "UPDATE pesawat SET 
            $addOnColumn
            nama_pesawat = '$nama',
            kapasitas = $kapasitas
            WHERE id = $id
        ";
        return $this->executeAffected($query);
    }
    function deletePesawat($id){
        try{
            $query = "DELETE FROM pesawat WHERE id=$id";
            return $this->executeAffected($query);
        }catch(Exception $e){
            return "error";
        }
    }
}