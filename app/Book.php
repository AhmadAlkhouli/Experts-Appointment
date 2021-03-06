<?php

namespace App;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Database\Eloquent\Model;
use Exception;


class Book extends Model
{

    protected $fillable=['expert_id','user','appointment_type','appointment_date','from_time','to_time'];
    protected $dates = [
        'appointment_date','from_time','to_time'
    ];

    static function isAvalable($expert,$from,$to){

        // this function called when booking appointment to insure timeslot avalibilty 

        $expert->WorkingHours->From->setTimezone('UTC');
        $expert->WorkingHours->To->setTimezone('UTC');

       
        $timefrom=$expert->WorkingHours->From;
        $timeto=$expert->WorkingHours->To;

       $offday=$from->day-$timefrom->day;
            $timefrom->add($offday.' days');
            $timeto->add($offday.' days');

        if ($from<$timefrom){
            
            return false;
        }
        if ($to>$timeto){
           
            return false;
        }
        $books=Book::where('appointment_date','=',$from->format('Y-m-d'))->
        where('appointment_date','=',$to->format('Y-m-d'))->orderby('from_time')->get();
        
        foreach($books as $book){
            if (($from<$book->from_time && $to<$book->from_time)||
            ($from>$book->to_time && $to>$book->to_time ))
            {
                return true;
            }else
            {
                return false;
            }
        }
        return true;
    }
    static function valaidte($expertId,$from,$to){

        // Booking validation
        
        $expert=Expert::get($expertId);
        $msg="Invalid Time; minutes should be 0,15,30,45";
        if ($from->format('i')%15>0||$to->format('i')%15>0){
        throw new Exception($msg);
        }
        if (!Book::isAvalable($expert,$from,$to))
        throw new Exception("This time is bokked".$from->format('Y-m-d H:i').' | '.$expert->WorkingHours->From->setTimezone('UTC')->format('Y-m-d H:i'));
    }
    
}
