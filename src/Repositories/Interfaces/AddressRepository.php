<?php

namespace RapideInternet\Matrixian\Repositories\Interfaces;

use Illuminate\Support\Collection;
use RapideInternet\Matrixian\Models\Implementation\Address;

interface AddressRepository {

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
    ): Collection;

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
    ): ?Address;
}
