<html>
<head>
<style>
html, body {
  width: 210mm;
  height: 297mm;
  /* to centre page on screen*/
  margin-left: auto;
  margin-right: auto;
}

@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
}
table {
  width: 100%;
}
.grid th {
  height: 50px;
}
.grid{
  border-collapse: collapse;
  text-align: center;
}
.grid th, .grid td {
  border: 1px solid black;
}
.gradeSystem {
  border: 1px solid black;
  text-align: justify;
  padding-left: 5px;
}
.tb_info td{
  text-align: left;
}
h2{
  font-size: 1.8em;
}
h3{
  font-size: 1.5em;
}
.pull-right{
  text-align: right;
}
.text-center{
  text-align: center;
}
</style>
</head>
<body>

  <table>

    <tr>
      <td width="20%"style="vertical-align:center;text-align:right;"><img height="80px;" width="80px;" src="assets/images/logo.jpg" /></td>
      <td width="60%" style="text-align:center;vertical-align:center">
        <h2>{{$metaData->institute}}<h2>
        </td>
        <td width="20%"style="text-align:right;vertical-align:top">
          Book:..................<br>
          Serial No:..................<br>
          Date:..................
        </td>

      </tr>
      <tr>
        <td width="20%"></td>
        <td width="60%" style="text-align:center;vertical-align:top">
          <h3>Transcript of Academic Records</h3>
        </td>
        <td width="20%" style="vertical-align:top">
          <div class="gradeSystem">
            A= 4(80.00-100%)<br>
            B= 3(70.00-79.99%)<br>
            C= 2(60.00-69.99%)<br>
            D= 1(50.00-59.99%)<br>
            F= Fail(<49.99%)<br>
          </div>
        </td>
      </tr>
    </table>
    <table class="tb_info">
      <tr>
        <td><strong>Name Of Student:</strong></td>
        <td colspan="2">{{$metaData->name}}</td>
        <td><strong>Date of birth:</strong></td>
        <td colspan="2"> {{$metaData->dob}}</td>
        <td colspan="2"><strong>Id No:</strong> {{$metaData->idNo}}</td>
      </tr>
      <tr>
        <td colspan="2"><strong>BNC Reg.</strong> {{$metaData->bncReg}}</td>
        <td><strong>Father's name:</strong></td>
        <td colspan="2">{{$metaData->fatherName}}</td>
        <td><strong>Mother's name:</strong></td>
        <td colspan="2"> {{$metaData->motherName}}</td>

      </tr>
      <tr>
        <td colspan="4"><strong>Department:</strong> {{$metaData->department}}</td>
        <td colspan="2"><strong>Examination:</strong> {{$metaData->exam}}</td>
        <td colspan="2"><strong>Session:</strong> {{$metaData->session}}</td>
      </tr>
    </table>
    <br>
    <table class="grid">

      <tr>
        <th colspan="2">Year & Semester</th>
        <th style="text-align: center" colspan="4">Course </th>
        <th style="text-align: center">Credit earned</th>
        <th style="text-align: center">Letter Grade</th>
        <th style="text-align: center">Point</th>
        <th>Semester Grade</th>
        <th>Year Grade GPA</th>
      </tr>

      @foreach ($L1T1data->subjects as $key => $subject)
      @if($key==0)
      <tr>
        <td rowspan="{{count($L1T1data->subjects)+1}}" colspan="2"> Year 1<br>Semeser 1
          <br><br>
          {{$L1T1data->monthYear}}
        </td>
        <td colspan="4">{{$subject['course']}}</td>
        <td>{{$subject['credit']}}</td>
        <td>{{$subject['grade']}}</td>
        <td>{{$subject['point']}}</td>
        <td rowspan="{{count($L1T1data->subjects)+1}}">{{$L1T1data->semGrade}}</td>
        <td rowspan="{{count($L1T1data->subjects)+count($L1T2data->subjects)+2}}">{{$fyData['grade']}}</td>
      </tr>
      @else
      <tr>
      <td colspan="4">{{$subject['course']}}</td>
      <td>{{$subject['credit']}}</td>
      <td>{{$subject['grade']}}</td>
      <td>{{$subject['point']}}</td>
    </tr>
      @endif

      @endforeach

      <tr>
        <td colspan="4"><strong>Total Credit<strong></td>
        <td><strong>{{$L1T1data->totalCredit}}</strong></td>
        <td></td>
        <td><strong>{{$L1T1data->totalPoint}}</strong></td>

      </tr>
      @foreach ($L1T2data->subjects as $key => $subject)
      @if($key==0)
      <tr>
        <td rowspan="{{count($L1T2data->subjects)+1}}" colspan="2"> Year 1<br>Semeser 2
          <br><br>
          {{$L1T2data->monthYear}}
        </td>
        <td colspan="4">{{$subject['course']}}</td>
        <td>{{$subject['credit']}}</td>
        <td>{{$subject['grade']}}</td>
        <td>{{$subject['point']}}</td>
        <td rowspan="{{count($L1T2data->subjects)+1}}">{{$L1T2data->semGrade}}</td>

      </tr>
      @else
      <tr>
      <td colspan="4">{{$subject['course']}}</td>
      <td>{{$subject['credit']}}</td>
      <td>{{$subject['grade']}}</td>
      <td>{{$subject['point']}}</td>
    </tr>
      @endif

      @endforeach

      <tr>
        <td colspan="4"><strong>Total Credit<strong></td>
        <td><strong>{{$L1T2data->totalCredit}}</strong></td>
        <td></td>
        <td><strong>{{$L1T2data->totalPoint}}</strong></td>

      </tr>
      <!-- SCOND year -->
      @foreach ($L2T1data->subjects as $key => $subject)
      @if($key==0)
      <tr>
        <td rowspan="{{count($L2T1data->subjects)+1}}" colspan="2"> Year 2<br>Semeser 1
          <br><br>
          {{$L2T1data->monthYear}}
        </td>
        <td colspan="4">{{$subject['course']}}</td>
        <td>{{$subject['credit']}}</td>
        <td>{{$subject['grade']}}</td>
        <td>{{$subject['point']}}</td>
        <td rowspan="{{count($L2T1data->subjects)+1}}">{{$L2T1data->semGrade}}</td>
        <td rowspan="{{count($L2T1data->subjects)+count($L2T2data->subjects)+2}}">{{$syData['grade']}}</td>

      </tr>
      @else
      <tr>
      <td colspan="4">{{$subject['course']}}</td>
      <td>{{$subject['credit']}}</td>
      <td>{{$subject['grade']}}</td>
      <td>{{$subject['point']}}</td>
    </tr>
      @endif

      @endforeach

      <tr>
        <td colspan="4"><strong>Total Credit<strong></td>
        <td><strong>{{$L2T1data->totalCredit}}</strong></td>
        <td></td>
        <td><strong>{{$L2T1data->totalPoint}}</strong></td>

      </tr>
      @foreach ($L2T2data->subjects as $key => $subject)
      @if($key==0)
      <tr>
        <td rowspan="{{count($L2T2data->subjects)+1}}" colspan="2"> Year 2<br>Semeser 2
          <br><br>
          {{$L2T2data->monthYear}}
        </td>
        <td colspan="4">{{$subject['course']}}</td>
        <td>{{$subject['credit']}}</td>
        <td>{{$subject['grade']}}</td>
        <td>{{$subject['point']}}</td>
        <td rowspan="{{count($L2T2data->subjects)+1}}">{{$L2T2data->semGrade}}</td>

      </tr>
      @else
      <tr>
      <td colspan="4">{{$subject['course']}}</td>
      <td>{{$subject['credit']}}</td>
      <td>{{$subject['grade']}}</td>
      <td>{{$subject['point']}}</td>
    </tr>
      @endif

      @endforeach

      <tr>
        <td colspan="4"><strong>Total Credit<strong></td>
        <td><strong>{{$L2T2data->totalCredit}}</strong></td>
        <td></td>
        <td><strong>{{$L2T2data->totalPoint}}</strong></td>

      </tr>

      <!-- Third year -->
      @foreach ($L3T1data->subjects as $key => $subject)
      @if($key==0)
      <tr>
        <td rowspan="{{count($L3T1data->subjects)+1}}" colspan="2"> Year 3<br>Semeser 1
          <br><br>
          {{$L3T1data->monthYear}}
        </td>
        <td colspan="4">{{$subject['course']}}</td>
        <td>{{$subject['credit']}}</td>
        <td>{{$subject['grade']}}</td>
        <td>{{$subject['point']}}</td>
        <td rowspan="{{count($L3T1data->subjects)+1}}">{{$L3T1data->semGrade}}</td>
        <td rowspan="{{count($L3T1data->subjects)+count($L3T2data->subjects)+2}}">{{$tyData['grade']}}</td>

      </tr>
      @else
      <tr>
      <td colspan="4">{{$subject['course']}}</td>
      <td>{{$subject['credit']}}</td>
      <td>{{$subject['grade']}}</td>
      <td>{{$subject['point']}}</td>
    </tr>
      @endif

      @endforeach

      <tr>
        <td colspan="4"><strong>Total Credit<strong></td>
        <td><strong>{{$L3T1data->totalCredit}}</strong></td>
        <td></td>
        <td><strong>{{$L3T1data->totalPoint}}</strong></td>

      </tr>
      @foreach ($L3T2data->subjects as $key => $subject)
      @if($key==0)
      <tr>
        <td rowspan="{{count($L3T2data->subjects)+1}}" colspan="2"> Year 3<br>Semeser 2
          <br><br>
          {{$L3T2data->monthYear}}
        </td>
        <td colspan="4">{{$subject['course']}}</td>
        <td>{{$subject['credit']}}</td>
        <td>{{$subject['grade']}}</td>
        <td>{{$subject['point']}}</td>
        <td rowspan="{{count($L3T2data->subjects)+1}}">{{$L3T2data->semGrade}}</td>

      </tr>
      @else
      <tr>
      <td colspan="4">{{$subject['course']}}</td>
      <td>{{$subject['credit']}}</td>
      <td>{{$subject['grade']}}</td>
      <td>{{$subject['point']}}</td>
    </tr>
      @endif

      @endforeach

      <tr>
        <td colspan="4"><strong>Total Credit<strong></td>
        <td><strong>{{$L3T2data->totalCredit}}</strong></td>
        <td></td>
        <td><strong>{{$L3T2data->totalPoint}}</strong></td>

      </tr>

       <!-- 4th year -->
       @foreach ($L4T1data->subjects as $key => $subject)
      @if($key==0)
      <tr>
        <td rowspan="{{count($L4T1data->subjects)+1}}" colspan="2"> Year 4<br>Semeser 1
          <br><br>
          {{$L4T1data->monthYear}}
        </td>
        <td colspan="4">{{$subject['course']}}</td>
        <td>{{$subject['credit']}}</td>
        <td>{{$subject['grade']}}</td>
        <td>{{$subject['point']}}</td>
        <td rowspan="{{count($L4T1data->subjects)+1}}">{{$L4T1data->semGrade}}</td>
        <td rowspan="{{count($L4T1data->subjects)+count($L4T2data->subjects)+2}}">{{$t4yData['grade']}}</td>

      </tr>
      @else
      <tr>
      <td colspan="4">{{$subject['course']}}</td>
      <td>{{$subject['credit']}}</td>
      <td>{{$subject['grade']}}</td>
      <td>{{$subject['point']}}</td>
    </tr>
      @endif

      @endforeach

      <tr>
        <td colspan="4"><strong>Total Credit<strong></td>
        <td><strong>{{$L4T1data->totalCredit}}</strong></td>
        <td></td>
        <td><strong>{{$L4T1data->totalPoint}}</strong></td>

      </tr>
      @foreach ($L4T2data->subjects as $key => $subject)
      @if($key==0)
      <tr>
        <td rowspan="{{count($L4T2data->subjects)+1}}" colspan="2"> Year 4<br>Semeser 2
          <br><br>
          {{$L4T2data->monthYear}}
        </td>
        <td colspan="4">{{$subject['course']}}</td>
        <td>{{$subject['credit']}}</td>
        <td>{{$subject['grade']}}</td>
        <td>{{$subject['point']}}</td>
        <td rowspan="{{count($L4T2data->subjects)+1}}">{{$L4T2data->semGrade}}</td>

      </tr>
      @else
      <tr>
      <td colspan="4">{{$subject['course']}}</td>
      <td>{{$subject['credit']}}</td>
      <td>{{$subject['grade']}}</td>
      <td>{{$subject['point']}}</td>
    </tr>
      @endif

      @endforeach

      <tr>
        <td colspan="4"><strong>Total Credit<strong></td>
        <td><strong>{{$L4T2data->totalCredit}}</strong></td>
        <td></td>
        <td><strong>{{$L4T2data->totalPoint}}</strong></td>

      </tr>

    </table>
    <br>
    <!--- summerize ---->
    <table class="grid">

      <tr>
        <th >Year</th>
        <th>Credit earned </th>
        <th>Point </th>
        <th>GPA</th>
        <th>Letter Grade</th>
      </tr>
      <tr>
        <td> Year 1</td>
        <td>{{$fyData['credit']}}</td>
        <td>{{round($fyData['point'],2)}}</td>
        <td rowspan="5">{{round($result['point'],2)}}</td>
        <td rowspan="5">{{$result['grade']}}</td>
      </tr>
      <tr>
        <td> Year 2</td>
        <td>{{$syData['credit']}}</td>
        <td>{{round($syData['point'],2)}}</td>
      </tr>
      <tr>
        <td> Year 3</td>
        <td>{{$tyData['credit']}}</td>
        <td>{{round($tyData['point'],2)}}</td>
      </tr>
      <tr>
        <td> Year 4</td>
        <td>{{$t4yData['credit']}}</td>
        <td>{{round($t4yData['point'],2)}}</td>
      </tr>
      <tr>
        <td style="text-align:right"> <strong>Total</strong></td>
        <td>{{$fyData['credit']+$syData['credit']+$tyData['credit']+$t4yData['credit']}}</td>
        <td></td>
      </tr>
      
    </table>
    <!-- bottom -->
    <table>
      <tr>
          <td><strong>Total Credit earned: {{$fyData['credit']+$syData['credit']+$tyData['credit']+$t4yData['credit']}}</td>
            <td class="text-center"><strong>GPA: {{round($result['point'],2)}}</strong></td>
         
          <td colspan="2"><td>
            <td class="text-center"><strong>Result: {{$result['result']}}</strong></td>
          </tr>
        </table>
        <br>
    <!-- Office --->
    <table style="text-align:left">
      <tr>
        <th >Prepared by</th>
        <th>Checked & Verified by<br>Date: </th>
        <th>Principal </th>

      </tr>
  </table>
      </body>
      </html>
