@extends('dashboard.layouts.dashboardApp')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Game Results Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Game Results Settings</li>
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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $gameName }}</h3>

                            <div class="card-tools float-right">
                                <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Set future game results
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Count</th>
                                        <th>Round</th>
                                        <th>Result</th>
                                        <th>Start Point</th>
                                        <th>End Point</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i =1 ?>
                                    <tr>
                                        @foreach ($resultsFuture as $gameFuture)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $gameFuture->round }}</td>
                                        <td>
                                            @if ($gameFuture->result == 1)
                                                <span class="badge bg-danger">Odd</span>
                                            @endif
                                            @if ($gameFuture->result == 0)
                                                <span class="badge bg-success">Even</span>
                                            @endif
                                        </td>
                                        <td>{{ $gameFuture->startPoint }}</td>
                                        <td>{{ $gameFuture->endPoint }}</td>
                                        <td>
                                            <a class="btn btn-block btn-danger"
                                                href="{{ url('/delete/neonladder/result/' . $gameFuture->id) }}">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tr>
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
                    <h4 class="modal-title">Set future game results - {{ $gameName }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" method="POST" action="{{ route('future.speedLadder') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Round</label>
                            <input required name="round" type="number" type="text" class="form-control"
                                placeholder="Enter Round">
                        </div>
                        <div class="form-group">
                            <label>Game Select</label>
                            <select required name="result" class="custom-select">
                                <option value="1">Odd</option>
                                <option value="0">Even</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Start Point</label>
                            <select required name="startPoint" class="custom-select">
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>End Start</label>
                            <select required name="endPoint" class="custom-select">
                                <option value="3">3</option>
                                <option value="4">4</option>
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
