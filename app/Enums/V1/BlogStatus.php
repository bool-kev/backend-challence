<?php

namespace App\Enums\V1;

enum BlogStatus:string
{
    case PUBLISHED = 'publié';
    case DRAFT = 'brouillon';
    case ARCHIVED = 'archivé';
    case DELETED = 'supprimé';
}

