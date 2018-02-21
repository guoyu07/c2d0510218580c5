<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hotel Voucher</title>
	<style>
		html *{
			font-family : Arial !important;
		}
		body{
			top:0;
			right:0;
			left:0;
			bottom:0;
			margin: 0;
			padding: 0;
		}
		@page {
	    margin-top: 60px;
	    margin-bottom: 60px;
	    margin-left: 50px;
	    margin-right: 60px;
		}
		.box{
			/* padding: 50px; */
		}
		.hr-line{
			border-width: 1px;
			border-color: #000;
		}
		.hr-line{
			border-width: 1px;
			border-color: #ebebeb;
		}
		.m-top-5{ margin-top: 5px;}
		.m-top-10{ margin-top: 10px;}
		.m-top-20{ margin-top: 20px;}
		.img-thumb{
			width: 100%;
			height: 150px;
		}
		.p-top-5{
			padding-top: 5px; 
		}
		.p-right-10{
			padding-right: 10px; 
		}
		.height-100p{
			height: 100%;
		}
		.width-100p{
			width: 100%;
		}
		.p-tr > td
		{
			padding-top: 5px;
			padding-bottom: 5px;
		}
	</style>
</head>
<body>
	<div class="box">
		<div>
			<table class="width-100p">
				<tr>
					<td width="80%">
						<div>
							<div><b style="font-size: 20px;">{{ $data->voucher->user->admin->companyname }}</b> </div>
							<br>
							<div class="m-top-20">{!! str_replace("\n", "<br/>", $data->voucher->user->admin->address) !!}</div>
						</div>
					</td>
					<td width="20%" style="text-align: right;">
						<img src="{{ $data->voucher->user->admin->profile_pic }}" style="float: right;" height="80">
					</td>
				</tr>
			</table>
			<!-- <div><br> <small></small></div> -->
			<div class="m-top-20"></div>
			<hr class="hr-line">
		</div>
		<div>
			<h3>Your Reservation is Confirmed!</h3>
			<div>{{ $data->remark }}</div>
			<div class="m-top-20"></div>
			<h2>{{ array_get($data->data, 'name') }}</h2>
			<div>{{ $data->check_in->format('d-M-Y') }} - {{ $data->check_out->format('d-M-Y') }} | ID #{{ $data->uid }} | Confirmation No. #HDJKKS78K</div>
			<div class="m-top-20"></div>
			<table class="width-100p">
				<tr>
					<td width="20%" class="p-right-10"><img src="{{ array_get($data->data, 'image'), 'https://s-ec.bstatic.com/images/hotel/max200/132/13219673.jpg'}}" alt="Adctivity" width="200px"></td>
					<td width="80%" valign="top">
						<table>
							<tr class="p-tr">
								<td colspan="2">
									{{ array_get($data->data, 'name') }}. <br>
									{!! getStarImage($data->accommodation_details->star_rating, 13, 13) !!}
								</td>
							</tr>
							<tr class="p-tr m-top-5">
								<td>
									{{ $data->check_in->format('d-M-Y') }} <br>
									<small>Check-in</small>
								</td>
								<td> </td>
								<td>
									{{ $data->check_out->format('d-M-Y') }} <br>
									<small>Check-out</small>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div>
				<hr class="hr-gray-line">
				<table class="width-100p">
					<tr>
						<td width="60%">{{ $data->accommodation_details->address }}</td>
						<td width="40%"></td>
					</tr>
				</table>
			</div>
			<div>
				<hr class="hr-gray-line">
				<div class="m-top-10"></div>
				<div>
					@foreach($data->guests as $key => $guest)
						<h4>Room : {{ $key+1 }} <small>{{ $data->mealsString() }}</small></h4>
						<div></div>
						<div>Reserved for: {{ $data->voucher->client->fullname }} <br>
							<small>{{ array_get($guest, 'adults') }} adults</small>
						</div>

					@endforeach
				</div>
				<div class="m-top-20"></div>

				<hr class="hr-gray-line">
				<h3><u>Cancellation policy</u></h3>
				<div style="color:red;">
					{{ $data->terms }}
				</div>
				<div class="m-top-20"></div>
				<div>
					<b>Booking Terms & Conditions</b>
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
	</div>
</body>
</html>