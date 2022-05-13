@extends('layouts.master')

@section('content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
            <div class="col-12">
                <div class="card">
              		<div class="card-header border-0">
                		<h3 class="card-title"><b>User List</b></h3>
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
	              		<table class="table table-bordered table-hover" id="usersTable">
	              			<thead>
	              				<tr>
	              					<th>Serial</th>
	              					<th>Name</th>
	              					<th>Email</th>
	              					<th>Role</th>
	              					<th>Action</th>
	              				</tr>
	              			</thead>
	              			<tbody>
	              				
	              			</tbody>
	              		</table>
	              	</div>
	            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){
        getAllUsers();
    });
    function getAllUsers(){
        var i = 1;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table= $('#usersTable').DataTable( {
            "processing": true,
            "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
            "pageLength": 10,
            "serverSide": true,
            "destroy" :true,
            "ajax": {
                "url": './get-all-users',
                "type": 'POST',
                // "data": function ( d ) {
                //     d.current_semester = $('#current_semester').val();
                    
                // },
            },
            "columns": [
                { "data": "0" },
                { "data": "name" },
                { "data": "email" },
                { "data": "role",
                  "render": function ( data, type, full, meta ) {
                    if(data == 1){
                    	return 'Admin';
                    }
                    else{
                    	return 'User';
                    }
                  }
                },
                { "data": "id",
                  "render": function ( data, type, full, meta ) {
                    var buttons = "";
                    buttons += '<a href="edit-user/'+data+'"><button type="button" class="btn btn-primary btn-flat">Edit</button>&nbsp</a>';
                    buttons +='<button type="button" class="btn btn-danger btn-flat" onclick="deleteUser('+data+')">Delete</button>';
                    return buttons;
                  }
                }
            ]
        });
    }

    function deleteUser(id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let text = "Are you sure you want to delete?";
	  	if (confirm(text) == true) {
	    	$.ajax({
                    type: 'POST',
                    url: 'delete-user/'+id,
                    data: {
                      id : id
                    },
                    dataType: 'json',
                })
                .done(function (data) {
                    if(data){
                        alert('Successfully deleted')
                        getAllUsers();
                    }
                    else{
                        alert('Something went wrong')
                    }
                });
	  	} else {
	  	}
        
    }
</script>
@endsection