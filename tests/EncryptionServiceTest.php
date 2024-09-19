<?php
namespace App\Tests;

use App\Service\EncryptionService;
use PHPUnit\Framework\TestCase;

class EncryptionServiceTest extends TestCase
{
    private $encryptionService;

    protected function setUp(): void
    {
        $this->encryptionService = new EncryptionService();
    }

    public function testEncryptDecrypt()
    {
        $data = 'Hello World';
        $encrypted = $this->encryptionService->encrypt($data);
        $encrypted2 = $this->encryptionService->encrypt($data);

        $this->assertNotEquals($data, $encrypted);
        $this->assertNotEquals($encrypted, $encrypted2);

        $decrypted = $this->encryptionService->decrypt($encrypted);
        $decrypted2 = $this->encryptionService->decrypt($encrypted2);
        
        $this->assertEquals($data, $decrypted);
        $this->assertEquals($decrypted, $decrypted2);
        
    }

}
