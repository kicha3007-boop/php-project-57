<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHome(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('Привет от Хекслета!');
    }
}
