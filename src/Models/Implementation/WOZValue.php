<?php

namespace RapideInternet\Matrixian\Models\Implementation;

use Carbon\Carbon;
use RapideInternet\Matrixian\Models\Interfaces;

class WOZValue implements Interfaces\WOZValue {

    public ?Carbon $date;
    public ?float $value;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->date = new Carbon($data['date']);
        $this->value = (float) $data['value'];
    }
}
