<?php

namespace Tests\Feature;

use App\Services\ModuleManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModuleManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_modules_enabled_after_seed(): void
    {
        $this->seed();
        $mm = app(ModuleManager::class);
        $this->assertTrue($mm->enabled('policies'));
        $this->assertTrue($mm->enabled('access_reviews'));
        $this->assertTrue($mm->enabled('risk_scoring'));
        $this->assertTrue($mm->enabled('audit_logs'));
        $this->assertTrue($mm->enabled('posture'));
        $this->assertFalse($mm->enabled('catalog_scrape'));
    }
}
