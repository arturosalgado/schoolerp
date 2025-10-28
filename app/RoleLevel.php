<?php

namespace App;

enum RoleLevel:string
{
    case STUDENT = 'student';
    case ADMIN = 'admin';
    case SUPERADMIN = 'superadmin';
    case TEACHER = 'teacher';

    public function getLabel(): string
    {
        return match($this) {
            self::STUDENT => 'Alumno',
            self::ADMIN => 'Administrador',
            self::SUPERADMIN => 'Super Administrador',
            self::TEACHER => 'Docente',
        };
    }
}
