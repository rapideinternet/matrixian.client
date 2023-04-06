<?php

namespace RapideInternet\Matrixian\Transformers\Interfaces;

use RapideInternet\Matrixian\Models\Interfaces\HouseDetails;

interface HouseDetailsTransformer extends Transformer  {

    /**
     * @param HouseDetails $houseDetails
     * @return array
     */
    public function transform(HouseDetails $houseDetails): array;

    /**
     * @param HouseDetails $houseDetails
     * @return string
     */
    public function toString(HouseDetails $houseDetails): string;
}
