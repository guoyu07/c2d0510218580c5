@extends('backend.protected.dashboard.main')

@section('content')
	
	{{-- <div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href="{{ url()->back() }}" class="btn btn-primary btn-block">Back</a>
		</div>
	</div> --}}

	<div class="m-top-10"></div>
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Media Gallery </h2>
					<a href="{{ Request::url() }}/create" class="btn btn-success pull-right">Add Images</a>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						@foreach ($images as $image)
							<div class="col-md-55">
								<div class="thumbnail">
									<div class="image view view-first">
										<img style="width: 100%; display: block;" src="{{ $image->url }}" alt="image">
										<div class="mask">
											{{-- <p>Your Text</p> --}}
											<div class="tools tools-bottom">
												{{-- <a href="#"><i class="fa fa-link"></i></a>
												<a href="#"><i class="fa fa-pencil"></i></a> --}}
												<form method="post" action="{{ Request::url().'/delete/'.$image->id }}">
													{{ csrf_field() }}
													<a href='#' onclick='this.parentNode.submit(); return false;'><i class="fa fa-times"></i></a>
												</form>
											</div>
										</div>
									</div>
									<div class="caption">
										<p>{{ $image->caption }}</p>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection