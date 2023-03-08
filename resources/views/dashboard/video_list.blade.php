@extends('dashboard.layouts.dashboardApp')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{$type}} {{ __('public.Minutes Type') }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ __('public.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('public.Video Type') }}</li>
                </ol>
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
                    <div class="card-tools float-right">
                        <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    {{ __('public.sync') }}
                        </button>
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead class="v-text">
                                <tr>

                                    <th>{{ __('public.Video ID') }}</th>
                                    <th>{{ __('public.Usage') }}</th>
                                    <th>{{ __('public.Video Result') }}</th>
                                    <th>{{ __('public.URL') }}</th>
                                    <th>{{ __('public.Action') }}</th>
                                    {{-- <th>Video URL</th> --}}
                                    {{-- <th>Date</th> --}}
                                </tr>
                            </thead>
                            <tbody class="v-text">
                                <?php $i =1; ?>
                                @foreach ($videoList as $data)
                                <?php $result = explode(" ", $data->result); ?>
                                <tr id="">
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->count}}</td>
                                    <td class="vtd">
                                        <div class="vresult"> {{$result[0]}}</div>
                                        <div class="vresult"> {{$result[1]}}</div>
                                        <div class="vresult"> {{$result[2]}}</div>
                                        <div class="vresult"> {{$result[3]}}</div>
                                        <div class="vresult"> {{$result[4]}}</div>
                                        <div class="vresult"> {{$result[5]}}</div>
                                        <div class="vresult"> {{$result[6]}}</div>
                                        <div class="vresult"> {{$result[7]}}</div>
                                        <div class="vresult"> {{$result[8]}}</div>
                                        <div class="vresult"> {{$result[9]}}</div>
                                    </td>
                                    <td>
                                        <input type="text" hidden value="{{$data->url}}" id="url_{{$data->id}}">
                                        <button class="btn btn-primary btn-circle btn-sm" onclick="myFunction({{$data->id}})">Copy URL</button>
                                    </td>
                                    <td>
                                    <a class="btn btn-block btn-danger"
                                        href="{{ url('/delete/video_file/' . $data->id. '/'. $data->type) }}">Delete</a>
                                    </td>
                                    {{-- <td>{{$data->url}}</td> --}}
                                    {{-- <td>{{$data->created_at}}</td> --}}
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="tab-paggin">
                    {{ $videoList->links() }}
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


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sync Video List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ url('/videolist_update_command') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Video Type</label>
                        <select required name="type" class="custom-select">
                            <option value="{{$type}}">{{$type}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select required name="status" class="custom-select">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@push('scripts')

    <script type="text/javascript">
        $(function() {
        $('#datepicker').datepicker();
        });
    </script>
                        <script type="text/javascript">
                            $(function() {
                                $('#datepicker1').datepicker();
                            });
                        </script>
        <script>
            function myFunction(id) {
                // Get the text field
                var copyText = document.getElementById("url_"+id);

                // Select the text field
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile devices

                // Copy the text inside the text field
                navigator.clipboard.writeText(copyText.value);

                // Alert the copied text
                alert("Copied the text: " + copyText.value);
              }
            </script>
@endpush
