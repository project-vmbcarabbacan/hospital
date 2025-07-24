<?php

namespace App\Enums;

enum DateEnum: string
{
    case TIME_ZONE = 'Asia/Dubai';
    case FORMAT_FE_DATE = 'd/m/y H:i';
    case FORMAT_FE_DATE_ONLY = 'd/m/y';
}
