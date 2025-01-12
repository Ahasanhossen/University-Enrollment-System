@extends('layouts.admin')

@section('head')
<title>PUC-Admin | Overlap List</title>
@endsection

@section('main')
<ul class='navbar-nav d-flex flex-row mainopt'>
    <li class='nav-item'>
        <a class='nav-link text-uppercase options mr-1 mt-2 mb-0 px-4' href='sessionlist'> Session List </a>
    </li>
    <li class='nav-item'>
        <a class='nav-link text-uppercase options mr-1 mt-2 mb-0 px-4' href='courselimit'> Course Limitations </a>
    </li>
    <li class='nav-item'>
        <a class='nav-link text-uppercase options mr-1 mt-2 mb-0 px-4' href='overlaplist'> Overlap List </a>
    </li>
</ul>
<div class="optionline d-none d-sm-block">
    <span></span>
</div>
<br>
<div class="mainpage">
    @if($data->count())
    <form target="_self" enctype="multipart/form-data" method="get" id="form1" class="animate__animated animate__zoomIn">
        @csrf
        <div class="form-group row">
            <label for="teaid" class="col-sm-2 col-form-label">Select Available Session </label>
            <div class="col-sm-10">
                <select type="text" class="form-control" id="session" name="session" value="{{ old('session') }}" required>
                    <option value="" disabled selected>Select Session</option>
                    @foreach($data as $d)
                    @if (old('session')==$d->name)
                    <option value={{$d->name}} selected>{{$d->name }}</option>
                    @else
                    <option value="{{$d->name}}"> {{$d->name}}</option>
                    @endif
                    @endforeach
                </select>
                @if ($errors->has('session'))
                <div class="form-text alert alert-danger"> {{ $errors->first('session') }} </div>
                @endif
            </div>
        </div>
        <div class="form-group row text-center">
            <div class="col-sm-10">
                <button type="submit" name="search" class="btn btn-outline-info">Submit</button>
            </div>
        </div>
    </form>
    @else
    <p class="alert alert-danger text-center">Enrollment Closed</p>
    @endif
    @if(isset($_GET['search']))
    <style>
        #form1 {
            display: none;
        }
    </style>
    @php($sessionname=$_GET['session'])
    <div>
        <p class="text-right"><b>Session:</b> {{$sessionname}}</p>
        <p class="text-right"><b>Exam Type:</b> Regular, Recourse</p>
    </div>
    <hr>
    <table class='table table-sm table-striped table-hover table-responsive-sm text-center list' id='overlaplist'>
        <thead class="tableheader">
            <th>Course</th>
            <th>Overlapped Course</th>
            <th>Overlapped Students</th>
        </thead>
        <tbody class="table-bordered">
            @if(count($overlap) > 0)
            @foreach(array_values($course) as $i)
            @foreach (array_values($course) as $j)
            @if($i === $j or $overlap[$i][$j] == 'Same Semester' or $overlap[$i][$j] == 'Already Counted' or $overlap[$i][$j] == '0')
            @continue
            @endif
            <tr>
                <td class='animate__animated animate__fadeIn animate__slower'>
                    {{ array_keys($course)[$i-1] }} (Semester: {{ $semester[array_values($course)[$i-1]] }} )
                </td>
                <td class="animate__animated animate__fadeIn animate__slower">
                    {{ array_keys($course)[$j-1] }} (Semester: {{ $semester[array_values($course)[$j-1]] }})
                </td>
                <td class="animate__animated animate__fadeIn animate__slower">
                    {{ $overlap[$i][$j] }}
                </td>
            </tr>
            @endforeach
            @endforeach
            @else
            <tr class="text-center">
                <td colspan="9">No Overlap Found</td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif
    <script>
        $(document).ready(function() {
            $('#overlaplist').DataTable();
        });
        $('#overlaplist').dataTable({
            "pagingType": "full_numbers",
            language: {
                paginate: {
                    first: '«',
                    previous: '‹',
                    next: '›',
                    last: '»'
                },
                aria: {
                    paginate: {
                        first: 'First',
                        previous: 'Previous',
                        next: 'Next',
                        last: 'Last'
                    }
                },
                "lengthMenu": "Show _MENU_ Entries<br><br>List of Overlapped Courses",
                // "info": "",
            },
            "order": [],
            "lengthMenu": [20, 50, 100],
            columnDefs: [{
                orderable: false,
                targets: [0, 1]
            }],
        });
    </script>
</div>
@endsection