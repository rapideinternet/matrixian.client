<?php

namespace RapideInternet\Matrixian\Models;

use Illuminate\Support\Collection;

class WOZ {

    public ?int $house_number;
    public ?string $house_number_ext;
    public ?string $postal_code;
    public ?string $house_number_letter;
    public ?int $build_year;
    public ?string $use_purpose;
    public ?string $use_surface;
    public Collection $wozValues;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->house_number = $data['houseNumber'];
        $this->house_number_ext = $data['houseNumberExt'] ?? null;
        $this->postal_code = $data['postalCode'];
        $this->house_number_letter = $data['houseNumberLetter'] ?? null;

        // Characteristics
        if(isset($data['characteristics']) && is_array($data['characteristics'])) {
            $this->build_year = (int) $data['characteristics']['buildYear'];
            $this->use_purpose = $data['characteristics']['usePurpose'];
            $this->use_surface = $data['characteristics']['useSurface'];
        }

        // Values
        $this->wozValues = collect();
        if(isset($data['wozValue']) && is_array($data['wozValue'])) {
            foreach($data['wozValue'] as $date => $value) {
                $this->wozValues->push(new WOZValue([
                    'date' => $date,
                    'value' => $value
                ]));
            }
        }
    }

    /**
     * @return WOZValue|null
     */
    public function last(): ?WOZValue {
        return $this->wozValues->sortByDesc(function(WOZValue $woz) {
            return $woz->date->unix();
        })->first();
    }
}
