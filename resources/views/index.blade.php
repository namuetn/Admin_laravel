@extends('layout')

@section('content')

@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{$message}}</p>
	</div>
@endif
<div class="row">
	<div class="col-md-6">
		<h1>Trang Quan Tri Admin</h1>
	</div>
	<div class="col-md-4">
		<form action="/search" method="get">
			<div class="input-group">
				<input type="search" class="form-control" name="search">
				<span class="input-group-prepend">
					<button type="submit" class="btn btn-primary">Search</button>
				</span>
			</div>
		</form>
	</div>
	<div class="col-md-2 text-right">
		<a class="btn btn-primary" href="{{action('PostController@create')}}" >Add Data</a>
	</div>
</div>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Detail</th>
			<th>Author</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($posts as $post)
		<tr>
			<th>{{$post->id}}</th>
			<th>{{$post->name}}</th>
			<th>{{$post->detail}}</th>
			<th>{{$post->author}}</th>
			<th>
				<form action="{{action('PostController@destroy', $post->id)}}" method="post">
					<a href="{{action('PostController@show', $post->id)}}" class="btn btn-info" >Show</a>
					<a href="{{action('PostController@edit', $post->id)}}" class="btn btn-warning">Edit</a>
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-danger">Delete</button>
				</form>
			</th>
		</tr>
		@endforeach
	</tbody>
</table>
{{$posts->links()}}

@endsection