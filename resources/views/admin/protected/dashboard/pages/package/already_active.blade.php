@extends('admin.protected.dashboard.main')
@section('content')
	<div class="x_panel">
		<div class="x_title">
			<h1>Plan is already Activated</h1>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<p>Your plan is already activated.</p>
			<label for="">Plan Name : </label>
			<b>{{ isset($auth->package->plan->name) ? $auth->package->plan->name : ''}}</b>
			<div>to know more please contact customer care</div>
		</div>
	</div>
@endsection