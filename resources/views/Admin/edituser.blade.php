@extends('Admin.layout.master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.0/css/bootstrap-select.min.css" />
<style>
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 400px;
    display:block;
    left:0;
    right:0;
}

.bootstrap-select.btn-group .dropdown-toggle .filter-option {
    display: inline-block;
    overflow: hidden;
    width: 100%;
    text-align:left;
}
/* input[type=file] {
      color: transparent !important;
  } */
input[type=file]::before {
    content: "Attach Your Profile Picture: ";
    color: black;
    margin-right: 10px; 
}
</style>
@section('content')
<div id="wrapper">
<!-- MAIN -->
<div class="main">
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">
<!-- OVERVIEW -->
<div class="panel panel-headline">
<div class="panel-heading">
<h3 class="panel-title">Edit User</h3>
</div>
<div class="panel-body">
<div class="row">
<div class="col-xl-5 col-lg-10 col-md-12 col-sm-10 mx-auto text-center form p-4">
<h1 class="display-4 py-2 text-truncate">Update User</h1>
<div class="px-2">
<form action="/usersupdate" method="POST" 
enctype="multipart/form-data" class="justify-content-center">
    {{ csrf_field() }}
<div class="form-row">
<div class="form-group col-md-6">
    <input type='hidden' name="id" value="{{$data->id}}">
    <select class="selectpicker" id="type" name="club_id" data-live-search="true">
      <option value="" selected>Select Club</option>
      @if($users)
        @foreach($users as $user)
        <option value="{{$user->id}}" {{ $user->id == $data->club_id ? 'selected' : '' }}>{{$user->club_name}}</option>
        @endforeach
        @endif
      </select>
      <span class="text-danger">@error('club_id') {{$message}}  @enderror</span>
    </div>
    <div class="form-group col-md-6">
    <select class="selectpicker" id="role_type" name="role_id" data-live-search="true" required>
      <option value="" selected>Select Roles Type</option>
      @if($users)
        @foreach($roles as $role)
        <option value="{{$role->id}}" {{ $role->id == $data->role_id ? 'selected' : '' }}>{{$role->role_name}}</option>
        @endforeach
        @endif
      </select>
      <span class="text-danger">@error('role_id') {{$message}}  @enderror</span>
    </div>
<div class="form-group col-md-6">
<input type="text" id="name" name="name" value="{{$data->name}}" class="form-control" placeholder="Name" required>
<span class="text-danger">@error('name') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<input type="email" name="email" id="email" value="{{$data->email}}" class="form-control" placeholder="Email">
<span class="text-danger">@error('email') {{$message}}  @enderror</span>
@if($message = Session::get('error'))
<span class="text-danger">{{$message}}  </span>
 @endif
</div>
<div class="form-group col-md-6">
<input type="password" name="password" value="{{$data->view_password}}" id="password" class="form-control" placeholder="Password">
<span class="text-danger">@error('password') {{$message}}  @enderror</span>
</div>
</div>
<div class="form-row">
<div class="form-group col-md-6">
<input type="date" name="creation_date" value="{{$data->creation_date}}" id="creation_date" class="form-control" placeholder="Date">
<span class="text-danger">@error('creation_date') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<input type="file" name="profile_picture" value="{{$data->profile_picture}}"  id="profile_picture" class="form-control" placeholder="LOGO">
<span class="text-danger">@error('profile_picture') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
    <select class="selectpicker" multiple id="categoryList" title="Select Ballrooms" name="ball_id[]" data-live-search="true">
      @if($users)
        @foreach($balls as $ball)
        <option value="{{$ball->id}}" {{ $ball->id == $data->ball_id ? 'selected' : '' }}>{{$ball->name}}</option>
        @endforeach
        @endif
      </select>
      <span class="text-danger">@error('ballroom_id'){{$message}}  @enderror</span>
    </div>
<div class="form-group col-md-2">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
</div>
</div>

</div> 
<!-- END REALTIME CHART -->
</div>
</div>
</div>
</div>
<!-- END MAIN CONTENT -->
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.0/js/bootstrap-select.min.js"></script>
@endsection