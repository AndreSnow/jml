<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Rules\Cnpj;

class CnpjRuleTest extends TestCase
{
    /** @test */
    public function it_accepts_valid_cnpj(): void
    {
        $cnpj = new Cnpj();
        $this->assertTrue($cnpj->passes('cnpj', '12345678000195'));
        $this->assertTrue($cnpj->passes('cnpj', '04252011000110'));
        $this->assertTrue($cnpj->passes('cnpj', '11444777000161'));
    }

    /** @test */
    public function it_rejects_invalid_cnpj(): void
    {
        $cnpj = new Cnpj();
        $this->assertFalse($cnpj->passes('cnpj', '11111111111111'));
        $this->assertFalse($cnpj->passes('cnpj', '12345678000100'));
        $this->assertFalse($cnpj->passes('cnpj', '00000000000000'));
        $this->assertFalse($cnpj->passes('cnpj', '123'));
        $this->assertFalse($cnpj->passes('cnpj', 'abcdefghijklmno'));
    }
}
