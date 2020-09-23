<?php

namespace App;

    use Carbon\Carbon;
    use DateTimeZone;
    use DateInterval;
    use App\Utility;
    use Ramsey\Uuid\Type\Time;
    use SebastianBergmann\Environment\Console;

class Expert{
    
    
    static function schedule($appointmentType,$start,$end){

        //Sheduale time slots between tow time 

        $appointment=AppointmentType::get($appointmentType);
        $sch=[];
        $index=0;
       
        $clearinterval=new DateInterval('PT'.'15'.'M');
        $period=new DateInterval('PT' . $appointment . 'M');
        for ($iStart=clone $start;$iStart<$end;$iStart->add($clearinterval)){
            $from=clone $iStart;
            $to= (clone $iStart)->add($period);
            if ($iStart>$end) 
                break;
            array_push($sch,(['From'=>  $from,'To'=>$to ]));
        }
        return $sch;
    }
    static function getAvalaible($id,$appointmentType,$date){

        // Get avalable time slots that could be booked by client

        $schedule=[];
        $count=0;
        $expert=Expert::get($id);
        $date->setTimezone('UTC');

        $start=$expert->WorkingHours->From->setTimezone('UTC');
        $end=$expert->WorkingHours->To->setTimezone('UTC');

        $books=Book::where([['expert_id',$id],['appointment_date','>=',$date->format('Y-m-d')]])->orderBy('from_time')->get();
        
        $count=count($books);
        if ($count==0) {
            return Expert::schedule($appointmentType,$start,$end);
        }
        
        $t=new DateInterval('PT15M');
        $t->invert=1;
        $b=new DateInterval('PT15M');
       
           if (Utility::getPeriodMi($start,(clone $books[0]->from_time)->add($t))>$appointmentType){
        $avalable=Expert::schedule($appointmentType,$start,clone($books[0]->from_time)->add($t));
        $schedule=array_merge($schedule,$avalable);
           }

        for($i=0;$i<($count-1);$i++){
            $startfrom=(clone $books[$i]->to_time)->add($b);
            $endto=(clone $books[$i+1]->from_time)->add($t);
            if ((Utility::getPeriodMi($startfrom,$endto))<$appointmentType)
            continue;
            $avalable=Expert::schedule($appointmentType,$startfrom,$endto);
            $schedule=array_merge($schedule,$avalable);
        }
        
        $avalable=Expert::schedule($appointmentType,clone($books[$count-1]->to_time)->add($b), $end);
        $schedule=array_merge($schedule,$avalable);

        return $schedule;
    }

    static function all(){

        // This function return experts list

        $experts=(Object)[
            (object)['Id'=>1,
            'Name'=>'Ahmad Ali',
            'Expert'=>'Doctor',
            'WorkingHours'=>(object)['From'=>Carbon::createFromFormat('H:i','08:00',new DateTimeZone('NZST')),
                            'To'=>Carbon::createFromFormat('H:i','18:00',new DateTimeZone('NZST'))],
            'Country'=>'New Zealand'
            ],

            (object)['Id'=>2,
            'Name'=>'Nezar Ahmad',
            'Expert'=>'Civil Engineer',
            'WorkingHours'=>(object)['From'=>Carbon::createFromFormat('H:i','05:00',new DateTimeZone('+3')),
                            'To'=>Carbon::createFromFormat('H:i','12:00',new DateTimeZone('+3'))],
            'Country'=>'Syria'
            ],

            (object)['Id'=>3,
            'Name'=>'Hoda Ahmad',
            'Expert'=>'Computer Engineer',
            'WorkingHours'=>(object)['From'=>Carbon::createFromFormat('H:i','15:00',new DateTimeZone('EET')),
                            'To'=>Carbon::createFromFormat('H:i','16:00',new DateTimeZone('EET'))],
            'Country'=>'Egypt'
            ],
       ];
        return $experts;
    }
    static function get($id){

      // return Expert by Id

        foreach(Expert::all() as $expert) {
            if ($id == $expert->Id) {
                $item = $expert;
                break;
            }
        }
        return $item;
    }
   
}