<?php
return [
    'createPost' => [
        'type' => 2,
        'description' => 'Create a post',
    ],
    'updatePost' => [
        'type' => 2,
        'description' => 'Update a post',
    ],
    'updateOwnPost' => [
        'type' => 2,
        'description' => 'Update a own post',
    ],
    'user' => [
        'type' => 1,
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'user',
            'createPost',
            'updatePost',
            'updateOwnPost',
        ],
    ],
];
