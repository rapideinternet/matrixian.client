<?php

namespace RapideInternet\Matrixian\Models;

use Carbon\Carbon;

class WOZValue implements \RapideInternet\Matrixian\Interfaces\WOZValue {

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
