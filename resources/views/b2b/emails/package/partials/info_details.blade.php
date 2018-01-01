<table align="center" bgcolor="#fff" cellpadding="0" cellspacing="0" width="650">
	<tbody>
		<tr>
			<td bgcolor="{{ $theme->color3 }}" style="padding:20px">
				<p style="font-size:18px;font-weight:normal;color:#ffffff;font-family:Arial,sans-serif;margin-top:0">Your Package Details</p>
				<table border="0" cellpadding="6" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<td align="left" valign="middle" width="48">
								<img src="http://storage.trawish.com/storage/images/package/icon/map_mark.png" width="48" class="CToWUd">
							</td>
							<td align="left" style="font-size:13px;color:#ffffff;font-family:Arial,sans-serif" valign="middle">
								<b> Destination:<br>
								</b>
								<span>{{ $destination }}</span>
							</td>
							<td align="left" valign="middle" width="48">
								<img src="http://storage.trawish.com/storage/images/package/icon/clock.png" width="48" class="CToWUd">
							</td>
							<td align="left" style="font-size:13px;color:#ffffff;font-family:Arial,sans-serif" valign="middle">
								<b>Duration:<br>
								</b>{{ $duration }}
							</td>
						</tr>
						<tr>
							<td align="left" valign="middle">
								<img src="http://storage.trawish.com/storage/images/package/icon/meal.png" width="48" class="CToWUd">
							</td>
							<td align="left" style="font-size:13px;color:#ffffff;font-family:Arial,sans-serif" valign="middle">
								<b> Meal Plan:<br>
								</b>{{ $meal }}
							</td>
							<td align="left" valign="middle">
								<img src="http://storage.trawish.com/storage/images/package/icon/image.png" width="48" class="CToWUd">
							</td>
							<td align="left" style="font-size:13px;color:#ffffff;font-family:Arial,sans-serif" valign="middle">
								<b> Tour Type:<br>
								</b>{{ $tourType }}
							</td>
						</tr>
						<tr>
							<td align="left" valign="middle">
								<img src="http://storage.trawish.com/storage/images/package/icon/calander.png" width="48" class="CToWUd">
							</td>
							<td align="left" style="font-size:13px;color:#ffffff;font-family:Arial,sans-serif" valign="middle">
								<b> Date of Travel:<br>
								</b>{{ $startDate }}
							</td>
							<td align="left" valign="middle">
								<img src="http://storage.trawish.com/storage/images/package/icon/people.png" width="48" class="CToWUd">
							</td>
							<td align="left" style="font-size:13px;color:#ffffff;font-family:Arial,sans-serif" valign="middle">
								<b> Passanger Details:<br>
								</b>{{ $pax }}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>