<!DOCTYPE HTML>
<html lang="en-US" dir="ltr">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<title>Flights | {{ $package->uid }} {{ $package->title }}</title>
		@include('subway.pages.home_partials.head')
		<style>
			#map_canvas{
				height: 400px;
				width: 100%;
				background: url(../images/module_box_transparency75.png) 0 0 repeat;
			}
		</style>
	</head>
	<body id="page" class="page home blog sidebar-a-right sidebar-b-right isblog wp-home wp-front_page transparency-75 system-transparent">
		<div id="page-body">
			<div class="page-body-1">
				<div id="socialbar">
					@include('subway.pages.home_partials.social')
				</div>
				<div class="wrapper grid-block">
					@include('subway.pages.home_partials.header')
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 subway-theme-font">
							<div class="m-top-5" style="padding: 5px;">
								<div id="map_canvas"></div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<section id="content" class="grid-block">
								<div id="system">
									<div class="items items-col-1 grid-block">
										<div class="grid-box width100">
											@include('subway.pages.flights_partials.flights')	
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
					{{-- @include('subway.pages.home_partials.footer') --}}
				</div>
				<script type='text/javascript' src='{{ url('/') }}/subway/wp-includes/js/wp-embed.min1c9b.js?ver=4.6.1'></script>
				<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDkiwDy_5u1y7s99ODNmehYqSYh9tmyTjo&libraries=geometry,places"></script>

				<script>
					<?php
						$arrayOfLocationPoints = [];
						$locationAirports = [];
						foreach ($package->flightRoutes as $flightRoute) {
							$arrayOfLocationPoints[] = [
									"Item1" => $flightRoute->origin_detail->latitude.'|'.$flightRoute->origin_detail->longitude,
					  			"Item2" =>  $flightRoute->destination_detail->latitude.'|'.$flightRoute->destination_detail->longitude,
								];

							$locationAirports[] = [
									"Item1" => $flightRoute->originCode.'|'.$flightRoute->origin,
					  			"Item2" => $flightRoute->destinationCode.'|'.$flightRoute->destination,
								];
						}
					?>
					var arrayOfLocationPoints = {!! json_encode($arrayOfLocationPoints) !!};
					var locationAirports = {!! json_encode($locationAirports) !!};
					var map;
					var FlightIconLines = [];
					var geoDisc = false;
					var flightSVGIcon = {
					  path: "M 341.68032,435.72254 C 341.20649,434.97913 318.35103,391.06654 290.89042,338.13903 C 263.42982,285.2115 240.5353,241.47293 240.01371,240.9422 C 239.40475,240.3226 224.87159,254.16767 199.40456,279.62871 C 162.19988,316.82465 159.74472,319.4955 159.75908,322.75711 C 159.76748,324.66943 161.29656,338.73427 163.157,354.01232 L 166.53962,381.79058 L 150.46254,397.93832 L 134.38546,414.08604 L 115.72849,378.57029 L 97.071547,343.05455 L 61.95992,324.72348 C 42.648539,314.6414 26.838515,306.16398 26.826552,305.88476 C 26.814586,305.60554 33.905134,298.28717 42.583321,289.6217 L 58.361846,273.86631 L 89.312123,277.62282 L 120.2624,281.37935 L 160.35096,241.3056 C 191.61286,210.05523 200.13431,201.01341 199.05345,200.23976 C 198.29113,199.69412 153.64225,176.03495 99.833713,147.66383 L 2,96.079986 L 22.204074,75.875926 L 42.408158,55.671865 L 163.17031,87.675347 L 283.93249,119.67882 L 339.1518,64.569475 C 377.85615,25.942215 395.70632,8.7904897 398.8355,7.2211495 C 401.71737,5.7758285 405.77566,4.8204267 410.28434,4.525862 C 419.1547,3.9463348 425.75568,6.5390314 431.62708,12.908736 C 437.08313,18.827845 438.85127,23.292794 438.82691,31.089953 C 438.7893,43.133211 439.47031,42.318501 377.46076,104.50395 L 321.56672,160.55652 L 345.71016,253.81214 C 358.98905,305.10272 372.74731,358.28843 376.28406,372.00258 L 382.71451,396.9374 L 362.62817,417.00581 C 347.70391,431.91672 342.32043,436.72684 341.68032,435.72254 z ",
					  fillColor: '#fff',
					  fillOpacity: 1,
					  anchor: new google.maps.Point(0, 450),
					  strokeWeight: 1.5,
					  strokeColor: '#ff970d',
					  scale: .05,
					  rotation: -45
					}

					function init_map() {
					  var geoPointCombinations = assembleGeoPoints();
					  var styledMapType = new google.maps.StyledMapType([
						  {
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#212121"
						      }
						    ]
						  },
						  {
						    "elementType": "labels.icon",
						    "stylers": [
						      {
						        "visibility": "off"
						      }
						    ]
						  },
						  {
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#757575"
						      }
						    ]
						  },
						  {
						    "elementType": "labels.text.stroke",
						    "stylers": [
						      {
						        "color": "#212121"
						      }
						    ]
						  },
						  {
						    "featureType": "administrative",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#757575"
						      }
						    ]
						  },
						  {
						    "featureType": "administrative.country",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#9e9e9e"
						      }
						    ]
						  },
						  {
						    "featureType": "administrative.land_parcel",
						    "stylers": [
						      {
						        "visibility": "off"
						      }
						    ]
						  },
						  {
						    "featureType": "administrative.locality",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#bdbdbd"
						      }
						    ]
						  },
						  {
						    "featureType": "poi",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#757575"
						      }
						    ]
						  },
						  {
						    "featureType": "poi.park",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#181818"
						      }
						    ]
						  },
						  {
						    "featureType": "poi.park",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#616161"
						      }
						    ]
						  },
						  {
						    "featureType": "poi.park",
						    "elementType": "labels.text.stroke",
						    "stylers": [
						      {
						        "color": "#1b1b1b"
						      }
						    ]
						  },
						  {
						    "featureType": "road",
						    "elementType": "geometry.fill",
						    "stylers": [
						      {
						        "color": "#2c2c2c"
						      }
						    ]
						  },
						  {
						    "featureType": "road",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#8a8a8a"
						      }
						    ]
						  },
						  {
						    "featureType": "road.arterial",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#373737"
						      }
						    ]
						  },
						  {
						    "featureType": "road.highway",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#3c3c3c"
						      }
						    ]
						  },
						  {
						    "featureType": "road.highway.controlled_access",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#4e4e4e"
						      }
						    ]
						  },
						  {
						    "featureType": "road.local",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#616161"
						      }
						    ]
						  },
						  {
						    "featureType": "transit",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#757575"
						      }
						    ]
						  },
						  {
						    "featureType": "water",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#000000"
						      }
						    ]
						  },
						  {
						    "featureType": "water",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#3d3d3d"
						      }
						    ]
						  }
						],{name: 'Dark'});

					  var myOptions = {
					    zoom: 15,
					    center: geoPointCombinations[0].P1.loc,
					    mapTypeId: google.maps.MapTypeId.ROADMAP,
					    mapTypeControlOptions: {
		            mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
		                    'styled_map']
		          }
					  };
					  var bounds = new google.maps.LatLngBounds();
					  for (var index = 0; index < geoPointCombinations.length; index++) {
					    geoDisc = !geoDisc;
					    var geoPointCombination = geoPointCombinations[index];
					    if (index == 0) {
					      map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
					      map.mapTypes.set('styled_map', styledMapType);
        				map.setMapTypeId('styled_map');
					    }
					    bounds.extend(geoPointCombination.P1.loc);
					    bounds.extend(geoPointCombination.P2.loc);
					    var markerP1 = plotMapMarker(geoPointCombination.P1);
					    var markerP2 = plotMapMarker(geoPointCombination.P2);
					    var FlightIcon = new google.maps.Polyline({
					      path: [geoPointCombination.P1.loc, geoPointCombination.P2.loc],
					      strokeOpacity: 1,
					      strokeWeight: 3,
					      strokeColor: '#ff970d',
					      fillColor: 'ff9001',
					      geodesic: geoDisc,
					      icons: [{
					        icon: flightSVGIcon,
					        strokeWeight: 2,
					        offset: '100%',
					        repeat: '100%',
					      }]
					    });


					    FlightIconLines.push(FlightIcon);
					    FlightIcon.setMap(map);
					    animateFlight();
					  }
					  map.fitBounds(bounds);
					}

					function plotMapMarker(geoPoint) {
					  var marker = new google.maps.Marker({
					    position: geoPoint.loc,
					    map: map,
					    label: geoPoint.lbl,
					    //icon: $('#hd_mapMarker').val(),
					    zIndex: Math.round(geoPoint.loc.lat() * -100000) << 5
					  });
					  return marker;
					}

					function assembleGeoPoints() {
					  var geoPoints = [];
					  for (var index = 0; index < arrayOfLocationPoints.length; index++) {
					    point = arrayOfLocationPoints[index];
					    label = locationAirports[index];
					    var latlngP1 = point.Item1.split('|');
					    var latlngP2 = point.Item2.split('|');
					    var labelP1 = label.Item1.split('|');
					    var labelP2 = label.Item2.split('|');
					    var geoPoint = {};
					    geoPoint.P1 = {};
					    geoPoint.P2 = {};
					    geoPoint.P1.loc = new google.maps.LatLng(latlngP1[0], latlngP1[1]);
					    geoPoint.P1.lbl = labelP1[0];
					    geoPoint.P2.loc = new google.maps.LatLng(latlngP2[0], latlngP2[1]);
					    geoPoint.P2.lbl = labelP2[0];
					    geoPoints.push(geoPoint);
					  }
					  return geoPoints;
					}

					function animateFlight() {
					  var count = 0;
					  offsetId = window.setInterval(function() {
					    count = (count + 1) % 2000;
					    for (var i = 0; i < FlightIconLines.length; i++) {
					      var icons = FlightIconLines[i].get('icons');
					      icons[0].offset = (count / 2) + '%';
					      FlightIconLines[i].set('icons', icons);
					    }
					  }, 200);
					}
					
					google.maps.event.addDomListener(window, 'load', init_map);

				</script>
			</div>
		</div>
	</body>
</html>