<?php

namespace App\Enums;

use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class NumberOfEmployees{
    private $List=[
        1=>__('From 1 to 10'),
        2=>__('From 11 to 49'),
        3=>__('From 50 to 99'),
        4=>__('From 100 to 499'),
        5=>__('From 499 to 1000'),
        6=>__('More than 1000'),
    ];
    public function getList(){
        return $this->List;
    }
    public function getName($case){
        return $this->List[$case];
    }
}
