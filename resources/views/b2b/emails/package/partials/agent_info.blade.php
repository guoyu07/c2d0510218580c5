<table align="center" bgcolor="#00B5F0" cellpadding="10" cellspacing="0" style="border:3px solid #333333" width="670">
	<tbody>
		<tr>
			<td align="center" bgcolor="{{ $theme->color }}" valign="middle">
				
				<span style="font-size:13px;font-family:Arial;font-weight:bold">Thanks &amp; Best Regards,</span>
				<br>
				<span style="font-family:Arial;font-size:18px;font-weight:bold;font-style:italic;color:#5ac4ce">{{ $agentName }}</span>
				<br><br> 
				<span style="font-size:13px;font-family:Arial;font-weight:normal">Direct: 
					<span style="color:red">
						<span>
							<a href="tel:{{ $agentCont }}" value="+91{{ $agentCont }}" target="_blank">+91 {{ $agentCont }}</a>
						</span>
					</span>
				</span>
				<span> | </span>
				<span style="font-size:13px;font-family:Arial;font-weight:normal">Tel: 
					<span style="color:red">
						<span>
							<a href="tel:{{ $companyCont }}" value="+91{{ $companyCont }}" target="_blank">{{ $companyCont }}</a>
						</span>
					</span>
				</span>
				<span> | </span>
				<span style="font-size:13px;font-family:Arial;font-weight:normal">Email: 
					<span style="color:red">
						<span>
							<a href="mailto:{{ $agentEmail }}" target="_blank">{{ $agentEmail }}</a>
						</span>
					</span>
				</span>
			</td>
		</tr>
	</tbody>
</table>