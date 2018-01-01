@extends('admin.protected.dashboard.main')

@section('css')
<link rel="stylesheet" type="text/css" id="u0" href="https://cdn.tinymce.com/4/skins/lightgray/skin.min.css">
@endsection

@section('content')
	<div class="row">
		
	</div>
  <div class="row">
    <div class="col-md-10 col-sm-10 col-md-offset-1 col-xs-12">
      <div class="form-style-8 width-100-p height-80vh" >
        <h2 class="font-white">Text</h2>
        <form method="post" action="{{ url('dashboard/settings/text/'.(isset($text->id) ? $text->id : '')) }}" enctype="multipart/form-data">
        	{{ isset($text->id) ? method_field('PUT') : '' }}
          {{ csrf_field() }}
          <input type="text" name="title" placeholder="Title" value="{{ isset($text->title) ? $text->title : '' }}" />
          <textarea name="text" placeholder="text">{!! isset($text->text) ? $text->text : '' !!}</textarea>

          <div class="row padding-tb-10">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="submit" class="btn btn-success btn-block radius-0" value="Save" />
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
							<a href="{{ url('dashboard/settings/text') }}" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i> Back to Texts</a>
						</div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('headJs')
  <script src="{{ asset('js/tinymce.min.js') }}"></script>
  {{-- <script src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ojx87hfs53fqsef62yibco7kh4nk7gyzf1trcc14tt3vlmrn"></script> --}}
  <script>
    tinymce.init({ 
      selector:'textarea',
      plugins : 'autolink link image lists preview table',
      menu: {
        file: {title: 'File', items: 'newdocument'},
        edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
        insert: {title: 'Insert', items: 'link media | template hr'},
        view: {title: 'View', items: 'visualaid'},
        format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
        table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
        tools: {title: 'Tools', items: 'spellchecker code'}
      },
      menubar: 'file edit insert view format table tools',
      height : 210
    });
  </script>
@endsection