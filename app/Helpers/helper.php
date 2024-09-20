<?php

function nama_bulan($bulan)
{
    if ($bulan == '1') {
        $hasil = 'Januari';
    }
    if ($bulan == '2') {
        $hasil = 'Februari';
    }
    if ($bulan == '3') {
        $hasil = 'Maret';
    }
    if ($bulan == '4') {
        $hasil = 'April';
    }
    if ($bulan == '5') {
        $hasil = 'Mei';
    }
    if ($bulan == '6') {
        $hasil = 'Juni';
    }
    if ($bulan == '7') {
        $hasil = 'Juli';
    }
    if ($bulan == '8') {
        $hasil = 'Agustus';
    }
    if ($bulan == '9') {
        $hasil = 'September';
    }
    if ($bulan == '10') {
        $hasil = 'Oktober';
    }
    if ($bulan == '11') {
        $hasil = 'November';
    }
    if ($bulan == '12') {
        $hasil = 'Desember';
    }
    if ($bulan == null) {
        $hasil = '';
    }
    return $hasil;
}
