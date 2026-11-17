<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->boolean('enabled')->default(true);
            $table->boolean('is_core')->default(false);
            $table->unsignedInteger('hours_saved_weekly')->default(0);
            $table->timestamps();
        });

        Schema::create('ai_assets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('asset_type')->default('model');
            $table->string('environment')->default('production');
            $table->string('owner_team')->nullable();
            $table->string('data_classification')->default('internal');
            $table->string('vendor')->nullable();
            $table->unsignedTinyInteger('risk_tier')->default(2);
            $table->boolean('is_active')->default(true);
            $table->json('tags')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('governance_policies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('security');
            $table->string('severity')->default('medium');
            $table->string('status')->default('draft');
            $table->string('version')->default('1.0');
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('enforcement_enabled')->default(true);
            $table->timestamp('effective_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('body')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
        });

        Schema::create('access_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->string('scope')->default('ai_systems');
            $table->string('status')->default('draft');
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('entitlements_total')->default(0);
            $table->unsignedInteger('entitlements_reviewed')->default(0);
            $table->unsignedInteger('flags_count')->default(0);
            $table->date('due_on')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('summary')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('subject_type');
            $table->string('subject_name');
            $table->foreignId('ai_asset_id')->nullable()->constrained('ai_assets')->nullOnDelete();
            $table->foreignId('assessor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedTinyInteger('score')->default(0);
            $table->string('level')->default('medium');
            $table->string('status')->default('open');
            $table->json('factors')->nullable();
            $table->text('recommendation')->nullable();
            $table->timestamp('assessed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_id')->unique();
            $table->string('action');
            $table->string('entity_type')->nullable();
            $table->string('entity_id')->nullable();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('severity')->default('info');
            $table->string('source')->default('app');
            $table->json('payload')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
        });

        Schema::create('posture_checks', function (Blueprint $table) {
            $table->id();
            $table->string('check_key')->unique();
            $table->string('name');
            $table->string('domain')->default('identity');
            $table->unsignedTinyInteger('score')->default(0);
            $table->string('status')->default('pass');
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('finding')->nullable();
            $table->text('remediation')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('policy_violations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('governance_policy_id')->nullable()->constrained('governance_policies')->nullOnDelete();
            $table->foreignId('ai_asset_id')->nullable()->constrained('ai_assets')->nullOnDelete();
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('severity')->default('medium');
            $table->string('status')->default('open');
            $table->text('description')->nullable();
            $table->timestamp('detected_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policy_violations');
        Schema::dropIfExists('posture_checks');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('risk_assessments');
        Schema::dropIfExists('access_reviews');
        Schema::dropIfExists('governance_policies');
        Schema::dropIfExists('ai_assets');
        Schema::dropIfExists('module_settings');
    }
};
