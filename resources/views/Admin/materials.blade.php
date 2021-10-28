@extends('Admin.layout.master')
@section('content')
<style>
.float-right{
    float:right;
    position:sticky;
}
.mat-img{
	width:150px;
	height:80px;
}
}
</style>
<div id="wrapper">
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
                        <a href="/add-material" class="btn btn-primary float-right">Add Material</a>
                        <h3 class="panel-title">Materials</h3>
                        @if($message = Session::get('success'))
                        <div class="alert alert-success text-center alert-dismissible" role="alert">{{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>   
                        </div>
                        @endif
						</div>
						<div class="panel-body">
							<div class="row">

							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">

								</div>
								<table class="table">
										<thead>
											<tr>
												<th>ID</th>
												<th>Material Name</th>
												<th>Supplier</th>
												<th>Price</th>
												<th>Material Image</th>
												<th>Material Icon</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach($materials as $item)
											<tr>
												<td>{{$item->id}}</td>
												<td>{{$item->mat_name}}</td>
												<td>{{$item->supplier}}</td>
												<td>{{$item->price}}</td>
												<td><img src="{{asset('upload/'.$item->mat_image)}}" class="mat-img"></td>
												<td><img src="{{asset('upload/'.$item->icon)}}" class="mat-img"></td>
												<td><a href="{{'delete_material/' .$item->id }}" onclick="return confirm('Are you sure you want to delete this User?');" class="">                   
                                                <img src="https://img.icons8.com/wired/30/000000/delete-forever.png"/></a></td>
											</tr>
											@endforeach
										</tbody>
									</table>
							</div>
							<!-- END BASIC TABLE -->
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