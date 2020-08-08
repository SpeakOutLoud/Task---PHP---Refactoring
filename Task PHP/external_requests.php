<?php

function validateCardLocation($bin_number)
{
    $binResults = file_get_contents('https://lookup.binlist.net/' . $bin_number);
    if (!$binResults)
    {
        var_dump('validating card number failed');
        return "";
    }
    $r = json_decode($binResults);
    $isEu = IsCardInsideEuZone($r->country->alpha2);
    return $isEu;
}

function get_currency_rate($currency)
{
    $currency_date = json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true);
    return $currency_date['rates'][$currency];
}