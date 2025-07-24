<?php

namespace App\Enums;

enum RoleEnum: int
{
    case SUPER_ADMIN = 1;
    case HOSPITAL_ADMIN = 2;
    case DOCTOR = 3;
    case NURSE = 4;
    case RECEPTIONIST = 5;
    case PHARMACIST = 6;
    case LAB_TECHNICIAN = 7;
    case BILLING_ACCOUNTS = 8;
    case CONTENT_MANAGER = 9;
    case MARKETING = 10;
    case PATIENT = 11;
    case IT_SUPPORT = 12;
}
