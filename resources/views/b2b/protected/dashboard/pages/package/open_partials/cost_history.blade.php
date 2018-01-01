<div class="x_panel">
	<div class="x_title">
		<h2>Cost History</h2>
		<ul class="nav navbar-right panel_toolbox panel_toolbox1">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content max-height-350px scroll-auto scroll-bar">

		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Currency</th>
					<th>Visa Cost</th>
					<th>Net Cost</th>
					<th>Profit</th>
					<th>Total</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				@if(isset($package->costs))
					@foreach($package->costs as $packageCostKey => $packageCost)
						<tr>
							<th scope="row">{{ $packageCostKey+1 }}</th>
							<td>{{$packageCost->currency}}</td>
							<td>{{$packageCost->visa_cost}}</td>
							<td>{{$packageCost->net_cost}}</td>
							<td>{{$packageCost->margin}}</td>
							<td>{{$packageCost->total_cost}}</td>
							<th>{{$packageCost->created_at->format('d-M-Y H:i')}}</th>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>

	</div>
</div>