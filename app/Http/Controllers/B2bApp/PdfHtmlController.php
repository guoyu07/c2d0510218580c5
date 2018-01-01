<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\TrackPackageController;
use App\Models\B2bApp\PdfHtmlModel;
use App\Traits\CallTrait;

class PdfHtmlController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new PdfHtmlModel;
	}

	public function createNew($packageDbId, $html)
	{
		$pdfHtml = new PdfHtmlModel;
		$pdfHtml->package_id = $packageDbId;
		$pdfHtml->html = $html;
		$pdfHtml->save();
		$pdfHtml->hash_id = sha1('b2b_fgf'.$pdfHtml->id);
		$pdfHtml->save();
		return $pdfHtml;

	}

	public function find($pdfHtmlId)
	{
		return PdfHtmlModel::find($pdfHtmlId);
	}


	public function findByHashId($hashId)
	{
		$pdfHtml = PdfHtmlModel::select()
							->where(['hash_id' => $hashId])
								->first();
		return $pdfHtml;
	}

	/*
	| this function is to only pull html by hash id
	*/
	public function htmlByHashId($hashId)
	{
		$pdfHtml = PdfHtmlModel::select()
							->where(['hash_id' => $hashId])
								->first();

		$html = $pdfHtml->html;
		return $html;
	}


	/*
	| this function pull html with tracking js script
	*/
	public function htmlByHashIdWithTrack($hashId)
	{
		$pdfHtml = PdfHtmlModel::select()
							->where(['hash_id' => $hashId])
								->first();

		$html = $pdfHtml->html;

		$script = '<script src="'.asset('common/dashboard/vendors/jquery/dist/jquery.min.js').'"></script>
			<script>
				$(document).ready(function() {
					$.ajax({
						type:"get",
						url: "'.url("/dashboard/package/html/".$pdfHtml->package_id).'",
						data: data,
						success: function(response, textStatus, xhr) {
							response = JSON.parse(response);
							if (response.status == 200) {
								var pdfUrl = "{{ url("/dashboard/package/pdf/") }}/"+response.hash_id;
								$("#btn_pdf").attr("href", pdfUrl);
								window.open(pdfUrl, "_blank");
							}
			      },
			      error: function(xhr, textStatus) {
							if(xhr.status == 401){
								window.open("{{ url("login") }}", "_blank");
							}
			      }

					});
				});
			</script>';

		$search = [
				'<body', 
				// '</body>'
			];
		$replace = [
			'<body style="border: 1px solid #ccc;width: 64%;margin: auto;"',
			// trimHtml($script)
		];
		$html = str_replace($search, $replace, $html);

		TrackPackageController::call()->opened($pdfHtml->package_id);

		return $html;
	}


	/*
	| this fuction is only used for one time 
	*/
	public function copyIdasHashPdfHtmls()
	{
		$changeSomething = new \App\Models\B2bApp\ChangeSomethingModel;
		$changeSomething->detail = 'Copying All id as hash in hash_id column in pdf_htmls table';

		if (!env('IS_LOCALHOST')) {
			$htmls = PdfHtmlModel::select('id')->get();
			if ($htmls->count()) {
				foreach ($htmls as $html) {
					$html->hash_id = sha1('b2b_fgf'.$html->id);
					$html->save();
				}
			}
		}

		$changeSomething->save();
		$changeSomething->stack_id = $changeSomething->id;
		$changeSomething->save();
	}

}
