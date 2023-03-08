@extends('dashboard.layouts.dashboardApp')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create {{$balancing_type}} balancing</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- <div class="card-header">

                    </div> --}}
                    <div class="card-body table-responsive p-0">
                        <form role="form" method="POST" action="{{ url('/api/balancing/betting/feed') }}">
                            {{-- {{ csrf_field() }}/ --}}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Type</label>
                                        <select required name="type" class="custom-select">
                                            <option value="3min">3 min</option>
                                            <option value="5min">5 min</option>
                                        </select>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Powerball Bet Amount ODD Under</label>
                                                <input required name="powerball_bet_amount_odd_under" type="text" class="form-control"
                                                    placeholder="powerball_bet_amount_odd_under">
                                        </div>
                                        <div class="form-group">
                                            <label>Powerball Bet Amount ODD Over</label>
                                                <input required name="powerball_bet_amount_odd_over" type="text" class="form-control"
                                                    placeholder="powerball_bet_amount_odd_over">
                                        </div>
                                        <div class="form-group">
                                            <label>Powerball Bet Amount Even Under</label>
                                                <input required name="powerball_bet_amount_even_under" type="text" class="form-control"
                                                    placeholder="powerball_bet_amount_even_under">
                                        </div>
                                        <div class="form-group">
                                            <label>Powerball Bet Amount Even Over</label>
                                                <input required name="powerball_bet_amount_even_over" type="text" class="form-control"
                                                    placeholder="powerball_bet_amount_even_over">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Normalball Bet Amount ODD Under</label>
                                                <input required name="normalball_bet_amount_odd_under" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_odd_under">
                                        </div>
                                        <div class="form-group">
                                            <label>Normalball Bet Amount ODD Over</label>
                                                <input required name="normalball_bet_amount_odd_over" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_odd_over">
                                        </div>
                                        <div class="form-group">
                                            <label>Normalball Bet Amount Even Under</label>
                                                <input required name="normalball_bet_amount_even_under" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_even_under">
                                        </div>
                                        <div class="form-group">
                                            <label>Normalball Bet Amount Even Over</label>
                                                <input required name="normalball_bet_amount_even_over" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_even_over">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Normalball Bet Amount ODD Large</label>
                                                <input required name="normalball_bet_amount_odd_large" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_odd_large">
                                        </div>
                                        <div class="form-group">
                                            <label>Normalball Bet Amount ODD Medium</label>
                                                <input required name="normalball_bet_amount_odd_medium" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_odd_medium">
                                        </div>
                                        <div class="form-group">
                                            <label>Normalball Bet Amount ODD Single</label>
                                                <input required name="normalball_bet_amount_odd_small" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_odd_small">
                                        </div>
                                        <div class="form-group">
                                            <label>Normalball Bet Amount EVEN Large</label>
                                                <input required name="normalball_bet_amount_even_large" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_even_large">
                                        </div>
                                        <div class="form-group">
                                            <label>Normalball Bet Amount EVEN Medium</label>
                                                <input required name="normalball_bet_amount_even_medium" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_even_medium">
                                        </div>
                                        <div class="form-group">
                                            <label>Normalball Bet Amount EVEN Single</label>
                                                <input required name="normalball_bet_amount_even_small" type="text" class="form-control"
                                                    placeholder="normalball_bet_amount_even_small">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" class="btn btn-primary">Add Balancing</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
