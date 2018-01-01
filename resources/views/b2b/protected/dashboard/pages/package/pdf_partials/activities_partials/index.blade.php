<?php
	$activityDate = $selectedActivity->date->format('d-M-Y');
	$activityMode = proper($selectedActivity->mode);
	$activityTiming = proper($selectedActivity->timing);
	$activityName = $selectedActivity->detail->name;
	$activityImageThumb = $selectedActivity->detail->image;
	$activityDescription = $selectedActivity->detail->description;
?>

<div class="box-stack min-height-200px p-top-20px">
	<img src="{{ $activityImageThumb }}" class="img-thmb">
		<b class="font-size-20px">{{ $activityName }}</b>
		<hr>
		<i>
			&nbsp;
			<b>Date: </b>{{ $activityDate }} | 
			<b>Timing: </b>{{ $activityTiming }} | 
			<b>Transfer: </b>{{$activityMode}}
		</i>
		<br/>
		<b>About : </b>
		<span>{!! $activityDescription !!}</span>
		<br/>
</div>
<hr/>