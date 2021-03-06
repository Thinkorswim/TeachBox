@extends('layouts.master-after')
@section('title')
	 {{$keyword}} -
@stop

@section('description')
	Search the courses in teachbox
@stop

@section('content')
	<div class="search-page">
	<div class="container">
		@if($keyword)
		<h1>Search for <strong>{{ $keyword }}</strong></h1>
		@else
		<h1>Please type at least one letter.</strong></h1>
		@endif
	</div>
	</div>
@if($keyword)
<div class="container follow">
	<div class="col-xs-12 col-sm-4">

		<div class="panel panel-default actions results">
		  <div class="panel-heading">
		    <h3 class="panel-title">Results</h3>
		  </div>
			<div class="panel-body">
				<div class="list-group">
				  <a class="list-group-item active" href="#">
				    <span class="badge">{{$countCourse}}</span>
				    Courses
				  </a>
				  <a class="list-group-item" href="{{ URL::action('SearchController@searchLesson', [$keyword]) }}">
				    <span class="badge">{{$countLesson}}</span>
				    Lessons
				  </a>
				  <a class="list-group-item" href="{{ URL::action('SearchController@searchUser', [$keyword]) }}">
				    <span class="badge">{{$countUser}}</span>
				    People
				  </a>

				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8">
		@if(count($courses) == 0)
			<div class="place row centered">
				<h2><strong>No results.</strong></h2>
				<small>Maybe change your search to something less specific. </small>
			</div>
		@endif
		<div class="search scroll">
			@foreach ($courses as $course)
					<div class="course">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
						  	<div class="col-xs-12 col-lg-3">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}">
							  </a>
							</div>
							<div class="col-xs-12 col-lg-9">
						  	  <h4><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h4>
							  <small>Category: <a href="{{ URL::action('CourseController@category', $course->category) }}"> {{ $course->category; }}</a></small>
							  <p>{{ excerpt($course->description) }}</p>

							</div>
						  </div>
						</div>
					</div>

			@endforeach

		{{ $courses->links() }}
	</div>
	</div>
</div>
@endif
@endsection