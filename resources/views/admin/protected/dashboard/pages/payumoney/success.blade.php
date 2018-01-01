@extends('admin.protected.dashboard.main')
@section('content')
	<div class="x_panel">
		<div class="x_title">
			<h2>Payment Done Successfully.</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<section class="content invoice">
				<!-- title row -->
				<div class="row">
					<div class="col-xs-12 invoice-header">
						<h1>
							{{ $productinfo }}
							<small class="pull-right">Txn Id: {{ $txnid }}</small>
						</h1>
					</div>
				</div>
				<div class="m-top-20"></div>
				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table">
						<table class="table table-striped">
							<tbody>
								<tr>
									<td>Name</td>
									<td>{{ $name }}</td>
								</tr>
								<tr>
									<td>Product Info:</td>
									<td>{{ $productinfo }}</td>
								</tr>
								<tr>
									<td>Payment Id</td>
									<td>{{ $paymentId }}</td>
								</tr>
								<tr>
									<td>Date </td>
									<td>{{ $addedon }}</td>
								</tr>
								<tr>
									<td>Total:</td>
									<td>{{ $amount }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- /.col -->
				</div>

				<!-- this row will not appear when printing -->
				<div class="row no-print">
					<div class="col-xs-12">
						<button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
					</div>
				</div>
			</section>
		</div>
	</div>
@endsection