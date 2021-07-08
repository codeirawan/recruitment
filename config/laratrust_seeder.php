<?php

return [
    'role_structure' => [
        'super_administrator' => [
            'role' => 'v,c,u',
            'user' => 'v,c,u,d',
            'product-category' => 'v,c,u,d',
            'product-unit' => 'v,c,u,d',
            'payment-method' => 'v,c,u,d',
            'product' => 'v,c,u,d',
            'supplier' => 'v,c,u,d',
            'purchase' => 'v,c,vd,vf,p,vl',
            'storage-transaction' => 'v,c,vd',
            'position' => 'v,c,u,d',
            'resume-source' => 'v,c,u,d',
            'file-type' => 'v,c,u,d',
            'recruitment' => 'v,c,u,d,vf,cl,cs,vl',
        ],
    ],
    'permission_structure' => [],
    'permissions_map' => [
        'v' => 'view',
        'c' => 'create',
        'u' => 'update',
        'd' => 'delete',
        'p' => 'process',
        'vd' => 'void',
        'vf' => 'verify',
        'vl' => 'validate',
        'cs' => 'create-schedule',
        'cl' => 'cancel',
    ]
];
