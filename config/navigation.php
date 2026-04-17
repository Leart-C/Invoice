<?php

return [
    'sidebar' => [
        [
            'label'  => 'Dashboard',
            'route'  => 'dashboard',
            'match'  => 'dashboard',
            'active' => true,
            'icon'   => 'dashboard',
        ],
        [
            'label'  => 'Clients',
            'route'  => 'clients.index',
            'match'  => 'clients.*',
            'active' => true,
            'icon'   => 'clients',
        ],
        [
            'label'  => 'Invoices',
            'route'  => 'invoices.index',
            'match'  => 'invoices.*',
            'active' => true,
            'icon'   => 'invoices',
        ],
        [
            'label'  => 'Audit Log',
            'route'  => 'audit-logs.index',
            'match'  => 'audit-logs.*',
            'active' => true,
            'icon'   => 'audit',
            'admin_only' => true,
        ],
    ],
];