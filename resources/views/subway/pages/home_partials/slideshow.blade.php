<?php 
	/*$tempImages = [
			urlImage("images/country/australia.jpg"),
			urlImage("images/country/european.jpg"),
			urlImage("images/country/fiji.jpg"),
			urlImage("images/country/singapore.jpg"),
			urlImage("images/country/south-africa.jpg"),
		];*/
?>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="row">
		<div id="ninja-slider">
			<div class="slider-inner">
				<ul class="nomargin">
					@foreach ($package->images->shuffle() as $tempImage)
						<li><a class="ns-img" href="{{ $tempImage }}"></a></li>
					@endforeach
				</ul>
				<div class="navsWrapper">
					<div id="ninja-slider-prev"></div>
					<div id="ninja-slider-next"></div>
				</div>
			</div>
		</div>
	</div>
</div>