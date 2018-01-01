<div class="x_panel">
	<div class="x_title">
		<h2>
			Action
		</h2>
		<ul class="nav navbar-right panel_toolbox panel_toolbox1">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<div class="row m-top-20">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<button type="button" id="btn_publish_package" class="btn btn-{{ $package->is_locked ? 'danger' : 'success'}} btn-block"><span class="btn-text">{{ $package->is_locked ? 'Unpublish' : 'Publish'}} Package</span> <i class="fa fa-spinner fa-pulse fa-3x fa-fw font-size-20 hide"></i></button>
			</div>

			<div class="col-md-6 col-sm-6 col-xs-12">
				<button type="button" id="btn_send_email" class="btn btn-primary btn-block" {{ is_null($package->package_url) ? 'disabled' : '' }}>Send Email <i class="email-send fa fa-spinner fa-pulse fa-3x fa-fw font-size-20 hide"></i></button>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				{{-- <button id="run_pdf" class="btn btn-primary btn-block" target="_blank">Generate PDF</button>
				<a id="btn_pdf" href="{{ newRedirectUrl(urlPdfPacakge($package->id)) }}" class="btn btn-primary btn-block hide" target="_blank"></a> --}}
			</div>
		</div>

		<?php
			$aHref = '';
			if (!is_null($package->package_preview_url)) {
				$aHref = 'href="'.$package->package_preview_url.'"';
			}
		?>
		<div class="row m-top-20">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="input-group">
	        <input type="text" id="input_html_link" class="form-control" placeholder=" Web link ..." value="{{ $package->package_preview_url }}" />
	        <span class="input-group-btn">
	          <a {!! $aHref !!} id="a_html_link" type="button" class="btn btn-primary" target="_blank">Preview !</a>
	        </span>
	      </div>
	      <label> Package url for client : </label>
	      <input type="text" id="input_client_html_link" class="form-control" placeholder=" Web link ..." value="{{ $package->package_url }}" />
			</div>
		</div>
	</div>
</div>