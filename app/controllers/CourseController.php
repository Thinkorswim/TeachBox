<?php

class CourseController extends \BaseController {

	public function create ()
	{
		if(Auth::check()){
			return View::make('courses.create');
		}else{
			return View::make('home.before');
		}
	}

	public function postCreate()
	{
		if (Auth::check()){
			$validator = Validator::make(Input::all(),
				array(
						'name' 				 => 'required|min:4|max:40',
				));

			if($validator->fails()){		
				return Redirect::action('CourseController@create')
						->withErrors($validator);
			}else{

				$name 	 = Input::get('name');

				$user_id = Auth::user()->id;
				$course = Course::create(array(
						'name' 		=> $name,
						'user_id'  => $user_id,
					));

				if($course){
					return Redirect::route('home')
							->with('global-positive', 'Your course is created.');

				}

					return Redirect::action('CourseController@create')
							->with('global-negative', 'Your profile settings could not be created.');
			}
	    }
	}

	public function course($id)
	{
		$course = Course::find($id);
		if(Auth::check()){

		$isJoined = UserCourse::where(function ($query) {
			    $query->where('user_id', '=', Auth::user()->id);
			})->where(function ($query) use ($id) {
			    $query->where('course_id', '=', $id);
			})->count();


			if($isJoined){
				return View::make('courses.join')
							->with('course', $course);
			}else{
				return View::make('courses.not_join')
							->with('course', $course);
			}
		}else{
			return View::make('home.before');
		}
	}

	public function postJoin($id)
	{
		if(Auth::check()){

			$user_id = Auth::user()->id;
			$userCourse = UserCourse::create(array(
					'course_id' => $id,
					'user_id'  => $user_id,
				));
		    if($userCourse){
				return Redirect::route('course-page', array('id' => $id));
			}else{
				return Redirect::route('course-page', array('id' => $id))
											->with('global-negative', 'You could not join this course.');
			}
		}else{
			return View::make('home.before');
		}
	}

	public function courseEdit($id)
	{
		if(Auth::check()){
			$course = Course::find($id);
			return View::make('courses.edit');
		}else{
			return View::make('home.before');
		}
	}
}

