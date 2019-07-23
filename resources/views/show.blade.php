@extends('layout')

@section('content')
<div class="card" style="width: 350px">
	@foreach($posts as $post)
		<div class="card-body">
			<div class="card-title">{{$post->name}}</div>
			<p class="card-text">{{$post->detail}}</p>
			<a href="{{action('PostController@index')}}" class="btn btn-primary">Back</a>
		</div>
	@endforeach	
</div>	
@endsection