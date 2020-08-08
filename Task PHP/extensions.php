<?php

function IsCardInsideEuZone($cardNumber)
{
    $result = false;
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
            $result = 'yes';
            return $result;
        default:
            $result = 'no';
    }
    return $result;
}