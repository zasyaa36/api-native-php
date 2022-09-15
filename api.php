<?php

require_once "koneksi.php";


//pemanggil function
if(function_exists($_GET['function'])){
    $_GET['function']();
}

//Get Data
function getUsers(){

    global $koneksi;
    $query = mysqli_query($koneksi, "SELECT * FROM users");
    while($data = mysqli_fetch_object($query)){
        $users[] = $data;
    }

    $respon = array(
        'status'    => 1,
        'message'   => 'Success get users',
        'users'     => $users
    );

    header('Content:Type: application/json');
    print json_encode($respon);

}

//Post Data - Tambah
function addUser(){

    global $koneksi;

    $parameter = array(
        'nama'      => '',
        'alamat'    => ''
    );

    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count($parameter)){

        $nama   = $_POST['nama'];
        $alamat = $_POST['alamat'];

        $result = mysqli_query($koneksi, "INSERT INTO users VALUES('', '$nama', '$alamat')");

        if($result){
            $respon = array(
                'status'    => 1,
                'message'   => 'Insert data succsess!'
            );
        }else{
            $respon = array(
                'status'    => 1,
                'message'   => 'Insert data failed!'
            );
        }

    }else{
        $respon = array(
            'status'    => 0,
            'message'   => 'Parameter Salah!'
        );
    }

    header('Content:Type: application/json');
    print json_encode($respon);

}

function message($status, $msg){

    $respon = array(
        'status'    => $status,
        'message'   => $msg
    );

    header('Content:Type: application/json');
    print json_encode($respon);
}

//Update Data User
function updateUser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $parameter = array(
        'nama'      => "",
        'alamat'    => ""
    );

    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count($parameter)){

        $nama   = $_POST['nama'];
        $alamat = $_POST['alamat'];

        $result = mysqli_query($koneksi, "UPDATE users SET nama='$nama', alamat='$alamat' WHERE id='$id'");

        if($result){
            return message(1, "Update data $nama success");
        }else{
            return message(0, "Update data failed");
        }

    }else{
        return message(0, "Parameter salah");
    }
}

//Delete Data User
function deleteUser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $result = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    if($result){
        return message(1, "Delete data success");
    }else{
        return message(0, "Delete data failed");
    }
}

//Detail User 
function detailUserId(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $result = $koneksi->query("SELECT * FROM users WHERE id='$id'");

    while($data = mysqli_fetch_object($result)){
        $detailUser[] = $data;
    }

    if($detailUser){
        $respon = array(
            'status'    =>1,
            'message'   => "Berhasil mendapatkan data detail user",
            'user'      => $detailUser
        );
    }else{
        return message(0, "Data tidak ditemukan");
    }

    
    header('Content:Type: application/json');
    print json_encode($respon);

}

?>