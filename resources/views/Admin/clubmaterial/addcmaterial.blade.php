@extends('Admin.layout.master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.0/css/bootstrap-select.min.css" />
<style>
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 455px;
    display:block;
    left:0;
    right:0;
}

.bootstrap-select.btn-group .dropdown-toggle .filter-option {
    display: inline-block;
    overflow: hidden;
    width: 100%;
    text-align: left;
}
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
<h3 class="panel-title">Club Materials</h3>
</div>
<div class="panel-body">
<div class="row">
<div class="col-xl-5 col-lg-10 col-md-12 col-sm-10 mx-auto text-center form p-4">
<h1 class="display-4 py-2 text-truncate">Club Materials</h1>
<div class="px-2">
<form action="/add-cmaterial" method="POST" enctype="multipart/form-data" class="justify-content-center">
@csrf
<div class="form-row">
<div class="form-group col-md-6">
<select class="selectpicker" id="categoryList" name="club_id" data-live-search="true">
<option value="selected">Select Club</option>
@if($clubs)
@foreach($clubs as $user)
<option value="{{$user->id}}">{{$user->club_name}}</option>
@endforeach
@endif
</select>
<span class="text-danger">@error('club_id') {{$message}}  @enderror</span>
</div>
<div class="form-row">
<div class="form-group col-md-6">
<select class="selectpicker" multiple id="material_id" name="material_id[]" title="Select Material" data-live-search="true">
@if($mats)
@foreach($mats as $mat)
<option value="{{$mat->id}}">{{$mat->mat_name}}</option>
@endforeach
@endif
</select>
<span class="text-danger">@error('material_id') {{$message}}  @enderror</span>
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