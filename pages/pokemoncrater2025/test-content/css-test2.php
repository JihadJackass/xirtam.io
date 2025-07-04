<!DOCTYPE html>
<html>
<head>
<style type="text/css">
  /* initial state */
  #outerspace {
    position: relative;
    height: 400px;
    background: #0c0440 url(outerspace.jpg);
    color: #fff;
  }
  div.rocket {
    position: absolute;
    bottom: 10px;
    left: 20px;
    -webkit-transition: 3s ease-in;
    -moz-transition: 3s ease-in;
    -o-transition: 3s ease-in;
    transition: 3s ease-in;
  }
  div.rocket div {
    width: 92px;
    height: 215px;
    background: url(http://static.pokemon-vortex.com/images/pokemon/Clefairy.gif) no-repeat;
    -webkit-transition: 2s ease-in-out;
    -moz-transition: 2s ease-in-out;
    -o-transition: 2s ease-in-out;
    transition: 2s ease-in-out;
  }

  /* hover final state */
  #outerspace:hover div.rocket {
    -webkit-transform: translate(540px,-200px);
    -moz-transform: translate(540px,-200px);
    -o-transform: translate(540px,-200px);
    -ms-transform: translate(540px,-200px);
    transform: translate(540px,-200px);
  }
  #outerspace:hover div.rocket div {
    -webkit-transform: rotate(70deg);
    -moz-transform: rotate(70deg);
    -o-transform: rotate(70deg);
    -ms-transform: rotate(70deg);
    transform: rotate(70deg);
  }
  /* WebKit and Opera browsers */
  @-webkit-keyframes spinner {
    from { -webkit-transform: rotateY(0deg);    }
    to   { -webkit-transform: rotateY(-360deg); }
  }

  /* all other browsers */
  @keyframes spinner {
    from {
      -moz-transform: rotateY(0deg);
      -ms-transform: rotateY(0deg);
      transform: rotateY(0deg);
    }
    to {
      -moz-transform: rotateY(-360deg);
      -ms-transform: rotateY(-360deg);
      transform: rotateY(-360deg);
    }
  }

  #stage {
    margin: 1em auto;
    -webkit-perspective: 1200px;
    -moz-perspective: 1200px;
    -ms-perspective: 1200px;
    perspective: 1200px;
  }
  #spinner {
    -webkit-animation-name: spinner;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-duration: 6s;

    animation-name: spinner;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-duration: 6s;

    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -ms-transform-style: preserve-3d;
    transform-style: preserve-3d;
  }

  #spinner:hover {
    -webkit-animation-play-state: paused;
    animation-play-state: paused;
  }
  @-webkit-keyframes spincube {
    from,to  { -webkit-transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg); }
    16%      { -webkit-transform: rotateY(-90deg);                           }
    33%      { -webkit-transform: rotateY(-90deg) rotateZ(90deg);            }
    50%      { -webkit-transform: rotateY(-180deg) rotateZ(90deg);           }
    66%      { -webkit-transform: rotateY(-270deg) rotateX(90deg);           }
    83%      { -webkit-transform: rotateX(90deg);                            }
  }

  @keyframes spincube {
    from,to {
      -moz-transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);
      -ms-transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);
      transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);
    }
    16% {
      -moz-transform: rotateY(-90deg);
      -ms-transform: rotateY(-90deg);
      transform: rotateY(-90deg);
    }
    33% {
      -moz-transform: rotateY(-90deg) rotateZ(90deg);
      -ms-transform: rotateY(-90deg) rotateZ(90deg);
      transform: rotateY(-90deg) rotateZ(90deg);
    }
    50% {
      -moz-transform: rotateY(-180deg) rotateZ(90deg);
      -ms-transform: rotateY(-180deg) rotateZ(90deg);
      transform: rotateY(-180deg) rotateZ(90deg);
    }
    66% {
      -moz-transform: rotateY(-270deg) rotateX(90deg);
      -ms-transform: rotateY(-270deg) rotateX(90deg);
      transform: rotateY(-270deg) rotateX(90deg);
    }
    83% {
      -moz-transform: rotateX(90deg);
      -ms-transform: rotateX(90deg);
      transform: rotateX(90deg);
    }
  }

  .cubespinner {
    -webkit-animation-name: spincube;
    -webkit-animation-timing-function: ease-in-out;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-duration: 12s;

    animation-name: spincube;
    animation-timing-function: ease-in-out;
    animation-iteration-count: infinite;
    animation-duration: 12s;

    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -ms-transform-style: preserve-3d;
    transform-style: preserve-3d;

    -webkit-transform-origin: 60px 60px 0;
    -moz-transform-origin: 60px 60px 0;
    -ms-transform-origin: 60px 60px 0;
    transform-origin: 60px 60px 0;
  }

  .cubespinner div {
    position: absolute;
    width: 120px;
    height: 120px;
    border: 1px solid #ccc;
    background: rgba(255,255,255,0.8);
    box-shadow: inset 0 0 20px rgba(0,0,0,0.2);
    line-height: 120px;
    text-align: center;
    font-size: 100px;
  }

  .cubespinner .face1 {
    -webkit-transform: translateZ(60px);
    -moz-transform: translateZ(60px);
    -ms-transform: translateZ(60px);
    transform: translateZ(60px);
  }
  .cubespinner .face2 {
    -webkit-transform: rotateY(90deg) translateZ(60px);
    -moz-transform: rotateY(90deg) translateZ(60px);
    -ms-transform: rotateY(90deg) translateZ(60px);
    transform: rotateY(90deg) translateZ(60px);
  }
  .cubespinner .face3 {
    -webkit-transform: rotateY(90deg) rotateX(90deg) translateZ(60px);
    -moz-transform: rotateY(90deg) rotateX(90deg) translateZ(60px);
    -ms-transform: rotateY(90deg) rotateX(90deg) translateZ(60px);
    transform: rotateY(90deg) rotateX(90deg) translateZ(60px);
  }
  .cubespinner .face4 {
    -webkit-transform: rotateY(180deg) rotateZ(90deg) translateZ(60px);
    -moz-transform: rotateY(180deg) rotateZ(90deg) translateZ(60px);
    -ms-transform: rotateY(180deg) rotateZ(90deg) translateZ(60px);
    transform: rotateY(180deg) rotateZ(90deg) translateZ(60px);
  }
  .cubespinner .face5 {
    -webkit-transform: rotateY(-90deg) rotateZ(90deg) translateZ(60px);
    -moz-transform: rotateY(-90deg) rotateZ(90deg) translateZ(60px);
    -ms-transform: rotateY(-90deg) rotateZ(90deg) translateZ(60px);
    transform: rotateY(-90deg) rotateZ(90deg) translateZ(60px);
  }
  .cubespinner .face6 {
    -webkit-transform: rotateX(-90deg) translateZ(60px);
    -moz-transform: rotateX(-90deg) translateZ(60px);
    -ms-transform: rotateX(-90deg) translateZ(60px);
    transform: rotateX(-90deg) translateZ(60px);
  }
</style>
<style>
 {
	margin: 0;
	padding: 0;
}

html {
	background-color: #222;
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAAGklEQVQIW2NkYGD4D8SMQAwGcAY2AbBKDBUAVuYCBQPd34sAAAAASUVORK5CYII=);
	background-repeat: repeat;
}

body {
	background: transparent!important;
}

/** 
  * Element which wraps all of the other .meny parts 
  */
.meny-wrapper {
	-webkit-perspective: 800px;
	   -moz-perspective: 800px;
	    -ms-perspective: 800px;
	     -o-perspective: 800px;
	        perspective: 800px;

	-webkit-perspective-origin: 0% 50%;
	   -moz-perspective-origin: 0% 50%;
	    -ms-perspective-origin: 0% 50%;
	     -o-perspective-origin: 0% 50%;
	        perspective-origin: 0% 50%;
}

.meny,
.meny-contents {
	-webkit-box-sizing: border-box;
	   -moz-box-sizing: border-box;
	        box-sizing: border-box;

	-webkit-transition: -webkit-transform .4s ease;
	   -moz-transition: -moz-transform .4s ease;
	    -ms-transition: -ms-transform .4s ease;
	     -o-transition: -o-transform .4s ease;
	        transition: transform .4s ease;

	-webkit-transform-origin: 0% 50%;
	   -moz-transform-origin: 0% 50%;
	    -ms-transform-origin: 0% 50%;
	     -o-transform-origin: 0% 50%;
	        transform-origin: 0% 50%;
}

/** 
 * The menu element which expands out from the left.
 */
.meny {
	display: none;
	position: fixed;
	height: 100%;
	width: 300px;
	top: 0;
	left: 0;
	z-index: 2;
	margin: 0px;
	padding: 20px;

	-webkit-transform: rotateY( -30deg ) translateX( -100% );
	   -moz-transform: rotateY( -30deg ) translateX( -100% );
	    -ms-transform: rotateY( -30deg ) translateX( -100% );
	     -o-transform: rotateY( -30deg ) translateX( -100% );
	        transform: rotateY( -30deg ) translateX( -100% );
}
	.meny-ready .meny {
		display: block!important;
	}
	.meny-active .meny {
		-webkit-transform: rotateY(0deg);
		   -moz-transform: rotateY(0deg);
		    -ms-transform: rotateY(0deg);
		     -o-transform: rotateY(0deg);
		        transform: rotateY(0deg);
	}

/** 
 * Page contents which gets pushed aside while meny is active.
 */
.meny-contents {
	width: 100%;
	height: 100%;
	overflow-y: auto;
}
	.meny-active .meny-contents {
		-webkit-transform: translateX( 300px ) rotateY( 15deg );
		   -moz-transform: translateX( 300px ) rotateY( 15deg );
		    -ms-transform: translateX( 300px ) rotateY( 15deg );
		     -o-transform: translateX( 300px ) rotateY( 15deg );
		        transform: translateX( 300px ) rotateY( 15deg );
	}

/**
 * A shadow-like element placed on top of the contents while 
 * meny is active.
 */
.meny-contents .cover {
	display: none;
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	visibility: hidden;
	z-index: 1000;
	opacity: 0;

	background: -moz-linear-gradient(left,  rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.65) 100%);
	background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(0,0,0,0.15)), color-stop(100%,rgba(0,0,0,0.65)));
	background: -webkit-linear-gradient(left,  rgba(0,0,0,0.15) 0%,rgba(0,0,0,0.65) 100%);
	background: -o-linear-gradient(left,  rgba(0,0,0,0.15) 0%,rgba(0,0,0,0.65) 100%);
	background: -ms-linear-gradient(left,  rgba(0,0,0,0.15) 0%,rgba(0,0,0,0.65) 100%);
	background: linear-gradient(to right,  rgba(0,0,0,0.15) 0%,rgba(0,0,0,0.65) 100%);

	-webkit-transition: all .4s ease;
	   -moz-transition: all .4s ease;
	    -ms-transition: all .4s ease;
	     -o-transition: all .4s ease;
	        transition: all .4s ease;
}
	.meny-ready .meny-contents .cover {
		display: block;
	}
	.meny-active .meny-contents .cover {
		visibility: visible;
		opacity: 1;
	}

/**
 * Graphic that highlights menu availability while inactive.
 */
.meny-arrow {
	position: absolute;
	top: 45%;
	left: 0px;
	z-index: 1;
	font-family: sans-serif;
	font-size: 12px;
	opacity: 0;

	-webkit-transform: rotate( 90deg );
	   -moz-transform: rotate( 90deg );
	    -ms-transform: rotate( 90deg );
	     -o-transform: rotate( 90deg );
	        transform: rotate( 90deg );

	-webkit-transform-origin: 0px 0px;
	   -moz-transform-origin: 0px 0px;
	    -ms-transform-origin: 0px 0px;
	     -o-transform-origin: 0px 0px;
	        transform-origin: 0px 0px;

	-webkit-transition: all 0.8s cubic-bezier(0.680, -0.550, 0.265, 1.550); 
	   -moz-transition: all 0.8s cubic-bezier(0.680, -0.550, 0.265, 1.550); 
	    -ms-transition: all 0.8s cubic-bezier(0.680, -0.550, 0.265, 1.550); 
	     -o-transition: all 0.8s cubic-bezier(0.680, -0.550, 0.265, 1.550); 
	        transition: all 0.8s cubic-bezier(0.680, -0.550, 0.265, 1.550);
}
	.meny-arrow span {
		position: relative;
		top: 2px;
	}
	.meny-ready .meny-arrow {
		left: 18px;
		opacity: 0.7;
	}
	.meny-active .meny-arrow {
		left: -40px;
		opacity: 0;
	}


/**
 * Fallback for browsers that don't support transforms.
 */

.meny-no-transform .meny,
.meny-no-transform .meny-contents {
	-webkit-transition: left .4s ease;
	   -moz-transition: left .4s ease;
	    -ms-transition: left .4s ease;
	     -o-transition: left .4s ease;
	        transition: left .4s ease;
}

.meny-no-transform .meny {
	left: -300px;
}
	.meny-no-transform.meny-active .meny {
		left: 0px;
	}

.meny-no-transform .meny-contents {
	position: absolute;
}
	.meny-no-transform.meny-active .meny-contents {
		left: 300px;
	}


/**
 * Styles that are more or less specific to the demo page:
 */

.meny {
	background: #333;
	color: #eee;
	font-family: 'Lato', 'Molengo', sans-serif;
}
	.meny h2 {
		font-size: 24px;
	}
	.meny a {
		color: #c2575b;
		text-decoration: none;

		-webkit-transition: 0.15s color ease;
		   -moz-transition: 0.15s color ease;
		    -ms-transition: 0.15s color ease;
		     -o-transition: 0.15s color ease;
		        transition: 0.15s color ease;
	}
		.meny a:hover {
			color: #f76f76;
		}
	.meny ul {
		margin-top: 10px;
	}
		.meny ul li {
			list-style: none;
			font-size: 20px;
			padding: 3px 10px;
		}
			.meny ul li:before {
				content: '-';
				margin-right: 5px;
				color: rgba( 255, 255, 255, 0.2 );
			}


</style>
</head>
<body>

<div id="outerspace">
<div class="rocket">
<div><!-- rocket --></div>
Clefaiiiiiiiiiiiiiiii....
</div>
</div>

<div id="stage" style="background: rgba(0,0,0,0.3);">
<p id="spinner" style="background: rgba(0,0,0,0.5); text-align: center; color: #fff;">Clefairy!</p>
</div>

<div class="stage" style="width: 120px; height: 120px; align:center;">
<div class="cubespinner">
<div class="face1"><img src="http://static.pokemon-vortex.com/images/pokemon/Charmander.gif"><br />Normal</div>
<div class="face2"><img src="http://static.pokemon-vortex.com/images/pokemon/Shadow Charmander.gif"><br />Shadow</div>
<div class="face3"><img src="http://static.pokemon-vortex.com/images/pokemon/Dark Charmander.gif"><br />Dark</div>
<div class="face4"><img src="http://static.pokemon-vortex.com/images/pokemon/Mystic Charmander.gif"><br />Mystic</div>
<div class="face5"><img src="http://static.pokemon-vortex.com/images/pokemon/Metallic Charmander.gif"><br />Metallic</div>
<div class="face6"><img src="http://static.pokemon-vortex.com/images/pokemon/Shiny Charmander.gif"><br />Shiny</div>
</div>
</div>





<body data-twttr-rendered="true" class=" meny-wrapper">

		<div class="main-container meny-contents">

		<canvas width="956" height="478"></canvas>

		<div class="cover"></div></div>
<script>
		(function() {

				var canvas = document.querySelector( 'canvas' ),
					context = canvas.getContext( '2d' ),

					width = window.innerWidth * 0.7,
					height = window.innerHeight * 0.7,

					radius = Math.min( width, height ) * 0.5,

					// Number of layers
					quality = 180,

					// Layer instances
					layers = [],

					// Width/height of layers
					layerSize = radius * 0.25,

					// Layers that overlap to create the infinity illusion
					layerOverlap = Math.round( quality * 0.1 );

				function initialize() {

					for( var i = 0; i < quality; i++ ) {
						layers.push({
							x: width/2 + Math.sin( i / quality * 2 * Math.PI ) * ( radius - layerSize ),
							y: height/2 + Math.cos( i / quality * 2 * Math.PI ) * ( radius - layerSize ),
							r: ( i / quality ) * Math.PI
						});
					}

					resize();
					update();

				}

				function resize() {

					canvas.width = width;
					canvas.height = height;

				}

				function update() {

					requestAnimationFrame( update );

					step();
					clear();
					paint();

				}

				// Takes a step in the simulation
				function step () {

					for( var i = 0, len = layers.length; i < len; i++ ) {

						layers[i].r += 0.01;

					}

				}

				// Clears the painting
				function clear() {

					context.clearRect( 0, 0, canvas.width, canvas.height );

				}

				// Paints the current state
				function paint() {

					// Number of layers in total
					var layersLength = layers.length;

					// Draw the overlap layers
					for( var i = layersLength - layerOverlap, len = layersLength; i < len; i++ ) {

						context.save();
						context.globalCompositeOperation = 'destination-over';
						paintLayer( layers[i] );
						context.restore();

					}

					// Cut out the overflow layers using the first layer as a mask
					context.save();
					context.globalCompositeOperation = 'destination-in';
					paintLayer( layers[0], true );
					context.restore();

					// // Draw the normal layers underneath the overlap
					for( var i = 0, len = layersLength; i < len; i++ ) {

						context.save();
						context.globalCompositeOperation = 'destination-over';
						paintLayer( layers[i] );
						context.restore();

					}

				}

				// Pains one layer
				function paintLayer( layer, mask ) {
					size = layerSize + ( mask ? 10 : 0 );
					size2 = size / 2;

					context.translate( layer.x, layer.y );
					context.rotate( layer.r );

					// No stroke if this is a mask
					if( !mask ) {
						context.strokeStyle = '#000';
						context.lineWidth = 1;
						context.strokeRect( -size2, -size2, size, size );
					}

					context.fillStyle = '#fff';
					context.fillRect( -size2, -size2, size, size );

				}

				/**
				 * rAF polyfill.
				 */
				(function() {
					var lastTime = 0;
					var vendors = ['ms', 'moz', 'webkit', 'o'];
					for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
						window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
						window.cancelAnimationFrame = 
						  window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
					}

					if (!window.requestAnimationFrame)
						window.requestAnimationFrame = function(callback, element) {
							var currTime = new Date().getTime();
							var timeToCall = Math.max(0, 16 - (currTime - lastTime));
							var id = window.setTimeout(function() { callback(currTime + timeToCall); }, 
							  timeToCall);
							lastTime = currTime + timeToCall;
							return id;
						};

					if (!window.cancelAnimationFrame)
						window.cancelAnimationFrame = function(id) {
							clearTimeout(id);
						};
				}());

				initialize();

			})();


		</script>
<br /><br /><br />



	
</body>
</html></html>