<?php

$component =
    'components' => [
    'label' => 'Columns',
    'slug' => 'columns',
    'fields' => [
        'title' => [
            'type' => 'text',
            'label' => 'Titre de colonne',
            'default' => 'Titre de colonne'
        ],
    ],
    'sub_elements' => [
        'label' => 'Cartes',
        'fields' => [
            'title' => [
                'type' => 'text',
                'label' => 'Titre de carte',
                'default' => 'Titre de carte'
            ],
        ]
    ]
];
