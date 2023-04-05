<?php

namespace RapideInternet\Matrixian\Clients;

use RapideInternet\Matrixian\Response;

class AddressClient extends AbstractClient {

    /**
     * @param string $country_code
     * @param string $postal_code
     * @param string $house_number
     * @param string|null $house_number_ext
     * @param string|null $house_letter
     * @return Response
     */
    public function check(
        string $country_code,
        string $postal_code,
        string $house_number,
        string $house_number_ext = null,
        string $house_letter = null
    ): Response {
        $parameters = ['countryCode' => $country_code, 'postalCode' => $postal_code, 'houseNumber' => $house_number];
        if(!empty($house_letter)) {
            $parameters['houseNumberExt'] = $house_letter;
        }
        if(!empty($house_number_ext)) {
            $parameters['houseNumberExt'] = $house_number_ext;
        }
        return $this->matrixian->get('/address/check', $parameters);
    }
}
