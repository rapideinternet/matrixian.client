<?php

namespace RapideInternet\Matrixian\Repositories;

use Illuminate\Support\Collection;
use RapideInternet\Matrixian\Models\Address;

class AddressRepository extends AbstractRepository {

    /**
     * @param string $country_code
     * @param string|null $postal_code
     * @param string|null $house_number
     * @param string|null $house_number_ext
     * @param string|null $house_letter
     * @return Collection
     */
    public function check(
        string $country_code = 'NL',
        ?string $postal_code = null,
        ?string $house_number = null,
        ?string $house_number_ext = null,
        ?string $house_letter = null
    ): Collection {
        if(empty($postal_code) || empty($house_number)) {
            return collect();
        }

        /** @var $response */
        $response = $this->matrixian->address->check($country_code, $postal_code, $house_number, $house_number_ext, $house_letter);
        return $response->isValid() ? collect($response->getData())->map(function($data) {
            return new Address($data);
        }) : collect();
    }

    /**
     * @param string $country_code
     * @param string|null $postal_code
     * @param string|null $house_number
     * @param string|null $house_number_ext
     * @param string|null $house_letter
     * @return Address|null
     */
    public function first(
        string $country_code = 'NL',
        ?string $postal_code = null,
        ?string $house_number = null,
        ?string $house_number_ext = null,
        ?string $house_letter = null
    ): ?Address {
        return $this->check($country_code, $postal_code, $house_number, $house_number_ext, $house_letter)->first();
    }
}
