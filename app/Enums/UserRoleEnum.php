<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMIN = "admin";
    case CREATOR = "creator";
    case FRIEND = "friend";
    case TEST = "test";
    case GIGABYTE = "gigabyte";
    case USER = "user";
}
