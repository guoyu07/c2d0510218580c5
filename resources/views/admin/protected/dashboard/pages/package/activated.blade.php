@extends('admin.protected.dashboard.main')
@section('content')
	<div class="row">
		<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
			<div class="m-top-50">
				<div class="x_panel">
					<div class="x_title">
						<h2>Voila! Your plan is activated</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="col-md-12 text-center">
							<img src="{{url('images/icons/successful.png')}}" alt="">
						</div>

						<section class="content invoice">
							<div class="row">
								<div class="col-xs-12 invoice-header m-top-20">
									<h2>Updated Balance : <i class="fa fa-rupee"> {{ $balance }}</i></h2>
									<h2 class="m-top-10">Transection Id : {{ $txnid }}</h2>
								</div>
							</div>
							<div class="m-top-20"></div>
						</section>

						<div class="col-md-12 text-center">
							<a href="{{ url('dashboard') }}" class="btn btn-primary">Back</a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
