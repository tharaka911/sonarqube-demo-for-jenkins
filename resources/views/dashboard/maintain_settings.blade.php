@extends('dashboard.layouts.dashboardApp')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/maintain.css') }}">
        <link rel="stylesheet" href="{{ asset('css/switch.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    </head>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Maintenance Settings') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('public.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Maintenance Settings') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body table-responsive p-0 cardBackground">
        <table class="table table-hover text-nowrap">
            <thead class="v-text">
                <tr>
                    <th>#</th>
                    <th style="text-align: left;">{{ __('Game') }}</th>
                    <th style="text-align: center;">{{ __('Status') }}</th>
                    <th style="text-align: left;">{{ __('Action') }}</th>
                    <th style="text-align: left;">{{ __('Duration') }}</th>
                    <th style="text-align: left;">{{ __('Last Maintenance') }}</th>
                </tr>
            </thead>

            <tbody class="v-text">
                <?php $i = 1; ?>
                @foreach ($maintain_data as $data)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ strtoupper(str_replace('_', ' ', $data->game_type)) }} - {{ strtoupper($data->type) }}</td>
                        <td class="">
                            <div class=" mt-3 toolbar">
                                
                                    @if ($data->maintain_status == 0)
                                    <p href="#" class="btn btn_live statusButton" style="cursor: unset;margin: auto;">
                                        Live
                                        <span class="live-icon"></span>
                                    </p>
                                    @endif
                                    @if ($data->maintain_status == 1)
                                    <p href="#" class="btn btn_offline" style="cursor: unset;margin: auto;">
                                        Offline
                                    </p>
                                    @endif
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="dropdown show">
                                <button class="btn btn-secondary dropdown-toggle ButtonHover" type="button"
                                    id="dropdownMenuButton_{{ $data->game_type }}_{{ $data->type }}"
                                    data-toggle="dropdown" aria-expanded="false">
                                    Edit
                                </button>
                                <ul class="dropdown-menu m-2"
                                    aria-labelledby="dropdownMenuButton_{{ $data->game_type }}_{{ $data->type }}">
                                    <div class="d-flex flex-column justify-content-start m-2">
                                        <li class="mb-2 ListItemLive">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $data->game_type }}_{{ $data->type }}_maintain"
                                                id="live_{{ $data->game_type }}_{{ $data->type }}"
                                                onclick="maintainFunction('{{ $data->game_type }}', '{{ $data->type }}', 0, 0)"
                                                @if ($data->maintain_status == 0 && $data->maintain_type == 0) checked @endif />
                                            <label class="form-check-label vedrana-font text-16"
                                                for="live_{{ $data->game_type }}_{{ $data->type }}">Live</label>
                                        </div>
                                    </li>
                                    <li class="mb-2 ListItemMaintain">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $data->game_type }}_{{ $data->type }}_maintain"
                                                id="full_maintain_{{ $data->game_type }}_{{ $data->type }}"
                                                onclick="maintainFunction('{{ $data->game_type }}', '{{ $data->type }}', 1, 1)"
                                                @if ($data->maintain_status == 1 && $data->maintain_type == 1) checked @endif />
                                            <label class="form-check-label vedrana-font text-16"
                                                for="full_maintain_{{ $data->game_type }}_{{ $data->type }}">Full
                                                Maintain</label>
                                        </div>
                                    </li>
                                    <li class="ListItemMaintain">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $data->game_type }}_{{ $data->type }}_maintain"
                                                id="normal_maintain_{{ $data->game_type }}_{{ $data->type }}"
                                                onclick="maintainFunction('{{ $data->game_type }}', '{{ $data->type }}', 1, 0)"
                                                style="margin-left: 20 !important"
                                                @if ($data->maintain_status == 1 && $data->maintain_type == 0) checked @endif />
                                            <label class="form-check-label vedrana-font text-16"
                                                for="normal_maintain_{{ $data->game_type }}_{{ $data->type }}">Normal
                                                Maintain</label>
                                        </div>
                                    </li>
                                </div>
                                </ul>
                            </div>
                        </td>
                        <td></td>
                        <td>{{ $data->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{--  <script>
            window.onload = function() {
                var toggle = document.getElementById('container');
                var toggleContainer = document.getElementById('toggle-container');
                var toggleNumber;

                toggle.addEventListener('click', function() {
                    toggleNumber = !toggleNumber;
                    if (toggleNumber) {
                        toggleContainer.style.clipPath = 'inset(0 0 0 50%)';
                        toggleContainer.style.backgroundColor = '#FF0000';
                    } else {
                        toggleContainer.style.clipPath = 'inset(0 50% 0 0)';
                        toggleContainer.style.backgroundColor = 'dodgerblue';
                    }
                    console.log(toggleNumber)
                });
            };
        </script>  --}}

        <script>
            function maintainFunction(game, type, maintain_status, maintain_type) {
                $.ajax({
                    type: "GET",
                    url: `/api/maintain/${game}/${type}/${maintain_status}/${maintain_type}`,
                    success: function(data) {
                        console.log("success - maintain status");
                        console.log("success1 - maintain status", maintain_type);
                    }
                });
                $(document).ready(function() {
                    $('.dropdown-toggle').dropdown();
                });
            }
        </script>
    @endsection
    @push('scripts')
    @endpush
