<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.css') }}">
</head>
<body>

	<form id="uploadform" class="uploadform dropzone no-margin nopadding dz-clickable text-left min-max-height-355px bg-color-gray" action="https://api.imgur.com/3/image" method="post">	
		<div class="dz-default dz-message">
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2">
					<div class="height-100px vertical-parent">
						<div class="vertical-child">
							Drop activity image here
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
	<script>
		$(document).ready(function(argument) {
			var currnetFile = '';
			var myDropzone = new Dropzone('#uploadform', {	
				acceptedFiles: "image/*",
				url:  "https://api.imgur.com/3/image",
				dataType: 'JSONP',
				maxFiles: 10, // Number of files at a time
				maxFilesize: 5, //in MB
				headers: {
					'Authorization': 'Client-ID 7e45443e00671ee',
					// 'Content-Type' : 'application/json'
					'Cache-Control': null,
					'X-Requested-With': null
				},
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
			
		});
	</script>
</body>
</html>
