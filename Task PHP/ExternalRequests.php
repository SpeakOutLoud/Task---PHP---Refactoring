<?php

class ExternalRequests
{
    public static function validate_card_location($bin_number)
    {
        $binResults = file_get_contents(Config::$CARD_VALIDATION_ENDPOINT . $bin_number);
        if (!$binResults)
        {
            var_dump('validating card number failed');
            return "";
        }
        $r = json_decode($binResults);
        $insideEuruopeZone = is_card_in_europe_zone($r->country->alpha2);
        return $insideEuruopeZone;
    }

    public static function get_currency_rate($currency)
    {
        $currency_date = json_decode(file_get_contents(Config::$EXCHANGE_RATE_ENDPOINT), true);
        return $currency_date['rates'][$currency];
    }
}