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
        
       // $expert->WorkingHours->From->setDate('Y-m-d',$from->format('Y-m-d'),$from->tz);
       
        //$expert->WorkingHours->To->setDate('Y-m-d',$to->format('Y-m-d'),$to->tz);
        
        //$timefrom=Carbon::create($from->year,$from->month,$from->day,$timef->format('H'),$timef->minute,0,null);
        //$timefrom->setTime('H:i',$expert->WorkingHours->From->format('H:i'));
        //$timeto=Carbon::create($to->year,$to->month,$to->day,$timet->format('H'),$timet->minute,0,null);
        

    
       /*if ($timefrom>$timeto){
        $timefrom->addHours(12);
        $timeto->addHours(12);
       }*/

        if ($from<$timefrom){
            
            return false;
        }
        if ($to>$timeto){
            throw new Exception('okkkkkkkkkkkkkkk'.$timeto->format('Y-m-d H:i'));
            return false;
        }
        $books=Book::where('appointment_date','>=',$timefrom->format('Y-m-d'))->get();
        
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
