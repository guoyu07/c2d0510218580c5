@if (count($package->itinerary))
<div class="m-bottom-20px">
	<div class="bg-color-theme font-size-40px text-center">Itinerary</div>
	<div class="width-95p m-10x-auto text-justify">
		@foreach($package->itinerary as $itinerary)
			<div class="border-gray m-top-20px">
				<div class="bg-color-gray font-size-20px p-10">
					<b>Day {{ $itinerary->day }} 
						({{ isset($itinerary->location) ? implode(' - ', $itinerary->location) : '' }})
					</b>
				</div>
				<div class="p-10 font-size-15px">
					<ul>
						@if(isset($itinerary->body))
							@foreach ($itinerary->body as $body)
								<li>{{ $body }}</li>
							@endforeach
						@endif
					</ul>
				</div>
				@if (!empty($itinerary->images))
				<table width="100%">
					<tbody>
						<tr>
							@if (count($itinerary->images) > 2)
								<?php $itiImageCount = 0; ?>
								@foreach ($itinerary->images as $itiImage)
									<?php 
										$itiImageCount++; 
									?>
									@break($itiImageCount > 3)
									<td width="33.333%">
										<img src="{{ $itiImage }}" style="width: 250px; height: 200px;">
									</td>
								@endforeach
							@endif
						</tr>
					</tbody>
				</table>
				@endif
			</div>
		@endforeach
	</div>
</div>	
@endif