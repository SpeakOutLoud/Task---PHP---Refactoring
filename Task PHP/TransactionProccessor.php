<?php
include 'extensions.php';
include 'ExternalRequests.php';

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

$app = new TransactionProccessor($argv[1]);
$app->process_transactions();

class TransactionProccessor
{
    private $_filename = "";

    public function __construct($filename)
    {
        $this->$_filename = $filename;
    }

    function process_transactions()
    {
        $transaction_content = $this->read_transaction_file();
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

        $is_card_in_eu = ExternalRequests::validateCardLocation($transaction->bin);
    
        $currency_rate = ExternalRequests::get_currency_rate($transaction->currency);
        if ($transaction->currency == 'EUR' or $currency_rate == 0) {
            $amntFixed = $transaction->amount;
        }
        if ($transaction->currency != 'EUR' or $currency_rate > 0) {
            $amntFixed = $transaction->amount / $currency_rate;
        }
    
        echo floor(($amntFixed * ($is_card_in_eu ? 0.01 : 0.02)) * 100) / 100;
        print "\n";
    }

    function read_transaction_file()
    {
        if($this->$_filename != null && file_exists($this->$_filename))
        {
            return file_get_contents($this->$_filename);
        }
        return "";
    }
}


