<article class="item">
	<header>
		<h1 class="title">All Packages</h1>
	</header>
	<div class="content clearfix p-10">
		<div class="x_content sans-serif">
			<div class="content clearfix">
        @foreach ($package->packages->where('is_locked', 1) as $tempPackage)
          <div class="col-md-3 col-sm-3 col-xs-3">
            <div class="square mod-box-color1">
              <a href="{{ $tempPackage->package_url }}" class="font-white">
                <div class="square-content text-center font-white">
                  <div class="tile-line font-size-20 m-top-20">
                    <b>{{ $tempPackage->uid }}</b>
                  </div>

                  <div class="tile-line m-top-10">
                    <i class="fa fa-rupee"></i>
                    <b> {{ $tempPackage->cost->total_cost }} per person</b>
                  </div>
                  <div class="tile-line"><b>for : {{ $tempPackage->nights}} nights/{{ $tempPackage->nights+1 }} days</b></div>
                </div>
              </a>
              <div class="down-title font-size-14 text-center"> 
                <label>
                  <input type="checkbox" class="compare nomargin" data-token="{{ $tempPackage->token }}"> Compare</a>
                </label>
              </div>
            </div>
          </div>
        @endforeach
			</div>
      <div class="content clearfix">
        <div class="col-md-3 col-sm-3 col-xs-3">
          <div class="m-top-10"></div>
          <button id="btn_compare" class="btn btn-success" style="margin: 2.1%;">Compare</button>
        </div>
      </div>
		</div>
	</div>
</article>

