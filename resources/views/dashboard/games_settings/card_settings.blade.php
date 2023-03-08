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
                <!-- <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $gameName }}</h3>
                        </div>
                  
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Round</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $game)
                                        <tr>
                                            <td>{{ $game->round }}</td>
                                            <td>
                                                @if ($game->result == 1 && $game->game_id == 'ladder')
                                                    <span class="badge bg-danger">Odd</span>
                                                @endif
                                                @if ($game->result == 0 && $game->game_id == 'ladder')
                                                    <span class="badge bg-success">Even</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                   
                    </div>
                 
                </div> -->






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
                                        <th>Icon</th>
                                        <th>NType</th>
                                        <th>Total</th>
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
                                        <td>{{ $gameFuture->icon }}</td>
                                        <td>{{ $gameFuture->ntype }}</td>
                                        <td>{{ $gameFuture->total }}</td>
                                        <td>
                                            <a class="btn btn-block btn-danger"
                                                href="{{ url('/delete/neoncard/result/' . $gameFuture->id) }}">Delete</a>
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
                <form role="form" method="POST" action="{{ route('future.neonCard') }}">
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
                                <option value="High">High</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <select required name="icon" class="custom-select">
                                <option value="Clubs">Clubs</option>
                                <option value="Hearts">Hearts</option>
                                <option value="Diamonds">Diamonds</option>
                                <option value="Spades">Spades</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>NType</label>
                            <select required name="ntype" class="custom-select">
                                <option value="odd">Odd</option>
                                <option value="even">Even</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Total</label>
                            <input required name="total" type="number" type="text" class="form-control"
                                placeholder="Enter Total">
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
