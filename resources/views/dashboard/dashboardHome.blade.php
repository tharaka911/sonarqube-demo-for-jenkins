@extends('dashboard.layouts.dashboardApp')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('public.dashboard') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('public.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('public.dashboard') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <!-- <section class="content">
        <div class="container-fluid">
         
            <div class="row">
                <div class="col-lg-4 col-6">
                 
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Speed Ladder</h3>

                            <p>API 0 SET</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Powerball</h3>

                            <p>API 0 SET</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Game 3</h3>

                            <p>API 0 SET</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>Game 4</h3>

                            <p>API 0 SET</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                 
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Game 5</h3>

                            <p>API 0 SET</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Game 6</h3>

                            <p>API 0 SET</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

             
            </div>
        






        </div>
    </section> -->


{{-- 
    <section class="section">
        <div class="row">
                    <div class="col-12 col-md-6" id="basic-table">
                        <div class="">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">3 MIN {{ __('public.Video List') }}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">     
                                        <div class="table-responsive">
                                            <table class="table ">
                                                <tbody>
                                                    <tr>
                                                        <td>DATE</td>
                                                        <td>YYYY-MM-DD</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Time</td>
                                                        <td>HH:MM</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td colspan="2" style="font-size: 9rem;"><span class="border border-dark rounded rounded-3 px-5">1</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3 MIN Progress</td>
                                                        <td><div class="progress progress-info">
                                                        <div class="progress-bar" role="progressbar" style="width: 60%"
                                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div></td>
                                                    <td class="col-3 text-center">60%</td>
                                                        <!-- <td>John</td> -->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6" id="basic-table">
                        <div class="">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">5 MIN {{ __('public.Video List') }}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body"> 
                                        <div class="table-responsive">    
                                                    <table class="table table-lg">
                                                    <tbody>
                                                    <tr>
                                                        <td>DATE</td>
                                                        <td>YYYY-MM-DD</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Time</td>
                                                        <td>HH:MM</td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td colspan="2" style="font-size: 9rem;"><span class="border border-dark rounded rounded-3 px-5">1</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5 MIN Progress</td>
                                                        <td><div class="progress progress-info">
                                                        <div class="progress-bar"  role="progressbar" style="width: 50%"
                                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div></td>
                                                    <td class="col-3 text-center">60%</td>
                                                        <!-- <td>John</td> -->
                                                    </tr>
                                                </tbody>
                                                    </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </section>                                                        
                                        
                                     --}}

                                  
                                    

                

    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@push('scripts')
@endpush
