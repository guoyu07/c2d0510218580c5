@extends('b2b.protected.dashboard.main')

@section('content')
<div class="row">
	<div class="div-square bg-color-gray text-center">
		<a href="{{ url('dashboard/tools/calendar') }}">
			<span class="glyphicon glyphicon-calendar" style="font-size: 14vw; padding: 10px 0 0 19px;"></span>
			<span class="font-size-30">Calandar</span>
		</a>
	</div>
	<div class="div-square bg-color-gray text-center">
	<a href="{{ url('dashboard/tools/contacts') }}">
			<span class="glyphicon glyphicon-user" style="font-size: 14vw; padding: 10px 0 0 0px;"></span>
			<span class="font-size-30">Contacts</span>
		</a>
	</div>
	<div class="div-square bg-color-gray text-center">
		<a href="{{ url('dashboard/tools/invoice') }}">
			<span class="glyphicon glyphicon-list-alt" style="font-size: 14vw; padding: 10px 14px 0 0px;"></span>
			<span class="font-size-30">Invoice</span>
		</a>
	</div>
	<div class="div-square bg-color-gray text-center">
		<a href="{{ url('dashboard/tools/inbox') }}">
			<span class="glyphicon glyphicon-inbox" style="font-size: 14vw; padding: 10px 0 0 0px;"></span>
			<span class="font-size-30">Inbox</span>
		</a>
	</div>
</div>
<div class="row">
	<div class="div-square bg-color-gray text-center">
		<a href="{{ url('dashboard/tools/vouchers') }}">
			<span class="glyphicon glyphicon-file" style="font-size: 14vw; padding: 10px 0 0 0px;"></span>
			<span class="font-size-30">Vouchers</span>
		</a>
	</div>
</div>
@endsection

