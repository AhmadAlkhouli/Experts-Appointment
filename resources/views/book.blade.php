@extends('layout')
@section('content')

<div class="container text-center">
    <div class="card" style="width: 30rem;">
                    
        <img src="/avatar.jpeg" class="card-img-top" alt="Avatar">
        <div class="card-body">
          <h5 class="card-title">{{$expert->Name}}</h5>
        <h6 class="card-text">{{$expert->Expert}}</h6>
        <p class="card-text">

            <div id="app">

            <input ref="expid" type="hidden"  value="{{$expert->Id}}"/>
            <h6 class="card-text">User <input type="text" v-model="user"></h6>
            <h6 class="card-text">Period 
                <select id="appointmentDate" type="date" v-model="input.appointmentType">
                <option value="m15">15 Minutes</option>
                <option value="m30">30 Minutes</option>
                <option value="m45">45 Minutes</option>
                <option value="h1">Hour</option>
                </select>
            </h6>
            <h6 class="card-text">Date <input id="appointmentDate" type="date" v-model="input.date" v-on:change="getSchedule()"/></h6>
            <h6><select class="card-text"  v-model="slot">
                <option v-model="slots" v-for="slot in slots" :value="slot" >@{{dateFormat(slot.From)}}--->@{{dateFormat(slot.To)}}</option>
                </select>
            </h6>
            <button class="btn btn-primary" v-on:click="invoke">Book</button>
            </div>

        </p>
         
        </div>
    </div>
</div>

   <!-- production version, optimized for size and speed -->
   <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    
   <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    

var app =new Vue({
    el:"#app",
   data:{
    input: {date:'',appointmentType:null},
      message:"hello vue",
      slots:[],
      slot:null,
      user:'',
   },
   methods: {
        getSchedule : function(){
            var that=this;
            var host = window.location.hostname;
            var id=this.$refs["expid"].value;
            console.log(this.input);
            axios.post("/api/experts/"+id+"/schedule",this.input).then( function(response){
            
            that.slots=response.data;
            console.log(that.slots);
        });
       },
      invoke : function(){
         console.log("in function 'invoke'");
         var host = window.location.hostname;
        
         var id=this.$refs["expid"].value;
        
         var para={"appointment_type":this.input.appointmentType,
         "appointment_date":this.input.date,
         "from_time":this.slot.From,
         "to_time":this.slot.To,
         "user":this.user,
         "expert_id":id
         };
         console.log(para);
         axios.post("/api/books",para).then( function(response){
            console.log("in response-function");
            console.log(response.data);
        });
    },
    dateFormat(date){
        //formated=utcDate.toLocaleString().split(',');
        //element.innerHTML=formated[1];
        d=new Date(date);
        return d.toLocaleString();
    },
   }
});

</script>
@endsection


