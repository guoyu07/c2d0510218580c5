@extends('admin.protected.dashboard.main')

@section('content')
	<div class="">

		<div class="page-title">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<a href="{{ url('dashboard/inventories/activity') }}?city={{ isset($activity->destination_code) ? $activity->destination_code : request()->city  }}" class="btn btn-success btn-block"><i class="fa fa-arrow-left"></i> Back to Activity</a>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			@if (!is_null($activity))
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>{{ $activity->title }}</h2>
							<div class="pull-right">
								<label for="">Destination : {{ $activity->destination->location }}</label>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="x_content" >
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									@isset ($activity->duration)
										Duration : {{ $activity->duration }} |
									@endisset
									@isset ($activity->pick_up)
										Pick Up (timing) : {{ $activity->pick_up }} |
									@endisset
									@isset ($activity->mode)
										Mode : {{ $activity->mode }} |
									@endisset
									@isset ($activity->timing)
										Timing : {{ $activity->timing }}
									@endisset
								</div>
							</div>
							<div class="m-top-20"></div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="">Description : </label>
									{!! $activity->description !!}
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="">Inclusion : </label>
									{!! $activity->inclusion !!}
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="">Exclusion : </label>
									{!! $activity->exclusion !!}
								</div>
							</div>
							<hr>
							<div class="row m-top-20">
								@foreach ($activity->images as $image)
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
							<hr>
							<div class="row m-top-20">
								<div class="col-md-2 col-sm-2 col-xs-12">
									<a href="{{ url('dashboard/inventories/activity/store/'.$activity->id) }}" class="btn btn-success btn-block">Edit</a>
								</div>
								<div class="btn-group col-md-2 col-sm-2 col-xs-12">
									<button data-toggle="dropdown" class="btn btn-block btn-default dropdown-toggle" type="button" aria-expanded="false"> More <span class="caret"></span> </button>
									<ul class="dropdown-menu">
										@if ($activity->is_active == 1)
											<li>
												<a class="trigger-form">Deactivate</a>
												<form method="POST" action="{{ $activity->openUrl().'/deactivate' }}">
													{{ csrf_field() }}
													{{ method_field('put') }}
													<button type="submit" class="input-submit" hidden></button>
												</form>
											</li>
										@endif
										@if (in_array($activity->is_active,[0, 2]))
											<li>
												<a class="trigger-form">Activate</a>
												<form method="POST" action="{{ $activity->openUrl().'/activate' }}">
													{{ csrf_field() }}
													{{ method_field('put') }}
													<button type="submit" class="input-submit" hidden></button>
												</form>
											</li>
										@endif
										<li>
											<a class="user-delete" data-href="{{ $activity->openUrl() }}">Delete</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			@else
				<p>Sorry... there is no vendor</p>
			@endif
		</div>
	</div>  
@endsection


@section('scripts')
	<script>
		$(document).on('click', '.user-delete', function () {
			var url = $(this).attr('data-href');
			$.confirm({
				title: 'Are you sure?',
				content: 'If you delete activity you will never be able recover deleted data. <form action="'+url+'" method="post" class="hide">{{ csrf_field() }} {{ method_field('delete') }}<button type="Submit" id="btn_delete"><button></form>',
				buttons: {
					cancel: function () {
						//close
					},
					formSubmit: {
						text: 'Submit',
						btnClass: 'btn-blue',
						action: function () {
							$('#btn_delete').trigger('click');
						}
					}
				}
			});
		});

		$(document).on('click', '.trigger-form', function () {
			$(this).closest('li').find('.input-submit').trigger('click');
		});

	</script>
@endsection
