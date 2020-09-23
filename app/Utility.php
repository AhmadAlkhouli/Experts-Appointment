<?php
namespace App;
class Utility{
 public static function getPeriodMi($firstDate,$secondDate){
    $interval = $firstDate->diff($secondDate);
    $days_passed = $interval->format('%a');
    $hours_diff = $interval->format('%H');
    $minutes_diff = $interval->format('%I');
    $total_minutes = (($days_passed*24 + $hours_diff) * 60 + $minutes_diff);
    return $total_minutes;
} 
}