<?php

namespace App\Domain\Enums;

enum LogEnum: string
{
    case USER_CREATED = 'User account @NAME@ created by @USER@ on @DATE@';
    case USER_LOGIN = 'User email: @EMAIL@ login on @DATE@';
    case USER_LOGOUT = 'User email: @EMAIL@ logout on @DATE@';
    case USER_UPDATED = 'User updated from @OLD@ to @NEW@ by @USER@ on @DATE@';
    case USER_PASSWORD = 'Password updated by @USER@ on @DATE@';
    case USER_FORGOT_PASSWORD = 'User @NAME@ with @ROLE@ requested code: @CODE@ on @DATE@';

    case DEPARTMENT_CREATED = 'Department: @NAME@ created by @USER@ on @DATE@';
    case DEPARTMENT_UPDATED = 'Department from @OLD@ to @NEW@ updated by @USER@ on @DATE@';
    case SPECIALIZATION_CREATED = 'Specialization: @NAME@ created by @USER@ on @DATE@';
    case SPECIALIZATION_UPDATED = 'Specialization from @OLD@ to @NEW@ updated by @USER@ on @DATE@';
    case DISTRIBUTOR_CREATED = 'Distributor: @NAME@ created by @USER@ on @DATE@';
    case DISTRIBUTOR_UPDATED = 'Distributor from @OLD@ to @NEW@ updated by @USER@ on @DATE@';

    case PRODUCT_CREATED = 'Product: @NAME@ created by @USER@ on @DATE@';
    case PRODUCT_UPDATED = 'Product from @OLD@ to @NEW@ updated by @USER@ on @DATE@';
    case PRODUCT_UPDATED_STATUS = 'Product @NAME@ updated the status from @OLD@ to @NEW@ by @USER@ on @DATE@';
    case PRODUCT_UPDATED_PRICE = 'Product @NAME@ updated the price from @OLD@ to @NEW@ by @USER@ on @DATE@';
    case PRODUCT_UPDATED_STOCKS = 'Product @NAME@ updated the stocks from @OLD@ to @NEW@ by @USER@ on @DATE@';
    case PRODUCT_REDUCED_STOCKS = 'Product @NAME@ deducted @COUNT@ remaining stocks @REMAINING@ by @USER@ on @DATE@';

    case SERVICE_CREATED = 'Service: @NAME@ created by @USER@ on @DATE@';
    case SERVICE_UPDATED = 'Service from @OLD@ to @NEW@ updated by @USER@ on @DATE@';
    case SERVICE_UPDATED_STATUS = 'Service @NAME@ updated the status from @OLD@ to @NEW@ by @USER@ on @DATE@';
    case SERVICE_UPDATED_PRICE = 'Service @NAME@ updated the price from @OLD@ to @NEW@ by @USER@ on @DATE@';
}
