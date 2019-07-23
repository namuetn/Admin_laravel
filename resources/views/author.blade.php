@extends('layouts.app')
@section('content')
<div class="container">
	<p>
		<h1 >Author</h1>
	</p>
	<div class="row">
		<div class="col-md-8">
			<table id="datatable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Age</th>
						<th>City</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div class="col-md-4">
			<form>
				<div class="form-group myid">
					<label>ID</label>
					<input type="number" id="id" class="form-control" readonly="readonly">
				</div>
				<div class="form-group">
					<label>Name</label>
					<input type="text" id="name" class="form-control">
				</div>
				<div class="form-group">
					<label>Age</label>
					<textarea type="text" name="" id="age" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<label>City</label>
					<input type="text" id="city" class="form-control">
				</div>
				<button type="button" id="save" onclick="saveData()" class="btn btn-primary">Submit</button>
				<button type="button" id="update" onclick="updateData()" class="btn btn-warning">Update</button>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
		// $('#datatable').DataTable();
		$('#save').show();
		$('#update').hide();
		$('.myid').hide();

		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		function viewData(){
			$.ajax({
				type: "GET",
				dataType: "json",
				url: "/authors",
				success: function(response){
					var rows = "";
					$.each(response, function(key, value){
						rows = rows + "<tr>";	
						rows = rows + "<td>"+value.id+"</td>";
						rows = rows + "<td>"+value.name+"</td>";
						rows = rows + "<td>"+value.age+"</td>";
						rows = rows + "<td>"+value.city+"</td>";
						rows = rows + "<td>";
						rows = rows + "<button type='button' class='btn btn-warning' onclick='editData("+value.id+")'>Edit</button>";
						rows = rows + "<button type='button' class='btn btn-danger' onclick='deleteData("+value.id+")'>Delete</button>";
						rows = rows + "</td></tr>";
					});
					$('tbody').html(rows);
				}
			});
		}
		viewData();

		function saveData(){
			var name = $('#name').val();
			var age = $('#age').val();
			var city = $('#city').val();
			var token = $('meta[name="csrf-token"]').attr('content');
			$.ajax({
				type: 'POST',
				dataType: 'json',
				data: {name:name, age:age, city:city, _token:token},
				url: '/authors',
				success: function(response){
					viewData();
					clearData();
					$('#save').show();
				} 
			});
		}

		function clearData(){
			$('#id').val('');
			$('#name').val('');
			$('#age').val('');
			$('#city').val('');
		}

		function editData(id){
			$('#save').hide();
			$('#update').show();
			$('.myid').show();

			$.ajax({
				type: "GET",
				dataType: 'json',
				url: "/authors/"+id+"/edit",
				success: function(response){
					$('#id').val(response.id);
					$('#name').val(response.name);
					$('#age').val(response.age);
					$('#city').val(response.city);
				}
			});
		}

		function updateData(){
			var id = $('#id').val();
			var name = $('#name').val();
			var age = $('#age').val();
			var city = $('#city').val();
			var token = $('meta[name="csrf-token"]').attr('content');
			$.ajax({
				type: "PUT",
				dataType: "json",
				data: {name:name, age:age, city:city,_token:token},
				url: '/authors/'+id,
				success: function(response){
					viewData();
					clearData();
					$('#save').show();
					$('#update').hide();
					$('.myid').hide(); 
				}
			});
		}

		function deleteData(id){
			$.ajaxSetup({
				headers:{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type: "DELETE",
				dataType: "json",
				url: '/authors/'+id,
				success: function(response){
					viewData();
				}
			})
		}

	</script>
</body>
</html>
@endsection