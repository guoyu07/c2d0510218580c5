<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	{{-- <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> --}}
	<style>
		body{
			top : 0;
			right: 0;
			bottom: 0;
			left: 0;
			margin: 0;
			padding: 0;
			font-family: 'Montserrat', sans-serif;
		}

		@page :first{
			background-image: url("/images/voucher_blank_1.jpg");
			background-image-resize:6;
			margin-bottom:0px;
			margin-top:0px;
		}
		.width-100p{
			width: 100%;
		}
	
		.reserv-box{
			text-align: center;
			margin-top: 80px;
			color: #fff;
		}

	</style>
</head>
<body>
	<div>
		<table class="width-100p">
			<tr>
				<td width="80%" style="padding: 40px 0 0 50px; ">
					<div>
						<div><b style="font-size: 20px;">{{ $data->voucher->user->admin->companyname }}</b> </div>
						<br>
						<div class="m-top-20">{!! str_replace("\n", "<br/>", $data->voucher->user->admin->address) !!}</div>
					</div>
				</td>
				<td width="20%" style="text-align: right; padding: 40px 50px 0 0;">
					<img src="{{ $data->voucher->user->admin->profile_pic }}" style="float: right;" height="80">
				</td>
			</tr>
		</table>
	</div>
	<div>
		<div class="reserv-box">
			<div style="font-size: 20px;">
				<b>Your Reservation is Confirmed!</b>
			</div>
			<div style="margin-top: 5px;">{{ $data->remark }}</div>
		</div>
	</div>
	<div style="color: #fff;">
		<div style="margin:200px 0 0 20px; ">
			<h2>{{ array_get($data->data, 'name') }} {!! getStarImage($data->accommodation_details->star_rating, 13, 13) !!}</h2>
			<b>
				{{ $data->check_in->format('d-M-Y') }} - 
				{{ $data->check_out->format('d-M-Y') }} | 
				ID #{{ $data->uid }}
				@if(array_get($data->data, 'confirmation_no', false))
				 | Confirmation No. {{ array_get($data->data, 'confirmation_no', '') }}
				@endif
			</b>
		</div>
		<table class="width-100p" style="color: #fff;">
			<tr>
				<td width="20%" valign="top" style="padding: 30px 0 0 20px">
					<img src="/images/hotel.jpg" alt="Adctivity" width="250px">
				</td>
				<td width="30%" valign="top" style="padding: 50px 0 0 10px;">
					<table class="width-100p">
						<tr>
							<td style="padding: 0 0 0 30px;">
								<b>
									<small>Check-in</small><br>
									{{ $data->check_in->format('d-M-Y') }}
								</b>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<br>
							</td>
						</tr>
						<tr>
							<td  style="padding: 0 0 0 30px;">
								<b>
									<small>Check-out</small><br>
									{{ $data->check_out->format('d-M-Y') }}
								</b>
							</td>
						</tr>
					</table>
				</td>
				<td width="50%" style="padding: 70px 20px 0 20px;">
					<table class="width-100p">
						<tr>
							<td style="padding: 20px 0 0 20px; color: #fd6a08;">
								<b>{{ $data->accommodation_details->address }}</b>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<br>
							</td>
						</tr>
						<tr>
							<td  style="color: #000; padding: 0 0 0 20px;">
								<b>Room : {{ $data->mealsString() }}</b>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<br>
							</td>
						</tr>
						<tr>
							<td  style="color: #000; padding: 0 0 0 20px;">
								<b>Reserved for : {{ $data->voucher->client->fullname }}.</b>
								<br>
								<span>No of Room : {{ count($data->guests) }}</span>
								 | <span>Pax : {{ array_sum(array_pluck($data->guests, 'adults')) }}</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div style="margin: 70px 20px 0 40px;">
		<div style="color: #fd6a08; font-size: 17px;">
			<b>Cancellation policy</b>
		</div>
		<div style="color: #959595; font-size: 12px; font-weight:bold;">
			
				<div style="margin-top: 5px;">
					{{ $data->terms }}
				</div>
				<div style="margin-top: 10px;">
					Booking Terms & Conditions
					<ul>
						<li><small>You must present a photo ID at the time of check in. Hotel may ask for credit card or cash deposit for the extra services at the time of check in.</small></li>
						<li><small>All extra charges should be collected directly from clients prior to departure such as parking, phone calls, room service, city tax, etc.</small></li>
						<li><small>We don't accept any responsibility for additional expenses due to the changes or delays in air, road, rail, sea or indeed of any other causes, all such expenses will have to be borne by passengers.</small></li>
						{{-- <li><small>In case of wrong residency & nationality selected by user at the time of booking; the supplement charges may be applicable and need to be paid to the hotel by guest on check in/ check out.</small></li> --}}
						<li><small>Any special request for bed type, early check in, late check out, smoking rooms, etc are not guaranteed as subject to availability at the time of check in.</small></li>
						<li><small>Early check out will attract full cancellation charges unless otherwise specified.</small></li>
					</ul>
				</div>
		</div>
	</div>
</body>
</html>