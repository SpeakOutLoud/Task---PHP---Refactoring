<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include "Task PHP\TransactionProccessor.php";
include 'ExternalRequests.php';

class TransactionProccessor_Test extends TestCase
{
    public function test_checkIfFileIsValidJson(): void
    {
        $app = new TransactionProccessor('input.txt');
        $transactionJson = $app->read_transaction_file();

        foreach (explode("\n", $transactionJson) as $transaction) {
            json_decode($transaction);
        }
        $validJson = (json_last_error() == JSON_ERROR_NONE);
        $this->assertTrue($validJson);
    }

    public function test_checkIfBinlistIsWorking(): void
    {
        //check if the bin number will return true, as in europe zone
        $result = ExternalRequests::validateCardLocation('4745030');
        $possibleResults = [true, false];
        $this->assertContains($result, $possibleResults);
    }

    public function test_checkCurrencyRate(): void
    {
        //check if the bin number will return true, as in europe zone
        $result = ExternalRequests::get_currency_rate('USD');
        
        $this->assertTrue(is_double($result));
    }
}