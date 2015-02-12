@extends('layouts.master-after')

@section('title')
  {{ $user->name }}'s courses -
@stop

@section('description')
  	{{ excerpt($user->decription) }}
@stop

@section('content')
	<div class="cover-section">
		<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"alt="{{ $user->name }}'s profile"/>
		@if ($user->date != '')
		<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
			<?php echo ageCalculator( $user->date ) ?>
		</span>
		@endif
		@if ($user->country != '')
		<span class="country" style="background:url('{{ URL::asset(countryFlag( $user->country ))}}') center center"
			data-toggle="tooltip" data-placement="left" title="{{ $user->city }}, {{ $user->country }}">
		</span>
		@endif
		@if (!$isFollowing && $user->id != Auth::user()->id)
			{{ Form::open(array('action' => array('ProfileController@postFollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-plus"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Follow  '. $user->name)) }}
				@endif
			{{ Form::close() }}
		@else
			@if($user->id != Auth::user()->id)
			{{ Form::open(array('action' => array('ProfileController@postUnfollow', $user->id))) }}
				@if(Auth::check())
					{{ Form::token() }}
						{{ Form::button('<i class="fa fa-user-times"></i>', array('type' => 'submit','class'=>'follow-circle',
						 'data-toggle' =>'tooltip','data-placement' =>'left','title' => 'Unfollow  '. $user->name)) }}
				@endif
			@endif
			{{ Form::close() }}
		@endif
		@if($user->id != Auth::user()->id)
		{{ Form::button('<i class="fa fa-comment"></i>', array(
		'data-toggle'=>'modal', 'data-target'=>'#exampleModal', 'class'=>'message-circle',
		 'data-placement' =>'left','title' => 'Start conversation with  '. $user->name)) }}
		<div class="modal fade settings-panel actions" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
		        <h4 class="modal-title" id="exampleModalLabel">New message to {{ $user->name }}</h4>
		      </div>
		      <div class="modal-body padding-panel">
					{{ Form::textarea('description', null, array('placeholder' => 'Say hi!',
					'rows' => '5', 'class'=>'form-control', 'id' => 'text')) }}
					{{ Form::submit('Send message', array('class'=>'form-control', 'id' => 'send-message')) }}
		      </div>
		    </div>
		  </div>
		</div>
		@endif
		<h1>{{ $user->name }}</h1>
		<h5>{{ $user->email }}</h5>
		<small>{{$followersCount}} followers | {{$followingCount}} following</small>
	</div>
	<div class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation"><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">Timeline</a></li>
			  <li role="presentation" class="active"><a href="{{ URL::action('ProfileController@userCourses', [$user->id]) }}">Courses</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowers', [$user->id]) }}">Followers</a></li>
			  <li role="presentation"><a href="{{ URL::action('ProfileController@userFollowing', [$user->id]) }}">Following</a></li>
			</ul>
		</div>
	</div>
	<div class="container follow">
		<div class="col-xs-12 col-sm-8">
		<div class="row">
			<h2>Created courses</h2>
		@if(count($createdList) > 0)

				@foreach ($createdList as $course)
					<div class="col-xs-12 col-sm-6 course two-in-line created">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/img/'. '/3x2' . $course->pic) }}">
							  </a>
						  	  <h4><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h4>
							   <p><a href="{{ URL::action('ProfileController@user', $user->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"></a>
						  	  <strong><a href="{{ URL::action('ProfileController@user', $course->user_id) }}"> {{  $user->name }} </a></strong></p>
							  <p>{{ excerpt($course->description) }}</p>
						  </div>
						</div>
					</div>
				@endforeach
		@else
			<div class="panel panel-default settings-panel actions no-timeline">
				<div class="panel-body padding-panel">
					<h4><strong>No created courses yet.</strong></h4>
				</div>
			</div>
		@endif
			</div>

			<div class="row">
			<h2>Enrolled courses</h2>
			@if(count($joinedList) - count($createdList) > 0)
			@foreach ($joinedList as $course)
				@if ($course->user_id != Auth::user()->id)
				<?php $creator = User::find($course->user_id); ?>
					<div class="col-xs-12 col-sm-6 course two-in-line joined">
						<div class="panel panel-default course-panel">
						  <div class="panel-body">
							  <a href="{{ URL::action('CourseController@course', [$course->id]) }}">
								<img src="{{ URL::asset('courses/'. $course->id . '/img/'. '/3x2' . $course->pic) }}">
							  </a>
						  	  <h4><a href="{{ URL::action('CourseController@course', [$course->id]) }}"> {{ $course->name; }} </a></h4>
						  	  <p><a href="{{ URL::action('ProfileController@user', $creator->id) }}"><img class="small-profile" src="{{ URL::asset('img/'. $creator->id . '/' . $creator->pic) }}"></a>
						  	  <strong><a href="{{ URL::action('ProfileController@user', $course->user_id) }}"> {{ $creator->name; }} </a></strong></p>
							  <p>{{ excerpt($course->description) }}</p>
						  </div>
						</div>
					</div>
				@endif
			@endforeach
		@else
			<div class="panel panel-default settings-panel actions">
				<div class="panel-body padding-panel">
					<h4><strong>No joined courses yet.</strong></h4>
				</div>
			</div>
		@endif
	    </div>
	</div>
	<div class="col-xs-12 col-sm-4">
			@if($user->decription != '')
				<div class="panel panel-default actions no-timeline">
				  <div class="panel-heading">
				    <h3 class="panel-title">About</h3>
				  </div>
				  <div class="panel-body padding-panel">
					<p>{{$user->decription}}</p>
					</div>
				  </div>
			@endif
    </div>
@endsection