@extends('Admin.layout.master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.0/css/bootstrap-select.min.css" />
<style>
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 300px;
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
</style>
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
							<h3 class="panel-title">Team</h3>
							@if($message = Session::get('success'))
                        <div class="alert alert-success text-center alert-dismissible" role="alert">{{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>   
                        </div>
                        @endif
                        <form action="/add-team" method="POST" enctype="multipart/form-data" class="justify-content-center">
                        @csrf
                        <div class="form-row">
                        <div class="form-group col-md-4">
                        <input type="text" id="name" name="team_name" class="form-control" placeholder="Name">
                        <span class="text-danger">@error('team_name') {{$message}}  @enderror</span>
                        </div>
                        <div class="form-group col-md-4">
                            
                    <select class="selectpicker" id="ballroom_id" name="year" title="Select Year" data-live-search="true">
                    @if($years)
                    @foreach($years as $year)
                    <option value="{{$year->year_name}}">{{$year->year_name}}</option>
                    @endforeach
                    @endif
                    </select>
                    <span class="text-danger">@error('year') {{$message}}  @enderror</span>

                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Team</button>
                        </form>
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
												<th>Name</th>
												<th>year</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
                                        @foreach($somes as $item)
											<tr>
												<td>{{$item->id}}</td>
												<td>{{$item->team_name}}</td>
                                                <td>{{$item->year}}</td>
												<td><a href="{{'delete_team/' .$item->id }}" onclick="return confirm('Are you sure you want to delete this Teams?');" class="">                   
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.0/js/bootstrap-select.min.js"></script>
		@endsection