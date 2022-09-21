<?php
require 'vendor/autoload.php';

$namespace = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$namespace = str_replace('client.php','server.php', $namespace);
$client = new nusoap_client($namespace);

$response = $client->call('welcome_msg', array(
    'nama' => 'Givery'
));
echo $response;

echo '<br>';

$response = $client->call('get_info_promo', array(
    'tipe_dvd' => 'film',
    'hari' => 'rabu'
));
echo $response;

echo '<br>';

$response = $client->call('hitung_diskon', array(
    'diskon' => 0.1,
    'harga_dvd' => 50000
));
echo $response;

echo '<br>';

$response = $client->call('best_seller', array(
    'genre' => "horror"
));
echo $response;