<?php

return [
    'super admin' => [
        [
            'name'  => 'User',
            'icon'  => 'users',
            'children' => [
                [
                    'name'  => 'Web Service',
                    'route' => ['user_ws.index'], // No params
                ],
                [
                    'name'  => 'Users Table',
                    'route' => ['users.index'], // No params
                ],
            ],
        ],
        [
            'name'  => 'Test',
            'icon'  => 'users',
            'children' => [
                [
                    'name'  => 'Test Page',
                    'route' => ['test.index'], // No params
                ],
            ],
        ],
    ],

    'admin' => [
        [
            'name'  => 'Login User',
            'icon'  => 'users',
            'children' => [
                [
                    'name'  => 'ASN',
                    'route' => ['users.login_user_index', 'params' => ['jenis' => 'asn']],
                ],
                [
                    'name'  => 'Non ASN',
                    'route' => ['users.login_user_index', 'params' => ['jenis' => 'non asn']],
                ],
            ],
        ],
    ],

    'cpns' => [
        [
            'name'  => 'TPP',
            'icon'  => 'users',
            'children' => [
                [
                    'name'  => 'ASN',
                    'route' => ['users.login user_index', 'params' => ['jenis' => 'asn']],
                ],
                [
                    'name'  => 'Non ASN',
                    'route' => ['users.login_user_index', 'params' => ['jenis' => 'non asn']],
                ],
            ],
        ],
    ],
    'pns' => [
        [
            'name'  => 'TPP',
            'icon'  => 'users',
            'children' => [
                [
                    'name'  => 'ASN',
                    'route' => ['users.login_user_index', 'params' => ['jenis' => 'asn']],
                ],
                [
                    'name'  => 'Non ASN',
                    'route' => ['users.login_user_index', 'params' => ['jenis' => 'non asn']],
                ],
            ],
        ],
    ],
    'pembuat spj' => [
        [
            'name'  => 'Master',
            'icon'  => 'users',
            'children' => [
                [
                    'name'  => 'Penyedia',
                    'route' => ['penyedia.index'],
                ],
                [
                    'name'  => 'Narasumber',
                    'route' => ['narasumber.index'],
                ],
            ],
        ],
        [
            'name'  => 'Lampiran Pendukung',
            'icon'  => 'file',
            'children' => [
                [
                    'name'  => 'Honor Narasumber',
                    'route' => ['lampiran_narasumber.index'],
                ],
            ],
        ],
    ],
];
