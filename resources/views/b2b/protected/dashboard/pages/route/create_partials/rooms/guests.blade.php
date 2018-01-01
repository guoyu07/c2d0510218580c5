`<div class="row room-main-box" data-key="`+index+`" data-id="`+id+`">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<label> Room : `+room+`</label>
	</div>
	<div class="col-md-5 col-sm-5 col-xs-5">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12 p-bottom-1 m-bottom-n-5 form-group has-feedback">
				<div class="center">
					<div class="input-group input-controller-box">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-number noradius bg-color-gray btn-decrease">
								<span class="glyphicon glyphicon-minus"></span>
							</button>
						</span>
						<span class="form-control text-center nopadding-right">
							<input type="text" class="adults input-field" value="`+adults+`" data-min="1" data-max="12" data-singular="Adult" data-plural="Adults" hidden>
							<span class="word-output">`+wordAdult+`</span>
						</span>
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0 btn-increase">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12 p-bottom-1 m-bottom-n-5 form-group has-feedback">
				<div class="center">
					<div class="input-group input-controller-box">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-number noradius bg-color-gray btn-decrease btn-child">
								<span class="glyphicon glyphicon-minus"></span>
							</button>
						</span>
						<span class="form-control text-center nopadding-right">
							<input type="text" class="input-field children" value="`+kids+`" data-min="0" data-max="4" data-singular="Kid" data-plural="Kids" hidden>
							<span class="word-output">`+wordKid+`</span>
						</span>
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0 btn-increase btn-child">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>				
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6 col-sm-6 col-xs-12 age">`;
		for (var i = 0; i < 4; i++) {

			var kid_age_v = isset(kids_age, i)
										? kids_age[i] 
										: {"id":"","age":"","is_bed":0};

			var isHide = isset(kids_age, i) ? '' : 'hide';

			content += `<div class="col-md-3 col-sm-3 col-xs-12 p-bottom-1 form-group has-feedback nopadding age-box `+isHide+`" data-id="`+kid_age_v.id+`">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0 0 0 10px;">
						<select class="form-control nopadding age-elem">
							<option value="">Age</option>`;
							for (var j = 1; j < 12; j++) {
								content += `<option value="`+j+`" `+(kid_age_v.age == j ? 'selected' : '')+` >`+j+`</option>`;
							}
						content += `</select>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 nopadding">
						<input type="checkbox" class="form-control is-bed" style="height: 16px;width: 43px;box-shadow:none;margin: 2px 0 0;" `+(kid_age_v.is_bed ? 'checked' : '')+` >
				    <label style="padding-left: 9px; margin: 0;">Bed</label>
					</div>
				</div>
			</div>`;
		}
	content += `</div>
	<div class="col-md-1 col-sm-1 col-xs-12 text-center">
		<a class="btn-remove-room cursor-pointer `+(index == 0 ? 'hide' : '')+`">
			<i class="fa fa-times-circle font-size-30 m-top-2"></i>
		</a>
	</div>
</div>`;