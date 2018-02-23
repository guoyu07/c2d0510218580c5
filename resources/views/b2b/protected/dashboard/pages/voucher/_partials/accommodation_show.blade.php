<div class="col-md-12 col-sm-12 col-xs-12 service-child-box">
	<div class="x_panel">
		<div class="x_title">
			<div class="col-md-5 col-sm-5 col-xs-5">
				<h2>Accommodation</h2>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-7">
				<label class="pull-right">Confirmation No: `+_.get(data, 'data.confirmation_no', '?')+`</label>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2>`+name+`</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					`+check_in+` - `+check_out+`
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<label>Property Type : `+prop_type+`</label>
				</div>`+thisObj.getGuestString(guests)+`</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
					<a href="{{ url('dashboard/vouchers/show/pdf') }}/`+_.get(res, 'vstoken', '')+`" class="btn btn-success" target="_blank">Get Voucher</a>

					<button class="btn btn-primary btn-primary btn-service-edit" data-vstoken="`+_.get(res, 'vstoken', '')+`">Edit</button>
				</div>
			</div>
		</div>
	</div>
</div>