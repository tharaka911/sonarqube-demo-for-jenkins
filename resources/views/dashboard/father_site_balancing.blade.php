@extends('dashboard.layouts.dashboardApp')
@section('content')

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

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap" id="table1">
                            <thead class="b-text">
                                <tr>
                                    <th>P{{ __('public.round') }}</th>
                                    <th>P{{ __('public.Odd') }}</th>
                                    <th>P{{ __('public.Even') }}</th>
                                    <th>P{{ __('public.Under') }}</th>
                                    <th>N{{ __('public.Over') }}</th>
                                    <th>N{{ __('public.Odd') }}</th>
                                    <th>N{{ __('public.Even') }}</th>
                                    <th>N{{ __('public.Under') }}</th>
                                    <th>N{{ __('public.Over') }}</th>
                                    <th>{{ __('public.Small') }}</th>
                                    <th>{{ __('public.Medium') }}</th>
                                    <th>{{ __('public.Large') }}</th>
                                    <th>P{{ __('public.Odd') }}+{{ __('public.Under') }}</th>
                                    <th>P{{ __('public.Odd') }}+{{ __('public.Over') }}</th>
                                    <th>P{{ __('public.Even') }}+{{ __('public.Under') }}</th>
                                    <th>P{{ __('public.Even') }}+{{ __('public.Over') }}</th>
                                    <th>N{{ __('public.Odd') }}+{{ __('public.Under') }}</th>
                                    <th>N{{ __('public.Odd') }}+{{ __('public.Over') }}</th>
                                    <th>N{{ __('public.Even') }}+{{ __('public.Under') }}</th>
                                    <th>N{{ __('public.Even') }}+{{ __('public.Over') }}</th>
                                    <th>{{ __('public.Odd') }}+{{ __('public.Small') }}</th>
                                    <th>{{ __('public.Odd') }}+{{ __('public.Medium') }}</th>
                                    <th>{{ __('public.Odd') }}+{{ __('public.Large') }}</th>
                                    <th>{{ __('public.Even') }}+{{ __('public.Small') }}</th>
                                    <th>{{ __('public.Even') }}+{{ __('public.Medium') }}</th>
                                    <th>{{ __('public.Even') }}+{{ __('public.Large') }}</th>
                                    <th>Date</th>

                                </tr>
                            </thead>
                            <tbody class="b-text" id="table2">
                         
                                @foreach ($father_site_data as $data)
                               
                                <tr>
                                    <td>{{$data->round}}</td>
                                    <td>{{$data->pb_odd}}</td>
                                    <td>{{$data->pb_even}}</td>
                                    <td>{{$data->pb_under}}</td>
                                    <td>{{$data->pb_over}}</td>
                                    <td>{{$data->nb_odd}}</td>
                                    <td>{{$data->nb_even}}</td>
                                    <td>{{$data->nb_under}}</td>
                                    <td>{{$data->nb_over}}</td>
                                    <td>{{$data->nb_large}}</td>
                                    <td>{{$data->nb_medium}}</td>
                                    <td>{{$data->nb_small}}</td>
                                    <td>{{$data->pb_odd_under}}</td>
                                    <td>{{$data->pb_odd_over}}</td>
                                    <td>{{$data->pb_even_under}}</td>
                                    <td>{{$data->pb_even_over}}</td>
                                    <td>{{$data->nb_odd_under}}</td>
                                    <td>{{$data->nb_odd_over}}</td>
                                    <td>{{$data->nb_even_under}}</td>
                                    <td>{{$data->nb_even_over}}</td>
                                    <td>{{$data->nb_odd_small}}</td>
                                    <td>{{$data->nb_odd_medium}}</td>
                                    <td>{{$data->nb_odd_large}}</td>
                                    <td>{{$data->nb_even_small}}</td>
                                    <td>{{$data->nb_even_medium}}</td>
                                    <td>{{$data->nb_even_large}}</td>
                                    <td>{{$data->date}}</td>
                  
                                </tr>
                
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
    // function updateTable() {
    //     let type = `{{ $type }}`;
    //     let interval;

    //     if(type == "3min"){
    //         interval = 3;
    //     }
    //     if(type == "5min"){
    //         interval = 5;
    //     }

    //     $.ajax({
    //         url: `powerball/get/liveball/today?type=${interval}`,
    //         success: function(data) {

    //             // Update the table with the new data

    //             $('#table2').empty();
    //             data.data.data.sort().reverse();
    //             $.each(data.data.data, function(index, item) {
    //                 if (index>=10) return;
    //                 result=item.result.split(" ")
    //                 $('#table2').append(
    //                     '<tr>' +
    //                         '<td>' + item.round + '</td>' +
    //                         '<td>' + ((result.slice(0,5)).toString()).replaceAll(","," ") + '</td>' +
    //                         '<td>' + result[8]  + '</td>' +
    //                         '<td>' + result[5] + '</td>' +
    //                         '<td>' + item.status + '</td>' +
    //                     '</tr>'
    //                 );
    //             });
    //         }
    //     });
    // }

    //setInterval(updateTable, 5000);
</script>

@endsection



@push('scripts')

    <script src="{{asset('main/js/simple-datatables/simple-datatables.js')}}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

@endpush



