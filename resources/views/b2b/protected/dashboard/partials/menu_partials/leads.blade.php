<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-dropbox font-size-20"></i>
		<span id="menu_lead_box_count" class="badge bg-green">{{-- {{ $pendingLeads->count() ? $pendingLeads->count() : ''  }} --}}</span>
	</a>
	
	<ul id="menu_lead_box" class="width-450 dropdown-menu list-unstyled msg_list max-height-350px scroll-auto scroll-bar" role="menu">
		<li><h2>Lead Box</h2></li>
		{{-- @foreach ($pendingLeads as $pendingLead)
			<li>
				<a href="{{ route('openPackage',$pendingLead->token) }}">
					<span>
						<span><b class="font-size-15">{{ $pendingLead->fullname }}</b></span>
						<span class="time">{{ $pendingLead->created_at }}</span>
					</span>
					<div><b>Mobile : </b>{{ $pendingLead->mobile }}</div>
					<span class="message"><b>Message : </b>
						{{ sub_string($pendingLead->note)}}
					</span>
				</a>
			</li>
		@endforeach --}}
	</ul>
</li>