<?php

namespace App\Enums;

enum TypeEvent: string
{
    case CREATED = 'created';
    case CREATING = 'creating';
    case UPDATED = 'updated';
    case UPDATING = 'updating';
    case DELETED = 'deleted';
    case DELETING = 'deleting';
}
