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
    <!--<script src="js/phaser.min.js" type="text/javascript"></script>-->
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
    #selected{
        float: right;
        display: inline-block;
        position: absolute;
        margin-top: 0px;
    }

    #overlay, #overlay2, #overlay3 {
         visibility: hidden;
         position: absolute;
         left: 0px;
         top: 0px;
         width:100%;
         height:100%;
         text-align:center;
         z-index: 1000;
    }
    #overlay div, #overlay2 div, #overlay3 div {
         width:300px;
         margin: 100px auto;
         background-color: #fff;
         border:1px solid #000;
         padding:15px;
         text-align:center;
    }
    </style>
  </head>
  <body>
    <br>
    <label>Motor Speed: </label>
    <input type="range" id="changeSpeed" value="40" min="0" max="100" oninput="changeSpeed(this.value)">
    <br>
    <label>Number of Teeth: </label>
    <input type="range" id="changeNumOfTeeth" value="40" min="10" max="55" oninput="changeNumOfTeeth(this.value)">
    <br>
    <label>Tooth Height: </label>
    <input type="range" id="changeToothHeight" value="25" min="0" max="30" oninput="changeToothHeight(this.value)">
    <br>
    <label>Tooth Width: </label>
    <input type="range" id="changeToothWidth" value="300" min="0" max="800" oninput="changeToothWidth(this.value)">
    <br>
    <label>Gear Radius: </label>
    <input type="range" id="changeRadius" value="75" min="20" max="100" oninput="changeRadius(this.value)">
    <br>
    <label>Time Interval: </label>
    <input type="range" id="changeTimeInterval" value="3" min="1" max="30" oninput="changeTimeInterval(this.value)">
    <br>
    <label>Rotate Object: </label>
    <input type="range" id="changeRotation" value="0" min="0" max="360" oninput="rotateObject(this.value)">
    <br>
    <br>
    <button type="button" id="setRotation" onclick="setObjectRotation()">Set Rotation</button>
    <br>
    <button type="button" id="resetRotation" onclick="resetRotation()">Reset Rotation</button>
    <br>
    <button type="button" id="lockRotation" onclick="lockRotation()">Lock Rotation</button>
    <br>
    <button type="button" id="unlockRotation" onclick="unlockRotation()">Unlock Rotation</button>
    <br>
    <button type="button" id="selection" onclick="selectingMode()">Selection Mode</button> 
    <br>
    <button type="button" id="multiSelection" onclick="multiSelectingMode()">Multi-Select Mode</button> 
    <br>
    <button type="button" id="drag" onclick="draggingMode()">Drag Mode</button> 
    <br>
    <button type="button" id="constrain" onclick="constrainingMode()">Add Constraint</button> 
    <br>
    <button type="button" id="deleteConstraint" onclick="constrainingDeleteMode()">Remove Constraint</button> 
    <br>
    <!--<button type="button" id="motorSet" onclick="motorSet()">Set Motor</button> 
    <br>-->
    <button type="button" id="addMotor" onclick="addMotor()">Add Motor</button>
    <br>
    <button type="button" id="removeMotor" onclick="removeMotor()">Remove Motor</button>
    <br>
    <button type="button" id="reverseMotor" onclick="reverseMotor()">Reverse Motor</button>
    <br>
    <button type="button" id="createGear" onclick="addGearComposite()">Add Gear</button>
    <br>
    <button type="button" id="deleteGear" onclick="removeComposite()">Remove Object</button> 
    <br>
    <button type="button" id="modal" onclick="overlay()">Add Rectangle</button>
    <br>
    <!--<button type="button" id="rotate" onclick="overlay3()">Set Angle</button>-->
    <div id="overlay">
         <div>
            <label>Width:</label>
            <br>
            <input id= "widthInput" class="w3-input" type="text">
            <br>
            <br>
            <label>Height:</label>
            <br>
            <input id = "heightInput" class="w3-input" type="text">
            <br>
            <br>
            <button type="button" id="cancel" onclick="overlay()">Cancel</button> 
            <button type="button" id="createRect" onclick="createRect()">Create</button>
         </div>
    </div>
    <div id="overlay2">
         <div>
            <!--<label>Offset Object 1</label>
            <br>
            <input id= "offset1" class="w3-input" type="text">
            <br>
            <br>
            <label>Offset Object 2</label>
            <br>
            <input id = "offset2" class="w3-input" type="text">
            <br>
            <br>-->
            <label>Length</label>
            <br>
            <input id = "length" class="w3-input" type="text">
            <br>
            <br>
            <button type="button" id="cancel" onclick="overlay2()">Cancel</button> 
            <button type="button" id="createRect" onclick="createConstraint()">Create</button>
         </div>
    </div>
    <div id="overlay3">
         <div>
            <h2>Rotate</h2>
            <br>
            <br>
            <label>Angle: </label>
            <br>
            <input id = "changeAngle" class="w3-input" type="text">
            <br>
            <br>
            <br>
            <button type="button" id="cancel" onclick="overlay3()">Cancel</button> 
            <button type="button" id="createRect" onclick="setObjectRotation()">Rotate</button>
         </div>
    </div>
    <script type="text/javascript">
    </script>
  </body>
</html>
