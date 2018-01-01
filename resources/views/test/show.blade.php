<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>	
	form {
	width: 300px;
	margin: 0 auto;
	text-align: center;
	padding-top: 50px;
}

.value-button {
	display: inline-block;
	border: 1px solid #ddd;
	margin: 0px;
	width: 40px;
	height: 20px;
	text-align: center;
	vertical-align: middle;
	padding: 11px 0;
	background: #eee;
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.value-button:hover {
	cursor: pointer;
}

form #decrease {
	margin-right: -4px;
	border-radius: 8px 0 0 8px;
}

form #increase {
	margin-left: -4px;
	border-radius: 0 8px 8px 0;
}

form #input-wrap {
	margin: 0px;
	padding: 0px;
}

input#number {
	text-align: center;
	border: none;
	border-top: 1px solid #ddd;
	border-bottom: 1px solid #ddd;
	margin: 0px;
	width: 40px;
	height: 40px;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
}
</style>
</head>
<body>

<form action="/test/code">
	<label><b>Rank Group</b>
    <select multiple name="workerRGroup[]">
      <option value="sAgent">Security Agent</option>
      <option value="supervisor">Supervisor</option>
      <option value="human">Human Resources</option>
      <option value="tech">Technical</option>
    </select>
  </label>
  <button type="submit">submit</button>
</form>
<button class="btn-decrease" field="#number">-</button>
<input type="number" id="number" data-max="4" data-min="1" value="2"/>
<button class="btn-increase" field="#number">+</button>
</body>
	<script src="http://b2b.flygoldfinch.dev/common/dashboard/vendors/jquery/dist/jquery.min.js"></script>
	<script>
		$(document).on('click', '.btn-decrease', function () {
			var elem = $(this).attr('field');
			var max = $(elem).attr('data-max');
			var min = $(elem).attr('data-min');
			var value = parseInt($(elem).val(), 10);
			value = isNaN(value) ? 0 : value;
			value < 1 ? value = 1 : '';
			value--;
			(value == min)
			? $(this).prop('disabled', true)
			: $('.btn-increase[field="'+elem+'"]').prop('disabled', false);
			$(elem).val(value);
		});

		$(document).on('click', '.btn-increase', function () {
			var elem = $(this).attr('field');
			var max = $(elem).attr('data-max');
			var min = $(elem).attr('data-min');
			var value = parseInt($(elem).val(), 10);
			value = isNaN(value) ? 0 : value;
			value++;
			
			(value == max )
			? $(this).prop('disabled', true) 
			: $('.btn-decrease[field="'+elem+'"]').prop('disabled', false);

			$(elem).val(value);
		});

		/*var browser = '';
		var browserVersion = 0;

		if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
				browser = 'Opera';
		} else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
				browser = 'MSIE';
		} else if (/Navigator[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
				browser = 'Netscape';
		} else if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
				browser = 'Chrome';
		} else if (/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
				browser = 'Safari';
				/Version[\/\s](\d+\.\d+)/.test(navigator.userAgent);
				browserVersion = new Number(RegExp.$1);
		} else if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
				browser = 'Firefox';
		}
		if(browserVersion === 0){
				browserVersion = parseFloat(new Number(RegExp.$1));
		}
		console.log(browser + "*" + browserVersion);*/
	</script>
</html>