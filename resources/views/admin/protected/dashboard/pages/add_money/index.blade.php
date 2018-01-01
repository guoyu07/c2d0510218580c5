@extends('admin.protected.dashboard.main')
@section('content')
	<div class="x_panel">
		<div class="x_title">
			<h2>Add Money</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">

			<section class="content invoice">
				<div class="row">
					<div class="col-xs-12 invoice-header">
						<h3>Balance : <i class="fa fa-rupee">{{$auth->balance}}</i></h3>
					</div>
				</div>
				<div class="m-top-20"></div>

				<!-- this row will not appear when printing -->
				<div class="row no-print">
					<div class="col-xs-6">
						<form action="{{ route('pay') }}">
							<input id="net_amount" type="text" class="form-control" name="net_amount" value="{{ $request->m }}" placeholder="ENTER AMOUNT"/>
							<div class="m-top-20">
								<label> 
									<span>PayUMoney Convenience Charge (2.9%) : </span>
									<i class="fa fa-rupee"></i>
									<span id="payu_charge" name="payu_charge"></span>
								</label>
							</div>
							<div class="m-top-20">
								<label> 
									<span>Total Amount : </span>
									<i class="fa fa-rupee"></i>
									<span id="show_total"></span>
									<input type="hidden" id="amount" name="amount">
								</label>
							</div>
							<button type="submit" class="btn btn-success m-top-20"><i class="fa fa-credit-card"></i> Submit Payment</button>
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function () {
			calc();
		});
		$(document).on('keyup', '#net_amount', function () {
			calc();
		});

		function calc() {
			var val = parseInt($('#net_amount').val());
			var payu = parseFloat((val*0.029).toFixed(2));
			var amount = val+payu;
			console.log(payu == 'NaN');
			if (!isNaN(payu) && val != '' && val != 0) {
				$('#payu_charge').text(payu);
				$('#show_total').text(amount);
				$('#amount').val(amount);
			}
		}
	</script>
@endsection