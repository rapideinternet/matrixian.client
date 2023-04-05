<?php

namespace RapideInternet\Matrixian\Repositories;

use Illuminate\Support\Collection;
use RapideInternet\Matrixian\Models\Address;

class AddressRepository extends AbstractRepository {

    /**
     * @param string $postal_code
     * @param string $house_number
     * @param string|null $house_number_ext
     * @param string|null $house_letter
     * @param string $country_code
     * @return Collection
     */
    public function check(
        string $postal_code,
        string $house_number,
        string $house_number_ext = null,
        string $house_letter = null,
        string $country_code = 'NL'
    ): Collection {
        $response = $this->matrixian->address->check($country_code, $postal_code, $house_number, $house_number_ext, $house_letter);
        return $response->isValid() ? collect($response->getData())->map(function($data) {
            return new Address($data);
        }) : collect();
    }

    /**
     * @param string $postal_code
     * @param string $house_number
     * @param string|null $house_number_ext
     * @param string|null $house_letter
     * @param string $country_code
     * @return Address|null
     */
    public function first(
        string $postal_code,
        string $house_number,
        string $house_number_ext = null,
        string $house_letter = null,
        string $country_code = 'NL'
    ): ?Address {
        return $this->check($postal_code, $house_number, $house_number_ext, $house_letter, $country_code)->first();
    }
}
