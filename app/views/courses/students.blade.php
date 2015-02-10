@extends('layouts.master-after')

@section('title')
	Students in {{$course->name}} -
@stop

@section('description')
	{{ excerpt($course->description) }}
@stop

@section('content')

<div class="course-section">
	<div class="container">
		<div class="col-xs-12 col-md-3">
				<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}" alt="{{ $course->name }}"/>
				<span class="age" data-toggle="tooltip" data-placement="right" title="@if($studentCount == 1) {{ $studentCount ." student" }}@else{{ $studentCount ." students" }}@endif">
				 {{$studentCount}} 			
				 </span>
		</div>
		<div class="col-xs-12 col-xs-9">
			<h1>{{ $course->name }}</h1>
			<h5> by <strong><a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></strong></h5>
		</div>
	</div>
</div>
<div class="tabs-profile">
	<div class="container">
		<ul class="nav nav-pills">
		  <li role="presentation" ><a href="{{ URL::action('CourseController@course', [$course->id]) }}">About the course</a></li>
		  <li role="presentation" ><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
		  <li role="presentation" class="active"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
		</ul>
	</div>
</div>
<div class="container follow">
	<div class="col-xs-12 col-sm-8">
		<?php $studentIdList = array(); ?> 
		@foreach ($studentList as $student)
		<?php $studentId = $student->id; $studentIdList[] = $studentId;?>
		@if ($student->id != $user->id)
		<div class="col-xs-12 col-sm-6 student">
			<div class="panel panel-default student-card">
			  <div class="panel-body padding-panel">
			  		<a href="{{ URL::action('ProfileController@user', [$student->id]) }}">
			  		<img src="{{ URL::asset('img/'. $student->id . '/' . $student->pic) }}"alt="{{ $student->name }}'s profile">
			  		</a>
					@if ($student->date != '')
					<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $student->date )}} years old">
						{{ageCalculator( $student->date )}}
					</span>
					@endif 
				    @if ($student->country != '')
					<span class="country" style="background:url('{{ URL::asset(countryFlag( $student->country ))}}') center center" 
						data-toggle="tooltip" data-placement="left" title="{{ $student->city }}, {{ $student->country }}">
					</span>
					@endif
			  		<h4><a href="{{ URL::action('ProfileController@user', [$student->id]) }}">{{ $student->name }} </a></h4>
			  		<small>{{ $student->city }}, {{ $student-> country }}</small>
			  </div>
			</div>
		</div>
		@endif
		@endforeach
   </div>
	
		<div class="col-xs-12 col-sm-4 author-card">
			@if ((in_array($user->id, $studentIdList)))
			@else
		    {{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
		    		@if(Auth::check())
						{{ Form::token() }}
						{{ Form::submit('Take this course', array('class'=>'btn btn-default join')) }}
					@endif
			{{ Form::close() }}	
			@endif
			@if (Auth::user()->id == $course->user_id)
			<div class="panel panel-default actions">
			  <div class="panel-heading">
			    <h3 class="panel-title">Actions</h3>
			  </div>
			  <div class="panel-body">
				<div class="list-group">
				  <a class="list-group-item" href="{{ URL::action('CourseController@courseAdd', [$course->id]) }}"><i class="fa fa-plus fa-fw"></i> Add Lesson</a>
				  <a class="list-group-item" href="{{ URL::action('CourseController@courseEdit', [$course->id]) }}"><i class="fa fa-edit fa-fw"></i> Edit Course</a>
				</div>
				
			  </div>
			</div>
		@endif
			<div class="panel panel-default author-card student-card">
				<div class="panel-heading">
					<h3 class="panel-title">About the tutor</h3>
				</div>
			  <div class="panel-body padding-panel author">
			  		<a href="{{ URL::action('ProfileController@user', [$user->id]) }}">
			  		<img src="{{ URL::asset('img/'. $user->id . '/' . $user->pic) }}"alt="{{ $user->name }}'s profile">
			  		</a>
					@if ($user->date != '')
					<span class="age" data-toggle="tooltip" data-placement="left" title="{{ageCalculator( $user->date )}} years old">
						{{ageCalculator( $user->date )}}
					</span>
					@endif 
				    @if ($user->country != '')
					<span class="country" style="background:url('{{ URL::asset(countryFlag( $user->country ))}}') center center" 
						data-toggle="tooltip" data-placement="left" title="{{ $user->city }}, {{ $user->country }}">
					</span>
					@endif
			  		<h4><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">{{ $user->name }} </a></h4>
			  		<small>{{ $user->city }}, {{ $user-> country }}</small>
			  	</div>
				<div class="row">
				@if($user->decription != '')
					<p>{{$user->decription}}</p>
				@endif
				</div>
    </div>
</div>

@endsection