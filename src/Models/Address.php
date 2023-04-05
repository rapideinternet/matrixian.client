<?php

namespace RapideInternet\Matrixian\Models;

class Address implements \RapideInternet\Matrixian\Interfaces\Address {

    public ?string $country_name;
    public ?string $state;
    public ?string $city;
    public ?string $street;
    public ?string $house_number;
    public ?string $house_number_ext;
    public ?string $postal_code;
    public ?string $company_name;
    public ?string $country_iso_2;
    public ?string $country_iso_3;
    public ?string $locality;
    public ?string $building_name;
    public ?float $latitude;
    public ?float $longitude;
    public ?string $mailbox;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->country_name = $data['countryName'] ?? null;
        $this->state = $data['state'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->street = $data['street'] ?? null;
        $this->house_number = $data['houseNumber'] ?? null;
        $this->house_number_ext = $data['houseNumberExt'] ?? null;
        $this->postal_code = $data['postalCode'] ?? null;
        $this->company_name = $data['companyName'] ?? null;
        $this->country_iso_2 = $data['countryIso2'] ?? null;
        $this->country_iso_3 = $data['countryIso3'] ?? null;
        $this->locality = $data['locality'] ?? null;
        $this->building_name = $data['buildingName'] ?? null;
        $this->latitude = $data['latitude'] ?? null;
        $this->longitude = $data['longitude'] ?? null;
        $this->mailbox = $data['mailbox'] ?? null;
    }
}
