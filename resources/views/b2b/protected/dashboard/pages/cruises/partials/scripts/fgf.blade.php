<script>
	function postFgfCruise(rid) {

		var ridObj = getRidObject(rid);
		var did = ridObj.did;
		var elem_id = "cruise_"+rid;
		var ids = {
				"_token" : csrf_token,
				'elem_id' : elem_id,
				'did' : did,
				'rid' : rid
			};

		$.ajax({
			type:"post",
			url: "{{ url('/fo/cruises/result/') }}/"+did,
			data: ids,
			success: function(response, textStatus, xhr) {
				var response = JSON.parse(response);
				// console.log(response);
				var html = '';
				var cruises = response.cruises;
				// console.log(cruises.length);
				if (cruises.length) {
					$('#loging_log').hide();

					$.each(cruises, function(i,v){
						html = makeFgfHtml(i, v, ids);
						$('#'+elem_id).append(html);
						$('#'+elem_id).find('input').iCheck({
							checkboxClass: 'icheckbox_flat-green'
						});
					});
					filter.initFilter(rid);
				}
				else{
					return postFgfCruise(did, rid);
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					/*postFgfCruise(did, rid);*/
				}
			}
		});
	}
</script>


<script>
	function makeFgfHtml(i, obj, ids) {
		var cruiseImage = isset(obj.images, 0) 
										? obj.images[0].url 
										: '{{ urlDefaultImageCruise() }}';

		var cabins = insertCabinImage(obj.cabins, obj.images);

		var cabinsObj = {
				'cabins' : cabins, 
				'did' : ids.did,
				'rid' : ids.rid,
				'vendor' : 'fgf'
			}

		var cruise = {
				"id" : obj.vendor_detail_id,
				"name" : proper(obj.name),
				"image" : cruiseImage,
				"starRating" : obj.star_rating,
				"starRatingHtml" : star_Rating(obj.star_rating),
				"imagesHtml" : imagesHtml(obj.images),
				"cabinsHtml" : cabinsHtml(cabinsObj),
				"description" : obj.description,
				"address" : obj.address,
				"vendor" : "fgf"
			};

		return getCruiseStack(cruise);
	}
</script>

<script>
	function insertCabinImage(cabins, images) {
		var result = [];
		var imageKey = 0;

		$.each(cabins, function(cabinKey, cabin) {
			cabin['image'] = isset(images, imageKey) 
										 ? images[imageKey].url
										 : '{{ urlDefaultImageCruise() }}';

			if (imageKey < images.length-1) {
				imageKey = imageKey+1;
			}else{
				imageKey = 0;
			}
			result.push(cabin);
		});
		return result;
	}
</script>

<script>
	function imagesHtml(images) {
		var imagesHtml = '';
		$.each(images, function(imageKey, image) {
			imagesHtml += '<div class="height-160px width-48-p">'+
				'<img class="width-100-p height-100p" src="'+image.url+'" />'+
			'</div>'
		})
		return imagesHtml;
	}
</script>

<?php
	$cabinsHtml = view('b2b.protected.dashboard.pages.cruises.partials.scripts.cabin_partials.cabin')->render();
	$cabinsHtml = trimHtml($cabinsHtml);
?>

<script>
	function cabinsHtml(cabins) {
		var cabinsHtml = '';
		$.each(cabins.cabins, function (cabinKey, cabin) {
			cabinsHtml += '{!! $cabinsHtml !!}';
		})
		return cabinsHtml;
	}
</script>