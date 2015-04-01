@extends('layouts.master-after')

@section('title')
	{{$course->name}} -
@stop

@section('description')
	{{ excerpt($course->description) }}
@stop

@section('fb-image')
	{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}
@stop

@section('content')
	<div class="course-section">
		<div class="container">
			<div class="col-xs-12 col-md-3">
				<div class="activity_rounded">
					<img src="{{ URL::asset('courses/'. $course->id . '/img/' . $course->pic) }}" alt="{{ $course->name }}">
				</div>
					<span class="age" data-toggle="tooltip" data-placement="right" title="@if($studentCount == 1) {{ $studentCount ." student" }}@else{{ $studentCount ." students" }}@endif">
						{{ $studentCount }}
					</span>
			</div>
			<div class="col-xs-12 col-md-9">
				<h1>{{ $course->name }}</h1>
				<h4> in <strong><a href="#"> {{ $course->category; }} </a></strong></h4>
				<h5> by <strong><a href="{{ URL::action('ProfileController@user', $user->id) }}"> {{ $user->name; }} </a></strong></h5>
			</div>
		</div>

	</div>
	<div id="visible" class="tabs-profile">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation" class="active"><a href="">About the course</a></li>
			  <li role="presentation"><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
			  <li role="presentation"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
			</ul>
		</div>
	</div>
	<div id="hidden" class="tabs-profile hidden">
		<div class="container">
			<ul class="nav nav-pills">
			  <li role="presentation" class="active"><a href="">About the course</a></li>
			  <li role="presentation"><a href="{{ URL::action('CourseController@courseQuestion', [$course->id]) }}"> Discussion </a></li>
			  <li role="presentation"><a href="{{ URL::action('CourseController@courseStudents', [$course->id]) }}">Students</a></li>
			</ul>
		</div>
	</div>
	<div class="container follow">
		<div class="col-xs-12 col-sm-8">
			<div class="panel panel-default description">
			  <div class="panel-body">
				<p>{{ $course->description }}</p>
			  </div>
			</div>
		@if (count($lessonList) > 0)
			<?php $i = 1; ?>
		<div class="panel panel-default actions">
		  <div class="panel-heading">
		  	<h3 class="panel-title">Lessons</h3>
		  </div>
		  <div class="panel-body">
		  @if (Auth::user()->id == $course->user_id)
		  <div class="list-group tutor-list">
		  @else
			  	<div class="list-group">
			  @endif
					@foreach ($lessonList as $lesson)
					 <a class="list-group-item" href="{{ URL::action('CourseController@courseLesson', [$course->id,$lesson->order]) }}">
					@if (Auth::user()->id == $course->user_id)
					 <strong><?php echo $i; $i++; ?>.</strong> {{ $lesson->name; }} 
					 <a class="edit-lesson" href ="{{ URL::action('CourseController@postLessonEdit', [$course->id,$lesson->order]) }}" >
						<i class="fa fa-edit"></i>
					 </a>
					@else
							<div class="col-xs-9">
							 	<strong><?php echo $i; $i++; ?>.</strong> {{ $lesson->name; }} 
							</div>
				 			<div class="col-xs-3">
				 			 	<div class="pull-right">{{ $lesson->duration; }}</div> 
				 			</div>
					@endif
				</a>
					@endforeach
	    		</div>
	       </div>
	    </div>
	    @endif
	   </div>
<!-- Print all reviews		@foreach($reviews as $review)
		  <hr>
		  <div class="row">
		    <div class="col-md-12">
		    @for ($i=1; $i <= 5 ; $i++)
		      <span class="fa fa-star{{ ($i <= $review->rating) ? '' : '-empty'}}"></span>
		    @endfor

		    {{ $review->user_id }} <span class="pull-right"></span> 

		    <p>{{{$review->text}}}</p>
		    </div>
		  </div>
		@endforeach -->


	   <div class="container">
	<div class="row" style="margin-top:40px;">
		<div class="col-md-6">
    	<div class="well well-sm">
            <div class="text-right">
                <a class="btn btn-success btn-green" href="#reviews-anchor" id="open-review-box">Leave a Review</a>
            </div>
        
            <div class="row" id="post-review-box" style="display:none;">
                <div class="col-md-12">
                  {{ Form::open(array('action' => array('CourseController@postCourseReview', $course->id))) }}
                        <input id="ratings-hidden" name="rating" type="hidden"> 
                        <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="Enter your review here..." rows="5"></textarea>
        
                        <div class="text-right">
                            <div class="stars starrr" data-rating="1"></div>
                            <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                            <span class="glyphicon glyphicon-remove"></span>Cancel</a>
								{{ Form::token() }}
								{{ Form::submit('Submit', array('class'=>'btn btn-success btn-lg')) }}
                        </div>
				 {{ Form::close() }}

                </div>
            </div>
        </div> 
         
		</div>
	</div>
</div>
	    <div class="col-xs-12 col-sm-4">
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
		    @if(!$isJoined)
			    <div class="panel panel-default settings-panel actions join ask">
				    {{ Form::open(array('action' => array('CourseController@postJoin', $course->id))) }}
								{{ Form::token() }}
								{{ Form::submit('Take this course', array('class'=>'btn btn-default join')) }}

					{{ Form::close() }}
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
						data-toggle="tooltip" data-placement="left" title="{{ $user->city }}@if($user->country && $user->country), @endif {{ $user->country }}">
					</span>
					@endif
			  		<h4><a href="{{ URL::action('ProfileController@user', [$user->id]) }}">{{ $user->name }} </a></h4>
			  		<small>{{ $user->city }}@if($user->country && $user->country), @endif {{ $user-> country }}</small>
			  	</div>
				<div class="row">
				@if($user->decription != '')
				<hr>
				
					<p>{{$user->decription}}</p>
				@endif
				</div>
			</div>
			<?php $num = 1; ?>
			<div class="panel panel-default actions rankings">
				<div class="panel-heading">
					<h3 class="panel-title">Ranking</h3>
				</div>
			  <div class="panel-body">
			<div class="list-group">
			@foreach($sorted_data as $ranking)
			 <a class="list-group-item" href="{{ URL::action('ProfileController@user', $ranking->id) }}"> 
			<strong><?php echo $num; ?>.</strong> {{$ranking->name}}  <span class="pull-right">{{$ranking->avg}}%</span>
			 </a>
			 <?php $num++; ?>
			@endforeach
			</div>
			</div>
			</div>
	    </div>
	</div>
@endsection
