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
            <th style="text-align: center" colspan="5">Midterm Exam(100)</th>
            <th style="text-align: center" colspan="5">Final Exam(100)</th>
            <th class="rotate">AVG<br>Total</th>
            <th class="rotate">Grade</th>
        </tr>

        <tr>

            <td >Written</td>
            <td >Quiz</td>
            <td>Present.</td>
            <td>Lab</td>
            <td>Total</td>
            <td >Written</td>
            <td >Quiz</td>
            <td>Presentation</td>
            <td>Lab</td>
            <td>Total</td>

        </tr>
        @foreach($students as $student)
        <tr>
            <td colspan="2">{{$student['idNo']}}</td>
            <td colspan="2">{{$student['name']}}</td>
            <td >{{$student['m_written']}}</td>
            <td >{{$student['m_quiz']}}</td>
            <td>{{$student['m_presentation']}}</td>
            <td>{{$student['m_lab']}}</td>
            <td >{{$student['m_total_marks']}}</td>
            <td >{{$student['f_written']}}</td>
            <td >{{$student['f_quiz']}}</td>
            <td>{{$student['f_presentation']}}</td>
            <td>{{$student['f_lab']}}</td>
            <td >{{$student['f_total_marks']}}</td>

            <td >{{$student['avg_total_marks']}}</td>
            <td>{{$student['grade']}}</td>


        </tr>
        @endforeach

    </table>
</body>
</html>
