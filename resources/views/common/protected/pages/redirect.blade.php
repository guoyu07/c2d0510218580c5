<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="{{ asset('css/icon.css') }}">
	<style type="text/css">

		#logo{
			top: 32vh;
			left: 42.5%;
			position: fixed;
			font-size: 210px !important;
		}

		#fgfpreloader {
			top: 27vh;
	    left: 40%;
			font-size: 5px;
			border-radius: 50%;
			width: 250px;
	    height: 250px;

			position: fixed;
			text-indent: -9999em;
			border-top: 1.1em solid rgba(255,255,128, 0.2);
			border-right: 1.1em solid rgba(255,255,128, 0.2);
			border-bottom: 1.1em solid rgba(255,255,128, 0.2);
			border-left: 1.1em solid #FFD700;
			z-index: 100;
			-webkit-transform: translateZ(0);
			-ms-transform: translateZ(0);
			transform: translateZ(0);
			-webkit-animation: load8 1.1s infinite linear;
			animation: load8 1.1s infinite linear;
		}

		@-webkit-keyframes load8 {
			0% {
				-webkit-transform: rotate(0deg);
				transform: rotate(0deg);
			}
			100% {
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			}
		}
		@keyframes load8 {
			0% {
				-webkit-transform: rotate(0deg);
				transform: rotate(0deg);
			}
			100% {
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			}
		}
	</style>
</head>
<body onload="window.location='{{ $url }}'" >
	<div id="fgfpreloader" class="fixed-top"></div>
	<i id="logo" class="s-icon-fgf font-big fixed-top"></i>
</body>
</html>