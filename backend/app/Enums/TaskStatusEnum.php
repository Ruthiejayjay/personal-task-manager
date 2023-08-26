<?php

namespace App\Enums;

enum TaskStatusEnum:string {
    case PENDING = 'PENDING';
    case INPROGRESS = 'INPROGRESS';
    case COMPLETED = 'COMPLETED';
}