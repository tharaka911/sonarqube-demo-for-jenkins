@extends('dashboard.layouts.dashboardApp')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <p class="d-flex justify-content-center ft-text align-items-center">{{ __('public.Father Site Betting Result') }} - {{ $type }}</p>
            </div>
            <!-- /.card-header -->

            <!-- /.card-body -->
        </div>
        <div class="row" style="margin-bottom:10px">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <p class="ft-text-sm">{{ __('public.power ball') }}(X1.95)</p>
                    <div class="card-tools float-right">
                        <!-- <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Sync
                        </button> -->
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered text-nowrap" id="">

                            <tbody>
                                <tr>
                                    <td>{{ __('public.Odd') }}</td>
                                    <td id="pb_odd" ></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Even') }}</td>
                                    <td id="pb_even" ></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Under') }}</td>
                                    <td id="pb_under" ></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Over') }}</td>
                                    <td id="pb_over" ></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <p class="ft-text-sm">{{ __('public.normal ball') }}(X1.95)</p>
                    <div class="card-tools float-right">
                        <!-- <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Sync
                        </button> -->
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered text-nowrap" id="">
                            <tbody>
                                <tr>
                                    <td>{{ __('public.Odd') }}</td>
                                    <td id="nb_odd"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Even') }}</td>
                                    <td id="nb_even"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Under') }}</td>
                                    <td id="nb_under"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Over') }}</td>
                                    <td id="nb_over"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <p class="ft-text-sm">{{ __('public.normal ball') }}(X2.4)</p>
                    <div class="card-tools float-right">
                        <!-- <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Sync
                        </button> -->
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered text-nowrap" id="">
                            <tbody>
                                <tr>
                                    <td>{{ __('public.Small') }}</td>
                                    <td id="nb_small"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Medium') }}</td>
                                    <td id="nb_medium"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Large') }}</td>
                                    <td id="nb_large"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <p class="ft-text-sm">{{ __('public.power ball') }} {{ __('public.combination') }}</p>
                    <div class="card-tools float-right">
                        <!-- <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Sync
                        </button> -->
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered text-nowrap" id="">
                            <tbody>

                                <tr>
                                    <td>{{ __('public.Odd') }}+{{ __('public.Under') }}</td>
                                    <td id="pb_odd_under"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Odd') }}+{{ __('public.Over') }}</td>
                                    <td id="pb_odd_over"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Even') }}+{{ __('public.Under') }}</td>
                                    <td id="pb_even_under"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('public.Even') }}+{{ __('public.Over') }}</td>
                                    <td id="pb_even_over"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <p class="ft-text-sm">{{ __('public.normal ball') }} {{ __('public.combination') }}(X3.7)</p>
                    <div class="card-tools float-right">
                        <!-- <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Sync
                        </button> -->
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered text-nowrap" id="">
                            <tbody>

                                <tr>
                                    <td>{{ __('public.Odd') }}+{{ __('public.Under') }}</td>
                                    <td id="nb_odd_under"></td>
                                </tr>

                                <tr>
                                    <td>{{ __('public.Odd') }}+{{ __('public.Over') }}</td>
                                    <td id="nb_odd_over"></td>
                                </tr>

                                <tr>
                                    <td>{{ __('public.Even') }}+{{ __('public.Under') }}</td>
                                    <td id="nb_even_under"></td>
                                </tr>

                                <tr>
                                    <td>{{ __('public.Even') }}+{{ __('public.Over') }}</td>
                                    <td id="nb_even_over"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <p class="ft-text-sm">{{ __('public.normal ball') }} {{ __('public.Small') }}/{{ __('public.Medium') }}/{{ __('public.Large') }} {{ __('public.combination') }}</p>
                    <div class="card-tools float-right">
                        <!-- <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Sync
                        </button> -->
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered text-nowrap" id="">
                            <tbody>

                                <tr>
                                    <td>{{ __('public.Odd') }}+{{ __('public.Small') }}</td>
                                    <td id="nb_odd_small"></td>
                                </tr>

                                <tr>
                                    <td>{{ __('public.Odd') }}+{{ __('public.Medium') }}</td>
                                    <td id="nb_odd_medium"></td>
                                </tr>

                                <tr>
                                    <td>{{ __('public.Odd') }}+{{ __('public.Large') }}</td>
                                    <td id="nb_odd_large"></td>
                                </tr>

                                <tr>
                                    <td>{{ __('public.Even') }}+{{ __('public.Small') }}</td>
                                    <td id="nb_even_small"></td>
                                </tr>

                                <tr>
                                    <td>{{ __('public.Even') }}+{{ __('public.Medium') }}</td>
                                    <td id="nb_even_medium"></td>
                                </tr>

                                <tr>
                                    <td>{{ __('public.Even') }}+{{ __('public.Large') }}</td>
                                    <td id="nb_even_large"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            {{-- <div class="col">
                <div class="card">
                    <div class="card-header">
                        <p class="ft-text">{{ __('public.Ladder Game') }}</p>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered text-nowrap" id="">

                    <tbody>
                        <tr>
                            <td>{{ __('public.Left') }}</td>
                            <td>100,000 KRW</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{ __('public.Right') }}</td>
                            <td>100,000 KRW</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{ __('public.3 Line') }}</td>
                            <td>100,000 KRW</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{ __('public.4 Line') }}</td>
                            <td>100,000 KRW</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{ __('public.Odd') }}</td>
                            <td>100,000 KRW</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{ __('public.Even') }}</td>
                            <td>100,000 KRW</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row mb-2">
            <div class="col-sm-8">
                <!-- <h1 class="m-0"> Balancing</h1> -->
                <a class="button-17 @if($balancing->status == 1 && $balancing->balancing_type == "single") active @endif" href="{{ url('/balancing/update/single').'/'.$balancing->stream_type }}">{{ __('public.Single Balancing') }} </a>
                <a class="button-17 @if($balancing->status == 1 && $balancing->balancing_type == "combine") active @endif" href="{{ url('/balancing/update/combine').'/'.$balancing->stream_type  }}">{{ __('public.Combine Balancing') }}</a>
                <a class="button-17 @if($balancing->status == 1 && $balancing->balancing_type == "single_unbalance") active @endif" href="{{ url('/balancing/update/single_unbalance').'/'.$balancing->stream_type }}">{{ __('public.Single UnBalancing') }} </a>
                <a class="button-17 @if($balancing->status == 1 && $balancing->balancing_type == "combine_unbalance") active @endif" href="{{ url('/balancing/update/combine_unbalance').'/'.$balancing->stream_type  }}">{{ __('public.Combine UnBalancing') }}</a>
            </div><!-- /.col -->
            <div class="col-sm-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center d-picker">
                    <div style="margin-right:15px">
                        <a class="button-17 @if($balancing->status == 1 && $balancing->balancing_type == "normal") active @endif" style="margin-left:20px" href="{{ url('/balancing/update/normal').'/'.$balancing->stream_type  }}">{{ __('public.Normal') }}</a>
                    </div>
                </div>
                <div>
                    <form role="form" method="POST" action="{{ url('/balancing/result/filter') }}">
                        {{ csrf_field() }}
                    <ol class="breadcrumb float-sm-right">
                        <div class="d-flex d-picker-sub">
                            <input type="date" value="{{$date}}" name="date">
                            <input type="text" hidden value="{{$type}}" name="type">
                        </div>
                        <div>
                            <button class="button-17" type="submit" style="margin-left:5px;min-height:10px !important;  !important;background-color:#343a40 !important;color:#fff;">Search <i class="fa fa-search" style="margin-left:5px;color:#fff;" aria-hidden="true"></i></button>
                        </div>
                    {{-- <li class="breadcrumb-item"><a href="#">{{ __('public.home') }}</a></li>
                    <li class="breadcrumb-item active" Style=" text-transform: capitalize;">{{ __('public.Balancing') }}</li> --}}
                    </ol>
                    <form>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Alert Section -->
@if (session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

    {{ session('success') }}
</div>
@endif

@if (session('delete'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

    {{ session('delete') }}
</div>
@endif

@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <p class="d-flex justify-content-center ft-text align-items-center">
                            @if($balancing->status == 1 && $balancing->balancing_type == "single")
                            {{ __('public.Single Balancing') }}
                            @endif
                            @if($balancing->status == 1 && $balancing->balancing_type == "combine")
                            {{ __('public.Combine Balancing') }}
                            @endif
                            @if($balancing->status == 1 && $balancing->balancing_type == "normal")
                            {{ __('public.Normal balancing') }}
                            @endif
                        </p>
                    <div class="card-tools float-right">
                        <!-- <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Sync
                        </button> -->
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap" id="table1">
                            <thead class="b-text">
                                <tr>
                                    <th>{{ __('public.round') }}</th>
                                    <th>{{ __('public.normal ball') }}</th>
                                    <th>{{ __('public.powerball') }}</th>
                                    <th>{{ __('public.sum') }}</th>
                                    <th>{{ __('public.Status') }}</th>
                                    {{-- <th>ODD/EVEN</th>
                                    <th>UNDER/OVER</th>
                                    <th>Small/Middle/Large</th>
                                    <th>ODD/EVEN</th>
                                    <th>UNDER/OVER</th>
                                    <th>powerball</th> --}}

                                </tr>
                            </thead>
                            <tbody class="b-text" id="table2">
                                <?php $i =1; ?>
                                <?php $reverse = array_reverse($liveball_results,true) ?>
                                @foreach ($reverse as $data)
                                <?php $result = explode(" ", $data['result']); ?>
                                <tr>
                                    <td>{{$data['round']}}</td>
                                    <td>{{$result[0]}} {{$result[1]}} {{$result[2]}} {{$result[3]}} {{$result[4]}}</td>
                                    <td>{{$result[8]}}</td>
                                    <td>{{$result[5]}}</td>
                                    <td>{{$data['status']}}</td>
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function updateTable() {
        let type = `{{ $type }}`;
        let interval;

        if(type == "3min"){
            interval = 3;
        }
        if(type == "5min"){
            interval = 5;
        }

        $.ajax({
            url: `{{ $winnerAPI }}powerball/get/liveball/today?type=${interval}`,
            success: function(data) {

                // Update the table with the new data

                $('#table2').empty();
                data.data.data.sort().reverse();
                $.each(data.data.data, function(index, item) {
                    if (index>=10) return;
                    result=item.result.split(" ")
                    $('#table2').append(
                        '<tr>' +
                            '<td>' + item.round + '</td>' +
                            '<td>' + ((result.slice(0,5)).toString()).replaceAll(","," ") + '</td>' +
                            '<td>' + result[8]  + '</td>' +
                            '<td>' + result[5] + '</td>' +
                            '<td>' + item.status + '</td>' +
                        '</tr>'
                    );
                });
            }
        });
    }

    setInterval(updateTable, 5000);
</script>

@endsection



@push('scripts')

    <script>

        window.onload = function() {
        var type = "{{$type}}"
        let url = location.origin+'/balancing_data/'+type

        fetch(url).then(response => response);

        //Pusher.logToConsole = true;

        var pusher = new Pusher('d6d3a84179fd4e757f7c', {
        cluster: 'ap2'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
        var msg = data.message

        if(msg.type == type){

            document.getElementById("pb_odd").innerHTML = msg.pb_odd === null ? 0 : msg.pb_odd
            document.getElementById("pb_even").innerHTML = msg.pb_even === null ? 0 : msg.pb_even
            document.getElementById("pb_under").innerHTML = msg.pb_under === null ? 0 : msg.pb_under
            document.getElementById("pb_over").innerHTML = msg.pb_over === null ? 0 : msg.pb_over

            document.getElementById("nb_odd").innerHTML = msg.nb_odd === null ? 0 : msg.nb_odd
            document.getElementById("nb_even").innerHTML = msg.nb_even === null ? 0 : msg.nb_even
            document.getElementById("nb_under").innerHTML = msg.nb_under === null ? 0 : msg.nb_under
            document.getElementById("nb_over").innerHTML = msg.nb_over === null ? 0 : msg.nb_over

            document.getElementById("nb_small").innerHTML = msg.nb_small === null ? 0 : msg.nb_small
            document.getElementById("nb_medium").innerHTML = msg.nb_medium === null ? 0 : msg.nb_medium
            document.getElementById("nb_large").innerHTML = msg.nb_large === null ? 0 : msg.nb_large

            document.getElementById("pb_odd_under").innerHTML = msg.pb_odd_under === null ? 0 : msg.pb_odd_under
            document.getElementById("pb_odd_over").innerHTML = msg.pb_odd_over === null ? 0 : msg.pb_odd_over
            document.getElementById("pb_even_under").innerHTML = msg.pb_even_under === null ? 0 : msg.pb_even_under
            document.getElementById("pb_even_over").innerHTML = msg.pb_even_over === null ? 0 : msg.pb_even_over

            document.getElementById("nb_odd_under").innerHTML = msg.nb_odd_under === null ? 0 : msg.nb_odd_under
            document.getElementById("nb_odd_over").innerHTML = msg.nb_odd_over === null ? 0 : msg.nb_odd_over
            document.getElementById("nb_even_under").innerHTML = msg.nb_even_under === null ? 0 : msg.nb_even_under
            document.getElementById("nb_even_over").innerHTML = msg.nb_even_over === null ? 0 : msg.nb_even_over

            document.getElementById("nb_odd_small").innerHTML = msg.nb_odd_small === null ? 0 : msg.nb_odd_small
            document.getElementById("nb_odd_medium").innerHTML = msg.nb_odd_medium === null ? 0 : msg.nb_odd_medium
            document.getElementById("nb_odd_large").innerHTML = msg.nb_odd_large === null ? 0 : msg.nb_odd_large
            document.getElementById("nb_even_small").innerHTML = msg.nb_even_small === null ? 0 : msg.nb_even_small
            document.getElementById("nb_even_medium").innerHTML = msg.nb_even_medium === null ? 0 : msg.nb_even_medium
            document.getElementById("nb_even_large").innerHTML = msg.nb_even_large === null ? 0 : msg.nb_even_large
        }

        });
        };


    </script>

    <script src="{{asset('main/js/simple-datatables/simple-datatables.js')}}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

@endpush



