<?php

namespace App\Services;

class BloodTypeService
{
    /**
     * Array of all states from the database.
     *
     * @var array
     */
    public static array $types = [
        'A+',
        'A-',
        'B+',
        'B-',

        'AB+',
        'AB-',
        'O+',
        'O-'

    ];
}
