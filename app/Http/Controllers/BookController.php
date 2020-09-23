<?php

namespace App\Http\Controllers;

use App\Book;
use App\Expert;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Y-m-d\TH:i:s\Z
        // old Y-m-d H:i O
        $fromTime=Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z',$request['from_time']);
        $fromTime->setTimezone('UTC');

        $toTime=Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z',$request['to_time']);
        $toTime->setTimezone('UTC');
        
        $appointmentDate=Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z',$request['from_time']);
        $appointmentDate->setTimezone('UTC');
        
        $appointmentType=$request['appointment_type'];
        $userId=$request['user'];
        $expert=Expert::get($request['expert_id']);

        Book::valaidte($expert->Id,$fromTime,$toTime);

        Book::create(['from_time'=>$fromTime,
        'to_time'=>$toTime,
        'appointment_type'=>$appointmentType,
        'appointment_date'=>$appointmentDate,
        'user'=>$userId,
        'expert_id'=>$expert->Id
        ]);
        

        

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
    public function getBooks($id){
        return Book::where('expert_id',$id)->get();
    }
}
