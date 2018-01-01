<?php 
	if (!isset(request()->rooms))
		request()->merge(["rooms" => [["adult" => "2"]]]);
?>


@foreach (request()->rooms as $roomKey => $room)
	<?php 
		$adult = isset($room['adult']) ? $room['adult'] : 2;
		$kids = isset($room['kids']) ? $room['kids'] : 0;
		$ages = isset($room['kids_age']) ? $room['kids_age'] : [];
	?>
	<div class="room">
		<div class="col-md-4">
			<div class="form-group form-group-lg form-group-select-plus">
				<label>Adult</label>
				<div class="btn-group btn-group-select-num" data-toggle="buttons">
					@for ($i = 1; $i < 5; $i++)
						<label class="btn btn-primary {{ $i == $adult ? 'active' : '' }}"><input type="radio" class="adult" name="rooms[{{$roomKey}}][adult]" value="{{ $i }}" {{ $i == $adult ? 'checked' : '' }} />{{ $i }}</label>
					@endfor
					<label class="btn btn-primary hide"><input type="radio" name="adult"/></label>
				</div>
				<select class="form-control hidden">
					{!! selectOptions(array_diff(range(0, 6), [0=>0])) !!}
				</select>
				@if ($roomKey > 0)
					<a class="remove-room cursor-pointer">Remove Room</a>
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-group-lg form-group-select-plus">
				<label>Kids</label>
				<div class="btn-group btn-group-select-num kids-box" data-toggle="buttons">
					@for ($i = 1; $i < 5 ; $i++)
						<label class="btn btn-primary {{ $i == $kids ? 'active' : '' }}"><input type="radio" name="rooms[{{$roomKey}}][kids]" class="kids" value="{{ $i }}" {{ $i == $kids ? 'checked' : '' }} />{{ $i }}</label>
					@endfor
					<label class="fa fa-times cursor-pointer m-top-10 remove-kid {{ $kids ? '' : 'hide'}}"></label>

					<label class="btn btn-primary hide"><input type="radio" name="kid_age" />3+</label>
				</div>
				<select class="form-control hidden">
					{!! selectOptions(array_diff(range(0, 4), [0=>0])) !!}
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group form-group-lg form-group-select-plus kids-age-box">
				<label>Kids Age</label>
				@for ($i = 0; $i < 4; $i++)
					<div class="col-md-3 {{ $i == 0 ? 'm-left-n-15' : '' }}">
						<select class="my-form-control kids-age" name="rooms[{{$roomKey}}][kids_age][]" {{ $i < $kids ? '' : 'disabled' }}>
							{!! selectOptions(array_diff(range(0, 12), [0 => 0]), isset($ages[$i]) ? $ages[$i] : '') !!}
						</select>
					</div>
				@endfor
			</div>
		</div>
		<div class="row"></div>
	</div>
@endforeach