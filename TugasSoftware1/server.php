<?php
require 'vendor/autoload.php';
$server = new soap_server();

$namespace = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$server->configureWSDL('tokodvd');
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'dvd',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'ID' => array('name' => 'ID', 'type' => 'xsd:string'),
        'author' => array('name' => 'author', 'type' => 'xsd:string'),
        'judul' => array('name' => 'judul', 'type' => 'xsd:string'),
        'jml_durasi' => array('name' => 'jml_durasi', 'type' => 'xsd:int'),
        'genre' => array('name' => 'genre', 'type' => 'xsd:string'),
    ));

function welcome_msg($nama) {
    return "Selamat Datang $nama!";
}

$server->register('welcome_msg',
    array('nama' => 'xsd:string'),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Welcoming Messages'
);

function get_info_promo($tipe_dvd, $hari) {
    if ($tipe_dvd == "film" and $hari == "rabu"){
        return "Ada diskon 20%";
    } 
    elseif ($tipe_dvd == "film" and $hari == "rabu"){
        return "Ada diskon 10%!";
    }
    else {
        return "Tidak ada diskon.";
    }
}

$server->register('get_info_promo',
    array(
        'tipe_dvd' => 'xsd:string',
        'hari' => 'xsd:string'
    ),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Mencari informasi promo'
);

function hitung_diskon($diskon, $harga_dvd){
    $harga_diskon = $harga_dvd-($harga_dvd*$diskon);
    return "Setelah diskon harga total menjadi Rp.$harga_diskon ";
}

$server->register('hitung_diskon',
    array(
        'diskon' => 'xsd:float',
        'harga_dvd' => 'xsd:int'
    ),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'hasil harga diskon dvd'
);

function best_seller($genre){
    if($genre == 'horror') {
        $m_bestseller = join(', ', array(
            "KKN desa penari.", "pengabdi setan.", "pengabdi setan 2."
        ));
        return "Film horror best seller minggu ini adalah <br>$m_bestseller";
    }
    elseif($genre == 'action'){
        $r_bestseller = $m_bestseller = join(', ', array(
            "Fast n Furious", "James Bond", "mission impossible"
        ));
        return "Film action best seller minggu ini adalah <br>$r_bestseller";
    }
    else {
        return "Genre ini tidak memiliki best seller.";
    }
}

$server->register('best_seller',
    array('genre' => 'xsd:string',),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Film best seller'
);

$server->service(file_get_contents("php://input"));
exit();