<?php declare(strict_types = 1);

namespace Takoma\Template\Api;

use PHPUnit\Framework\TestCase;

class RootTest extends TestCase
{
    /** @test */
    public function getReturnInstance()
    {
        $this->assertInstanceOf(
            Root::class,
            Root::get()
        );
    }
}
