@extends('dashboard.layouts.dashboardApp')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('public.Video List') }}</h1>
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
                            <div class="row date-flow">

                            <div class="card-tools float-right">
                                <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Create Playlist
                                </button>
                            </div>
                                
                                            
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        
                                        <div class="col-lg-6 ">
                                            
                                        </div>
                                        <div class="col-lg-6"><span class="  ">ID:</span><input type="search" name="" id="" class=" "><i class="fa fa-search ms-3" aria-hidden="true"></i></div></div></div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <section class="container">
                                    
                                                <!-- <form>
                                                    <div class="row form-group" style="display:flex;align-items:center;">
                                                        <label for="date" class="">Date</label>
                                                        <div class="col" >
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="input-group date" id="datepicker">
                                                                <input type="text" class="form-control">
                                                                <span class="input-group-append">
                                                                    <span class="input-group-text bg-white">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                                <div class="col"><div class="input-group date" id="datepicker1">
                                                                <input type="text" class="form-control">
                                                                <span class="input-group-append">
                                                                    <span class="input-group-text bg-white">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </form> -->
                                            </section>
                                               
                                        </div>
                            </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead class="v-text">
                                <tr>
                                    <th>#</th>
                                    <th>Video ID</th>
                                    <th>Usage</th>
                                    <th>Video Result</th>
                                    <th>Date</th>
                                    <!-- <th>Status</th>
                                        <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody class="v-text">

                                <?php $i =1; ?>

                            </tbody>
                        </table>
                    </div>

                    <ul id="sortlist">
                        <li>
                            <div style="font:bold">1</div>
                            <div></div>
                            <div>#990</div>
                            <div>5</div>
                            <div class="vtd" style="display:flex;justfy-content:center;">
                                <div class="vresult"> 12</div>
                                <div class="vresult"> 23</div>
                                <div class="vresult"> 34</div>
                                <div class="vresult"> 45</div>
                                <div class="vresult"> 56</div>
                                <div class="vresult"> 67</div>
                            </div>
                            <div>04-oct-2022</div>
                        </li>
                        <li>
                            <div style="font:bold">2</div>
                            <div></div>
                            <div>#990</div>
                            <div>5</div>
                            <div class="vtd" style="display:flex;justfy-content:center;">
                                <div class="vresult"> 12</div>
                                <div class="vresult"> 23</div>
                                <div class="vresult"> 34</div>
                                <div class="vresult"> 45</div>
                                <div class="vresult"> 56</div>
                                <div class="vresult"> 67</div>
                            </div>
                            <div>04-oct-2022</div>
                        </li>
                        <li>
                            <div style="font:bold">3</div>
                            <div></div>
                            <div>#999</div>
                            <div>5</div>
                            <div class="vtd" style="display:flex;justfy-content:center;">
                                <div class="vresult"> 12</div>
                                <div class="vresult"> 23</div>
                                <div class="vresult"> 34</div>
                                <div class="vresult"> 45</div>
                                <div class="vresult"> 56</div>
                                <div class="vresult"> 67</div>
                            </div>
                            <div>04-oct-2022</div>
                        </li>
                        <li>
                            <div style="font:bold" class="ms-5 me-5">4</div>
                            <div></div>
                            <div>#992</div>
                            <div>5</div>
                            <div class="vtd" style="display:flex;justfy-content:center;">
                                <div class="vresult"> 12</div>
                                <div class="vresult"> 23</div>
                                <div class="vresult"> 34</div>
                                <div class="vresult"> 45</div>
                                <div class="vresult"> 56</div>
                                <div class="vresult"> 67</div>
                            </div>
                            <div>04-oct-2022</div>
                        </li>
                        <li>
                            <div style="font:bold">5</div>
                            <div></div>
                            <div>#990</div>
                            <div>5</div>
                            <div class="vtd" style="display:flex;justfy-content:center;">
                                <div class="vresult"> 12</div>
                                <div class="vresult"> 23</div>
                                <div class="vresult"> 34</div>
                                <div class="vresult"> 45</div>
                                <div class="vresult"> 56</div>
                                <div class="vresult"> 67</div>
                            </div>
                            <div>04-oct-2022</div>
                        </li>
                    </ul>



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
                <h4 class="modal-title">Create Playlist</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ url('/create/apikey') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <!-- <div class="form-group">
                        <label>Game Select</label>
                        <select required name="game_type" class="custom-select">
                            <option value="vivace_chart">Vivace Chart</option>
                        </select>
                    </div> -->

                    <div class="form-group">
                        <label>SET RANGE</label>
                        <div class="row">
                        
                        
                            <div class="btn btn-primary toggle me-1" type="text-box"
                                aria-haspopup="true" aria-expanded="false">
                                <input required name="ip_address" type="text" class="form-control" placeholder="Enter B. Range">
                            </div>
                            <div class="btn btn-primary toggle me-1" type="text-box"
                                aria-haspopup="true" aria-expanded="false">
                                <input required name="ip_address" type="text" class="form-control" placeholder="Enter E. Range">
                            </div>
                        </div>
                            
                            
                        
                    </div>
                    
                                
                                

                    <div class="form-group">
                        <!-- <label>RANDOM</label>
                        <input required name="ip_address" type="text" class="form-control" placeholder="Enter Valid"> -->
                    </div>

                    <div class="form-group">
                        <label>PLAYLIST TYPE</label>
                        <select required name="status" class="custom-select">
                            <option value="1">3 MIN</option>
                            <option value="0">5 MIN</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    <button type="submit" class="btn btn-primary">RANDOM</button>
                    <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- sortable list -->

<!-- (C) INIT ON PAGE LOAD -->
<script>
    window.addEventListener("DOMContentLoaded", () => {
        slist(document.getElementById("sortlist"));
    });
</script>
<script>
    function slist(target) {
        // (A) SET CSS + GET ALL LIST ITEMS
        target.classList.add("slist");
        let items = target.getElementsByTagName("li"), current = null;

        // (B) MAKE ITEMS DRAGGABLE + SORTABLE
        for (let i of items) {
            // (B1) ATTACH DRAGGABLE
            i.draggable = true;

            // (B2) DRAG START - YELLOW HIGHLIGHT DROPZONES
            i.ondragstart = (ev) => {
                current = i;
                for (let it of items) {
                    if (it != current) { it.classList.add("hint"); }
                }
            };

            // (B3) DRAG ENTER - RED HIGHLIGHT DROPZONE
            i.ondragenter = (ev) => {
                if (i != current) { i.classList.add("active"); }
            };

            // (B4) DRAG LEAVE - REMOVE RED HIGHLIGHT
            i.ondragleave = () => {
                i.classList.remove("active");
            };

            // (B5) DRAG END - REMOVE ALL HIGHLIGHTS
            i.ondragend = () => {
                for (let it of items) {
                    it.classList.remove("hint");
                    it.classList.remove("active");
                }
            };

            // (B6) DRAG OVER - PREVENT THE DEFAULT "DROP", SO WE CAN DO OUR OWN
            i.ondragover = (evt) => { evt.preventDefault(); };

            // (B7) ON DROP - DO SOMETHING
            i.ondrop = (evt) => {
                evt.preventDefault();
                if (i != current) {
                    let currentpos = 0, droppedpos = 0;
                    for (let it = 0; it < items.length; it++) {
                        if (current == items[it]) { currentpos = it; }
                        if (i == items[it]) { droppedpos = it; }
                    }
                    if (currentpos < droppedpos) {
                        i.parentNode.insertBefore(current, i.nextSibling);
                    } else {
                        i.parentNode.insertBefore(current, i);
                    }
                }
            };
        }
    }
</script>




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
@endpush