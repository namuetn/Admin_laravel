@extends('layouts.app')
@section('content')
<div class="container">
	<p>
		<h1 >Song</h1>
	</p>
	<div class="row">
		<div class="col-md-8">
			<table id="datatable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Detail</th>
						<th>Author</th>
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
					<input type="number" id="id" class="form-control" readonly="readonly" required>
				</div>
				<div class="form-group">
					<label>Name</label>
					<input type="text" id="name" class="form-control" name="name" required>
				</div>
				<div class="form-group">
					<label>Detail</label>
					<textarea type="text" name="detail" id="detail" class="form-control" required></textarea>
				</div>
				<div class="form-group">
					<label>Author</label>
					<input type="text" id="author" class="form-control" name="author">
				</div>
				<div id="validate"></div>
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
				url: "/cruds",
				success: function(response){
					var rows = "";
					$.each(response, function(key, value){
						rows = rows + "<tr>";	
						rows = rows + "<td>"+value.id+"</td>";
						rows = rows + "<td>"+value.name+"</td>";
						rows = rows + "<td>"+value.detail+"</td>";
						rows = rows + "<td>"+value.author+"</td>";
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
			var detail = $('#detail').val();
			var author = $('#author').val();
			var token = $('meta[name="csrf-token"]').attr('content');
			$.ajax({
				type: 'POST',
				dataType: 'json',
				data: {name:name, detail:detail, author:author, _token:token},
				url: '/cruds',
				success: function(response){
					viewData();
					clearData();
					$('#save').show();
				},
				error: function(data){
					$('#validate').html('');
					$.each(data.responseJSON.errors, function(key, value){
						$('#validate').append('<div class="alert alert-danger">'+value+'</div');
					});
				}
			});
		}

		function clearData(){
			$('#id').val('');
			$('#name').val('');
			$('#detail').val('');
			$('#author').val('');
		}

		function editData(id){
			$('#save').hide();
			$('#update').show();
			$('.myid').show();
			$('#validate').html('');

			$.ajax({
				type: "GET",
				dataType: 'json',
				url: "/cruds/"+id+"/edit",
				success: function(response){
					$('#id').val(response.id);
					$('#name').val(response.name);
					$('#detail').val(response.detail);
					$('#author').val(response.author);
				}
			});
		}

		function updateData(){
			var id = $('#id').val();
			var name = $('#name').val();
			var detail = $('#detail').val();
			var author = $('#author').val();
			var token = $('meta[name="csrf-token"]').attr('content');

			$.ajax({
				type: "PUT",
				dataType: "json",
				data: {name:name, detail:detail, author:author, _token:token},
				url: '/cruds/'+id,
				success: function(response){
					viewData();
					clearData();
					$('#save').show();
					$('#update').hide();
					$('.myid').hide(); 

				},
				error: function(data){
					$('#validate').html('');
					$.each(data.responseJSON.errors, function(key, value){
						$('#validate').append('<div class="alert alert-danger">'+value+'</div');
					});
				}
			});
		}

		function deleteData(id){
			$.ajaxSetup({
				headers:{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			if(confirm('Are you sure ?')){
				$.ajax({
					type: "DELETE",
					dataType: "json",

					url: '/cruds/'+id,
					success: function(response){
						$('#validate').html('');
						viewData();
						
					}
				});
			}
		}

	</script>
</body>
</html>
@endsection
