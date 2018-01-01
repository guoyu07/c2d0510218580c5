@foreach ($result->prices as $key => $prices)
<div class="col-md-3 col-sm-3 col-xs-12">
	<div class="x_panel glowing-border">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row m-tb-10px">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="height-50">
						<img src="{{ $prices->product->image }}" alt="" height="100%" width="100%">
					</div>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12 text-left">
					<div class="flightName font-size-17">{{ $prices->product->display_name }}</div>
					<div>{{ $prices->product->description }}</div>
				</div>
			</div>
		</div>
		<button id="btn-model-cab" data-toggle="modal" data-target=".bs-example-modal-cab" hidden></button>
		<div class="col-md-6 col-sm-6 col-xs-6 m-tb-20px">
			<button class="btn btn-dark btn-block btn-bookCab" data-index="{{$key}}" data-rowIndex="{{ $result->dbId }}">Schedule</button>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6 m-tb-20px">
			<button class="btn btn-primary btn-block btn-pickUpCab" data-index="{{$key}}" data-rowIndex="{{ $result->dbId }}">PICKUP</button>
		</div>
	</div>
</div>
@endforeach