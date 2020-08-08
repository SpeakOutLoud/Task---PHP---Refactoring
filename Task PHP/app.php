<?php
include 'extensions.php';

$app = new App($argv[1]);
$app->process_transactions();


class App
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

        $binResults = file_get_contents('https://lookup.binlist.net/' . $transaction->bin);
        if (!$binResults)
        {
            var_dump('validating card number failed');
            return;
        }
        $r = json_decode($binResults);
        $isEu = IsCardInsideEuZone($r->country->alpha2);
    
        $rate = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'][$transaction->currency];
        if ($transaction->currency == 'EUR' or $rate == 0) {
            $amntFixed = $transaction->amount;
        }
        if ($transaction->currency != 'EUR' or $rate > 0) {
            $amntFixed = $transaction->amount / $rate;
        }
    
        echo $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02);
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

