@if (!empty($activities))
	@foreach ($activities as $activity)
		<tr>
			<td>{{ $activity->id }}</td>
			<td>{{ $activity->name }}</td>
			<td>{{ $activity->currency }}</td>
			<td width="10%">
				<select class="rank form-control" data-vendor="{{$activity->vendor}}" data-id="{{ $activity->id }}">
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
						<a href="{{ url('dashboard/activities/'.$activity->vendor.'/'.$activity->id) }}" class="btn btn-success btn-xs btn-block" target="_blank">Open</a>
					</div>	
					<div class="col-md-6 col-sm-6 col-xs-6 p-left-5">
						<a href="{{ url('dashboard/activities/v/'.$activity->vendor.'/'.$activity->id.'/edit') }}" class="btn btn-primary btn-xs btn-block">Edit</a>
					</div>
				</div>
			</td>
		</tr>
	@endforeach
@endif