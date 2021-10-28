@extends('Admin.layout.master')
<style>
#mat_image::before {
    content: "Attach Meterial Image: ";
    color: black;
    margin-right: 10px; 
}
#icon::before {
    content: "Attach Meterial Icon: ";
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
<h3 class="panel-title">Add Materials</h3>
</div>
<div class="panel-body">
<div class="row">
<div class="col-xl-5 col-lg-10 col-md-12 col-sm-10 mx-auto text-center form p-4">
<h1 class="display-4 py-2 text-truncate">Add Material</h1>
<div class="px-2">
<form action="/add-material" method="POST" enctype="multipart/form-data" class="justify-content-center">
@csrf
<div class="form-row">
<div class="form-group col-md-6">
<input type="text" id="name" name="mat_name" class="form-control" placeholder="Name">
<span class="text-danger">@error('name') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<input type="number" id="price" name="price" class="form-control" placeholder="Price">
<span class="text-danger">@error('price') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<input type="text" id="supplier" name="supplier" class="form-control" placeholder="Supplier">
<span class="text-danger">@error('supplier') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<input type="file" name="mat_image" id="mat_image" class="form-control" placeholder="LOGO">
<span class="text-danger">@error('mat_image') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<input type="file" name="icon" id="icon" class="form-control" placeholder="LOGO">
<span class="text-danger">@error('icon') {{$message}}  @enderror</span>
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