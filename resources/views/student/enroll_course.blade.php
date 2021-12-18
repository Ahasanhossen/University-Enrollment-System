@extends('layouts.student')

@section('head')
<title>PUC-Student Home | Student</title>
@endsection

@section('main')
<nav class='navbar navbar-expand-sm navbar-light mainopt'>
    <!-- <div class="d-block d-md-none">
        <span>Click here for more options</span>
    </div> -->
    <button class='navbar-toggler' style="background-image: url(images/3.png);" type='button' data-toggle='collapse' data-target='#collapsibleNavbar'>
        <span class='navbar-toggler-icon'></span>
    </button>
    <div class='collapse navbar-collapse' style="text-align: center;" id='collapsibleNavbar'>
        <ul class='navbar-nav'>
            <li class='nav-item'>
                <a class='nav-link text-uppercase options mr-1 mt-2 mb-0 px-5' href='enrollcourse'> Enrollment </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link text-uppercase options mr-1 mt-2 mb-0 px-5' href='checkrequests'> Check Requests </a>
            </li>
        </ul>
    </div>
</nav>
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
    <form target="_self" enctype="multipart/form-data" method="post" id="form2" action="{{ URL::to('enrollmentfinal')}}" class="animate__animated animate__zoomIn">
        @csrf
        <span style="float: left; font-family: Palatino Linotype, Verdana; font-size: 12pt">
            List of all Courses({{$data->count()}} Entries)
        </span>
        <table class='table table-sm table-striped table-hover table-responsive-sm text-center list' id='counterlist'>
            <thead class="tableheader">
                <th>No.</th>
                <th></th>
                <th>Title</th>
                <th>Code</th>
                <th>Type</th>
                <th>Credit</th>
                <th>Department</th>
                <th>Semester</th>
                <th>Exam Type</th>
            </thead>
            <tbody class="table-bordered">
                @if($data2->count())
                @foreach($data2 as $value)
                <tr>
                    <td class='animate__animated animate__fadeIn animate__slower'>{{$loop->iteration}}</td>
                    <td><input id="check" type="checkbox" name="slectcourse[]" value="{{$value->id}}"></td>
                    <td class='animate__animated animate__fadeIn animate__slower'>{{$value->title}}</td>
                    <td class='animate__animated animate__fadeIn animate__slower'>{{$value->code}}</td>
                    <td class='animate__animated animate__fadeIn animate__slower'>{{$value->type}}</td>
                    <td class='animate__animated animate__fadeIn animate__slower' >{{$value->credit}}</td>
                    <td class='animate__animated animate__fadeIn animate__slower'>{{$value->department}}</td>
                    <td class='animate__animated animate__fadeIn animate__slower'>{{$value->semester}}</td>
                    <td class='animate__animated animate__fadeIn animate__slower'>
                        <select type="text" class="form-control" id="examtype" name="examtype[]" value="">
                            <option value="" disabled selected> Select Type</option>
                            <option value="Regular"> Regular </option>
                            <option value="Recourse"> Recourse</option>
                        </select>
                    </td>
                    <input type="hidden" name="session" class="session" value="{{$sessionname}}">
                </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="9">No Course Found</td>
                </tr>
                @endif
            </tbody>
        </table>
        @if ($errors->has('examtype'))
        <div class="form-text alert alert-danger"> {{ $errors->first('examtype') }} </div>
        @endif
        <div>
            @if ($errors->has('slectcourse'))
            <div class="form-text alert alert-danger"> {{ $errors->first('slectcourse') }} </div>
            @endif
        </div>
        <div class="form-group row text-center">
            <div class="col-sm-10">
                <button type="submit" name="submit" class="btn btn-outline-info">Submit</button>
            </div>
        </div>
    </form>
    @endif
</div>
@endsection