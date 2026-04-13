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
            'label'  => 'Payments',
            'route'  => 'payments.index',
            'match'  => 'payments.*',
            'active' => false,
            'icon'   => 'payments',
        ],
        
    ],
];