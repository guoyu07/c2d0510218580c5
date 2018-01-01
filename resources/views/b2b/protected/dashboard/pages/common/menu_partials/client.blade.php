<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-user"></i>
		<span> Client Info</span>
		<span class="badge bg-green">{{-- Count of the cart --}}</span>
	</a>
	<ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		<li>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-10 col-sm-10 col-xs-12">
						<h3>{{ isset($client->fullname) ? $client->fullname : '' }}</h3>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 nopadding">
						<img class="width-100-p" src="{{ urlImage('images/user.jpg') }}" alt="Profile Image" />
					</div>
				</div>
			</div>
			
			<span class="image">
			</span>
		</li>
		<li class="text-left">
			<label for="">Package Id :</label>
			<span> {{ isset($package->uid) ? $package->uid : '' }}</span>
		</li>
		<li class="text-left">
			<div>
				<i class="fa fa-phone"></i>
				<span> {{ isset($client->mobile) ? $client->mobile : '' }}</span>
			</div>
			<div>
				<i class="fa fa-envelope"></i>
				<span> {{ isset($client->email) ? $client->email : '' }}</span>
			</div>
		</li>
		<li>
			<div><b>Message</b></div>
			<div>{{ isset($client->note) ? $client->note : '' }}</div>
		</li>
		<li>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 m-top-10">
					<a href="{{ route('openPackage', $package->token) }}" class="btn btn-success btn-block">
						<i class="fa fa-arrow-left"> </i> Back to Package
					</a>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 m-top-10">
					<a href="{{ route('createRoute', [$package->client->token, $package->token]) }}" class="btn btn-primary btn-block">Modify Route</a>
				</div>
			</div>
		</li>
	</ul>
</li>