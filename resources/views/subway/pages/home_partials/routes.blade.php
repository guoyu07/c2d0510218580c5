<article class="item">
	<header>
		<h1 class="title">trip summary</h1>
	</header>
	<div class="content clearfix">
		<table class="zebra">
			<thead>
				<tr>
					<th>Mode</th>
					<th>Origin</th>
					<th>Destination</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($package->routes as $routeKey => $route)
					<tr {{ $routeKey%2 == 0 ? '' : 'class="odd"'}}>
						<td>{{ proper($route->mode) }}</td>
						<td>{{ $route->origin == '' ? '-' : $route->origin }}</td>
						<td>{{ $route->destination }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</article>