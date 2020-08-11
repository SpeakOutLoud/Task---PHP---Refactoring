<?php

include 'Extensions.php';

class TransactionProccessor
{
    private $_fileUtilityManager;

    public function __construct($fileUtilityManager)
    {
        $this->$_fileUtilityManager = $fileUtilityManager;
    }

    function process_transactions()
    {
        $transaction_content = $this->$_fileUtilityManager->read_transaction_file();
        if($transaction_content)
        {
            foreach (explode("\n", $transaction_content) as $transaction) {
                $this->validate_transaction($transaction);
            }
        }
        else
        {
            var_dump('no content or no file found');
        }
    }

    function validate_transaction($transaction_string)
    {
        if (empty($transaction_string))
        { 
            var_dump('tranasction not valid');
            return;
        }
        $transaction = json_decode($transaction_string);

        $is_card_in_europe_zone = ExternalRequests::validate_card_location($transaction->bin);
        $currency_rate = ExternalRequests::get_currency_rate($transaction->currency);

        $amount_fixed = $this->calculate_rate($transaction->currency, $currency_rate, $transaction->amount);
        $this->log_currency_rate($amount_fixed, $is_card_in_europe_zone, $transaction->amount);

        print "\n";
    }

    function log_currency_rate($amount_fixed, $is_card_in_europe_zone)
    {
        echo floor(($amount_fixed * ($is_card_in_eu ? 0.01 : 0.02)) * 100) / 100;
    }

    function calculate_rate($currency, $currency_rate, $amount)
    {
        if ($currency == 'EUR' || $currency_rate == 0) {
            $amount_fixed = $amount;
        }
        if ($currency != 'EUR' || $currency_rate > 0) {
            $amount_fixed = $amount / $currency_rate;
        }
        return $amount_fixed;
    }
}