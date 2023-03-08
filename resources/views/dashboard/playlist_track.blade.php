@extends('dashboard.layouts.dashboardApp')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-3">
                <h1 class="m-0">Playlist Tracks - {{$type}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6" style="text-align: center; color:red">
                <h1 class="m-0" id="indicator"></h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Playlist Tracks</li>
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
                        <div class="card-tools float-left">
                            <h5>Total Videos (List) - <span id="total_video_count_list"></span></h5>
                            <h5>Total Videos (DB) -
                                <span id="total_video_count_db">
                                    {{ count($playlistTracks) }}
                                </span>
                            </h5>
                        </div>
                        <div class="row date-flow">

                            <div class="card-tools float-right">
                                <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Create Random Tracks
                                </button>
                            </div>
                            <div style="margin-right: 5%" class="card-tools float-right">
                                <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default-regenerate">
                                    Regenerate Tracks
                                </button>
                            </div>

                            <div style="margin-right: 5%" class="card-tools float-right">
                                <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default-change-track">
                                    Change Track
                                </button>
                            </div>
                            <div style="margin-right: 5%" class="card-tools float-right">
                                <button type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default-change-track-by-filter">
                                    Change Track by Filter
                                </button>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row">

                                    <div class="col-lg-6 ">

                                    </div>
                                    {{-- <div class="col-lg-6"><span class="  ">ID:</span><input type="search" name="" id=""
                                            class=" "><i class="fa fa-search ms-3" aria-hidden="true"></i></div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <section class="container">
                                </section>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead class="v-text">
                                <tr>
                                    <!-- <th>#</th> -->
                                    <th>Round</th>
                                    <th>Track ID</th>
                                    <th>Video ID</th>
                                    <th>Video Result</th>
                                    <th>URL</th>
                                </tr>
                            </thead>
                            <tbody class="v-text">

                                <?php $i =1; ?>

                            </tbody>
                        </table>
                    </div>
                    <ul id="sortlist">
                        <?php $i =1; ?>
                        

                        @foreach ($playlistTracks as $data)
                        <?php $result = explode(" ", $data->result); ?>

                        <li class="liitems">

                            <!-- <div><ion-icon id={{$data->track_id}} name="play" size="large" style="display:none"></ion-icon></i></div> -->
                            {{-- <div style="font:bold">{{$i}}</div> --}}
                            <div style="font:bold;">
                            <ion-icon id={{$data->track_id}} name="play" size="large" style="display:none"></ion-icon></i> {{$i}}</div>
                            <div>{{$data->track_id}}</div>
                            <div>{{$data->video_id}}</div>
                            {{-- <div>{{$data->count}}</div> --}}
                            <div class="vtd" style="display:flex;justfy-content:center;">
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
                            </div>
                            <div>
                                <input type="text" hidden value="{{$data->url}}" id="url_{{$data->id}}">
                                <button class="btn btn-primary btn-circle btn-sm" onclick="myFunction({{$data->id}})">Copy URL</button>
                            </div>
                            {{-- <div>{{ $data->created_at }}</div> --}}
                        </li>
                        <?php $i++; ?>
                        @endforeach
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
                <h4 class="modal-title">Create Random Playlist Tracks</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ url('/playlist_track') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <!-- <div class="form-group">
                        <label>Range start</label>
                        <input required name="start" type="number" min=0 class="form-control"
                        placeholder="Enter Start Range">
                    </div>

                    <div class="form-group">
                        <label>Range end</label>
                        <input required name="end" type="number" min=0 class="form-control"
                        placeholder="Enter End Range">
                    </div> -->

                    <div class="form-group">
                        <label>Playlist type</label>
                        <select required name="type" class="custom-select">
                            <option value="{{$type}}">{{$type}}</option>
                        </select>
                    </div>

                    <input hidden value={{$playlistID}} name="playlist_id" type="text" class="form-control">

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

<div class="modal fade" id="modal-default-regenerate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Regenerate Playlist Tracks</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ url('/playlist_track_regenerate') }}">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="form-group">
                        <label>Playlist type</label>
                        <select required name="type" class="custom-select">
                            <option value="{{$type}}">{{$type}}</option>
                        </select>
                    </div>

                    <input hidden value={{$playlistID}} name="playlist_id" type="text" class="form-control">

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


<div class="modal fade" id="modal-default-change-track">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Track</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ url('/change_playlist_track') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Current Track ID</label>
                        <input required name="current_track_id" type="text" class="form-control"
                        placeholder="Enter Current Track Video ID | 2,4">
                    </div>

                    <div class="form-group">
                        <label>New Track Video ID</label>
                        <input required name="new_track_video_id" type="text" class="form-control"
                        placeholder="Enter New Track Video ID | 5,6,7">
                    </div>

                    <div class="form-group">
                        <label>Playlist type</label>
                        <select required name="type" class="custom-select">
                            <option selected value="{{$type}}">{{$type}}</option>
                        </select>
                    </div>

                    <input hidden value={{$playlistID}} name="playlist_id" type="text" class="form-control">

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




<div class="modal fade" id="modal-default-change-track-by-filter">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Track By Filter</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" action="{{ url('/change_playlist_track_by_filter') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Current Track ID</label>
                        <input required name="current_track_id" type="text" class="form-control"
                        placeholder="Enter Current Track Video ID | 2,4">
                    </div>

                    <div class="form-group">
                        <label>Normal Ball Under/Over</label>
                        <select required name="normalball_under_over" class="custom-select">
                            <option selected value="under">Under</option>
                            <option selected value="over">Over</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Normal Ball Odd/Even</label>
                        <select required name="normalball_odd_even" class="custom-select">
                            <option selected value="odd">Odd</option>
                            <option selected value="even">Even</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Power Ball Under/Over</label>
                        <select required name="powerball_under_over" class="custom-select">
                            <option selected value="under">Under</option>
                            <option selected value="over">Over</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Power Ball Odd/Even</label>
                        <select required name="powerball_odd_even" class="custom-select">
                            <option selected value="odd">Odd</option>
                            <option selected value="even">Even</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Playlist type</label>
                        <select required name="type" class="custom-select">
                            <option selected value="{{$type}}">{{$type}}</option>
                        </select>
                    </div>

                    <input hidden value={{$playlistID}} name="playlist_id" type="text" class="form-control">

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
            i.draggable = false;

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

<script>
    var list = document.getElementById("sortlist").getElementsByTagName("li");
    var count = list.length;

    const element = document.getElementById('total_video_count_list');
    element.innerHTML = count;
</script>

@endsection

@push('scripts')

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

<script type="text/javascript">
    $(function () {
        $('#datepicker').datepicker();
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#datepicker1').datepicker();
    });
</script>

<script src="{{ asset('js/5min_indicator.js') }}"></script>

<script>
    var playlist_id = {{ $playlistID }};
    setTimeout (()=>{
        console.log(currentTrack, 'dss');
    },5000)
</script>

<!-- Socket 3min -->
@if($type == "3min" && count($playlistTracks)>0)
<script src="{{ asset('js/3min_indicator.js') }}"></script>
@endif

@if($type == "5min" && count($playlistTracks)>0)
<script src="{{ asset('js/5min_indicator.js') }}"></script>
@endif

@endpush
