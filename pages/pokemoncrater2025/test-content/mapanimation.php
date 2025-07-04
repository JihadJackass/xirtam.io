<html>
<head>
</head>
<body>
<canvas id="cloud_demo_canvas" width="400" height="400"></canvas>
<script lang="javascript">
var canvas;
var ctx;
 
var background;
var width = 300;
var height = 200;
 
var cloud;
var cloud_x;
 
function init() {
	canvas = document.getElementById("cloud_demo_canvas");
	width = canvas.width;
	height = canvas.height;
	ctx = canvas.getContext("2d");
 
	// init background 
	background = new Image();
	background.src = 'http://static.pokemon-vortex.com/images/maps/map1.png';
 
	// init cloud
	cloud = new Image();
	cloud.src = 'cloud.png';
	cloud.onload = function(){
		cloud_x = -cloud.width;
	};
 
	return setInterval(main_loop, 10);
}
 
function update(){
	cloud_x += 0.3;
	if (cloud_x > width ) {
		cloud_x = -cloud.width;
	}
}
 
function draw() {
	ctx.drawImage(background,0,0);
	ctx.drawImage(cloud, cloud_x, 0);
}
 
function main_loop() {
	draw();
	update();
}
 
init();</script>
</body>
</html>
