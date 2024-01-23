<?php

namespace App\Enums;

enum TaskStatus: string
{
    case ACTIVE = 'active';
    CASE DONE = 'done';
    case REMOVE = 'remove';
}
