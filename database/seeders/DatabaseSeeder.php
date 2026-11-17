<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\AccessReview;
use App\Models\AiAsset;
use App\Models\AuditLog;
use App\Models\GovernancePolicy;
use App\Models\PolicyViolation;
use App\Models\PostureCheck;
use App\Models\RiskAssessment;
use App\Models\User;
use App\Services\ModuleManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(ModuleManager::class)->syncFromConfig();

        $password = config('aisg.demo.password', 'password');

        $users = [];
        foreach ([
            ['name' => 'Imran Ahmed', 'email' => 'superadmin@ai-security-gov.test', 'role' => UserRole::SuperAdmin, 'company' => 'ImranDev BD', 'job_title' => 'Platform Architect'],
            ['name' => 'Nadia Rahman', 'email' => 'admin@ai-security-gov.test', 'role' => UserRole::Admin, 'company' => 'Northwind AI', 'job_title' => 'Security Admin'],
            ['name' => 'Karim Hossain', 'email' => 'manager@ai-security-gov.test', 'role' => UserRole::Manager, 'company' => 'Northwind AI', 'job_title' => 'Governance Manager'],
            ['name' => 'Lina Akter', 'email' => 'staff@ai-security-gov.test', 'role' => UserRole::Staff, 'company' => 'Northwind AI', 'job_title' => 'Security Analyst'],
            ['name' => 'External Partner', 'email' => 'client@ai-security-gov.test', 'role' => UserRole::Client, 'company' => 'Partner Co', 'job_title' => 'Compliance Lead'],
            ['name' => 'Demo User', 'email' => config('aisg.demo.email'), 'role' => UserRole::Demo, 'company' => 'Demo Co', 'job_title' => 'Evaluator'],
        ] as $row) {
            $users[$row['role']->value] = User::query()->updateOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['name'],
                    'password' => $password,
                    'role' => $row['role'],
                    'company' => $row['company'],
                    'job_title' => $row['job_title'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        $manager = $users[UserRole::Manager->value];
        $staff = $users[UserRole::Staff->value];
        $admin = $users[UserRole::Admin->value];
        $demo = $users[UserRole::Demo->value];

        $assets = [];
        foreach ([
            ['code' => 'AI-001', 'name' => 'Customer Support Agent', 'type' => 'agent', 'class' => 'confidential', 'tier' => 3],
            ['code' => 'AI-002', 'name' => 'Contract Summarizer', 'type' => 'model', 'class' => 'restricted', 'tier' => 4],
            ['code' => 'AI-003', 'name' => 'Knowledge RAG Hub', 'type' => 'rag', 'class' => 'internal', 'tier' => 2],
            ['code' => 'AI-004', 'name' => 'Vendor Risk Scorer', 'type' => 'model', 'class' => 'confidential', 'tier' => 3],
            ['code' => 'AI-005', 'name' => 'Slack Ops Bot', 'type' => 'integration', 'class' => 'internal', 'tier' => 2],
        ] as $a) {
            $assets[$a['code']] = AiAsset::query()->updateOrCreate(
                ['code' => $a['code']],
                [
                    'name' => $a['name'],
                    'slug' => Str::slug($a['name']),
                    'asset_type' => $a['type'],
                    'environment' => 'production',
                    'owner_team' => 'AI Platform',
                    'data_classification' => $a['class'],
                    'vendor' => 'Northwind',
                    'risk_tier' => $a['tier'],
                    'is_active' => true,
                    'tags' => ['demo', $a['type']],
                    'notes' => 'Seeded AI asset for AegisGov demos.',
                ]
            );
        }

        $policies = [];
        foreach ([
            ['code' => 'POL-AI-USE', 'title' => 'Acceptable AI Use Policy', 'category' => 'ai_use', 'severity' => 'high'],
            ['code' => 'POL-ACCESS', 'title' => 'Privileged Access Policy', 'category' => 'access', 'severity' => 'critical'],
            ['code' => 'POL-DATA', 'title' => 'AI Data Handling Policy', 'category' => 'privacy', 'severity' => 'high'],
            ['code' => 'POL-RET', 'title' => 'Model Log Retention Policy', 'category' => 'retention', 'severity' => 'medium'],
            ['code' => 'POL-VENDOR', 'title' => 'Third-Party Model Policy', 'category' => 'security', 'severity' => 'high'],
        ] as $p) {
            $policies[$p['code']] = GovernancePolicy::query()->updateOrCreate(
                ['code' => $p['code']],
                [
                    'title' => $p['title'],
                    'slug' => Str::slug($p['title']),
                    'category' => $p['category'],
                    'severity' => $p['severity'],
                    'status' => 'active',
                    'version' => '1.2',
                    'owner_id' => $manager->id,
                    'enforcement_enabled' => true,
                    'effective_at' => now()->subMonths(2),
                    'reviewed_at' => now()->subWeeks(2),
                    'summary' => $p['title'].' for enterprise AI governance.',
                    'body' => "Enforce {$p['title']} across all production AI systems.",
                    'tags' => ['governance', 'seed'],
                ]
            );
        }

        AccessReview::query()->updateOrCreate(
            ['code' => 'AR-2026-Q4-AI'],
            [
                'title' => 'Q4 AI System Access Review',
                'scope' => 'ai_systems',
                'status' => 'in_progress',
                'reviewer_id' => $manager->id,
                'entitlements_total' => 128,
                'entitlements_reviewed' => 86,
                'flags_count' => 7,
                'due_on' => now()->addDays(12)->toDateString(),
                'started_at' => now()->subDays(8),
                'summary' => 'Review production model and agent entitlements.',
                'metadata' => ['campaign' => 'q4'],
            ]
        );

        AccessReview::query()->updateOrCreate(
            ['code' => 'AR-2026-ADMIN'],
            [
                'title' => 'Admin Role Recertification',
                'scope' => 'admin_roles',
                'status' => 'completed',
                'reviewer_id' => $admin->id,
                'entitlements_total' => 42,
                'entitlements_reviewed' => 42,
                'flags_count' => 2,
                'due_on' => now()->subDays(3)->toDateString(),
                'started_at' => now()->subDays(20),
                'completed_at' => now()->subDays(4),
                'summary' => 'Completed admin privilege recertification.',
                'metadata' => ['campaign' => 'admin'],
            ]
        );

        AccessReview::query()->updateOrCreate(
            ['code' => 'AR-2026-VENDOR'],
            [
                'title' => 'Vendor AI Access Campaign',
                'scope' => 'vendor_access',
                'status' => 'draft',
                'reviewer_id' => $staff->id,
                'entitlements_total' => 55,
                'entitlements_reviewed' => 0,
                'flags_count' => 0,
                'due_on' => now()->addDays(30)->toDateString(),
                'summary' => 'Upcoming vendor connector review.',
                'metadata' => ['campaign' => 'vendor'],
            ]
        );

        $i = 1;
        foreach ($assets as $code => $asset) {
            $score = 45 + ($i * 8);
            RiskAssessment::query()->updateOrCreate(
                ['code' => 'RISK-'.$code],
                [
                    'subject_type' => 'ai_asset',
                    'subject_name' => $asset->name,
                    'ai_asset_id' => $asset->id,
                    'assessor_id' => $staff->id,
                    'score' => min(95, $score),
                    'level' => $score >= 75 ? 'high' : ($score >= 55 ? 'medium' : 'low'),
                    'status' => 'open',
                    'factors' => ['data_class' => $asset->data_classification, 'tier' => $asset->risk_tier],
                    'recommendation' => 'Tighten access, enable logging, and schedule policy attestation.',
                    'assessed_at' => now()->subDays($i),
                ]
            );
            $i++;
        }

        foreach ([
            ['key' => 'mfa_coverage', 'name' => 'MFA coverage on AI consoles', 'domain' => 'identity', 'score' => 92, 'status' => 'pass'],
            ['key' => 'prompt_logging', 'name' => 'Prompt / response logging', 'domain' => 'model', 'score' => 78, 'status' => 'warn'],
            ['key' => 'pii_redaction', 'name' => 'PII redaction in RAG', 'domain' => 'data', 'score' => 88, 'status' => 'pass'],
            ['key' => 'egress_controls', 'name' => 'Model egress controls', 'domain' => 'network', 'score' => 71, 'status' => 'warn'],
            ['key' => 'vendor_soc2', 'name' => 'Vendor SOC 2 attestation', 'domain' => 'vendor', 'score' => 84, 'status' => 'pass'],
            ['key' => 'secret_scan', 'name' => 'Secret scanning in agents', 'domain' => 'model', 'score' => 63, 'status' => 'fail'],
        ] as $c) {
            PostureCheck::query()->updateOrCreate(
                ['check_key' => $c['key']],
                [
                    'name' => $c['name'],
                    'domain' => $c['domain'],
                    'score' => $c['score'],
                    'status' => $c['status'],
                    'owner_id' => $manager->id,
                    'finding' => $c['status'] === 'pass' ? 'Within policy thresholds.' : 'Requires remediation this sprint.',
                    'remediation' => $c['status'] === 'pass' ? null : 'Assign owner and track in risk register.',
                    'last_checked_at' => now()->subHours(6),
                ]
            );
        }

        PolicyViolation::query()->updateOrCreate(
            ['code' => 'VIO-2026-001'],
            [
                'governance_policy_id' => $policies['POL-DATA']->id,
                'ai_asset_id' => $assets['AI-002']->id,
                'reported_by' => $staff->id,
                'title' => 'Unmasked PII in contract summarizer logs',
                'severity' => 'high',
                'status' => 'investigating',
                'description' => 'Sample logs contained customer identifiers without redaction.',
                'detected_at' => now()->subDays(2),
            ]
        );

        PolicyViolation::query()->updateOrCreate(
            ['code' => 'VIO-2026-002'],
            [
                'governance_policy_id' => $policies['POL-ACCESS']->id,
                'ai_asset_id' => $assets['AI-001']->id,
                'reported_by' => $demo->id,
                'title' => 'Stale admin token on support agent',
                'severity' => 'critical',
                'status' => 'open',
                'description' => 'Service account not rotated within policy window.',
                'detected_at' => now()->subDay(),
            ]
        );

        foreach ([
            ['action' => 'policy.published', 'entity' => 'GovernancePolicy', 'severity' => 'info'],
            ['action' => 'access_review.started', 'entity' => 'AccessReview', 'severity' => 'info'],
            ['action' => 'risk.scored', 'entity' => 'RiskAssessment', 'severity' => 'warning'],
            ['action' => 'violation.opened', 'entity' => 'PolicyViolation', 'severity' => 'critical'],
            ['action' => 'posture.checked', 'entity' => 'PostureCheck', 'severity' => 'info'],
            ['action' => 'module.toggled', 'entity' => 'ModuleSetting', 'severity' => 'info'],
        ] as $idx => $ev) {
            AuditLog::query()->updateOrCreate(
                ['event_id' => 'EVT-'.str_pad((string) ($idx + 1), 4, '0', STR_PAD_LEFT)],
                [
                    'action' => $ev['action'],
                    'entity_type' => $ev['entity'],
                    'entity_id' => (string) ($idx + 1),
                    'actor_id' => $idx % 2 === 0 ? $admin->id : $manager->id,
                    'severity' => $ev['severity'],
                    'source' => 'aegisgov',
                    'payload' => ['seed' => true, 'index' => $idx],
                    'ip_address' => '203.0.113.'.(10 + $idx),
                    'occurred_at' => now()->subHours(20 - $idx),
                ]
            );
        }
    }
}
