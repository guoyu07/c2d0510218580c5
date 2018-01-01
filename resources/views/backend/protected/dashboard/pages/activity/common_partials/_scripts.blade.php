<script>
	function addDropzone(elemid) {
		Dropzone.autoDiscover = false; // keep this line if you have multiple dropzones in the same page
		var currnetFile = '';
		$(elemid).dropzone({	
			acceptedFiles: "image/*",
			url: '{{ url('image/upload') }}',
			maxFiles: 10, // Number of files at a time
			maxFilesize: 2, //in MB
			maxfilesexceeded: function(file) {
				alert('You have uploaded more than 10 Image. Only the 10 file will be uploaded!');
			},
			success: function (response) {
				$(response.previewElement).addClass('bg-color-gray');
				var resHtml = '<div class="dz-response-json" hidden>'+response.xhr.responseText+'</div>';
				$(response.previewElement).append(resHtml);
			},		
			addRemoveLinks: true,
			removedfile: function(file) {
				var _ref;
				return (_ref = file.previewElement) != null 
							? _ref.parentNode.removeChild(file.previewElement) 
							: void 0;  
			}	
			
		});
	}

	function makeImagesObject() {
		var imageObj = [];
		$('.uploadform').find('.dz-response-json').each(function () {
			var json = $(this).text();
			json = JSON.parse(json);
			imageObj.push(json);
		});
		return imageObj;
	}

</script>
