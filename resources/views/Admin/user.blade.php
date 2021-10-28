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
						@if(Auth()->user()->type == 2)
                        <a href="{{ route('users.create') }}" class="btn btn-primary float-right">New User</a>
						@endif
							<h3 class="panel-title">User</h3>
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
												<th>Club</th>
												<th>Name</th>
												<th>Role Type</th>
												<th>Email</th>
												<th>Creation Date</th>
												<th>Status</th>
												<th>Invite</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach($items as $item)
											<tr>
												<td>{{$item->id}}</td>
												<td>{{$item->club_name}}</td>
												<td>{{$item->name}}{{ ($item->type==2)?'(Club Admin)':'(User)' }}</td>
												<td>{{$item->role_name}}</td>
												<td>{{$item->email}}</td>
												<td>{{$item->creation_date}}</td>
												<td>{{($item->user_status)?'Active':'In Active'}}</td>
								@if(Auth()->user()->type == 2)
                                  <td>
                        <a href="{{ route('inviteUser',$item->id) }}" class="btn btn-primary">Invite User</a></td>
                        @endif
												<td>
													<form action="{{ route('users.destroy',$item->id) }}" method="POST">
														{{-- <a class="btn btn-info" href="{{ route('users.show',$item->id) }}">Show</a>--}}
														<a class="btn btn-success" href="{{ route('users.edit',$item->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
														<br>
														@csrf
														@method('DELETE')
														<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this User?');"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
													</form>
												</td>												
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