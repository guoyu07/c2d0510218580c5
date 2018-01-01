<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Activity Voucher</title>
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
			<h3>{{ $data->companyName }}</h3>
			<div>{!! str_replace("\n", "<br/>", $data->companyAddr) !!}</div>
			<div class="m-top-20"></div>
			<hr class="hr-line">
		</div>
		<div>
			<h3>Your activity is Confirmed!</h3>
			<div>{{ $data->companyName }} special rate. Thanx for continuous support</div>
			<div class="m-top-20"></div>
			<h2>{{ $data->name }}</h2>
			<div>{{ $data->date->format('d-M-Y') }} | Itinerary #{{ uid() }}</div>
			<div class="m-top-20"></div>
			<table class="width-100p">
				<tr>
					<td width="20%" class="p-right-10"><img src="https://s-ec.bstatic.com/images/hotel/max200/132/13219673.jpg" alt="Adctivity" width="200px"></td>
					<td width="80%" valign="top">
						<table>
							<tr class="p-tr">
								<td>Traveler Name</td>
								<td>:</td>
								<td>{{ $data->clientName }}</td>
							</tr>
							<tr class="p-tr">
								<td>Total Pax</td>
								<td>:</td>
								<td>Adult : {{ $data->pax->adult }}, Child : {{ $data->pax->child }}</td>
							</tr>
							<tr class="p-tr">
								<td>Date of Visit</td>
								<td>:</td>
								<td>{{ $data->date->format('d-M-Y') }}</td>
							</tr>
							<tr class="p-tr">
								<td>Booking Date</td>
								<td>:</td>
								<td>{{$data->date->format('d-M-Y')}}</td>
							</tr>
							<tr class="p-tr">
								<td>Redemption Code</td>
								<td>:</td>
								<td>{{ uid() }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div>
				<h2>Terms and Conditions</h2>
				<ul>
					<li>Lorem ipsum dolor sit amet, </li>
					<li>consectetur adipisicing elit. Ipsam ratione, </li>
					<li>est consequuntur exercitationem eius impedit itaque enim</li>
					<li>accusamus expedita aut recusandae eaque atque</li>
					<li>accusantium unde minus sapiente! Eos, rem, minus!</li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>