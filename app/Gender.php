<?php

namespace App;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function fromString(string $value): self
    {
        return match (strtolower($value)) {
            'male', 'masculino', 'h', 'hombre' => self::MALE,
            'female', 'femenino', 'm', 'mujer' => self::FEMALE,
            default => throw new \InvalidArgumentException("Invalid gender value: {$value}"),
        };
    }

    public function getCurpCode(): string
    {
        return match ($this) {
            self::MALE => 'H',
            self::FEMALE => 'M',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::MALE => 'Masculino',
            self::FEMALE => 'Femenino',
        };
    }
}
