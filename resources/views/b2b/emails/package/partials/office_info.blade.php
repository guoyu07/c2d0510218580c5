<table align="center" bgcolor="{{ $theme->color7 }}" cellpadding="0" cellspacing="0" width="650">
	<tbody>
		<tr>
			<td align="center" style="padding:20px">
				<p style="font-size:13px;color:#ffffff;font-family:Arial,sans-serif; text-align: center;">
					{{ $companyAddr }}
					<br> 
					E-Mail: <a href="mailto:{{ $companyEmail }}" style="color:#ffffff;font-weight:bold" target="_blank">
					{{ $companyEmail }}</a>
					@if (strlen($companySite))
						&nbsp;&nbsp;|&nbsp;&nbsp; 
						Web: <a href="{{ $companySite }}" style="color:#ffffff;font-weight:bold" target="_blank">{{ $companySite }}</a>
					@endif
				</p>
			</td>
		</tr>
	</tbody>
</table>