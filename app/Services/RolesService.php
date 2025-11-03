<?php

namespace App\Services;
// se decidio que los roles van por escuela : Admin , IT , Finance, aunqque se repitan , pero se van a marcar como de sistema
class RolesService
{
    public static array $roles=[
        'admin'=>'Administrador',
        'it'=>'Informática',
        'finance'=>'Finanzas',
    ];
}
