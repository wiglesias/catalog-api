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

    public static function fromLabel(string $label): ?self
    {
        $label = strtolower(trim($label));

        foreach (self::cases() as $case) {
            if (strtolower($case->label()) === $label) {
                return $case;
            }
        }

        return null;
    }

    public static function choices(): array
    {
        $choices = [];
        foreach (self::cases() as $case) {
            $choices[$case->label()] = $case->value;
        }
        return $choices;
    }
}

//enum UnitType: string
//{
//    case UNIT = 'unit';
//    case KG = 'kg';
//    case L = 'l';
//
//    public function label(): string
//    {
//        return match ($this) {
//            self::UNIT => 'UD.',
//            self::KG => 'KG',
//            self::L => 'L',
//        };
//    }
//
//    public static function choices(): array
//    {
//        return [
//            'unit' => self::UNIT,
//            'kg' => self::KG,
//            'l' => self::L,
//        ];
//    }
//}
