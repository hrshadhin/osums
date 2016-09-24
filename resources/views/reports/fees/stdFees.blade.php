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
#footer
{

  width:100%;
  height:50px;
  position:absolute;
  bottom:0;
  left:0;
}
</style>
</head>
<body>

  <table>

    <tr>
      <td style="vertical-align:center;text-align:right;"><img src="/assets/images/logo.jpg" /></td>
      <td  colspan="4" style="text-align:center;vertical-align:center">
        <h2>{{$metaData->institute}}<h2>
          <h3>Student Fee Collection Report</h3>
        </td>
      </tr>
    </table>
    <hr>
    <table class="tb_info">
      <tr>
        <td><strong>Name Of Student:</strong></td>
        <td colspan="2">{{$metaData->name}}</td>
        <td><strong>Date of birth:</strong></td>
        <td colspan="2"> {{$metaData->dob}}</td>
        <td><strong>Id No:</strong></td>
        <td colspan="2">{{$metaData->idNo}}</td>
      </tr>
      <tr>
        <td><strong>BNC Reg.</strong></td>
        <td colspan="2">{{$metaData->bncReg}}</td>
        <td><strong>Father's name:</strong></td>
        <td colspan="2">{{$metaData->fatherName}}</td>
        <td><strong>Mother's name:</strong></td>
        <td colspan="2"> {{$metaData->motherName}}</td>

      </tr>
      <tr>
        <td><strong>Department:</strong></td>
        <td colspan="5">{{$metaData->department}}</td>
        <td><strong>Session:</strong></td>
        <td colspan="2">{{$metaData->session}}</td>
      </tr>
    </table>
    <hr>
    <!-- Fee List -->
    @if($fees)
    <div class="row">
      <div class="col-md-12">
        <table id="feeList" class="grid">
          <thead>
            <tr>
              <th>Bill No</th>
              <th>Payable Amount</th>
              <th>Paid Amount</th>
              <th>Due Amount</th>
              <th>Pay Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($fees as $fee)
            <tr>
              <td>0{{$fee->id}}</td>
              <td>{{$fee->payableAmount}}</td>
              <td>{{$fee->paidAmount}}</td>
              <td>{{$fee->dueAmount}}</td>
              <td>{{$fee->payDate->format('F j,Y')}}</td>
            </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
          <table class="table">
            <tbody>
              <tr>
                <td></td>
                <td>Total Payable: <strong><i class="blue">{{$totals->payTotal}}</i></strong> tk.</td>
                <td>Total Paid: <strong><i class="blue">{{$totals->paiTotal}}</i></strong> tk.</td>
                <td>Total Due: <strong><i class="blue">{{$totals->dueamount}}</i></strong> tk.</td>
                <td></td>
                <td>
                </td>
              </tr>
              </tbody>
            </table>
          </div>

        </div>
        @else
        <h2 style="color:red">There are no fee record for this student.</h2>
        @endif
        <br><br><br><br><br>
        <!-- Office --->
        <table style="text-align:left">
          <tr>
            <th >Prepared by</th>
            <th>Checked & Verified by<br>Date:------- </th>
            <th>Principal </th>

          </tr>
          <tr>
            <td >-----------------</td>
            <td >-------------------------------</td>
            <td >----------------</td>

          </tr>
        </table>
        <!-- Fee List END-->
        <div id="footer">
          <p>Print Date: {{date('d/m/Y')}}</p>
        </div>

      </body>
      </html>
