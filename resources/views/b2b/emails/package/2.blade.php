<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<style>
		@media only screen and (max-width: 600px) {
			.inner-body {
				width: 100% !important;
			}

			.footer {
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 500px) {
			.button {
				width: 100% !important;
			}
		}
	</style>
	
	<?php
		$viewPath = 'b2b.emails.package.partials'; 
		$themes = [
				(object) [
					'color'  => '#FFFFFF',
					'color1' => '#F60144',
					'color2' => '#BA0233',
					'color3' => '#31010E',
					'color4' => '#580118',
					'color5' => '#451629',
					'color6' => '#ED4C76',
					'color7' => '#222222',
					'color8' => '#8B042A',
					'color9' => '#ac4368',
					'color10' => '#E4000D'
				],
				(object)[
					'color' => '#FFFFFF',
					'color1' => '#0ca1cf',
					'color2' => '#116b86',
					'color3' => '#2e8aa7',
					'color4' => '#069db9',
					'color5' => '#024e66',
					'color6' => '#6dd0ee',
					'color7' => '#222222',
					'color8' => '#04556f',
					'color9' => '#62e6db',
					'color10' => '#00c3ff'
				],
			];


		$theme = $themes[rand(0, (count($themes)-1))];

		$packageUrl = $package->package_url;
		$clientName = $package->client->fullname;
		$destination = $package->destinations();
		$duration = $package->duration;
		$meal = 'Room + Breakfast';
		$tourType = 'Holiday';
		$startDate = $package->start_date->format('d M Y');
		$pax = $package->pax_string;
		$agentName = $package->user->fullname;
		$agentCont = $package->user->mobile;
		$agentEmail = $package->user->email;
		$companyName = $package->user->admin->companyname;
		$companyCont = $package->user->admin->mobile;
		$companySite = $package->user->admin->website;
		$companyEmail = $package->user->admin->email;
		$companyAddr = $package->user->admin->address;
		$companyAbout = $package->user->admin->about;
		$texts = $package->user->admin->texts;
		$img1 = 'http://storage.trawish.com/storage/images/package/big.jpg';
		$img2 = 'http://storage.trawish.com/storage/images/package/sq.jpg';
		$img3 = 'http://storage.trawish.com/storage/images/package/ls.jpg';

	?>

	<table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				<table class="content" width="100%" cellpadding="0" cellspacing="0">

					<!-- Email Body -->
					<tr>
						<td class="body" width="100%" cellpadding="0" cellspacing="0">
							<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
								<!-- Body content -->
								<tr>
									<td align="center" bgcolor="#ffffff" valign="top" width="100%">
										<div style="background-color:{{ $theme->color1 }};margin:0 auto;padding:40px 30px;width:730px">
											<!-- include file hare -->
												@include($viewPath.'.header_logo')
												{{-- @include($viewPath.'.header_menu') --}}
												@include($viewPath.'.image_name')
												@include($viewPath.'.about_us')
												@include($viewPath.'.info_details')
												{{-- @include($viewPath.'.way_xpath') --}}
												@include($viewPath.'.open_button')
												{{-- @include($viewPath.'.inclusion') --}}
												{{-- @include($viewPath.'.accommodation_option') --}}
												{{-- @include($viewPath.'.exclusion') --}}
												@include($viewPath.'.procedure')
												@include($viewPath.'.agent_info')
												@include($viewPath.'.office_info')
												@include($viewPath.'.copyright')
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
