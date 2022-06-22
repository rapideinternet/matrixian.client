<?php

namespace RapideInternet\Matrixian\Repositories;

use Illuminate\Support\Collection;
use RapideInternet\Matrixian\Models\Address;

class AddressRepository extends AbstractRepository {

    /**
     * @param string $country_code
     * @param string $postal_code
     * @param string $house_number
     * @param string|null $house_number_ext
     * @param string|null $house_letter
     * @return Collection
     */
    public function check(string $country_code, string $postal_code, string $house_number, ?string $house_number_ext = null, ?string $house_letter = null): Collection {
        $response = $this->matrixian->address->find($country_code, $postal_code, $house_number, $house_number_ext, $house_letter);
        return $response->isValid() ? collect($response->getData())->map(function($data) {
            return new Address($data);
        }) : collect();
    }
}
