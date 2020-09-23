@extends('layout')
@section('content')
    <div class="container">
        <div style="text-align: center;padding: 40px">
        <h2>Welcome To Experts Community</h2>
        </div>
        <div class="container">
            <div class="row">
              
                @foreach ($experts as $expert)
                <div class="col-sm">
                <div class="card text-center" style="width: 18rem;">
                    
                    <img src="/avatar.jpeg" class="card-img-top" alt="Avatar">
                    <div class="card-body">
                      <h5 class="card-title">{{$expert->Name}}</h5>
                    <h6 class="card-text">{{$expert->Expert}}</h6>
                    <p class="card-text">Avaliable from <span name='timeVale'>{{$expert->WorkingHours->From->format('Y/m/d h:i A')}}</span> till <span name='timeVale'>{{$expert->WorkingHours->To->format('Y/m/d h:i A')}}</span></p>
                    <a href="/experts/{{$expert->Id}}/book" class="btn btn-primary">Book</a>
                    </div>
                </div>
                </div>
                @endforeach
              
            </div>
          </div>
        
    </div>
    
    <script>

        (function (){
            var fromTo=document.getElementsByName('timeVale');
            fromTo.forEach(element => {
                //var zone = new Date().toLocaleTimeString('en-us',{timeZoneName:'short'}).split(' ')[2];
                let utcDate = new Date(element.innerHTML+' UTC');
                //let date=new Date(element.innerHTML+' '+zone)//Intl.DateTimeFormat().resolvedOptions().timeZone);//(utcDate.getTimezoneOffset()/60));
                formated=utcDate.toLocaleString().split(',');
                element.innerHTML=formated[1];
                
            });
           
        }());
    </script>
@endsection