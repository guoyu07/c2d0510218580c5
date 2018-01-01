$(document).on('change', '.w3-input-image', function () {
	var form = $(this).closest('.w3-form-image'),
		bar = $(form).find('.progressBar .bar'), 
		progressBar = $(form).find('.progressBar'), 
		percent = $(form).find('.progressBar .percent')
		img = $(form).find("img");

	$(form).ajaxForm({
		dataType : 'JSON',
		beforeSend: function() {
			progressBar.fadeIn();
			var percentVal = '0%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		uploadProgress: function(event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		success: function(res, statusText, xhr, $form) {
			console.log(res);
			var percentVal = '100%';
			bar.width(percentVal)
			percent.html(percentVal);

			$(img).prop('src',res.host+'/'+res.path)
							.attr('data-host', res.host)			
								.attr('data-path', res.path);			
		},
		complete: function(xhr) {
			progressBar.fadeOut();			
		}	
	}).submit();		
});