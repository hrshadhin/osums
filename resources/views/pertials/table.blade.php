<table id="datatable-buttons" class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>ID no</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $student)
        <tr>
            <td>
                <img src="{{URL::asset('assets/images/students')}}/{{$student['photo']}}" alt="Photo" class="" width="80px" height="70px" />
            </td>
            <td>{{$student['firstName']}} {{$student['middleName']}} {{$student['lastName']}}</td>
            <td>{{$student['idNo']}}</td>
            <td>
                <a title='View' target="_blank" class='btn btn-success btn-xs btnUpdate' href='{{URL::route('student.show',$student['id'] ) }}'>
                    <i class="glyphicon glyphicon-zoom-out icon-white"></i>
                </a>
                <form class="deleteForm" method="get" action="{{URL::route('student.registration.destroy',$student['id'])}}">
                    <input name="_method" type="hidden" value="DELETE" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button type="submit" class='btn btn-danger btn-xs btnDelete'> <i class="glyphicon glyphicon-trash icon-white"></i> </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>