<?php

namespace App\Enum;

enum UnitType: string
{
    case UNIT = 'unit';
    case KG = 'kg';
    case L = 'l';

    public function label(): string
    {
        return match ($this) {
            self::UNIT => 'UD.',
            self::KG => 'KG',
            self::L => 'L',
        };
    }

    public static function choices(): array
    {
        return [
            'unit' => self::UNIT,
            'kg' => self::KG,
            'l' => self::L,
        ];
    }
}
