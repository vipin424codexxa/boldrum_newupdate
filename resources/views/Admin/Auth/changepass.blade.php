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
                        <h3 class="panel-title">Change Password</h3>
                        @if($message = Session::get('success'))
                        <div class="alert alert-success text-center alert-dismissible" role="alert">{{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>   
                        </div>
                        @endif
                        @if($message = Session::get('error'))
                        <div class="alert alert-danger text-center alert-dismissible" role="alert">{{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>   
                        </div>
                        @endif
                        <form action="/update-password" method="POST" enctype="multipart/form-data" class="justify-content-center">
                        @csrf
                        <div class="form-row">
                        <div class="form-group col-md-6">
                        <input type="password" id="name" name="old_password" class="form-control" placeholder="Old password">
                        <span class="text-danger">@error('old_name') {{$message}}  @enderror</span>
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                        <input type="password" id="name" name="new_password" class="form-control" placeholder="New password">
                        <span class="text-danger">@error('new_password') {{$message}}  @enderror</span>
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                        <input type="password" id="name" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        <span class="text-danger">@error('confirm_password') {{$message}}  @enderror</span>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        </form>
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