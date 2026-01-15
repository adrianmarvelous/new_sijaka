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
            'name'  => 'Super Admin',
            'icon'  => 'key',
            'children' => [
                [
                    'name'  => 'Upload Excel to Table',
                    'route' => ['upload_excel.index'], // No params
                ],
                [
                    'name'  => 'List API',
                    'route' => ['list_api.index'], // No params
                ],
                [
                    'name'  => 'Test Page',
                    'route' => ['test.index'], // No params
                ],
            ],
        ],
    ],

    'admin' => [
        [
            'name'  => 'Setting OPD',
            'icon'  => 'gear',
            'children' => [
                [
                    'name'  => 'Bidang',
                    'route' => ['setting_opd.index'], // No params
                ],
            ],
        ],
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
        [
            'name'  => 'SPJ',
            'icon'  => 'file',
            'children' => [
                [
                    'name'  => 'NPP - NPD',
                    'route' => ['npp_npd.index'],
                ],
            ],
        ],
    ],
];
