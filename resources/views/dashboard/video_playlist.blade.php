@extends('dashboard.layouts.dashboardApp')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('public.Video Playlists')}} - {{$type}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('public.home')}}</a></li>
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

                                {{-- @if(count($playlists)>=1)
                                <button disabled type="button" class="btn btn-block bg-gradient-primary" data-toggle="modal"
                                    data-target="#modal-default">
                                    Playlist is active.
                                </button>
                                @endif --}}
                            </div>
                            <div class="row date-flow">


                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">

                                        <div class="col-lg-6 ">

                                        </div>
                                        <!-- search -->
                                        <div class="col-lg-6">
                                            <!-- <span class="  ">
                                                ID:
                                            </span>
                                            <input type="search" name="" id="" class="form-control mr-2"><i class="fa fa-search ms-3" aria-hidden="true"></i> -->
                                            {{-- <div>
                                                <div class="mx-auto pull-right">
                                                    <div class="">
                                                    <div class="input-group">
                                                                <span class="input-group-btn mr-5 mt-1">

                                                                </span>
                                                                <form class="form-inline" action="{{ route('search') }}" method="GET">
                                                                    <input class="iform-control mr-sm-2 rounded" type="search" placeholder="Search" aria-label="Search" name="keyword" requred/>
                                                                    <button class="btn btn-info" type="submit" title="Search projects">
                                                                        <span class="fas fa-search"></span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <!-- <section class="container">
                                                <form>
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
                                                </form>
                                            </section> -->

                                        </div>
                            </div>
                        </div>
                        <!-- /.card-header -->




                        <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                                <thead class="v-text">
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>{{ __('public.Playlist ID') }}</th>
                                        <th>{{ __('public.Playlist Name') }}</th>
                                        <th>{{ __('public.Playlist Type') }}</th>
                                        <th>{{ __('public.Playlist Size') }}</th>
                                        <th>{{ __('public.URL') }}</th>
                                        <th>{{ __('public.Date') }}</th>
                                        <th>{{ __('public.Modify') }}</th>
                                        <th>{{ __('public.Active') }}</th>
                                        <th>{{ __('public.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="v-text">
                                    <?php $i =1; ?>
                                    @foreach ($playlists as $data)
                                        <tr>
                                            <td><ion-icon id="playlist_{{$data['id']}}" name="play" size="large" style="display:none"></ion-icon></i></td>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$data['id']}}</td>
                                            <td>{{$data['name']}}</td>
                                            <td>{{$data['type']}}</td>
                                            <td>{{$data['size']}}</td>
                                            <td>
                                                <input type="text" hidden value="{{$data['url']}}" id="url_{{$data['id']}}">
                                                <button class="btn btn-primary btn-circle btn-sm" onclick="myFunction({{$data['id']}})">Copy URL</button>
                                            </td>

                                            <td>{{ $data->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-block btn-success show_confirm" href="#" onclick="showEditModal({{ $data['id'] }})">Edit
                                                    <span class="success">
                                                        <i class='fas fa-edit' style='font-size:17px;color:purple'></i>
                                                      </span>
                                                </a>
                                            <td>
                                                @if ($data['status'] == 0)
                                                    <span class="badge bg-danger">Deactive</span>
                                                @endif
                                                @if ($data['status'] == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-block btn-danger show_confirm" href="#" onclick="showModal({{ $data['id'] }})">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- Modal for Delete -->
                                    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="passwordModalLabel">Enter Password</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label for="passwordInput">Password</label>
                                                            <input type="password" class="form-control" id="passwordInput">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" onclick="submitPassword()">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal for Edit -->
                                    <div class="modal fade" id="editPasswordModal" tabindex="-1" role="dialog" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPasswordModalLabel">Enter Password</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label for="editPasswordInput">Password</label>
                                                            <input type="password" class="form-control" id="editPasswordInput">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" onclick="submitEditPassword()">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function showModal(id) {
                                            currentId = id;
                                            $('#passwordModal').modal('show');
                                        }

                                        function submitPassword() {
                                            var password = $('#passwordInput').val();

                                            $.ajax({
                                                type: "POST",
                                                url: "/check-password",
                                                data: {
                                                    password: password,
                                                    _token: "{{ csrf_token() }}"
                                                },
                                                success: function (response) {
                                                    if (response.success) {
                                                    window.location.href = "/delete/playlist/" + currentId;
                                                    } else {
                                                        alert("Incorrect password.");
                                                    }
                                                }
                                            });
                                        }

                                        function showEditModal(id) {
                                            $("#editPasswordModal").modal("show");
                                            window.editId = id;
                                        }

                                        function submitEditPassword() {
                                            var password = $("#editPasswordInput").val();

                                            $.ajax({
                                                type: "POST",
                                                url: "/check-password",
                                                data: {
                                                    password: password,
                                                    _token: "{{ csrf_token() }}"
                                                },
                                                success: function (response) {
                                                    if (response.success) {
                                                        window.location.href = "/playlist_track/" + window.editId;
                                                    } else {
                                                        alert("Incorrect password.");
                                                    }
                                                }
                                            });
                                        }

                                    </script>
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
                    <h4 class="modal-title">Add Playlist </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" method="POST" action="{{ url('playlist') }}">
                    {{ csrf_field() }}/
                <div class="modal-body">
                    <div class="form-group">
                        <label>Playlist Type</label>
                        <select required name="type" class="custom-select">
                             <option value={{$type}}>{{{$type}}}</option>

                        </select>
                     </div>

                    <div class="form-group">
                        <label>Playlist Name</label>
                            <input required name="name" type="text" class="form-control"
                                placeholder="Enter Playlist Name">
                    </div>

                    <div class="form-group">
                        <label>Video Track Size</label>
                            <input required name="size" min=1 type="number" class="form-control"
                                placeholder="Enter Track Count">
                    </div>

                    {{-- <div class="form-group">
                        <label>Waiting Video URL</label>
                            <input required name="waiting_video_url" type="text" class="form-control"
                                placeholder="Enter Waiting Video URL">
                    </div> --}}

                    <div class="form-group">
                        <label>Playlist Status</label>
                        <select required name="status" class="custom-select">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                     </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Playlist</button>
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

    <!-- Socket 3min -->
    @if($type == "3min")
    <script src="{{ asset('js/3min_playlist_indicator.js') }}"></script>
    @endif

    @if($type == "5min")
    <script src="{{ asset('js/5min_playlist_indicator.js') }}"></script>
    @endif

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
