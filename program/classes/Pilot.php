<?php

class Pilot extends DB{
    function getPilot(){
        $query = "SELECT * FROM pilot";
        return $this->execute($query);
    }
    function getPilotById($id){
        $query = "SELECT * FROM pilot WHERE id=$id";
        return $this->execute($query);
    }
    function addPilot($data, $file){
        $foto = null;
        if (!empty($file['foto']['name'])) {
            if(move_uploaded_file($file['foto']['tmp_name'], 'assets/pilot/'.$file['foto']['name'])){
                $foto = "assets/pilot/".$file['foto']['name'];
            }
        }
        $nama = $data['nama_pilot'];
        $query = "INSERT INTO pilot VALUES('', '$nama', '$foto')";
        return $this->executeAffected($query);
    }
    function updatePilot($id, $data, $file){
        $foto = null;
        $addOnColumn = " ";
        if (!empty($file['foto']['name'])) {
            if(move_uploaded_file($file['foto']['tmp_name'], 'assets/pilot/'.$file['foto']['name'])){
                $foto = "assets/pilot/".$file['foto']['name'];
                $addOnColumn = " foto = '$foto',";
            }
        }
        $nama = $data['nama_pilot'];
        $query = "UPDATE pilot SET 
            $addOnColumn
            nama_pilot = '$nama'
            WHERE id = $id
        ";
        return $this->executeAffected($query);
    }

    function deletePilot($id){
        try{
            $query = "DELETE FROM pilot WHERE id=$id";
            return $this->executeAffected($query);
        }catch(Exception $e){
            return "error";
        }
    }
}