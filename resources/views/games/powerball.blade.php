<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('games/powerball/TemplateData/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('games/powerball/TemplateData/style.css') }}">
    <script src="{{ asset('games/powerball/TemplateData/UnityProgress.js') }}"></script>
    <script src="{{ asset('games/powerball/Build/UnityLoader.js') }}"></script>
    <script>
        var unityInstance = UnityLoader.instantiate("unityContainer", "games/powerball/Build/powerball.json", {
            onProgress: UnityProgress
        });
    </script>
    <style>
        .iframe-container {
            width: 100%;
            position: relative;
            overflow: hidden;
            padding-top: 50%;
        }

        .iframe-responsive {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            border: none;
            margin: 0px;
            padding: 0px;
        }

        .link-btn {
            text-decoration: none;
            background-color: black;
            color: white;
            padding: 6px 20px;
            border-radius: 5px;
            margin: 5px;
        }

        .doteven {
            height: 40px;
            width: 40px;
            background-color: red;
            border-radius: 50%;
            display: inline-block;
            font-size: 15px;
        }

        .dotodd {
            height: 40px;
            width: 40px;
            background-color: lightseagreen;
            border-radius: 50%;
            display: inline-block;
            font-size: 15px;
        }

        table {
            border: 5px solid white;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
        }

        table caption {
            font-size: 1.5em;
            margin: .5em 0 .75em;
        }

        table tr {
            background-color: whitesmoke;
            border: 5px solid white;
            padding: .35em;
        }

        table th,
        table td {
            padding: .625em;
            text-align: center;
        }

        table th {
            font-size: .7em;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        @media screen and (max-width: 550px) {

            table th,
            table td {
                margin-top: 20%;
                text-align: center;
                font-size: .5em;

            }

            .doteven {
                height: 27px;
                width: 25px;
                background-color: red;
                border-radius: 50%;
                display: inline-block;
                font-size: 11px;
            }

            .dotodd {
                height: 27px;
                width: 25px;
                background-color: lightseagreen;
                border-radius: 50%;
                display: inline-block;
                font-size: 11px;
            }

        }

    </style>
</head>

<body>


    <div class="webgl-content">
        <div id="unityContainer" style="width:150vh;height:90vh"></div>
        <div class="footer">
            <table style="text-align: center" class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <span style="color: lightseagreen">Odd</span>
                        </th>
                        <th scope="col">
                            <span style="color: red">Even</span>
                        </th>
                        <th scope="col">
                            <span style="color: lightseagreen">Odd</span>
                        </th>
                        <th scope="col">
                            <span style="color: red">Even</span>
                        </th>
                        <th scope="col">
                            <span style="color: lightseagreen">Odd</span>
                        </th>
                        <th scope="col">
                            <span style="color: red">Even</span>
                        </th>
                        <th scope="col">
                            <span style="color: lightseagreen">Odd</span>
                        </th>
                        <th scope="col">
                            <span style="color: red">Even</span>
                        </th>
                        <th scope="col">
                            <span style="color: lightseagreen">Odd</span>
                        </th>
                        <th scope="col">
                            <span style="color: red">Even</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="dotodd">100</span></td>
                        <td><span class="doteven">102</span></td>
                        <td><span class="dotodd">106</span></td>
                        <td><span class="doteven">108</span></td>
                        <td><span class="dotodd">109</span></td>
                        <td><span class="doteven">112</span></td>
                        <td><span class="dotodd">114</span></td>
                        <td><span class="doteven">115</span></td>
                        <td><span class="dotodd">119</span></td>
                        <td><span class="doteven">121</span></td>
                    </tr>
                    <tr>
                        <td><span class="dotodd">101</span></td>
                        <td><span class="doteven">103</span></td>
                        <td><span class="dotodd">107</span></td>
                        <td><span></span></td>
                        <td><span class="dotodd">110</span></td>
                        <td><span class="doteven">113</span></td>
                        <td><span></span></td>
                        <td><span class="doteven">116</span></td>
                        <td><span class="dotodd">120</span></td>
                        <td><span class="doteven">122</span></td>
                    </tr>
                    <tr>
                        <td><span></span></td>
                        <td><span class="doteven">104</span></td>
                        <td><span class="dotodd">104</span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span class="doteven">111</span></td>
                        <td><span></span></td>
                        <td><span class="doteven">117</span></td>
                        <td><span></span></td>
                        <td><span class="doteven">123</span></td>
                    </tr>
                    <tr>
                        <td><span></span></td>
                        <td><span class="doteven">105</span></td>
                        <td><span class="dotodd">104</span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span class="doteven">118</span></td>
                        <td><span></span></td>
                        <td><span class="doteven">124</span></td>
                    </tr>
                    <tr>
                        <td><span></span>2</td>
                        <td><span></span>4</td>
                        <td><span></span>4</td>
                        <td><span></span>1</td>
                        <td><span></span>2</td>
                        <td><span></span>3</td>
                        <td><span></span>1</td>
                        <td><span></span>4</td>
                        <td><span></span>2</td>
                        <td><span></span>4</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>






    <!--
    <div class="row">
        <div class="span12">
            <div class="webgl-content">
                <div id="unityContainer"></div>

                <div class="footer">
                    <table style="text-align: center" class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <span style="color: lightseagreen">Odd</span>
                                </th>
                                <th scope="col">
                                    <span style="color: red">Even</span>
                                </th>
                                <th scope="col">
                                    <span style="color: lightseagreen">Odd</span>
                                </th>
                                <th scope="col">
                                    <span style="color: red">Even</span>
                                </th>
                                <th scope="col">
                                    <span style="color: lightseagreen">Odd</span>
                                </th>
                                <th scope="col">
                                    <span style="color: red">Even</span>
                                </th>
                                <th scope="col">
                                    <span style="color: lightseagreen">Odd</span>
                                </th>
                                <th scope="col">
                                    <span style="color: red">Even</span>
                                </th>
                                <th scope="col">
                                    <span style="color: lightseagreen">Odd</span>
                                </th>
                                <th scope="col">
                                    <span style="color: red">Even</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="dotodd">100</span></td>
                                <td><span class="doteven">102</span></td>
                                <td><span class="dotodd">106</span></td>
                                <td><span class="doteven">108</span></td>
                                <td><span class="dotodd">109</span></td>
                                <td><span class="doteven">112</span></td>
                                <td><span class="dotodd">114</span></td>
                                <td><span class="doteven">115</span></td>
                                <td><span class="dotodd">119</span></td>
                                <td><span class="doteven">121</span></td>
                            </tr>
                            <tr>
                                <td><span class="dotodd">101</span></td>
                                <td><span class="doteven">103</span></td>
                                <td><span class="dotodd">107</span></td>
                                <td><span></span></td>
                                <td><span class="dotodd">110</span></td>
                                <td><span class="doteven">113</span></td>
                                <td><span></span></td>
                                <td><span class="doteven">116</span></td>
                                <td><span class="dotodd">120</span></td>
                                <td><span class="doteven">122</span></td>
                            </tr>
                            <tr>
                                <td><span></span></td>
                                <td><span class="doteven">104</span></td>
                                <td><span class="dotodd">104</span></td>
                                <td><span></span></td>
                                <td><span></span></td>
                                <td><span class="doteven">111</span></td>
                                <td><span></span></td>
                                <td><span class="doteven">117</span></td>
                                <td><span></span></td>
                                <td><span class="doteven">123</span></td>
                            </tr>
                            <tr>
                                <td><span></span></td>
                                <td><span class="doteven">105</span></td>
                                <td><span class="dotodd">104</span></td>
                                <td><span></span></td>
                                <td><span></span></td>
                                <td><span></span></td>
                                <td><span></span></td>
                                <td><span class="doteven">118</span></td>
                                <td><span></span></td>
                                <td><span class="doteven">124</span></td>
                            </tr>
                            <tr>
                                <td><span></span>2</td>
                                <td><span></span>4</td>
                                <td><span></span>4</td>
                                <td><span></span>1</td>
                                <td><span></span>2</td>
                                <td><span></span>3</td>
                                <td><span></span>1</td>
                                <td><span></span>4</td>
                                <td><span></span>2</td>
                                <td><span></span>4</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
-->
</body>

</html>
