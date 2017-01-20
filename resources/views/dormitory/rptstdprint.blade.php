<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
@media print {
 @page { margin: 0; }
 body { margin: 1.6cm; }
 body {-webkit-print-color-adjust: exact;}
}
.bg{
 width: 100%;
 background-color:#dcdcdc;
}
.bg2{
 width: 100%;
background-color:#cccccc;
}
.bg3{
  width: 100%;

}
.bg3 tr:nth-child(even) {
    background-color: #81DAF5;
}
.bg3 tr:nth-child(odd) {
    background-color: #82FA58;
}

table {
border-spacing: 0;
border-collapse: separate;

}
table td{
padding-left: 5px;
}
.thead td{
  border-bottom: solid green 2px;
  font-weight: bold;
  color:blue;
}
.red
{
  color:red;
  font-weight: bold;
}
.green {
  color:green;
  font-weight: bold;
}
.logo{
  height: 150px;
  width: 200px;
}
.lefthead{
  width: 30%;
}
.righthead{
  width: 70%;
}
.righthead p{
  margin: 0px;
  padding: 0px;
}
#footer
{
padding-left: 15px;
width:100%;
height:50px;
position:absolute;
bottom:0;
left:0;
}
</style>
</head>

<body >
<div id="admit">
  <table class="bg">
    <tr>
    <td class="lefthead">

     <img class="logo" src="{{url('/')}}/assets/images/logo.jpg">
    </td>

   <td class="righthead">
     <h3>{{$institute->name}}</h3><pre>
<p><strong>Establish:</strong> {{$institute->establish}}</p>
<p><strong>Web:</strong> {{$institute->web}}</p>
<p><strong>Email:</strong> {{$institute->email}}</p>
<p><strong>Phone:</strong> {{$institute->phoneNo}}</p>
<p><strong>Address:</strong> {{$institute->address}}</p>
     </pre>
   </td>
   </tr>

 </table>
 <table class="bg2">
   <tr><td>
    Dormitory Report
  </td>
  <td><strong>{{$rdata['name']}}</strong></td>
  <td >

  </td>
</tr>
</table>
<br>
<table class="bg3">

    <tr class="thead">
      <th>Name</th>
      <th>Contact</th>
      <th>Department</th>
      <th>Id No</th>
      <th>Guardian's Contact</th>
      <th>Room No</th>
      <th>Fee</th>
      <th>Joind Date</th>
      <th>Leave Date</th>
      <th>Is Active</th>
    </tr>
          @foreach($students as $student)
          <tr>
            <td>{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</td>
            <td>{{$student->mobileNo}}</td>
            <td>{{$student->department}}</td>
            <td>{{$student->idNo}}</td>
            <td>{{$student->fatherMobileNo}}</td>
            <td>{{$student->roomNo}}</td>
            <td>{{$student->monthlyFee}}</td>
            <td>{{date('M,j Y',strtotime($student->joinDate))}}</td>
            <td>@if($student->leaveDate){{date('M,j Y',strtotime($student->leaveDate))}}@endif</td>
            <td>{{$student->isActive}}</td>
            @endforeach

<br>

</table>

<table>
 <tr>  <td><strong>Total Rooms:</strong></td><td>{{$rdata['totalr']}}</td><td>&nbsp;&nbsp;</td><td><strong>Total Students:</strong></td><td>{{$rdata['totals']}}</td> <tr>
</table>
<div id="footer">
  <p>Print Date: {{date('d/m/Y')}}</p>
</div>
<script type="text/javascript">
  window.print();
</script>
</body>
</html>
