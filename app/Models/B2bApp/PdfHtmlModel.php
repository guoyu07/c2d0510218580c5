<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PdfHtmlModel extends Model
{
	protected $table = 'pdf_htmls';

	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}
}
