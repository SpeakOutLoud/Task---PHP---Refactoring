<?php
include 'config.php';


class ExternalRequests
{
public static function validateCardLocation($bin_number)
{
    $binResults = file_get_contents(Config::$_cardValidationEndpoint . $bin_number);
    if (!$binResults)
    {
        var_dump('validating card number failed');
        return "";
    }
    $r = json_decode($binResults);
    $insideEuruopeZone = IsCardInsideEuZone($r->country->alpha2);
    return $insideEuruopeZone;
}

public static function get_currency_rate($currency)
{
    $currency_date = json_decode(file_get_contents(Config::$_exchangeRateEndpoint), true);
    return $currency_date['rates'][$currency];
}
}