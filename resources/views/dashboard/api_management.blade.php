@extends('dashboard.layouts.dashboardApp')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('public.API Management') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('public.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('public.API Management') }}</li>
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
         <div class = "alert alert-danger">
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
                            <!--<h3 class="card-title">Responsive Hover Table</h3>-->
                            <!-- <div class="card-tools float-left">
                                <select class="form-control">
                                    <option>game 1</option>
                                    <option>game 2</option>
                                    <option>game 3</option>
                                    <option>game 4</option>
                                    <option>game 5</option>
                                    <option>game 6</option>
                                </select>
                            </div> -->

                            <div class="card-tools float-right">
                                <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    {{ __('public.add') }}
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>IP</th>
                                        <th>API Key Type</th>
                                        <th>API Key</th>
                                        <th>{{ __('public.Date') }}</th>
                                        <th>{{ __('public.Status') }}</th>
                                        <th>{{ __('public.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php $i =1; ?>
                                    <tr>
                                        @foreach ($apiKeyData['result'] as $data)
                                        <td>{{ $i++ }}</td>
                                        <td>{{$data['ip']}}</td>
                                        <td>{{$data['type']}}</td>
                                        <td>{{$data['apiKey']}}</td>
                                        <td>{{$data['created_at']}}</td>

                                        <td>
                                            @if ($data['status'] == 0)
                                                <span class="badge bg-danger">Deactive</span>
                                            @endif
                                            @if ($data['status'] == 1)
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-block btn-danger"
                                                    href="{{ url('/delete/apikey/' . $data['_id']) }}">Delete</a>
                                            </td>
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




    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add API Key</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" method="POST" action="{{ url('/create/apikey') }}">
                    {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Select</label>
                        <select required name="game_type" class="custom-select">
                             <option value="dh_powerball">DH Powerball</option>
                             <option value="live_powerball_father">Lve Powerball Father</option>
                        </select>
                     </div>

                    <div class="form-group">
                        <label>IP</label>
                            <input required name="ip_address" type="text" class="form-control"
                                placeholder="Enter Valid IP">
                    </div>

                    <div class="form-group">
                        <label>Game Status</label>
                        <select required name="status" class="custom-select">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                     </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
@endpush
