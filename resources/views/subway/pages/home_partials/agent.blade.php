<div class="row p-left-5">
	<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
		<div class="flipper">
			<div class="front">
				<div class="square mod-box-color1 full-image" style="background-image: url({{ $package->user->profile_pic }});">
					<div class="square-content text-center">
						<div class="down-title">
							{{ $package->user->fullname }}
						</div>
					</div>
				</div>
			</div>
			<div class="back">
				<div class="square mod-box-color2">
					<div class="square-content text-center">
						<div class="tile-title"><b>contact</b></div>
						<div class="tile-line">{{$package->user->mobile}}</div>
						<h4><b>{{$package->user->email}}</b></h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>