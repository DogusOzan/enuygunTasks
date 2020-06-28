



<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enuygun</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>
<body>


<div id="accordion">
    @foreach($taskfordevelopers as $key => $taskfordeveloper)
    <div class="card">
        <div class="card-header" id="headingThree">
            <h5 class="mb-1">
                <button class="btn btn-link w-100  collapsed" data-toggle="collapse" data-target="#{{$taskfordeveloper['name']}}" aria-expanded="false" aria-controls="collapseThree">
                    <div class="bg-light  text-dark">
                        <h5>{{$taskfordeveloper['name']}}</h5>
                        Seviyesi:{{ $taskfordeveloper['level'] }}
                        Çalışma Saati:{{ $taskfordeveloper['time'] }}
                    </div>
                </button>
            </h5>
        </div>
        <div id="{{$taskfordeveloper['name']}}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <div class="row">
                    @foreach($taskfordeveloper['weekly'] as $keyx => $value)
                        <div class="col-sm">
                            <h5 class="text-dark text-center">{{ $keyx  + 1 }}. Hafta</h5>
                            @foreach($value['tasks'] as $keyy => $tasks)
                                @if(isset($tasks['level']))
                                    <div class="card col-md-12 my-3 p-2 bg-light">
                                        <h5 class="card-title  text-center"> {{$tasks['task_id']}}</h5>
                                        <div class="card-body ">
                                            <hr class="m-1">
                                            <div class="text-center">

                                                <span class="col-sm-6 p-0 m-0 text-center">Zorluk: {{$tasks['level']}}</span></br>
                                                <span class="col-sm-6 p-0 m-0 text-center">Süre: {{$tasks['time']}}</span>


                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link w-100 " data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                       Tüm Tasklerin Toplam Tamamlanma Süresi =>  {{$finish}} Hafta
                    </button>
                </h5>
            </div>
        </div>

</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>





{{--

Çalışma Alanı

@foreach($taskfordevelopers as $key => $taskfordeveloper)
    <div>{{$taskfordeveloper['name']}}</div>
    @foreach($taskfordeveloper['weekly'] as $keyx => $value)
        <div>{{$keyx+1}} - Hafta</div>
        @foreach($value['tasks'] as $keyy => $tasks)
            <div>{{$tasks['task_id']}}---{{$tasks['level']}}---{{$tasks['time']}}</div>
        @endforeach
        <div>-----------------------------</div>
    @endforeach
    <div>-----------------------------</div>
    @endforeach--}}

{{--
@foreach($developerList as $key => $value )
    <div>{{$value['name']}}</div>
    @foreach($taskfordevelopers as $keyx => $valuex)


            @foreach($valuex as $keyy => $valuey)

                @if($keyx==$value['level'])

                    <div>{{$valuey['level']}} --- {{$valuey['time']}} --- {{$valuey['task_id']}} </div>
                @endif
            @endforeach


        @endforeach
    @endforeach
--}}



{{--
@foreach($developerList as $key => $value )
    <div>{{$value['name']}}</div>
    @foreach($taskfordevelopers as $keyx => $valuex)
        @foreach($valuex['tasks'] as $keyy => $valuey)
            @if($valuey['level']==$value['level'])
                <div>{{$valuey['level']}} --- {{$valuey['time']}} --- {{$valuey['task_id']}}- </div>
            @endif
        @endforeach
    @endforeach
@endforeach--}}
