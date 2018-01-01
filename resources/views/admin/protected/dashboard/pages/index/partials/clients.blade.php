@if (!is_null($clients) && !empty($clients))
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<h2>Client Status</h2>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					@include('admin.protected.dashboard.pages.enquiry.partials.clients')
				</div>
			</div>
		</div>
	</div>
@endif
