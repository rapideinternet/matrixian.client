<?php

namespace RapideInternet\Matrixian\Transformers\Implementation;

use RapideInternet\Matrixian\Models\Interfaces\HouseDetails;

class HouseDetailsTransformer implements \RapideInternet\Matrixian\Transformers\Interfaces\HouseDetailsTransformer  {

    /**
     * @param HouseDetails $houseDetails
     * @return array
     */
    public function transform(HouseDetails $houseDetails): array {
        return [
            'house_number' => $houseDetails->house_number,
            'house_number_ext' => $houseDetails->house_number_ext,
            'postal_code' => $houseDetails->postal_code,
            'house_letter' => $houseDetails->house_letter,
            'living_surface' => $houseDetails->living_surface,
            'other_indoor_space' => $houseDetails->other_indoor_space,
            'use_surface' => $houseDetails->use_surface,
            'parcel_surface' => $houseDetails->parcel_surface,
            'object_type' => $houseDetails->object_type,
            'build_year' => $houseDetails->build_year,
            'energy_label' => $houseDetails->energy_label,
            'description' => $houseDetails->description,
            'number_of_bathrooms' => $houseDetails->number_of_bathrooms,
            'number_of_bedrooms' => $houseDetails->number_of_bedrooms,
            'number_of_rooms' => $houseDetails->number_of_rooms,
            'number_of_toilets' => $houseDetails->number_of_toilets,
            'external_storage_space' => $houseDetails->external_storage_space,
            'attached_outdoor_space' => $houseDetails->attached_outdoor_space,
            'volume' => $houseDetails->volume
        ];
    }

    /**
     * @param HouseDetails $houseDetails
     * @return string
     */
    public function toString(HouseDetails $houseDetails): string {
        return $houseDetails->house_number.$houseDetails->house_number_ext.', '.$houseDetails->postal_code;
    }
}
