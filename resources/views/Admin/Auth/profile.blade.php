@extends('Admin.layout.master')
@section('content')
<style>
.float-right{
    float:right;
    position:sticky;
}
.panel .panel-heading {
    padding-top: 20px;
    padding-bottom: 60px;
    position: relative;
}
</style>
<div id="wrapper">
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
                    @foreach ($profiles as $object)
                        @endforeach
					<div class="panel panel-headline">
						<div class="panel-heading">
                        <h3 class="panel-title">My Profile</h3>
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
                        <form class="form-auth-small" method="POST" action="{{ route('update.post') }}">
                            @csrf
                            <div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="text" name="name" class="form-control" value="{{$object->name}}" id="signin-email" placeholder="First Name" required>
									@error('first_name') <span class="text-danger error">{{ $message }}</span>@enderror
								</div>
                                <!-- <div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="text" name="last_name" class="form-control" id="signin-email" value="{{old('last_name') }}" placeholder="Last Name" required>
									@error('last_name') <span class="text-danger error">{{ $message }}</span>@enderror
								</div> -->
								<!-- <div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="email" name="email" class="form-control" id="signin-email" value="{{old('email') }}" placeholder="Email" required>
									@error('email') <span class="text-danger error">{{ $message }}</span>@enderror
								</div> -->
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="text" name="club_name" class="form-control" value="{{$object->club_name}}" id="signin-password" placeholder="Club Name" required>
									@error('club_name') <span class="text-danger error">{{ $message }}</span>@enderror
								</div>
								<!-- <div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" name="password" class="form-control" value="{{old('password') }}" id="signin-password" placeholder="Password" required>
									@error('password') <span class="text-danger error">{{ $message }}</span>@enderror
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" name="password_confirmation" class="form-control" value="{{old('password') }}" id="signin-password" placeholder="Confirm Password" required>
									@error('password_confirmation') <span class="text-danger error">{{ $message }}</span>@enderror
								</div> -->
                                <div class="form-group col-md-4 mb-4">
								<button type="submit" class="btn btn-primary btn-lg btn-block">Update</button>
                                </div>
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