<?php
//rubah nama_database dengan sesuai database yang digunakan

$conn = mysqli_connect("localhost", "root", "", "coba");

function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
//menambah data ke database
function tambah($datas, $table)
{
    global $conn;
    $data = [];
    foreach ($datas as $item) {
        $data[] = htmlspecialchars($item);
    }
    //cek primary key
    $sql = "SHOW COLUMNS FROM $table";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $c = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $c[$i] = $row['Field'];
            $i++;
        }
    }

    $primary = $c[0];
    $ck = $data[0];
    $cek = mysqli_query($conn, "SELECT * FROM $table");
    foreach ($cek as $key) {
        if ($key[$primary] == $ck) {
            return false;
        }
    }
    $string = join("','", $data);
    $string1 = "'" . $string . "'";
    echo $string1;

    mysqli_query($conn, "INSERT INTO $table VALUES($string1)");
    return mysqli_affected_rows($conn);
}

function upload($foto)
{
    $namafile = $_FILES["$foto"]["name"];
    $ukuranfile = $_FILES["$foto"]["size"];
    $erorfile = $_FILES["$foto"]["error"];
    $tmpName = $_FILES["$foto"]["tmp_name"];

    if ($erorfile === 4) {
        echo "<script>alert('silahkan upload gambar');</script>";
        return false;
    }

    //cek upload
    $format = ['jpg', 'jpeg', 'png'];
    $ekstensi = explode('.', $namafile);
    $ekstensi = strtolower(end($ekstensi));

    if (!in_array($ekstensi, $format)) {
        echo "<script>alert('yang anda upload bukan gambar');</script>";
        return false;
    }

    //cek ukuran
    if ($ukuranfile > 1000000) {
        echo "<script>alert('ukuran gambar terlalu besar');</script>";
        return false;
    }
    //acaknama
    $random = uniqid();
    $random .= '.';
    $random .= $ekstensi;
    //penguploadan gambar
    move_uploaded_file($tmpName, 'image/' . $random);
    return $random;
}


//hapus data
function hapus($id, $table)
{
    global $conn;
    //cek primary key
    $sql = "SHOW COLUMNS FROM $table";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $c = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $c[$i] = $row['Field'];
            $i++;
        }
    }

    $primary = $c[0];
    mysqli_query($conn, "DELETE FROM $table WHERE $primary=$id");
    return mysqli_affected_rows($conn);
}

//ubah data
function ubah($datas, $table)
{
    global $conn;
    $data = [];
    foreach ($datas as $item) {
        $data[] = htmlspecialchars($item);
    }
    $sql = "SHOW COLUMNS FROM $table";
    $result = $conn->query($sql);
    $c = [];
    $i = 0;
    $ck = $data[0];
    while ($row = $result->fetch_assoc()) {
        $c[$i] = $row['Field'];
        $primary = $c[0];
        mysqli_query($conn, "UPDATE peserta SET
            $c[$i]= $data[$i]
        WHERE $primary = $ck
        ");
        $i++;
    }


    return mysqli_affected_rows($conn);
}

//cari data
function cari($data, $table)
{
    global $conn;
    $c = [];
    $i = 0;
    $sql = "SHOW COLUMNS FROM $table";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $c[$i] = $row['Field'];
        $query = "SELECT * FROM $table WHERE 
        $c[$i] LIKE '%$data%'
        ";
        $i++;
    }
    return query($query);
}
