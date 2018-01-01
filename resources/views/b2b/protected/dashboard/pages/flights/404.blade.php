@extends('b2b.protected.dashboard.404_main')
@section('title', ' | Flight Not Found')
@section('subject', 'Sorry..., no no no this package don\'t have any Flight')
@section('message', 'We are redirecting you to the package if still not redirected then click ')
@section('url', urlPackageAll($package->client->id, $package->id))
@section('url_name','here')

@section('scripts')
	<script>
		setTimeout(function () {    
			document.location.href = "{{ urlPackageAll($package->client->id, $package->id) }}";
	  }, 3000)
	</script>
@endsection