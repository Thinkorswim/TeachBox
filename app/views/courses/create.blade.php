@extends('layouts.master-after')

@section('content')
	<section class="full-screen teach-screen">
		<div class="container">
			<div class="col-xs-10 col-sm-6 col-md-4 tab-register">	
				<div class="tab-pane">
					<h3>Start your teachning journey!</h3>
					{{ Form::open(['route' => 'create-course','files' => true ]) }}	
						<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-university"></i></span>
						 {{ Form::text('name', null, array('placeholder'=>'Name of course','class'=>'form-control')) }}
						 </div>
						 @if($errors->has('name'))
							{{ $errors->first('name') }}
						@endif
						<div class="input-group">
						{{ Form::textarea('description', null, array('placeholder'=>'Description (min 50 characters ako sum prav de!)','class'=>'form-control')) }}
						 </div>
						 @if($errors->has('description'))
							{{ $errors->first('description') }}
						@endif
						<div>Upload image</div>
						<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
						<div class="fileUpload btn btn-primary">
						    <span>Choose a picture</span>
							{{ Form::file('image', array('id'=>'uploadBtn','class'=>'upload'))}}
						</div>
						{{ Form::token() }}
						{{ Form::submit('Create Course', array('class'=>'form-control register-button')) }}
					{{ Form::close() }}	
				</div>
			</div>
			<div class="col-xs-0 col-sm-1 col-md-1"></div>
			<div class="col-xs-12 col-sm-5 col-md-7 tab-register">
				<div class="tab-pane">
					<h3>Some heading</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
					In sed dapibus eros, sed varius tortor. Etiam at pharetra enim, sit amet blandit nisi. Etiam a hendrerit lectus, sed sollicitudin purus.
					 Nunc aliquet ac sapien a lobortis. Cras tincidunt dapibus finibus. Mauris convallis fermentum leo, ac tempus ligula ultricies eu. 
					 Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed in ligula accumsan mi commodo pretium.
					 Mauris sollicitudin ex quis varius finibus. Phasellus in quam id purus lobortis pellentesque sit amet ut ante.</p>
				</div>
			</div>
		</div>
	</section>
<section class="full-screen learn-screen">

</section>
@endsection