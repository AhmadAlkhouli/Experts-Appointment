<?php

namespace App\Http\Controllers;

use App\Expert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use Facade\FlareClient\View;
use Illuminate\Support\Arr;
class ExpertsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experts=Expert::all();
        foreach($experts as $expert){
            $expert->WorkingHours->From->setTimezone('UTC');
            $expert->WorkingHours->To->setTimezone('UTC');
        }   
        return View('index',compact('experts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Expert::get($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getSchedule(Request $request,$id){
        $appointmentType=$request->appointmentType;
        $date=$request->date;
        $date=Carbon::createFromFormat('Y-m-d',$date);
       return  Expert::getAvalaible($id,$appointmentType,$date);
    }
    public function book($id){
        $expert =Expert::get($id);
        return View('book',compact('expert'));
    }
}
