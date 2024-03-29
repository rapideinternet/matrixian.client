<?php

namespace RapideInternet\Matrixian\Transformers\Implementation;

use RapideInternet\Matrixian\Models\Interfaces\WOZ;
use RapideInternet\Matrixian\Transformers\Contracts\Transformer;

class WOZTransformer implements \RapideInternet\Matrixian\Transformers\Interfaces\WOZTransformer {

    /**
     * @param WOZ $woz
     * @return array
     */
    public function transform(WOZ $woz): array {
        return [
            'house_number' => $woz->house_number,
            'house_number_ext' => $woz->house_number_ext,
            'postal_code' => $woz->postal_code,
            'house_number_letter' => $woz->house_number_letter,
            'since' => ($last = $woz->last()) !== null ? $last->date->format('d-m-Y') : null,
            'current_value' => ($last = $woz->last()) !== null ? $last->value : null
        ];
    }

    /**
     * @param WOZ $woz
     * @return string
     */
    public function toString(WOZ $woz): string {
        return $woz->house_number.$woz->house_number_ext.', '.$woz->postal_code;
    }
}
