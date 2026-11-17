<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_marketing_pages_respond_ok(): void
    {
        $this->seed();

        foreach (['/', '/features', '/modules', '/policies', '/reviews', '/posture', '/pricing', '/demo'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}
