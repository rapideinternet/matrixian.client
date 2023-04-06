<?php

namespace RapideInternet\Matrixian\Transformers\Interfaces;

use RapideInternet\Matrixian\Models\Interfaces\Address;

interface AddressTransformer extends Transformer {

    /**
     * @param Address $address
     * @return array
     */
    public function transform(Address $address): array;

    /**
     * @param Address $address
     * @return string
     */
    public function toString(Address $address): string;
}
