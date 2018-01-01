<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<iframe src="https://www.cleartrip.com/flights/international/results?from=SIN&to=DPS&depart_date=27/04/2017&adults=1&childs=0&infants=0&class=Economy&airline=&carrier=&intl=y&sd=1490978924381&page=loaded" frameborder="0"></iframe>
	<script src="http://b2b.flygoldfinch.dev/common/dashboard/vendors/jquery/dist/jquery.min.js"></script>
	<script>
		$(window).ready(function () {
			// $.ajax({
			// 	type:"get",
			// 	dataType: 'jsonp',
			// 	url: "https://www.cleartrip.com/flights/international/results?from=SIN&to=DPS&depart_date=27/04/2017&adults=1&childs=0&infants=0&class=Economy&airline=&carrier=&intl=y&sd=1490978924381&page=loaded",
			// 	success: function() {
			// 	}
			// });
			setTimeout(function () {    
				getClearTrip();
		  }, 10000);
		});

	</script>

	<script>
		function getClearTrip() {
			$.ajax({
				type:"get",
				url: "https://www.cleartrip.com/flights/results/intlairjson?from=SIN&to=DPS&depart_date=27%2F04%2F2017&adults=1&childs=0&infants=0&class=Economy&airline=&carrier=&intl=y&sd=1490978924381&page=loaded&search_ver=V2&cc=1&rhc=1&timeout=3000&type=json&ver=V2"
			});
		}
	</script>
</body>
</html>