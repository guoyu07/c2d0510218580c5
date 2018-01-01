<div class="book-popup popup-model" style="display: none;">
	<div class="middle mod-box-color4">
		<button type="button" class="close book-popup" data-dismiss="modal" aria-label="Close"><span class="font-size-35" aria-hidden="true">×</span></button>
		<div class="row"></div>
		{{-- <div class="bg-color-black-trans padding-5 text-center">
			<h1>Book Now</h1>
		</div> --}}
		<div class="m-top-10"></div>
		<h2>
			<div class="row text-center">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<label>
						<input type="radio" class="radio-md book" value="pay_now" name="book" checked="">Pay now
					</label>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<label>
						<input type="radio" class="radio-md book" value="reserve" name="book">Reserve
					</label>
				</div>
			</div>
		</h2>
		<div class="m-top-30"></div>
		@include('subway.pages.home_partials.form_pay')
		@include('subway.pages.home_partials.form_reserve')
	</div>
</div>