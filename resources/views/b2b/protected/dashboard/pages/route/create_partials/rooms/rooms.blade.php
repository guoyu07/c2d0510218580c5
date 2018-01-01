<div id="room">
@if ($package->roomGuests->count())
	@include($viewPath.'.create_partials.rooms_old')
@else
	@include($viewPath.'.create_partials.room_new')
@endif
</div>
{{-- /Rooms-element  --}}
{{-- Add Room button --}}
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 p-bottom-1">
		<a id="btn-addRoom" class="btn-link cursor-pointer" data-count="1">Add Room</a>
	</div>
</div>

