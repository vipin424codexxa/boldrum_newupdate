@extends('Admin.layout.master')
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
<h3 class="panel-title">Add Ballroom</h3>
</div>
<div class="panel-body">
<div class="row">
<div class="col-xl-5 col-lg-10 col-md-12 col-sm-10 mx-auto text-center form p-4">
<h1 class="display-4 py-2 text-truncate">Add Ballroom</h1>
<div class="px-2">
<form action="/add-ballroom" method="POST" enctype="multipart/form-data" class="justify-content-center">
@csrf
<div class="form-row">
<div class="form-group col-md-6">
<input type="text" id="name" name="name" class="form-control" placeholder="Name">
<span class="text-danger">@error('name') {{$message}}  @enderror</span>
</div>
<div class="form-row">
<div class="form-group col-md-6">
<label class="sr-only">Shipping Address</label>
<input type="date" name="creation_date" id="creation_date" class="form-control" placeholder="Date">
<span class="text-danger">@error('creation_date') {{$message}}  @enderror</span>
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
@endsection