<script>
	function myAlert(alert) {
		<?php 
			$custom_alert_box = '<div id="custom_alert_box" class="alert-pop-up-base">
					<div class="alert-pop-up x_panel">
						<div class="row">
							<div class="col-md-10 col-sm-10 col-xs-12">
								<h3><i class="fa fa-warning" ></i> Alert</h3>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<button type="button" class="close close-alert"><span aria-hidden="true">×</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-11 col-sm-11 col-xs-12">\'+alert+\'</div>
						</div>
						<div class="row m-top-30">
							<div class="col-md-3 col-sm-3 col-xs-12 pull-right">
								<button class="btn btn-primary btn-block close-alert">Ok</button>
							</div>
						</div>
					</div>
				</div>';
			$custom_alert_box = trimHtml($custom_alert_box);
		?>
		$('body').prepend('{!! $custom_alert_box !!}');
	}

	$(document).on('click', '.close-alert', function() {
		$('#custom_alert_box').remove();
	});

	var csrf_token = $('[name="csrf_token"]').attr('content');
</script>