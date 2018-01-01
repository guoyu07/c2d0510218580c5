@extends('admin.protected.dashboard.main')
@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Users<small>Management</small></h2>
					<span class="pull-right">
						<a href="{{ url('dashboard/console/manage/users/create') }}" class="btn btn-success">Add New</a>
					</span>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($auth->users as $user)
								<tr>
									<th scope="row">{{ $user->fullname }}</th>
									<td>{{ $user->email }}</td>
									<td class="{{ statusCss($user->is_active) }}">
										{{ $user->status->name }}
										@if ($user->is_active == 3)
											<a href="{{ url('dashboard/console/manage/users/verify/'.$user->email) }}" class="btn btn-link">verify</a></td>
										@endif
									<td>
										<div class="row">
											<div class="btn-group pull-right">
												<a href="{{ url('dashboard/console/manage/users/'.$user->email) }}" class="btn btn-default btn-success">Open</a>
												<div class="btn-group">
													<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false"> More <span class="caret"></span> </button>
													<ul class="dropdown-menu">
														<li>
															<a href="{{ url('dashboard/console/manage/users/'.$user->email.'/edit') }}">Edit</a>
														</li>
														@if ($user->is_active == 1)
															<li>
																<a class="trigger-form">Suspend</a>
																<form method="POST" action="{{ url('dashboard/console/manage/users/suspend/'.$user->email) }}">
																	{{ csrf_field() }}
																	{{ method_field('put') }}
																	<button type="submit" class="input-submit" hidden></button>
																</form>
															</li>
															<li>
																<a href="{{ url('dashboard/console/manage/users/password/'.$user->email.'/reset') }}">Reset Password</a>
															</li>
														@endif
														@if (in_array($user->is_active,[0, 2]))
															<li>
																<a class="trigger-form">Activate</a>
																<form method="POST" action="{{ url('dashboard/console/manage/users/activate/'.$user->email) }}">
																	{{ csrf_field() }}
																	{{ method_field('put') }}
																	<button type="submit" class="input-submit" hidden></button>
																</form>
															</li>
														@endif
														<li>
															<a class="user-delete" data-href="{{ url('dashboard/console/manage/users/'.$user->email) }}">Delete</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
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