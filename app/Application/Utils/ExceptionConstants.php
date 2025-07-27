<?php

namespace App\Application\Utils;

class ExceptionConstants
{

    const LOGIN_INVALID = 'Invalid credentials';
    const USER_NOT_FOUND = 'User not found!';
    const USER_CREATE = 'Unable to create user';
    const USER_INFORMATION_CREATE = 'Unable to create user information';
    const DEPARTMENT_NOT_FOUND = 'Department not found';
    const DEPARTMENT_EXIST = 'Department already exists!';
    const DEPARTMENT_ADD = 'Unable to add department';
    const DEPARTMENT_UPDATE = 'Unable to update the department';

    const SPECIALIZATION_EXIST = 'Specialization already exist';
    const SPECIALIZATION_ADD = 'Unable to add specialization';
    const SPECIALIZATION_UPDATE = 'Unable to update specialization';
    const SPECIALIZATION_NOT_FOUND = 'Specialization not found';

    const DISTRIBUTOR_NOT_FOUND = 'Distributor not found!';
    const DISTRIBUTOR_EXIST = 'Distributor already exists!';
    const DISTRIBUTOR_ADD = 'Unable to add distributor';
    const DISTRIBUTOR_UPDATE = 'Unable to update distributor';

    const BRAND_NOT_FOUND = 'Brand not found!';
    const BRAND_EXIST = 'Brand already exists!';
    const BRAND_ADD = 'Unable to add brand';
    const BRAND_UPDATE = 'Unable to update brand';

    const PRODUCT_NOT_FOUND = 'Product not found!';
    const PRODUCT_EXIST = 'Product already exists!';
    const PRODUCT_ADD = 'Unable to add product';
    const PRODUCT_UPDATE = 'Unable to update product';

    const SERVICE_NOT_FOUND = 'Service not found!';
    const SERVICE_EXIST = 'Service already exists!';
    const SERVICE_ADD = 'Unable to add service';
    const SERVICE_UPDATE = 'Unable to update service';

    const ACHIEVEMENT_NOT_FOUND = 'Achievement not found!';
    const ACHIEVEMENT_ADD = 'Unable to add achievement';
    const ACHIEVEMENT_UPDATE = 'Unable to update achievement';

    const DOCTOR_SCHEDULE_NOT_FOUND = 'Doctor schedule not found!';
    const DOCTOR_SCHEDULE_EXIST = 'Doctor schedule already exist!';
    const DOCTOR_SCHEDULE_ADD = 'Unable to add schedule';
    const DOCTOR_SCHEDULE_UPDATE = 'Unable to update schedule';

    const DOCTOR_SCHEDULE_EXCEPTION_EXIST = 'Doctor schedule exception already exist';
    const DOCTOR_SCHEDULE_EXCEPTION_NOT_FOUND = 'Doctor schedule exception not found!';

    const APPOINTMENT_NOT_FOUND = 'Appointment not found';
    const APPOINTMENT_BOOK = 'You have already booked with the same date.';
    const APPOINTMENT_BOOKED = 'Appointment date and time no longer available';
}
