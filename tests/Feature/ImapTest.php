<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImapTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function testExample()
    {
          $this->call('POST', '/widgetd/imap_test', ['name' => 'Taylor']);
        $this->assertTrue(true);
    }
}
