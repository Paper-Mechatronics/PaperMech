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
    <title>Paper Mechatronics - Flapping</title>
    
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
    <link rel="shortcut icon" type="image/png" href="wp-content/uploads/2016/06/cropped-noun_221895_cc-32x32.png"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="js/decomp.js" type="text/javascript"></script>
    <script src="matterJS/build/matter.js" type="text/javascript"></script>
    <script src="matterJS/build/Examples.js" type="text/javascript"></script>
    <!--<script src="js/phaser.min.js" type="text/javascript"></script>-->
    <script src="js/flapping.js" type="text/javascript"></script>
    <!--<script src="js/p2.js"></script>
    <script src="js/p2.renderer.js"></script>-->
    <style> 
    body {
        padding: 0; 
        margin: 0;
        background-color: #4E4E4E;
        color: #fff;
    } 
    canvas {
        position: fixed;
    	display: inline-block;
    	float: right;
        right: 0;
        vertical-align: top;
        border-left: 2px solid black;
        

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
    #codeBlock{
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: #ccc;
        color: #000;
    }
    pre{
        background-color: #ccc;
    }
    button{
        border-radius: 3px;
    }
    input[type="range"]{
        width: 200px !important;
    }
    </style>
  </head>
  <body>
    <a href="#"><button class = "mode btn btn-primary" type="button" >Flapping Module</button></a>
    <br>
    <label>Motor Speed: </label>
    <input type="range" id="changeSpeed" value="40" min="0" max="100" oninput="changeSpeed(this.value)">
    <br>
    <label>Time Interval: </label>
    <input type="range" id="changeTimeInterval" value="3" min="1" max="30" oninput="changeTimeInterval(this.value)">
    <br>
    <!--<button type="button" id="rotate" onclick="overlay3()">Set Angle</button>-->
    <br>
    <div  id = "codeBlock">
        <pre>
        #include <Servo.h> 

        Servo myservo;

        void setup() 
        { 
          myservo.attach(9);
          myservo.write(90);  // set servo to mid-point
        } 

        void loop() {} 
        </pre> 
    <div>


    <script type="text/javascript">
    </script>
  </body>
</html>
