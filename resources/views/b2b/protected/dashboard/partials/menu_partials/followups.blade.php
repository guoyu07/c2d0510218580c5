<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-bell"></i>
		<span class="badge bg-green">{{-- {{ $pendingFollowUps->count() ? $pendingFollowUps->count() : ''  }} --}}</span>
	</a>
	
	<ul id="menu_followups" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		<li><h2>Follow-Ups</h2></li>
		{{-- @foreach ($pendingFollowUps as $pendingFollowUp)
			@if (!is_null($pendingFollowUp->package))
				<li>
					<a href="{{ route('openPackage', $pendingFollowUp->package->token) }}">
						<span>
							<span>
								<b class="font-size-15">{{ $pendingFollowUp->package->client->fullname }}</b> 
								({{ $pendingFollowUp->package->uid }})</span>
							<span class="time">{{ $pendingFollowUp->datetime }}</span>
						</span>
						<span class="message">
							{{ sub_string($pendingFollowUp->note)}}
						</span>
					</a>
				</li>
			@endif
		@endforeach --}}

		<li>
			<div class="text-center">
				<a href="{{ url('dashboard/follow-up') }}">
					<strong>See All Follow-Ups</strong>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
		</li>
	</ul>
</li>