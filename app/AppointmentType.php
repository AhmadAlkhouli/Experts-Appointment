<?php
namespace App;

use Exception;

abstract class AppointmentType {
    const m15=15;
    const m30=30;
    const m45=45;
    const h1=60;

    public static function get($value){
        switch ($value){
            case 'm15':
                return AppointmentType::m15;
            case 'm30':
                return AppointmentType::m30;
            case 'm45':
                return AppointmentType::m45;
            case 'h1':
                return AppointmentType::h1;
            default:
            throw new Exception("Not Valide Value");
            break;
        }
    } 

}