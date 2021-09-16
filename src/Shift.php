<?php

namespace src;

require './../vendor/autoload.php';

class Shift
{
    public function getShiftIds()
    {
        $shifts = [
            'Shipping_Steve_A7',
            'Sales_B9',
            'Support_Tara_K11',
            'J15',
            'Warehouse_B2',
            'Shipping_Dave_A6',
        ];

        return collect($shifts)->map(function ($shift) {
            return collect(explode('_', $shift))->last();
        });
    }
}

$shift = new Shift();

var_dump($shift->getShiftIds());
