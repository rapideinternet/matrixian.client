<?php

namespace RapideInternet\Matrixian\Transformers;

use RapideInternet\Matrixian\Interfaces\Address;

class AddressTransformer extends Transformer {

    /**
     * @param Address $address
     * @return array
     */
    public function transform(Address $address): array {
        return [
            'street' => $address->street,
            'house_number' => $address->house_number,
            'house_number_ext' => $address->house_number_ext,
            'postal_code' => $address->postal_code,
            'country_name' => $address->country_name,
            'state' => $address->state,
            'city' => $address->city,
            'company_name' => $address->company_name,
            'country_iso_2' => $address->country_iso_2,
            'country_iso_3' => $address->country_iso_3,
            'locality' => $address->locality,
            'building_name' => $address->building_name,
            'latitude' => $address->latitude,
            'longitude' => $address->longitude,
            'mailbox' => $address->mailbox
        ];
    }

    /**
     * @param Address $address
     * @return string
     */
    public function toString(Address $address): string {
        return $address->street.' '.$address->house_number.$address->house_number_ext.', '.$address->postal_code.' '.$address->city;
    }
}
