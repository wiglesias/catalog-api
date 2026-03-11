<?php

namespace App\Enum;

enum ArticleType: string
{
    case RAW_MATERIAL = 'raw_material';   // El aceite
    case PACKAGING = 'packaging';         // La botella
    case COMPONENT = 'component';         // Tapones y etiquetas
    case LABEL = 'label';         // Tapones y etiquetas
    case SHIPPING_MATERIAL = 'shipping_material'; // La caja de cartón (Embalaje)
    case FINISHED_PRODUCT = 'finished_product';   // Producto 4689 completo

    public function label(): string
    {
        return match ($this) {
            self::RAW_MATERIAL => 'MATERIA PRIMA',
            self::PACKAGING => 'ENVASE',
            self::COMPONENT => 'COMPONENTE',
            self::LABEL => 'ETIQUETA',
            self::SHIPPING_MATERIAL => 'EMBALAJE',
            self::FINISHED_PRODUCT => 'PRODUCTO TERMINADO',
        };
    }

    public static function choices(): array
    {
        return [
            'raw_material' => self::RAW_MATERIAL,
            'packaging' => self::PACKAGING,
            'component' => self::COMPONENT,
            'label' => self::LABEL,
            'shipping_material' => self::SHIPPING_MATERIAL,
            'finished_product' => self::FINISHED_PRODUCT,
        ];
    }
}
