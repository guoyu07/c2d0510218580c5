@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Not Modifiable</h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox1">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<h3>Sorry this package is not modifiable</h3>
					<p>Date has been past please build new package</p>
				</div>
			</div>
		</div>
	</div>
@endsection