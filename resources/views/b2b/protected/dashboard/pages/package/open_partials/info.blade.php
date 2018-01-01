<div class="x_panel">
	<div class="x_title">
		<h2>
			<a href="{{ $package->client->openUrl() }}" class="btn btn-link font-size-20 nopadding">{{ isset($package->client->fullname) ? $package->client->fullname : '' }}</a>
			<small>(Information)</small>
		</h2>
		<ul class="nav navbar-right panel_toolbox panel_toolbox1">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<p>
				<label for=""><i class="fa fa-suitcase"></i> Package Id : </label>
				<span>
					{{ isset($package->uid) ? $package->uid : '' }}
				</span>
			</p>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<p>
				<i class="fa fa-phone"> :</i>
				<span>
					{{ isset($package->client->mobile) ? $package->client->mobile : '' }}
				</span>
			</p>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<p>
				<i class="fa fa-envelope"> :</i>
				<span>
					{{ isset($package->client->email) ? $package->client->email : '' }}
				</span>
			</p>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<div class="col-md-6 col-sm-6 col-xs-12 nopadding">
				<p>
					<label for=""><i class="fa fa-calendar"> </i> Created At : </label>
					<span>
						{{ isset($package->created_at) ? $package->created_at : '' }}
					</span>
				</p>
			</div>	
			<div class="col-md-6 col-sm-6 col-xs-12 nopadding">
				<p>
					<label for=""><i class="fa fa-calendar"> </i> Updated At : </label>
					<span>
						{{ isset($package->updated_at) ? $package->updated_at : '' }}
					</span>
				</p>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<p>
				<label for=""><i class="fa fa-edit"> </i> Requirements : </label>
				<span class="scroll-bar" style="max-height: 163px; overflow: auto;">
					{{ isset($package->req) ? $package->req : '' }}
				</span>
			</p>
		</div>
	</div>
</div>