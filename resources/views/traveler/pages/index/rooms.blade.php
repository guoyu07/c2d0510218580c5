<div class="room">
	<div class="col-md-4">
		<div class="form-group form-group-lg form-group-select-plus">
			<label>Adult</label>
			<div class="btn-group btn-group-select-num" data-toggle="buttons">
				@for ($i = 1; $i < 5; $i++)
					<label class="btn btn-primary {{ $i == 2 ? 'active' : '' }}"><input type="radio" class="adult" name="rooms['+count+'][adult]" value="{{ $i }}" {{ $i == 2 ? 'checked' : '' }} />{{ $i }}</label>
				@endfor
				<label class="btn btn-primary hide"><input type="radio" class="adult" name="rooms['+count+'][adult]"/></label>
			</div>
			<select class="form-control hidden">
				{!! selectOptions(array_diff(range(0, 6), [0=>0])) !!}
			</select>
			<a class="remove-room cursor-pointer">Remove Room</a>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group form-group-lg form-group-select-plus">
			<label>Kids</label>
			<div class="btn-group btn-group-select-num kids-box" data-toggle="buttons">
				@for ($i = 1; $i < 5; $i++)
					<label class="btn btn-primary"><input type="radio" class="kids" name="rooms['+count+'][kids]" value="{{ $i }}" />{{ $i }}</label>
				@endfor

				<label class="fa fa-times cursor-pointer m-top-10 remove-kid hide"></label>
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
			@for ($i = 1; $i < 5; $i++)
				<div class="col-md-3 {{ $i == 1 ? 'm-left-n-15' : '' }}">
					<select class="my-form-control kids-age" name="rooms['+count+'][kids_age][]" disabled>
						{!! selectOptions(array_diff(range(1, 12), [0=>0])) !!}
					</select>
				</div>
			@endfor
		</div>
	</div>
	<div class="row"></div>
</div>
