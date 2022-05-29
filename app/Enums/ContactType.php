<?php

namespace App\Enums;

enum ContactType: string
{
    case Primary = 'primary';
    case Site = 'site';
    case Billing = 'billing';
    case Shipping = 'shipping';
    case Admin = 'admin';
}
