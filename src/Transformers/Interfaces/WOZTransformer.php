<?php

namespace RapideInternet\Matrixian\Transformers\Interfaces;

use RapideInternet\Matrixian\Models\Interfaces\WOZ;

interface WOZTransformer extends Transformer {

    /**
     * @param WOZ $woz
     * @return array
     */
    public function transform(WOZ $woz): array;

    /**
     * @param WOZ $woz
     * @return string
     */
    public function toString(WOZ $woz): string;
}
