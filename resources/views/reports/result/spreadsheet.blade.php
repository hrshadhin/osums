<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}
.grid th {
    height: 50px;
}
.grid th,td {
    border: 1px solid black;
}
.rotate {
  /* FF3.5+ */
  -moz-transform: rotate(-90.0deg);
  /* Opera 10.5 */
  -o-transform: rotate(-90.0deg);
  /* Saf3.1+, Chrome */
  -webkit-transform: rotate(-90.0deg);
  /* IE6,IE7 */
  filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
  /* IE8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
  /* Standard */
  transform: rotate(-90.0deg);
      font-size: small;
}
</style>
</head>
<body>
    <center>
        <table>
            <thead>
                <tr>
                    <th colspan="5">{{$metaData->institute}}</th>
                </tr>
                <tr>
                    <th colspan="5">{{$metaData->department}}</th>
                </tr>
                <tr>
                    <th colspan="5">{{$metaData->semester}}</th>
                </tr>
                <tr>
                    <th colspan="5">Result Sheet of Final Exam {{$metaData->monthYear}}</th>
                </tr>
                <tr>
                    <th colspan="5">Session: {{$metaData->session}}</th>
                </tr>
                <tr>
                    <th colspan="5">Sub: {{$metaData->subject}}</th>
                </tr>
            </thead>
        </table>
    </center>
    <table class="grid">

        <tr>
            <th colspan="2" rowspan="2">Id NO</th>
            <th colspan="2" rowspan="2">Name</th>
            <th style="text-align: center" colspan="4">Midterm Exam(50)</th>
            <th style="text-align: center" colspan="4">Final Exam(100)</th>
            <th style="text-align: center" colspan="4">Lab & Quiz (20+80)</th>
            <th class="rotate" rowspan="2">Total<br>Score</th>
            <th class="rotate" rowspan="2">Total<br>Weight</th>
            <th class="rotate" rowspan="2">Grade<br>Point<br>(Total Score/<br>Total Weight)</th>
            <th class="rotate" rowspan="2">Grade</th>
        </tr>

        <tr>

            <td >Raw Score</td>
            <td >%</td>
            <td>Weight</td>
            <td>% X Weight</td>
            <td >Raw Score</td>
            <td >%</td>
            <td>Weight</td>
            <td>% X Weight</td>
            <td >Raw Score</td>
            <td >%</td>
            <td>Weight</td>
            <td>% X Weight</td>

        </tr>
        @foreach($students as $student)
        <tr>
            <td colspan="2">{{$student['idNo']}}</td>
            <td colspan="2">{{$student['name']}}</td>
            <td >{{$student['m_Raw']}}</td>
            <td >{{$student['m_percentage']}}</td>
            <td>{{$student['m_weight']}}</td>
            <td>{{$student['m_percentage_x_weight']}}</td>

            <td >{{$student['f_Raw']}}</td>
            <td >{{$student['f_percentage']}}</td>
            <td>{{$student['f_weight']}}</td>
            <td>{{$student['f_percentage_x_weight']}}</td>

            <td >{{$student['l_Raw']}}</td>
            <td >{{$student['l_percentage']}}</td>
            <td>{{$student['l_weight']}}</td>
            <td>{{$student['l_percentage_x_weight']}}</td>



            <td >{{$student['total_score']}}</td>
            <td >{{$student['total_weight']}}</td>
            <td>{{round($student['grade_point'],2)}}</td>
            <td>{{$student['grade']}}</td>


        </tr>
        @endforeach

    </table>
</body>
</html>
