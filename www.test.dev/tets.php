<?php
include('wp-blog-header.php');

global $user_identity;
if($user_identity){
	echo $user_identity;
}
else{
	die('Sorry, you must be <a href="'. get_bloginfo('home') . '/wp-login.php?redirect_to=' . $_SERVER['PHP_SELF'] . '">logged in</a> to view this page.');
}
//echo do_shortcode( '[contact-form-7 id="1234" title="Contact form 1"]' );
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>turtle_flower3</title>
    <!--<script src="libraries/p5.js" type="text/javascript"></script>
    <script src="libraries/p5.dom.js" type="text/javascript"></script>
    <script src="libraries/p5.sound.js" type="text/javascript"></script>

    <script src="libraries/p5.svg.js" type="text/javascript"></script>
    <script src="libraries/p5.pdf.js" type="text/javascript"></script>-->
    <!--script language="javascript" type="text/javascript" src="../p5.js"></script-->
    <!-- uncomment lines below to include extra p5 libraries -->
  	<!--<script language="javascript" src="../addons/p5.dom.js"></script>-->
    <!--<script language="javascript" src="../addons/p5.sound.js"></script>-->
    <!--<script language="javascript" type="text/javascript" src="sketch.js"></script>-->
    <!-- ADD extra js files below here-->
    <!--<script language="javascript" type="text/javascript" src="modules/Intro.js"></script>
    <script language="javascript" type="text/javascript" src="modules/OpenClose.js"></script>
    <script language="javascript" type="text/javascript" src="modules/Bird.js"></script>
    <script language="javascript" type="text/javascript" src="modules/Walk.js"></script>
    <script language="javascript" type="text/javascript" src="modules/Planetary.js"></script>
	<script language="javascript" type="text/javascript" src="modules/turtle.js"></script>
    <script language="javascript" type="text/javascript" src="UI.js"></script>-->
    <!-- this line removes any default padding and style. you might only need one of these values set. -->
    <!--<script type="text/javascript" src = "js/phaser.min.js"></script>
    <script type="text/javascript" src = "js/phaserTest.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="js/decomp.js" type="text/javascript"></script>
    <script src="matterJS/build/matter.js" type="text/javascript"></script>
    <script src="matterJS/build/Examples.js" type="text/javascript"></script>
    <script src="js/phaser.min.js" type="text/javascript"></script>
    <script src="js/matterTest.js" type="text/javascript"></script>
    <!--<script src="js/p2.js"></script>
    <script src="js/p2.renderer.js"></script>-->
    <style> 
    body {
        padding: 0; 
        margin: 0;
    } 
    canvas {
    	display: inline-block;
    	float: right;
        vertical-align: top;
        

    } 
    #content{
    	position: absolute;
    	float: left;
    	width: 25%;
    	height: 100%;
    	display: inline-block;
    }
    #openClose{
        position:absolute;
        top:70%;
    }
    #flapping{
        position:absolute;
        top:73%;
    }
    .values{
        display: inline-block;
    }
    .p2-container{
    
    }
    #myCanvas{
    }
    </style>
  </head>
  <body>
    <canvas width="1200" height="800" id="myCanvas"></canvas>
    <input type="range" id="myRange" value="40" min="0" max="100" oninput="changeSpeed(this.value)">
    <input type="range" id="myRange" value="40" min="10" max="500" onchange="changeScale(this.value)">
  	<!-- <div id = "content">
	    <button id = "openClose" onClick = "openClosePage()">Opening and Closing</button>
	    <button id = "flapping"  onClick = "flappingPage()">Flapping</button>
	    
	    <p id = "sliderA" class = "values">Slider A Value: </p>
	    <br>
	    <p id = "sliderB" class = "values">Slider B Value: </p>
	    <br>
	    <p id = "sliderC" class = "values">Slider C Value: </p>
	    <br>
	    <p id = "sliderD" class = "values">Slider D Value: </p>
	    <br>
	    <p id = "sliderE" class = "values">Slider E Value: </p>
	    <br>
	    <p id = "sliderF" class = "values">Slider F Value: </p>
	    <br>
	    <input type="range" id="myRange" value="150" min="1" max="400" onchange="sliderDUpdate()" oninput="myFunction(this.value)">

		<p>Click the button to get the value of the slider control.</p>

		<button onclick="test()">Try it</button>

		<p><strong>Note:</strong> input elements with type="range" are not supported in IE 9 and earlier versions.</p>

		<p id="demo"></p>
	</div> -->

	<script>
	function myFunction(val) {
	    //var slider_A_Value = document.getElementById("myRange").value;
	    document.getElementById("demo").innerHTML = val;
	}
	// function sliderAUpdate(sliderAValue){
	// 	Bird1.setA(sliderAValue);
	// 	stdSliderValue.wings.A = sliderAValue;
	// }
	// function sliderCUpdate(sliderCValue){
	// 	Bird1.setC(sliderCValue);
	// 	stdSliderValue.wings.C = sliderCValue;
	// }
	</script>
    <script src="js/p2Test.js"></script>
  </body>
  <script type="text/javascript">
  </script>
</html>
