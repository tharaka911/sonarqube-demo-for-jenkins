@extends('dashboard.layouts.dashboardApp')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/missingdata.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    </head>
<div class="background">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Add Missing Data') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#" class="Line1">{{ __('public.home') }}</a></li>
                        <li class="breadcrumb-item active Line2">{{ __('Add Missing Data') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Live Power Ball section -->
@section('power_ball')
    <h3 class="text-center TextEffect mb-3 mt-3">Add Live Power Ball Missing Data</h3>

        <div class="mx-5 px-5">
            <div class="card mx-5 ">
                <form  id="my-form" class="pt-4 Tablebackground">
                    <table>
                        <tr>
                            <td>Date:</td>
                            <td><input class="InputColor" type="date" name="date" id="date"></td>
                        </tr>
                        <tr>
                            <td>Round:</td>
                            <td><input class="InputColor" type="text" name="round" id="round" placeholder="1,2,3,..."></td>
                        </tr>
                        <tr>
                            <td>Type:</td>
                            <td>
                                <select  class="InputColor" name="type" id="type">
                                    <option value="">-- Select Type --</option>
                                    <option value="5min">5 Minutes</option>
                                    <option value="3min">3 Minutes</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Result:</td>
                            <td><input class="InputColor" type="text" name="result" id="result" placeholder="25 16 3 13 23 80 E O 1 O">
                            </td>
                        </tr>
                    </table>
                    <div class="w-100 d-flex justify-content-end margin-end-20 mt-3 mb-5">
                        <button type="submit" class="btn submitButton justify-self-end me-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#my-form').submit(function(event) {
                    event.preventDefault();
                    var date = $('#date').val();
                    var round = $('#round').val();
                    var type = $('#type').val();
                    var result = $('#result').val();

                    if (date === '' || round === '' || type === '' || result === '') {
                        alert("Please fill in all fields before submitting.");

                        $("input, select").filter(function() {
                            return !this.value.trim();
                        }).addClass("border border-danger");
                        return;
                    }

                    var formData = {
                        'date': date,
                        'round': round,
                        'type': type,
                        'result': result
                    };

                    $.ajax({
                        type: "POST",
                        url: "https://api.winners-live.com/api/powerball/live_data",
                        data: JSON.stringify(formData),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            alert("Data submitted successfully!");
                        },
                        error: function(errMsg) {
                            console.log(errMsg);
                            alert("Data submission failed.");
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "https://api.winners-live.com/api/powerball/fake_liveball_data_external",
                        data: JSON.stringify(formData),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            alert(
                                "Data submitted to external endpoint successfully!");
                        },
                        error: function(errMsg) {
                            console.log(errMsg);
                            alert(
                                "Data submitted to external endpoint failed.");
                        }
                    });
                });
            });
        </script>
    @endsection


    <!-- DH power Ball section -->
    @section('dh_powerball')
        <h3 class="text-center TextEffect mb-3 mt-3">Add DH Power Ball Missing Data</h3>

            <div class="mx-5 px-5">
                <div class="card mx-5">
                    <form class="pt-4 Tablebackground" id="my-form" >
                        <table>
                            <tr>
                                <td>Date:</td>
                                <td><input class="InputColor" type="date" name="date" id="date"></td>
                            </tr>
                            <tr>
                                <td>Round:</td>
                                <td><input class="InputColor" type="text" name="round" id="round" placeholder="Enter round"></td>
                            </tr>
                            <tr>
                                <td>Powerball:</td>
                                <td>
                                    <select class="InputColor" name="powerball" id="powerball">
                                        <option value="over">Over</option>
                                        <option value="under">Under</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Normalball:</td>
                                <td>
                                    <select class="InputColor" name="normalball" id="normalball">
                                        <option value="even">Even</option>
                                        <option value="odd">Odd</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Game Index:</td>
                                <td><input class="InputColor" type="text" name="game_index" id="game_index" placeholder="Enter Game Index">
                                </td>
                            </tr>
                        </table>
                        <div class="w-100 d-flex justify-content-end margin-end-20 mt-3 mb-5">
                            <button type="submit" class="btn submitButton justify-self-end me-5">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#my-form').submit(function(event) {
                        event.preventDefault();
                        var date = $('#date').val();
                        var round = $('#round').val();
                        var powerball = $('#powerball').val();
                        var normalball = $('#normalball').val();
                        var game_index = $('#game_index').val();

                        if (date === '' || powerball === '' || normalball === '' || game_index === '') {
                            alert("Please fill in all fields before submitting.");

                            $("input, select").filter(function() {
                                return !this.value.trim();
                            }).addClass("border border-danger");
                            return;
                        }

                        var formData = {
                            'date': date,
                            'round': round,
                            'powerball': powerball,
                            'normalball': normalball,
                            'game_index': game_index
                        };

                        $.ajax({
                            type: "POST",
                            url: "https://api.winners-live.com/api/powerball/fake_data",
                            data: JSON.stringify(formData),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                alert("Data submitted successfully!");
                            },
                            error: function(errMsg) {
                                console.log(errMsg);
                                alert("Data submission failed.");
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: "https://api.winners-live.com/api/powerball/fake_powerball_data_external",
                            data: JSON.stringify(formData),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                alert(
                                    "Data submitted to external endpoint successfully!");
                            },
                            error: function(errMsg) {
                                console.log(errMsg);
                                alert(
                                    "Data submission to external endpoint failed.");
                            }
                        });
                    });
                });
            </script>
        @endsection

        <!-- DH speed Kino section -->
        @section('speed_kino')
            <h3 class="text-center TextEffect mb-3 mt-3">Add DH Speed Kino Missing Data</h3>

                <div class="mx-5 px-5">
                    <div class="card mx-5">
                        <form class="pt-4 Tablebackground"id="my-form">
                            <table>
                                <tr>
                                    <td>Date:</td>
                                    <td><input class="InputColor" type="date" name="date" id="date" placeholder="Enter date"></td>
                                </tr>
                                <tr>
                                    <td>Unique Key:</td>
                                    <td><input class="InputColor" type="text" name="unique_key" id="unique_key"
                                            placeholder="Enter unique key"></td>
                                </tr>
                                <tr>
                                    <td>Round:</td>
                                    <td><input class="InputColor" type="text" name="round" id="round" placeholder="Enter round"></td>
                                </tr>

                                <tr>
                                    <td>Sum:</td>
                                    <td><input class="InputColor" type="text" name="sum" id="sum" placeholder="Enter sum (nsum)">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Result:</td>
                                    <td><input class="InputColor" type="text" name="result" id="result" placeholder="Enter result (nn)">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Odd/Even:</td>
                                    <td><input class="InputColor" type="text" name="oddEven" id="oddEven"
                                            placeholder="Enter odd/even (fd3)"></td>
                                </tr>
                                <tr>
                                    <td>Section:</td>
                                    <td><input class="InputColor" type="text" name="section" id="section"
                                            placeholder="Enter section (ntype)"></td>
                                </tr>
                                <tr>
                                    <td>Under/Over:</td>
                                    <td><input class="InputColor" type="text" name="underOver" id="underOver"
                                            placeholder="Enter under/over (fd4)"></td>
                                </tr>
                                <tr>
                                    <td>Lucky Num Result:</td>
                                    <td><input class="InputColor" type="text" name="luckyNumResult" id="luckyNumResult"
                                            placeholder="Enter lucky number (lucky)"></td>
                                </tr>
                                <tr>
                                    <td>Lucky Num Odd/Even:</td>
                                    <td><input class="InputColor" type="text" name="luckyNumOddEven" id="luckyNumOddEven"
                                            placeholder="Enter lucky num odd/even (fd1)"></td>
                                </tr>
                                <tr>
                                    <td>Lucky Num Section:</td>
                                    <td><input class="InputColor" type="text" name="luckyNumSection" id="luckyNumSection"
                                            placeholder="Enter lucky num section (ltype)"></td>
                                </tr>
                                <tr>
                                    <td>Lucky Num Under/Over:</td>
                                    <td><input class="InputColor" type="text" name="luckyNumUnderOver" id="luckyNumUnderOver"
                                            placeholder="Enter lucky num under/over (fd2)"></td>
                                </tr>
                            </table>
                            <div class="w-100 d-flex justify-content-end margin-end-20 mt-3 mb-5">
                                <button type="submit" class="btn submitButton justify-self-end me-5">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                    $(document).ready(function() {
                        $('#my-form').submit(function(event) {
                            event.preventDefault();

                            var empty = false;
                            $('input[type=text], input[type=date]').each(function() {
                                if ($(this).val() === '') {
                                    empty = true;
                                    $(this).addClass(
                                        "border border-danger");
                                }
                            });
                            if (empty) {
                                alert("Please fill in all fields.");
                                return;
                            }
                            if (empty) {
                                alert("Please fill in all fields.");
                                return;
                            }

                            var formData = {
                                'date': $('#date').val(),
                                'unique_key': $('#unique_key').val(),
                                'round': $('#round').val(),
                                'data': {
                                    'sum': $('#sum').val(),
                                    'result': $('#result').val(),
                                    'oddEven': $('#oddEven').val(),
                                    'section': $('#section').val(),
                                    'underOver': $('#underOver').val(),
                                    'luckyNumResult': $('#luckyNumResult').val(),
                                    'luckyNumOddEven': $('#luckyNumOddEven').val(),
                                    'luckyNumSection': $('#luckyNumSection').val(),
                                    'luckyNumUnderOver': $('#luckyNumUnderOver').val()
                                }
                            };

                            $.ajax({
                                type: "POST",
                                url: "https://api.winners-live.com/api/kino/fake_data",
                                data: JSON.stringify(formData),
                                contentType: "application/json; charset=utf-8",
                                dataType: "json",
                                success: function(data) {
                                    console.log(data);
                                    alert("Data submitted successfully!");

                                    // send the data to the new endpoint
                                    $.ajax({
                                        type: "POST",
                                        url: "https://api.winners-live.com/api/kino/fake_data_external",
                                        data: JSON.stringify(formData),
                                        contentType: "application/json; charset=utf-8",
                                        dataType: "json",
                                        success: function(data) {
                                            console.log(data);
                                            alert(
                                                "Data submitted to external endpoint successfully!"
                                            );
                                        },
                                        error: function(errMsg) {
                                            console.log(errMsg);
                                            alert(
                                                "Data submission to external endpoint failed."
                                            );
                                        }
                                    });
                                },
                                error: function(errMsg) {
                                    console.log(errMsg);
                                    alert("Data submission failed.");
                                }
                            });
                        });
                    });
                </script>
            @endsection

            <div class="game-container">
                @if ($game_type == 'power_ball')
                    @yield('power_ball')
                @elseif($game_type == 'dh_powerball')
                    @yield('dh_powerball')
                @elseif($game_type == 'speed_kino')
                    @yield('speed_kino')
                @endif
            </div>
        </div>











        @endsection
        @push('scripts')
        @endpush
