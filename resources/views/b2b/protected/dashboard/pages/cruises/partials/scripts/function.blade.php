<?php
	$crusiePartisalPath = 'b2b.protected.dashboard.pages.cruises.partials'; 
	$html = trimHtml(view($crusiePartisalPath.'.scripts.html')->render());
?>

<script>

	function getRidObject(rid) {
		return idObject['cruise_'+rid];
	}


	function getCruiseStack(cruise) {
		var appendHtml = '';
		var searchWord = '';
		appendHtml += '{!!$html!!}';
		return appendHtml;
	}



	function changeChooseBtn(elem) {
		var isSeleted =  $(elem).attr('data-isseleted');
		if (isSeleted == 1) {
			$(elem).attr('data-isseleted', 0);
			$(elem).addClass('btn-primary');
			$(elem).removeClass('btn-danger');
			$(elem).text('Cabin');
			$('.btn-dark.btn-chooseRoom').prop('disabled', false);
			$('.btn-dark.btn-chooseRoom').addClass('btn-primary');
			$('.btn-dark.btn-chooseRoom').removeClass('btn-dark');
		}
		else{
			$(elem).attr('data-isseleted', 1);
			$(elem).addClass('btn-danger');
			$(elem).removeClass('btn-primary');
			$(elem).text('Seleted');
			$('.btn-primary.btn-chooseRoom').prop('disabled', true);
			$('.btn-primary.btn-chooseRoom').addClass('btn-dark');
			$('.btn-primary.btn-chooseRoom').removeClass('btn-primary');
		}
	}



	function changeBookBtn(elem) {
		var isSeleted =  $(elem).attr('data-isseleted');
		var parent = $(elem).closest('.tab-content');
		$(parent).find('.btn-danger.btn-book-cabin').addClass('btn-primary');
		$(parent).find('.btn-danger.btn-book-cabin').removeClass('btn-danger');

		if (isSeleted == 1) {
			$(elem).attr('data-isseleted', 0);
			$(elem).addClass('btn-primary');
			$(elem).removeClass('btn-danger');
			$(elem).text('Add');
		}
		else{
			$(elem).attr('data-isseleted', 1);
			$(elem).addClass('btn-danger');
			$(elem).removeClass('btn-primary');
			$(elem).text('Added');
		}
	}



	function postAddtoCartCruise(data) {
		/*Object must be like this 
		var data = {
			"_token" : csrf_token,
			"did" : did,
			"index" :id,
			"vendor" : vendor
		}*/

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/package/builder/cruise/cabin/book') }}/"+data.did,
			data: data,
			success : function(response){
				response = JSON.parse(response);
				if (response.status == 200) {
					$('#a_cruise_'+data.next_rid).click();
					$(window).scrollTop(0);
				}else{
					alert('Something went wrong please try again.');
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				alert('Something went wrong please try again.');
			}
		});
	}

</script>

@include($crusiePartisalPath.'.scripts.fgf')