@extends('admin.layout.master')
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
<h3 class="panel-title">Add Club</h3>
</div>
<div class="panel-body">
<div class="row">
<div class="col-xl-5 col-lg-10 col-md-12 col-sm-10 mx-auto text-center form p-4">
<h1 class="display-4 py-2 text-truncate">Add Club</h1>
<div class="px-2">
<form action="/add-club" method="POST" enctype="multipart/form-data" class="justify-content-center">
@csrf
<div class="form-row">
<div class="form-group col-md-6">
<input type="text" id="name" name="club_name" class="form-control" placeholder="Name">
<span class="text-danger">@error('club_name') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<label class="sr-only">Name</label>
<input type="number" name="phone" id="phone" class="form-control" placeholder="Phone">
<span class="text-danger">@error('phone') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<input type="text" name="address1" id="address" class="form-control" placeholder="Street">
<span class="text-danger">@error('address1') {{$message}}  @enderror</span>
</div>
</div>
<div class="form-row">
<div class="form-group col-md-6">
<label class="sr-only">Shipping Address</label>
<input type="text" name="address2" id="customers_street_address" class="form-control" placeholder="Address">
<span class="text-danger">@error('address2') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<label class="sr-only">Shipping Address</label>
<input type="text" name="city" id="customers_street_address" class="form-control" placeholder="City">
<span class="text-danger">@error('city') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<label class="sr-only">Shipping Address</label>
<input type="text" name="zipcode" id="customers_street_address" class="form-control" placeholder="Zipcode">
<span class="text-danger">@error('zipcode') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<label class="sr-only">Shipping Address</label>
<input type="text" name="website" id="website" class="form-control" placeholder="Website">
<span class="text-danger">@error('website') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<label class="sr-only">Name</label>
<input type="text" name="cvr" id="cvr" class="form-control" placeholder="CVR">
<span class="text-danger">@error('cvr') {{$message}}  @enderror</span>
</div>
<div class="form-group col-md-6">
<input type="file" name="logo" id="logo" class="form-control" placeholder="LOGO">
<span class="text-danger">@error('logo') {{$message}}  @enderror</span>
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