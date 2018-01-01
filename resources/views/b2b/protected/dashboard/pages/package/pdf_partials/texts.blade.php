@if (!is_null($texts))
	@foreach ($texts as $text)
		<div>
			<div class="bg-color-theme font-size-30px text-center">{{ $text->title }}</div>
			<div class="width-95p m-10x-auto text-justify">
				{!! $text->text !!}
			</div>
		</div>
	@endforeach
@endif