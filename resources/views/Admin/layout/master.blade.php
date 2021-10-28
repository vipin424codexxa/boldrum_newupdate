<!doctype html>
<html lang="en">
<head>
	<title>BoldRum</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist-custom.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>
<body>
{{View::make('Admin.layout.header')}}
   @yield('content') 
{{View::make('Admin.layout.footer')}}
<!-- Javascript -->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/scripts/klorofil-common.js')}}"></script>
<script>
$(function() {
var data, options;
// visits chart


new Chartist.Bar('#visits-chart', data, options);


// real-time pie chart
var sysLoad = $('#system-load').easyPieChart({
size: 130,
barColor: function(percent) {
return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
},
trackColor: 'rgba(245, 245, 245, 0.8)',
scaleColor: false,
lineWidth: 5,
lineCap: "square",
animate: 800
});

var updateInterval = 3000; // in milliseconds

setInterval(function() {
var randomVal;
randomVal = getRandomInt(0, 100);

sysLoad.data('easyPieChart').update(randomVal);
sysLoad.find('.percent').text(randomVal);
}, updateInterval);

function getRandomInt(min, max) {
return Math.floor(Math.random() * (max - min + 1)) + min;
}

});
</script>
</body>
</html>