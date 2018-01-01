<?php 
	$default = $package->tripSummary();
	$compareTo = $package->comparePackage(request()->compare_token);
	$checkAttrs = ['flights', 'hotels', 'transfers', 'activities'];
?>

<article class="item">
	<header>
		<h1 class="title">Compare</h1>
	</header>
	<div class="content clearfix p-10">
		<div class="x_content sans-serif">
			<div class="content clearfix">
				<table width="100%" class="table-lborder table-trip-sum td-p-10">
					<tr>
						<td >
							<h2>{{ $package->uid }}
								<span class="pull-right">
									<i class="fa fa-rupee"></i>
									<b>{{ $package->cost->total_cost }} /-</b>
								</span>
							</h2>
							<hr>
						</td>
						<td>
							<h2>{{ $comparePackage->uid }}
								<span class="pull-right">
									<i class="fa fa-rupee"></i>
									<b>{{ $comparePackage->cost->total_cost }} /-</b>
								</span>
							</h2>
							<hr>
						</td>
					</tr>
					@foreach ($checkAttrs as $checkAttr)
						<?php
							$check = isset($default[$checkAttr]) 
										&& isset($compareTo[$checkAttr])
										&& (!empty($compareTo[$checkAttr]['same'])
										|| !empty($compareTo[$checkAttr]['del'])
										|| !empty($compareTo[$checkAttr]['new']))
										&& (!empty($default[$checkAttr]) 
										|| !empty($compareTo[$checkAttr]));
						?>
						@if ($check)
							<tr>
								<td>
									<h4>{{ proper($checkAttr) }}</h4>
									<ul>
										@foreach ($default[$checkAttr] as $value)
											<li>{{ $value }}</li>
										@endforeach
									</ul>
								</td>
								<td>
									<h4>{{ proper($checkAttr) }}</h4>
									<ul>
										@foreach ($compareTo[$checkAttr]['same'] as $value)
											<li>{{ $value }}</li>
										@endforeach
										@foreach ($compareTo[$checkAttr]['del'] as $value)
											<li><del>{{ $value }}</del></li>
										@endforeach
										@foreach ($compareTo[$checkAttr]['new'] as $value)
											<li style="color: #aef3ae;">{{ $value }}</li>
										@endforeach
									</ul>
								</td>
							</tr>
						@endif
					@endforeach
					<tr>
						<td>
							<h4>Visa</h4>
							<ul>
								<li>{{ $default['visa'] ? 'Visa included' : 'Visa not included' }}</li>
							</ul>
						</td>
						<td>
							<h4>Visa</h4>
							<ul>
								<li>{{ $compareTo['visa'] ? 'Visa included' : 'Visa not included' }}</li>
							</ul>
						</td>
					</tr>
					@if (strlen($default['extra_word']) || strlen($compareTo['extra_word']['same']) || strlen($compareTo['extra_word']['changed']) || strlen($compareTo['extra_word']['new']))
						<tr>
							<td>
								<h4>More details</h4>
								<ul>
									@if (strlen($default['extra_word']))
										<li>{!! $default['extra_word'] !!}</li>
									@endif
								</ul>
							</td>
							<td>
								<h4>More details</h4>
								<ul>
									@if ($compareTo['extra_word']['which'] == 'same')
										
										@if (strlen($compareTo['extra_word']['same']))
											<li>{!! $compareTo['extra_word']['same'] !!}</li>
										@endif

									@elseif($compareTo['extra_word']['which'] == 'changed')

										@if (strlen($compareTo['extra_word']['same']))
											<li><del>{!! $compareTo['extra_word']['same'] !!}</del></li>
										@endif

										@if (strlen($compareTo['extra_word']['changed']))
											<li style="color: #aef3ae;">{!! $compareTo['extra_word']['changed'] !!}</li>
										@endif

									@elseif($compareTo['extra_word']['which'] == 'new')
										
										@if (strlen($compareTo['extra_word']['new']))
											<li style="color: #aef3ae;">{!! $compareTo['extra_word']['new'] !!}</li>
										@endif

									@endif
								</ul>
							</td>
						</tr>
					@endif

			</div>
		</div>
	</div>
</article>

