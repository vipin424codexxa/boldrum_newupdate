@extends('Admin.layout.master')
@section('content')
<style>
.float-right{
    float:right;
    position:sticky;
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
                        <a href="/add-ballroom" class="btn btn-primary float-right">Add Ballroom</a>
                        <h3 class="panel-title">Ballrooms</h3>
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
									<!-- <h3 class="panel-title">Basic Table</h3> -->
								</div>
								<div class="panel-body">
								<table class="table">
										<thead>
											<tr>
												<th>ID</th>
												<table class="table">
										<thead>
											<tr>
												<th>ID</th>
												<th>Name</th>
												<th>Owner</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach($items as $item)
											<tr>
												<td>{{$item->id}}</td>
												<td>{{$item->name}}</td>
												<td>{{$item->owner}}</td>
												<td>{{$item->creation_date}}</td>
												<td><a href="{{'delete_ballroom/' .$item->id }}" onclick="return confirm('Are you sure you want to delete this Roles?');" class="">                   
                                                <img src="https://img.icons8.com/wired/30/000000/delete-forever.png"/></a></td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
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