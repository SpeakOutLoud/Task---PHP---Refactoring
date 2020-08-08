<?php

function IsCardInsideEuZone($cardNumber)
{
    switch($c) {
        case 'AT':
        case 'BE':
        case 'BG':
        case 'CY':
        case 'CZ':
        case 'DE':
        case 'DK':
        case 'EE':
        case 'ES':
        case 'FI':
        case 'FR':
        case 'GR':
        case 'HR':
        case 'HU':
        case 'IE':
        case 'IT':
        case 'LT':
        case 'LU':
        case 'LV':
        case 'MT':
        case 'NL':
        case 'PO':
        case 'PT':
        case 'RO':
        case 'SE':
        case 'SI':
        case 'SK':
            return true;
        default:
            return false;
    }
}

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