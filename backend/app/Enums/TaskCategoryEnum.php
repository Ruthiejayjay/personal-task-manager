<?php

namespace App\Enums;

enum TaskCategoryEnum: string {
    case PERSONAL = 'PERSONAL';
    case WORK = 'WORK';
    case OTHER = 'OTHER';
}