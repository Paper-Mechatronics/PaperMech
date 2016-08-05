<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Paper Mechatronics - Create</title>
    
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
    <style> 
    body {
        padding: 0; 
        margin: 0;
    } 
    .navbar-default{
    background-color: #985ec5 !important;
    background-image: none;
    height: 57px;
    }
    .navbar-brand{
        position: absolute;
        margin-top: 0;

    }
    #logo{
        margin: 0;
        position: absolute;
        margin-top: -10px;
        height: 45px;
    }
    #container {
        height: auto;
        width: 60%;
        margin: 0 auto;
        margin-top: 100px;
        text-align: justify;
        -ms-text-justify: distribute-all-lines;
        text-justify: distribute-all-lines;

        /* just for demo */
        min-width: 612px;
    }

    .box {
        width: 175px;
        height: 175px;
        border-radius: 7px;
        border: 4px solid black;
        vertical-align: top;
        display: inline-block;
        *display: inline;
        zoom: 1;
        margin-bottom: 50px;
        padding: 0;
        text-align: center;
    }
    .box img{
        width: 100%;
        height: 100%;
        border-radius: 7px;
    }
    .box div{
        position: absolute;
        width: inherit;
        border-radius: 7px;
    }
    .stretch {
        width: 100%;
        display: inline-block;
        font-size: 0;
        line-height: 0;
    }
    #design-title{
        margin: 0 auto;
        text-align: center;
    }
    #design-title > ul{
        text-align: center;
    }
    .dropdown{
        display: inline-block;
    }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="http://www.papermech.net/">
            <img id = "logo" alt="Brand" src="img/papermech.gif">
          </a>
        </div>
      </div>
    </nav>
    <div id = "design-title">
        <h1>Design Your Own Machine</h1>
         <select id = "dropdown" name="cars" onchange="changeMods()">
            <option value="motion">Motion</option>
            <option value="mechanism">Mechanism</option>
          </select>
    </div>
    <div id="container">
        <a href = "#"><div class="box"><div id = "one">Open-Close</div><img src="http://placehold.it/175x175"></div></a>
        <a href = "#"><div class="box"><div id = "two">Up-Down</div><img src="http://placehold.it/175x175"></div></a>
        <a href = "flapping.php"><div class="box"><div id = "three">Flapping</div><img src="http://placehold.it/175x175"></div></a>
        <span class="stretch"></span>
        <br>
        <a href = "#"><div class="box"><div id = "four">Rotate</div><img src="http://placehold.it/175x175"></div></a>
        <a href = "#"><div class="box"><div id = "five">Zigzag</div><img src="http://placehold.it/175x175"></div></a>
        <a href = "custom.php"><div class="box"><div id = "custom">Custom</div><img src="http://placehold.it/175x175"></div></a>
        <span class="stretch"></span>
    </div>
    <script type="text/javascript">
        function changeMods(){
            if(document.getElementById("dropdown").value == "mechanism"){
                document.getElementById('one').value = "Rack & Pinion";
                document.getElementById('two').value = "Crank";
                document.getElementById('three').value = "Cam";
                document.getElementById('four').value = "Spur Gears";
                document.getElementById('five').value = "Planetary Gears";
            }
            else{
                document.getElementById('one').value = "Open-Close";
                document.getElementById('two').value = "Up-Down";
                document.getElementById('three').value = "Flapping";
                document.getElementById('four').value = "Rotate";
                document.getElementById('five').value = "Zigzag";
            }
        }
    </script>
  </body>
</html>
