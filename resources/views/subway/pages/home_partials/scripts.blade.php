<script>

	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_2",
			format : "DD/MM/YYYY",
			minDate : new Date(),
			startDate: new Date(),
		}, function(start, end, label) {
			// console.log(start.toISOString(), end.toISOString(), label);
		});
	});
	
	$(document).on('change', '.radio-md.book', function () {
		var val = $(this).val();
		var id = val == 'pay_now' ? '#form_pay_now' : '#form_reserve';
		var oppid = val == 'pay_now' ? '#form_reserve' : '#form_pay_now';
		$(oppid).hide();
		$(id).show();
	});

	$(document).on('click', '.show-book-popup', function () {
		showBookPopup();
	});


	$(document).on('click', '.close.book-popup', function () {
		hideBookPopup();
	});

	$(document).on('click', '.btn-pay', function () {
		var keys = ['name','mobile','email','date','pax','amount'];
		var fromId = '#form_pay_now';
		var isWrong = false;
		var data  = {'format' : 'json'};

		$.each(keys, function (i, v) {
			var val = $(fromId).find('[name="'+v+'"]').val();
			if (val == '') {
				$(fromId).find('[name="'+v+'"]')
														.addClass('border-red')
															.effect( "shake" );
				isWrong = true; 
				return false
			}else{
				$(fromId).find('[name="'+v+'"]').removeClass('border-red');
				$(fromId).find('[data-error="'+v+'"]').text('');
				data[v] = val;
			}
		});

		if (isWrong) { return false }
		$(this).form().submit();
	});


	$(document).on('click', '.btn-reserve', function () {
		var keys = ['name','mobile','email','date','pax'];
		var isWrong = false;
		var data  = {'_token' : csrf_token, 'format' : 'json'};
		var fromId = '#form_reserve';

		$.each(keys, function (i, v) {
			var val = $(fromId).find('[name="'+v+'"]').val();
			if (val == '') {
				$('#form_reserve').find('[name="'+v+'"]')
														.addClass('border-red')
															.effect( "shake" );
				isWrong = true; 
				return false
			}else{
				$(fromId).find('[name="'+v+'"]').removeClass('border-red');
				$(fromId).find('[data-error="'+v+'"]').text('');
				data[v] = val;
			}
		});

		/*console.log(data);*/

		if (isWrong) { return false }

		$.ajax({
			url : "{{ route('reservePackage', [$token]) }}",
			type : 'post',
			data : data,
			dataType : 'JSON',
			success : function (res) {
				if (res.status == 200) {
					$.alert({
									title : 'Thankyou !!!',
									content : 'we have successfully reserved your package our representative will get in touch with you.'
								});

					hideBookPopup();
				}
				else{
					$.alert({
									title : 'Sorry. something went wrong.',
									content : 'Kindly contact our representative.'
								});
					$.each(res.errors, function (i, v) {
						$(fromId).find('[name="'+i+'"]')
																.addClass('border-red')
																	.val('');
						$(fromId).find('[data-error="'+i+'"]').text(v[0]);
					});
				}
			},
			error : function () {
				$.alert({
								title : 'Sorry. something went wrong.',
								content : 'Kindly contact our representative.'
							});
				hideBookPopup();
			}
		});
	});


	$(document).on('keyup', '[name="amount"]', function () {
		var val = parseInt($(this).val());
		var payu = parseFloat((val*0.029).toFixed(2));
		if (!isNaN(payu) && val != '' && val != 0) {
			$('#payu_charge').text(payu);
		}else{
			$('#payu_charge').text(0);
		}
	});

	$(document).on('click', '.btn-more-less', function () {
		var parent = $(this).closest('ul');
		$(parent).find('li.more').toggle();
		$(parent).find('.btn-more-less').toggle();
		return false;
	});

	function showBookPopup() {
		$('.book-popup.popup-model').show();
	}

	function hideBookPopup() {
		$('.book-popup.popup-model').hide();
	}
</script>