<?php

function find_item($array, $id)
{
    foreach ($array as $element) {
        if ($id == $element->id) {
            return true;
        }
    }
    return false;
}
function generate_token()
{
    $token = openssl_random_pseudo_bytes(16);
    //Convert the binary data into hexadecimal representation.
    $convert = bin2hex($token);
    return $convert;
}

function array_push_assoc($array, $key, $value)
{
    $array[$key] = $value;
    return $array;
}

function random_string($length = 7)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@*#';
    $sandi = '';
    $characterListLength = mb_strlen($characters, '8bit') - 1;
    foreach (range(1, $length) as $i) {
        $sandi .= $characters[random_int(0, $characterListLength)];
    }
    $n = count(array_unique(str_split($sandi)));
    if ($n != $length) {
        while ($n < $length) {
            random_string();
        }
    }
    return $sandi;
}

function enkrip($data)
{
    return base64_encode($data . '*pendataanJemaat');
}

function dekrip($data)
{
    $dekrip = base64_decode($data);
    $pecah = explode('*', $dekrip);
    return $pecah[0];
}

function rupiah($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

// $items = array(['id' => '1', 'day_id' => 3], ['id' => '2', 'day_id' => 5]);
function filterData($items, $prop, $value, $operator = null)
{

    $result = array_filter($items, function ($item) use ($prop, $value, $operator) {
        $item = (array)$item;
        if (gettype($value) == 'array') {
            if ($operator == 'or') {
                if ($item[$prop] == $value[0] || $item[$prop] == $value[1]) {
                    return true;
                }
            } else {
                if ($item[$prop] == $value[0] && $item[$prop] == $value[1]) {
                    return true;
                }
            }
        }
    });
    return array_values($result);
}
