<?php

namespace RapideInternet\Matrixian\Models;

class HouseDetails {

    public ?int $house_number;
    public ?string $house_number_ext;
    public string $postal_code;
    public ?string $house_letter;
    public ?int $living_surface;
    public ?int $other_indoor_space;
    public ?int $use_surface;
    public ?int $parcel_surface;
    public string $object_type;
    public int $build_year;
    public string $energy_label;
    public ?string $description;
    public ?int $number_of_bathrooms;
    public ?int $number_of_bedrooms;
    public ?int $number_of_rooms;
    public ?int $number_of_toilets;
    public ?int $external_storage_space;
    public ?int $attached_outdoor_space;
    public ?int $volume;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->house_number = $data['houseNumber'];
        $this->house_number_ext = $data['houseNumberExt'];
        $this->postal_code = $data['postalCode'];
        $this->house_letter = $data['houseLetter'];
        $this->living_surface = $data['livingSurface'];
        $this->other_indoor_space = $data['otherIndoorSpace'];
        $this->use_surface = $data['useSurface'];
        $this->parcel_surface = $data['parcelSurface'];
        $this->object_type = $data['objectType'];
        $this->build_year = $data['buildYear'];
        $this->energy_label = $data['energyLabel'];
        $this->description = $data['description'];
        $this->number_of_bathrooms = $data['numberOfBathrooms'];
        $this->number_of_bedrooms = $data['numberOfBedrooms'];
        $this->number_of_rooms = $data['numberOfRooms'];
        $this->number_of_toilets = $data['numberOfToilets'];
        $this->external_storage_space = $data['externalStorageSpace'];
        $this->attached_outdoor_space = $data['attachedOutdoorSpace'];
        $this->volume = $data['volume'];
    }
}
