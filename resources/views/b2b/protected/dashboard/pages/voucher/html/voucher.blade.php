<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hotel Voucher</title>
	<style>
		body{
			top:0;
			right:0;
			left:0;
			bottom:0;
			margin: 0;
			padding: 0;
		}
		.box{
			padding: 50px;
		}
		.hr-line{
			border-width: 1px;
			border-color: #000;
		}
		.hr-line{
			border-width: 1px;
			border-color: #ebebeb;
		}
		.m-top-5{
			margin-top: 10px;
		}
		.m-top-20{
			margin-top: 20px;
		}
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
			<h3>{{ $data->user->admin->companyname }}</h3>
			<div>{!! str_replace("\n", "<br/>", $data->user->admin->address) !!}</div>
			<div class="m-top-20"></div>
			<hr class="hr-line">
		</div>
		<div>
			<h3>Your Reservation is Confirmed!</h3>
			<div>{{ $data->user->admin->companyname }} special rate. Thanx for continuous support <br>
			{{ $data->remark }}</div>
			<div class="m-top-20"></div>
			<h2>{{ array_get($data->data, 'name') }}</h2>
			<div>{{ $data->check_in->format('d-M-Y') }} - {{ $data->check_out->format('d-M-Y') }} | ID #{{ $data->uid }}</div>
			<div class="m-top-20"></div>
			<table class="width-100p">
				<tr>
					<td width="20%" class="p-right-10"><img src="{{ array_get($data->data, 'image'), 'https://s-ec.bstatic.com/images/hotel/max200/132/13219673.jpg'}}" alt="Adctivity" width="200px"></td>
					<td width="80%" valign="top">
						<table>
							<tr class="p-tr">
								<td colspan="2">
									{{ array_get($data->data, 'name') }} <br>
									{!! getStarImage(4, 13, 13) !!}
								</td>
							</tr>
							<tr class="p-tr">
								<td>
									{{ $data->check_in->format('d-M-Y') }} <br>
									<small>Check-in</small>
								</td>
								<td> </td>
								<td>
									{{ $data->check_in->format('d-M-Y') }} <br>
									<small>Check-out</small>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div>
				<div class="m-top-20"></div>
				<hr class="hr-gray-line">
				<div>
					@foreach($data->guests as $key => $guest)
						<h4>Room : {{ $key+1 }}</h4>
						<div>{{ array_get($data->data, 'prop_type') }}</div>
						<div>Reserved for: {{ $data->client->fullname }} <br>
							<small>{{ array_get($guest, 'adults') }} adults</small>
						</div>

					@endforeach
				</div>
				<div class="m-top-20"></div>

				<hr class="hr-gray-line">
				<h2>Cancellation policy</h2>
				<div>
					{{ $data->terms }}
				</div>
				<h2>Disclaimer</h2>
				<div>
					Bedding request subject to availability and on hotels discreation <br>

					Early check-in and late check-out are subject to availability and on hotels discreation<br>

					Under no circumstance shall we be liable for the above request<br>

					Free breakfast if any will be servered only after completion of 1st night
				</div>
			</div>
		</div>
	</div>
</body>
</html>