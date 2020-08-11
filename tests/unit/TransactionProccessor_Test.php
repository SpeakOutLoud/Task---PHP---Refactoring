<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include "Task PHP\TransactionProccessor.php";
include 'Task PHP\ExternalRequests.php';
include 'Task PHP\FileUtilityManager.php';
include 'Task PHP\Config.php';

class TransactionProccessor_Test extends TestCase
{
    public function test_checkIfFileIsValidJson(): void
    {
        $fileUtilityManager = new FileUtilityManager('input.txt');
        $transactionJson = $fileUtilityManager->read_transaction_file();

        foreach (explode("\n", $transactionJson) as $transaction) {
            json_decode($transaction);
        }
        $validJson = (json_last_error() == JSON_ERROR_NONE);
        $this->assertTrue($validJson);
    }

    public function test_checkIfBinlistIsWorking(): void
    {
        //check if the bin number will return true, as in europe zone
        $result = ExternalRequests::validate_card_location('4745030');
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