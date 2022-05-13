@extends('layouts.master')

@section('content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
            <div class="col-12">
                <div class="card">
              		<div class="card-header border-0">
                		<h3 class="card-title"><b>Add User</b></h3>
                		<div class="card-tools">
                  			<a href="#" class="btn btn-tool btn-sm">
                    			<i class="fas fa-download"></i>
                  			</a>
                  			<a href="#" class="btn btn-tool btn-sm">
                    			<i class="fas fa-bars"></i>
                  			</a>
                		</div>
              		</div>
              		<div class="card-body" style="padding-top: 0; padding-bottom: 0;">
	              		@include('layouts.message')
	              	</div>
	              	<div class="card-body">
	              		<form method="post" action="{{URL::to('admin/save-user')}}" id="userAddForm">
	              			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		              		<div class="form-group">
								<label for="exampleInputEmail1">Name</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
							</div>
			            	<div class="form-group">
								<label for="exampleInputEmail1">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Confirm Password</label>
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Role</label>
								<select class="form-control" name="role" id="role" required>
									<option value="">Select</option>
									<option value="1">Admin</option>
									<option value="2">User</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Save</button>
						</form>
	              	</div>
	            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	jQuery.validator.addMethod("validateEmail", function(value, element) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(value);
    }, "Please Enter a valid email address");

	$("#userAddForm").validate({
        rules: {
            name: "required",
            email: "validateEmail",
            password: {
                required: true,
                minlength: 4
            },
            password_confirmation: {
                required: true,
                maxlength: 4,
                equalTo : "#password"
            },
            role: "required",
        }
    });
</script>
@endsection