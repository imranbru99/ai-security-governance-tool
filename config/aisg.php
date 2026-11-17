<?php

return [
    'accent' => '#334155',
    'brand' => 'AegisGov',
    'demo' => [
        'email' => env('DEMO_USER_EMAIL', 'demo@ai-security-gov.test'),
        'password' => env('DEMO_USER_PASSWORD', 'password'),
    ],
    'hourly_rate' => (float) env('AISG_HOURLY_RATE', 85),
    'monthly_cost' => (float) env('AISG_MONTHLY_COST', 2400),
];
