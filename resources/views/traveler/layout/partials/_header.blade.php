<div class="header-top">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<a class="logo" href="{{ url('/') }}">
					<img src="{{ url('traveler') }}/img/logo-invert.png" alt="Image Alternative text" title="Image Title" />
				</a>
			</div>
			<div class="col-md-3 col-md-offset-2">
				{{-- <form class="main-header-search">
					<div class="form-group form-group-icon-left">
						<i class="fa fa-search input-icon"></i>
						<input type="text" class="form-control">
					</div>
				</form> --}}
			</div>
			<div class="col-md-4">
				@include('traveler.layout.partials._user')
			</div>
		</div>
	</div>
</div>