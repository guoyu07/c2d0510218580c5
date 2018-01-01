@extends('admin.protected.dashboard.main')

@section('content')
	<div class="">

		<div class="page-title">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<a href="{{ url('dashboard/settings/text/create') }}" class="btn btn-success btn-block">Add Text</a>
				</div>
				<div class="col-md-4 col-sm-7 col-xs-12 text-center">
					<h3>Texts</h3>
				</div>
				<div class="col-md-5 col-sm-8 col-xs-12 form-group pull-right top_search">
					<form action="{{ url('dashboard/settings/text') }}" method="head">
						<div class="input-group">
								<input type="text" class="form-control" name="t" placeholder="Search for...">
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit">Go!</button>
								</span>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			@forelse($texts as $text)
				<div class="col-md-12 col-sm-12 col-xs-12 ">
					<div class="x_panel">
						<div class="x_title">
							<h2>{{ $text->title }}</h2>
							<ul class="nav navbar-right panel_toolbox panel_toolbox1">
								<li></li>
								<li></li>
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="max-height-350px scroll-auto scroll-bar">
										{!! sub_string(strip_tags($text->text), 500) !!}
									</div>
								</div>
							</div>
							<div class="row m-top-10">
								<div class="col-md-2 col-sm-2 col-xs-12">
									<a href="{{ url('dashboard/settings/text/'.$text->id) }}" class="btn btn-success btn-block">Open</a>
								</div>
								<div class="btn-group col-md-2 col-sm-2 col-xs-12">
									<button data-toggle="dropdown" class="btn btn-default btn-block dropdown-toggle" type="button" aria-expanded="false"> More <span class="caret"></span> </button>
									<ul class="dropdown-menu">
										<li>
											<a href="{{ url('dashboard/settings/text/'.$text->id.'/edit') }}">Edit</a>
										</li>
										@if ($text->is_active == 1)
											<li>
												<a class="trigger-form">Deactivate</a>
												<form method="POST" action="{{ url('dashboard/settings/text/'.$text->id.'/deactivate') }}">
													{{ csrf_field() }}
													{{ method_field('put') }}
													<button type="submit" class="input-submit" hidden></button>
												</form>
											</li>
										@endif
										@if (in_array($text->is_active,[0, 2]))
											<li>
												<a class="trigger-form">Activate</a>
												<form method="POST" action="{{ url('dashboard/settings/text/'.$text->id.'/activate') }}">
													{{ csrf_field() }}
													{{ method_field('put') }}
													<button type="submit" class="input-submit" hidden></button>
												</form>
											</li>
										@endif
										<li>
											<a class="btn-delete" data-href="{{ url('dashboard/settings/text/'.$text->id) }}">Delete</a>
										</li>
									</ul>
								</div>
								<span class="m-top-20 pull-right">
									<b>Status : </b>(<span class="{{ statusCss($text->is_active) }}">{{ $text->status }}</span>)
								</span>
							</div>
						</div>
					</div>
				</div>
			@empty
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						You have not added any text.
					</div>
				</div>
			@endforelse
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		{{-- for more button --}}
		$(document).on('click', '.btn-delete', function () {
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
		{{-- /for more button --}}
	</script>
@endsection
