@foreach ($texts as $text)
	<table align="center" bgcolor="{{ $theme->color7 }}" cellpadding="0" cellspacing="0" width="650">
		<tbody>
			<tr>
				<td style="padding:20px">
					<p style="font-size:18px;color:#ffffff;font-family:Arial,sans-serif;margin-top:0;margin-bottom:10px">{{ $text->title }}</p>
					<table border="0" cellpadding="6" cellspacing="1" style="background-color:#888888" width="100%">
						<tbody>
							<tr>
								<td bgcolor="#FEF2F5" style="font-family:Arial,sans-serif;font-size:13px">
									<div>{!! $text->text !!}</div>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
@endforeach