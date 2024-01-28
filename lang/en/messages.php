<?php

return [
    'task' => [
        'update' => [
            'failed' => 'it\'s not your task'
        ],
        'store' => [
            'failed' => 'wrong task ID'
        ],
        'show' => [
            'failed' => 'this task has wrong ID'
        ],
        'destroy' => [
            'success' => 'task deleted successfully',
            'failed' => 'failed to delete task'
        ]
    ],
    'event' => [
        'destroy' => [
            'success' => 'event deleted successfully',
            'failed' => 'failed to delete event'
        ]
    ]
];
