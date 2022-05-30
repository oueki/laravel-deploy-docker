<?php
namespace Tests\Unit;

use App\Services\StringHelper;
use Tests\TestCase;

class StringHelperTest extends TestCase
{
    /** @test */
    public function test_empty()
    {
        $this->assertEquals('', StringHelper::cut('', 20));
    }

    /** @test */
    public function test_short_string()
    {
        $this->assertEquals('short', StringHelper::cut('short', 20));
    }

    /** @test */
    public function test_cut()
    {
        $this->assertEquals('long string shoul...',
            StringHelper::cut('long string should be cut', 20));
    }

}
