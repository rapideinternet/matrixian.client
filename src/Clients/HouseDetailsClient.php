<?php

namespace RapideInternet\Matrixian\Clients;

use RapideInternet\Matrixian\Response;

class HouseDetailsClient extends AbstractClient {

    /**
     * @param string $postal_code
     * @param string $house_number
     * @param string|null $house_number_ext
     * @param string|null $house_letter
     * @return Response
     */
    public function find(
        string $postal_code,
        string $house_number,
        ?string $house_number_ext = null,
        ?string $house_letter = null
    ): Response {
        $parameters = ['postalCode' => $postal_code, 'houseNumber' => $house_number];
        if(!empty($house_letter)) {
            $parameters['houseLetter'] = $house_letter;
        }
        if(!empty($house_number_ext)) {
            $parameters['houseNumberExt'] = $house_number_ext;
        }
        return $this->matrixian->get('/mx-house-details', $parameters);
    }
}
