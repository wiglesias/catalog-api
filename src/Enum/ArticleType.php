<?php

namespace App\Enum;

enum ArticleType: string
{
    case OLIVE_OIL = 'olive_oil';
    case GRAPE_SEED_OIL = 'grape_seed_oil';
    case OLIVE_POMACE_OIL = 'olive_pomace_oil';
    case VINEGAR = 'vinegar';
    case FATTY_ACIDS = 'fatty_acids';
    case MISC_PEPE = 'misc_pepe';
    case OLEINS = 'oleins';
    case OTHER_FATTY_MATERIALS = 'other_fatty_materials';
    case NEUTRALIZATION_PASTES = 'neutralization_pastes';
    case REFINERY_AUXILIARY = 'refinery_auxiliary';
    case PLANT_AUXILIARY = 'plant_auxiliary';
    case CANS = 'cans';
    case PROMOTIONAL_CATALOGS = 'promotional_catalogs';
    case BOXES = 'boxes';
    case LABELS = 'labels';
    case PLASTIC_CARBOYS = 'plastic_carboys';
    case PLASTIC_BOTTLES = 'plastic_bottles';
    case GLASS_BOTTLES = 'glass_bottles';
    case PALLETS = 'pallets';
    case DRUMS = 'drums';
    case CONTAINERS = 'containers';
    case KITCHEN_CLOTHING = 'kitchen_clothing';
    case WOODEN_KITCHEN_ITEMS = 'wooden_kitchen_items';
    case CORK_MANUFACTURES = 'cork_manufactures';
    case OLIVE_OIL_MINIATURES = 'olive_oil_miniatures';
    case DVDS = 'dvds';
    case PLASTIC_KITCHEN_ITEMS = 'plastic_kitchen_items';
    case FRIDGE_MAGNETS = 'fridge_magnets';

    public function label(): string
    {
        return match ($this) {
            self::OLIVE_OIL => 'ACEITE DE OLIVA',
            self::GRAPE_SEED_OIL => 'ACEITE DE GRANILLA DE UVA',
            self::OLIVE_POMACE_OIL => 'ACEITE DE ORUJO',
            self::VINEGAR => 'VINAGRE',
            self::FATTY_ACIDS => 'ÁCIDOS GRASOS',
            self::MISC_PEPE => 'VARIOS PEPE 20160224',
            self::OLEINS => 'OLEÍNAS',
            self::OTHER_FATTY_MATERIALS => 'OTRAS MATERIAS GRASAS',
            self::NEUTRALIZATION_PASTES => 'PASTAS DE NEUTRALIZACIÓN',
            self::REFINERY_AUXILIARY => 'MAT. AUXILIARES REFINERÍA',
            self::PLANT_AUXILIARY => 'MAT. AUXILIARES PLANTA ENVASADO',
            self::CANS => 'LATAS',
            self::PROMOTIONAL_CATALOGS => 'CATÁLOGOS PROMOCIONALES',
            self::BOXES => 'CAJAS',
            self::LABELS => 'ETIQUETAS',
            self::PLASTIC_CARBOYS => 'BOMBONAS DE PLÁSTICO',
            self::PLASTIC_BOTTLES => 'BOTELLAS DE PLÁSTICO',
            self::GLASS_BOTTLES => 'BOTELLAS DE VIDRIO',
            self::PALLETS => 'PALETS',
            self::DRUMS => 'BIDONES',
            self::CONTAINERS => 'CONTENEDORES',
            self::KITCHEN_CLOTHING => 'ROPA DE COCINA',
            self::WOODEN_KITCHEN_ITEMS => 'ARTÍCULOS DE COCINA DE MADERA',
            self::CORK_MANUFACTURES => 'MANUFACTURAS CORCHO',
            self::OLIVE_OIL_MINIATURES => 'MINIATURAS DE ACEITE DE OLIVA',
            self::DVDS => "DVD'S",
            self::PLASTIC_KITCHEN_ITEMS => 'ARTÍCULOS COCINA PLÁSTICO',
            self::FRIDGE_MAGNETS => 'MAGNÉTICOS NEVERA',
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
}

//enum ArticleType: string
//{
//    case RAW_MATERIAL = 'raw_material';   // El aceite
//    case PACKAGING = 'packaging';         // La botella
//    case COMPONENT = 'component';         // Tapones y etiquetas
//    case LABEL = 'label';         // Tapones y etiquetas
//    case SHIPPING_MATERIAL = 'shipping_material'; // La caja de cartón (Embalaje)
//    case FINISHED_PRODUCT = 'finished_product';   // Producto 4689 completo
//
//    public function label(): string
//    {
//        return match ($this) {
//            self::RAW_MATERIAL => 'MATERIA PRIMA',
//            self::PACKAGING => 'ENVASE',
//            self::COMPONENT => 'COMPONENTE',
//            self::LABEL => 'ETIQUETA',
//            self::SHIPPING_MATERIAL => 'EMBALAJE',
//            self::FINISHED_PRODUCT => 'PRODUCTO TERMINADO',
//        };
//    }
//
//    public static function choices(): array
//    {
//        return [
//            'raw_material' => self::RAW_MATERIAL,
//            'packaging' => self::PACKAGING,
//            'component' => self::COMPONENT,
//            'label' => self::LABEL,
//            'shipping_material' => self::SHIPPING_MATERIAL,
//            'finished_product' => self::FINISHED_PRODUCT,
//        ];
//    }
//}
