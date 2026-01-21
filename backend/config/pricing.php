<?php

return [
    'currency' => 'USD',
    'overheads_pct' => 0.08,
    'margin_tiers' => [
        'low' => 0.20,
        'medium' => 0.35,
        'high' => 0.50,
    ],
    'products' => [
        'vps' => [
            'display' => 'Virtual Private Server',
            'features' => [
                [
                    'id' => 'vcpus',
                    'label' => 'vCPU',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 7.5,
                ],
                [
                    'id' => 'ram',
                    'label' => 'RAM (GB)',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 2.4,
                ],
                [
                    'id' => 'ssd',
                    'label' => 'SSD (GB)',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 0.12,
                ],
                [
                    'id' => 'bw',
                    'label' => 'Traffic (TB)',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 6.0,
                ],
            ],
        ],
        'backup' => [
            'display' => 'Backup as a Service',
            'features' => [
                [
                    'id' => 'protected_gb',
                    'label' => 'Protected Data (GB)',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 0.06,
                ],
                [
                    'id' => 'retention_days',
                    'label' => 'Retention (days)',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 0.001,
                ],
                [
                    'id' => 'managed',
                    'label' => 'Managed Backup',
                    'type' => 'boolean',
                    'pricing' => 'flat',
                    'unit_price' => 15,
                ],
            ],
        ],
        'firewall' => [
            'display' => 'Firewall as a Service',
            'features' => [
                [
                    'id' => 'rules',
                    'label' => 'Rules Count',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 0.8,
                ],
                [
                    'id' => 'throughput',
                    'label' => 'Throughput (Mbps)',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 0.03,
                ],
                [
                    'id' => 'ips',
                    'label' => 'IPS/IDS',
                    'type' => 'boolean',
                    'pricing' => 'flat',
                    'unit_price' => 25,
                ],
            ],
        ],
        'kms' => [
            'display' => 'Key Management Service (KMS)',
            'features' => [
                [
                    'id' => 'keys',
                    'label' => 'Active Keys',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 2.5,
                ],
                [
                    'id' => 'api_calls',
                    'label' => 'API Calls (k)',
                    'type' => 'number',
                    'pricing' => 'per_unit',
                    'unit_price' => 0.04,
                ],
                [
                    'id' => 'hsm',
                    'label' => 'HSM-backed',
                    'type' => 'boolean',
                    'pricing' => 'flat',
                    'unit_price' => 60,
                ],
            ],
        ],
    ],
];
