<!DOCTYPE HTML>
<html lang="en-US" dir="ltr">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<title>All Packages | {{ $package->uid }} {{ $package->title }}</title>
		@include('subway.pages.home_partials.head')
	</head>
	<body id="page" class="page home blog sidebar-a-right sidebar-b-right isblog wp-home wp-front_page transparency-75 system-transparent">
		<div id="page-body">
			<div class="page-body-1">
				<div id="socialbar">
					@include('subway.pages.home_partials.social')
				</div>
				<div class="wrapper grid-block">
					@include('subway.pages.home_partials.header')
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<section id="content" class="grid-block">
								<div id="system">
									<div class="items items-col-1 grid-block">
										<div class="grid-box width100">
											@include('subway.pages.packages_partials.index')  
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			var windata = { checked_count : 0, tokens : {} };
			$(document).on('change', 'input.compare', function () {
				var prop = $(this).prop('checked');
				var token = $(this).attr('data-token');

				if (prop) {
					if (windata.checked_count == 2) {
						$(this).prop('checked', false);
						$.alert('<h3><b>You can only select two packages at a time.</b></h3>');
						return false;
					}
					windata.checked_count = windata.checked_count+1;
					windata.tokens[token] = token;
				}
				else{
					windata.checked_count = windata.checked_count-1;
					delete windata.tokens[token];
				}
			});

			$(document).on('click', '#btn_compare', function () {
				if (windata.checked_count == 2) {
					var defToken = '';
					var compToken = '';
					var index = 1;
					
					$.each(windata.tokens, function (i, v) {
						if (index == 1) {
							defToken = v;
						}
						else if(index == 2){
							compToken = v;
						}
						index++;
					});

					var url = '{{url('/')}}/your/package/detail/'+defToken+'/compare?ctk=974dcf893547f27823222fbbea375156&compare_token='+compToken;

					document.location.href = url;

				}else{
					$.alert('<h3><b>Select two packages first.</b></h3>')
				}
			});
		</script>
	</body>
</html>
