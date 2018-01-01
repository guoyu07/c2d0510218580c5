@extends('backend.protected.dashboard.main')
@section('content')
	<div class="row">
		<div class="col-md-3 col-sm-3 col-xs-12">
		{{-- <a href="{{ url('dashboard/manage/location/country/create') }}" class="btn btn-success">Add New</a> --}}
		</div>
		<div class="col-md-4 col-sm-7 col-xs-12 text-center">
		</div>
		<div class="col-md-5 col-sm-8 col-xs-12 form-group pull-right top_search">
			<form action="{{ url('dashboard/manage/location/country') }}" method="head">
				<div class="input-group">
					<input type="text" class="form-control location" name="s" placeholder="Enter country...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit">Go!</button>
					</span>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Counties</h2>
					<span class="pull-right">
						{{-- <a href="{{ url('dashboard/manage/location/country/create') }}" class="btn btn-success">Add New</a> --}}
					</span>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Country</th>
								<th>Country Code</th>
								<th>Currency Code</th>
								<th>Images</th>
								<th>Status</th>
								{{-- <th>Action</th> --}}
							</tr>
						</thead>
						<tbody>
							@foreach ($countries as $key => $country)
								<tr>
									<th scope="row">{{ $key+1 }}</th>
									<td>{{ $country->country }}</td>
									<td>{{ $country->country_code }}</td>
									<td>{{ $country->currency_code }}</td>
									<td><a href="{{ url('dashboard/manage/images/country/'.$country->id) }}" class="btn btn-link" target="_blank">images link</a></td>
									<td class="{{ statusCss($country->is_active) }}">
										{{ $country->status->name }}
										{{-- @if ($country->is_active == 3)
											<a href="{{ url('dashboard/manage/location/country/verify/'.$country->id) }}" class="btn btn-link">verify</a></td>
										@endif --}}
									{{-- <td>
										<div class="row">
											<div class="btn-group pull-right">
												<a href="{{ url('dashboard/manage/location/country/'.$country->id) }}" class="btn btn-default btn-success">Open</a>
												<div class="btn-group">
													<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false"> More <span class="caret"></span> </button>
													<ul class="dropdown-menu">
														<li>
															<a href="{{ url('dashboard/manage/location/country/'.$country->id.'/edit') }}">Edit</a>
														</li>
														@if ($country->is_active == 1)
															<li>
																<a class="trigger-form">Suspend</a>
																<form method="POST" action="{{ url('dashboard/manage/location/country/suspend/'.$country->id) }}">
																	{{ csrf_field() }}
																	{{ method_field('put') }}
																	<button type="submit" class="input-submit" hidden></button>
																</form>
															</li>
														@endif
														@if (in_array($country->is_active,[0, 2]))
															<li>
																<a class="trigger-form">Activate</a>
																<form method="POST" action="{{ url('dashboard/manage/location/country/activate/'.$country->id) }}">
																	{{ csrf_field() }}
																	{{ method_field('put') }}
																	<button type="submit" class="input-submit" hidden></button>
																</form>
															</li>
														@endif
														@if ($country->id)
															<li>
																<a class="user-delete" data-href="{{ url('dashboard/manage/location/country/'.$country->id) }}">Delete</a>
															</li>
														@endif
													</ul>
												</div>
											</div>
										</div>
									</td> --}}
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-12 pull-right text-right">
						@if (!is_null($countries))
							{{ $countries->links() }}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


@section('scripts')
	<script>
		$(document).on('click', '.user-delete', function () {
			var url = $(this).attr('data-href');
			$.confirm({
				title: 'Are you sure?',
				content: 'If you delete user you will never be able recover deleted data. <form action="'+url+'" method="post" class="hide">{{ csrf_field() }}{{ method_field('delete') }}<button type="Submit" id="btn_delete"><button></form>',
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