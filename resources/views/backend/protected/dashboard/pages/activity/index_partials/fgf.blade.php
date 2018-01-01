@if (isset($destination->activities) && !empty($destination->activities))
	@foreach ($destination->activities as $activity)
		<tr>
			<td>{{ $activity->id }}</td>
			<td>{{ $activity->name }}</td>
			<td>{{ $destination->country }}</td>
			<td>{{ $destination->destination }}</td>
			<td>{{ $activity->currency }}</td>
			<td>
				<select class="rank" data-vendor="f">
					@foreach ($ranks as $rankKey => $rank)
						<option value="{{ $rankKey }}" {{ $activity->rank == $rankKey ? 'selected' : ''}}>
							{{ $rank }}
						</option>
					@endforeach
				</select>
			</td>
			<td>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6 p-right-5">
						<a href="{{ url('dashboard/activities/v/'.$activity->id) }}" class="btn btn-success btn-xs btn-block" target="_blank">Open</a>
					</div>	
					<div class="col-md-6 col-sm-6 col-xs-6 p-left-5">
						<a href="{{ url('dashboard/activities/v/'.$activity->id.'/edit') }}" class="btn btn-primary btn-xs btn-block">Edit</a>
					</div>
				</div>
			</td>
		</tr>
	@endforeach
@endif