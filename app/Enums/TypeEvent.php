<?php

namespace App\Enums;

enum TypeEvent: string
{
    case CREATED = 'created';
    case CREATING = 'creating';
    case UPDATED = 'updated';
    case UPDATING = 'updating';
    case SAVED= 'saved';
    case SAVING = 'saving';
    case DELETED = 'deleted';
    case DELETING = 'deleting';
}
