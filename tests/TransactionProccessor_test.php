<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TransactionProccessor_test extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(
            Email::class,
            Email::fromString('user@example.com')
        );
    }
}