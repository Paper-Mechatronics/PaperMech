////////////////// INITIALIZATION ////////////////////////////
// Matter.js module aliases
var Engine = Matter.Engine,
    World = Matter.World,
    Body = Matter.Body,
    Bodies = Matter.Bodies,
    Common = Matter.Common,
    Constraint = Matter.Constraint,
    Composites = Matter.Composites,
    Composite = Matter.Composite,
    Events = Matter.Events,
    Render = Matter.Render,
    MouseConstraint = Matter.MouseConstraint,
    Vertices = Matter.Vertices,
    Query = Matter.Query,
    Mouse = Matter.Mouse;

// create a Matter.js engine
var engine = Engine.create(document.body, {
  render: {
    options: {
      height: 1200,
      width: window.innerWidth*0.75,
      wireframes: false,
      showAngleIndicator: true
    }
  }
});

// gravity init
engine.world.gravity.x = 0;
engine.world.gravity.y = 0;

///////////////////// VARIABLES //////////////////////////////////////

var mouseConstraint = MouseConstraint.create(engine);

var clicked = false;
var clickedComposite;
var counter = 0;
var rotationSpeed = 0.04;
var selectionMode = false;
var dragMode = true;
var constraintMode = false;
var constraintDeleteMode = false;
var selected;
var previousSelection;
var motor;
var constraintStart;
var constraintDestination;
var testConstraint;
var timeInterval = 3;

var xValues = [];
var yValues = [];
var steps = 40;
var centerX = 100;
var centerY = 100;
var radius = 75;
var verts2 = [];
var conversionFactor = (360/(2*Math.PI));
var gearGroup;
var toothHeight = 25;
var toothWidthDegree = 3;
var toothWidth = (toothWidthDegree/conversionFactor);
var offset = 0;
var motors = [];
var jointArray;

/////////////////////// Modal /////////////////////////////////////////
function overlay() {
    el = document.getElementById("overlay");
    el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
}
function overlay2() {
    el2 = document.getElementById("overlay2");
    el2.style.visibility = (el2.style.visibility == "visible") ? "hidden" : "visible";
}
function overlay3() {
    el3 = document.getElementById("overlay3");
    el3.style.visibility = (el3.style.visibility == "visible") ? "hidden" : "visible";
    displayConstraints();
}
////////////////////// GEAR GENERATION ///////////////////////////////
function drawGear(){
  verts2 = [];
  for (var i = 0; i < steps; i++) {
    xValues[i] = (centerX + radius * Math.cos(2 * Math.PI * i / steps));
    yValues[i] = (centerY + radius * Math.sin(2 * Math.PI * i / steps));
  }
  for (var i = 0; i < steps; i++) {
    verts2.push({ x: xValues[i], y: yValues[i]});
    if(i%2 == 0 && i<steps){
      verts2.push({x:(centerX + (radius+toothHeight) * Math.cos((2 * Math.PI * i / steps)+toothWidth)), y: (centerY + (radius+toothHeight) * Math.sin((2 * Math.PI * i / steps)+toothWidth))})
      verts2.push({x:(centerX + (radius+toothHeight) * Math.cos((2 * Math.PI * (i+1) / steps)-toothWidth)), y: (centerY + (radius+toothHeight) * Math.sin((2 * Math.PI * (i+1) / steps)-toothWidth))})
    }
  }
}
drawGear();
//////////////// COMPOSITES //////////////////////////////////////

var compositeArray = [];
var totalComposites = 0;
var constraintArray = [];
var totalConstraints = 0;
var jointComposites = [];
var totalJointComposites = 0;

function addGearComposite(){
  console.log(verts2.length)
  totalComposites++;
  totalConstraints++;
  compositeArray.push( 
  Composite.create({
        bodies:[Bodies.fromVertices(centerX, centerY, [verts2])],
        constraints:[],
        shape: "gear",
        radius: radius,
        toothWidthDegree: toothWidthDegree,
        toothHeight: toothHeight,
        numOfTeeth: steps
      })
  )
  constraintArray.push(
    Constraint.create({pointA: { x: centerX, y: centerY },
      bodyB: compositeArray[totalComposites-1].bodies[0], 
      stiffness: 1
    })
  )
  Composite.add(compositeArray[totalComposites-1], constraintArray[totalConstraints-1]);
  World.add(engine.world,[compositeArray[totalComposites-1]] );
  select(compositeArray[totalComposites-1].bodies[0]);
}
function addRectComposite(width, height){
  totalComposites++;
  totalConstraints++;
  compositeArray.push( 
  Composite.create({
        bodies:[Bodies.rectangle(centerX, centerY, width, height)],
        constraints:[],
        shape: "rect",
        width: width,
        height: height

      })
  )
  constraintArray.push(
    Constraint.create({pointA: { x: centerX+width/2, y: centerY },bodyB: compositeArray[totalComposites-1].bodies[0] ,pointB: { x: width/2, y: 0 }, stiffness: 1})
  )
  Composite.add(compositeArray[totalComposites-1], constraintArray[totalConstraints-1]);
  World.add(engine.world,[compositeArray[totalComposites-1]] );
  select(compositeArray[totalComposites-1].bodies[0]);
}
function removeComposite(){
  for(var i=0; i<compositeArray.length;i++){
    if(compositeArray[i].bodies[0] == selected){
      if(motor == compositeArray[i].bodies[0]){
        motor = null;
      }
      Composite.clear(compositeArray[i], true);
    }
  }
  //World.add(engine.world,[compositeArray[i]] );
}
function changeBody(){
  if(selected.label != "Rectangle Body"){
    for(var i=0; i<compositeArray.length;i++){
      if(compositeArray[i].bodies[0] == selected){
        if(motor == compositeArray[i].bodies[0]){
          motor = null;
        }
        Composite.remove(compositeArray[i], compositeArray[i].bodies[0]);
        var tmpConstraintXPoint = compositeArray[i].constraints[0].pointA.x;
        var tmpConstraintYPoint = compositeArray[i].constraints[0].pointA.y;
        Composite.remove(compositeArray[i], compositeArray[i].constraints[0]);
        verts2 = [];
        //console.log(verts2.length)
        drawGear();
        //console.log(verts2.length)
        Composite.add(compositeArray[i], Bodies.fromVertices(tmpConstraintXPoint, tmpConstraintYPoint, [verts2]))
        Composite.add(compositeArray[i], Constraint.create({pointA: { x: tmpConstraintXPoint, y: tmpConstraintYPoint },
            bodyB: compositeArray[i].bodies[0], 
            stiffness: 1
          })
        );
        select(compositeArray[i].bodies[0]);
      }
    }
  }
}

//////////////// CONSTRAINTS //////////////////////////////////////

// function displayConstraints(){
//   for(var i = 0;i<constraintArray.length;i++){
//     if(constraintArray[i].bodyB == selected || constraintArray[i].bodyA == selected){
//       document.getElementById("constraint1").innerHTML = constraintArray[i].label;
//       document.getElementById("constraint1Check").value = constraintArray[i].id;
//       //console.log("displayed!!!!!!");
//     }
//   }
// }
// function deleteConstraint(){
//   for(var i = 0;i<jointComposites.length;i++){
//     if(document.getElementById("constraint1Check").checked){
//       if(constraintArray[i].id == document.getElementById("constraint1Check").value){
//         console.log("working");
//         console.log(constraintArray[i].id)
//         console.log(document.getElementById("constraint1Check").value)
//       }
//     }
//   }
// }
function constraintStiffness(){
  for(var i = 0; i<compositeArray.length;i++){
    compositeArray[i].constraints[0].stiffness = 1;
    compositeArray[i].constraints[0].length = 0;
    //compositeArray[i].constraints[0].angularStiffness = 0.1;
  }
}
function deleteConstraint(){
  for(var i=0; i<jointComposites.length;i++){
    if((jointComposites[i].constraints[0].bodyA == constraintStart && jointComposites[i].constraints[0].bodyB == constraintDestination) || (jointComposites[i].constraints[0].bodyA == constraintDestination && jointComposites[i].constraints[0].bodyB == constraintStart)){
      Composite.clear(jointComposites[i], true);
    }
  }
  //World.add(engine.world,[compositeArray[i]] );
}
function createConstraint(){
  var startOffset;
  var destOffset;
  for(var i = 0; i<compositeArray.length;i++){
    if(constraintStart == compositeArray[i].bodies[0]){
      if(compositeArray[i].shape == "gear"){
        startOffset = compositeArray[i].radius *0.8;
      }
      else if(compositeArray[i].shape == "rect"){
        startOffset = compositeArray[i].width*-0.5;
      }
    }
    if(constraintDestination == compositeArray[i].bodies[0]){
      if(compositeArray[i].shape == "gear"){
        destOffset = compositeArray[i].radius *0.8;
      }
      else if(compositeArray[i].shape == "rect"){
        destOffset = compositeArray[i].width*-0.5;
      }
    }
  }
  overlay2();
  // var offset1 = document.getElementById("offset1").value;
  // var offset2 = document.getElementById("offset2").value;
  var cLength = document.getElementById("length").value;
  if(startOffset && destOffset){
    var constraintLength;
    if(cLength){
      constraintLength = cLength;
    }
    else{
      constraintLength = 250;
    }
    jointComposites.push(Composite.create({
        constraints: [Constraint.create({pointA: { x: startOffset*Math.cos(constraintStart.angle), y: startOffset*Math.sin(constraintStart.angle)  },
          bodyA: constraintStart ,
          bodyB: constraintDestination ,
          pointB: { x: destOffset*Math.cos(constraintDestination.angle), y: destOffset*Math.sin(constraintDestination.angle) }, 
          stiffness: 1,
          length: constraintLength
        })]
    }))
    totalJointComposites++;
    World.add(engine.world, jointComposites[totalJointComposites-1]);
  }
}

//////////////////////// ADD TO WORLD //////////////////////


World.add(engine.world, mouseConstraint);

////////////////// MODIFICATION FUNCTIONS ////////////////////////////
function createRect(){
  el = document.getElementById("overlay");
  el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
  var width = document.getElementById("widthInput").value;
  var height = document.getElementById("heightInput").value;
  if(width && height){
    addRectComposite(width, height);
  }
}

function changeNumOfTeeth(value){
  if(value){
    if(value % 2 != 0){
      value++;
    }
    steps = value;
    changeBody();
  }
}
function changeSpeed(value){
  for(var i = 0; i<compositeArray.length;i++){
    if(selected == compositeArray[i].bodies[0]){
      compositeArray[i].motorSpeed = parseInt(value)/1000;
    }
  }
}
function changeToothWidth(value){
  toothWidthDegree = parseInt(value)/100;
  toothWidth = (toothWidthDegree/conversionFactor);
  changeBody();
}
function changeToothHeight(value){
  toothHeight = parseInt(value);
  changeBody();
}
function changeRadius(value){
  radius = parseInt(value);
  changeBody();
}
// function changeScale(value){
//   Composite.scale(composite1,value/100,value/100,composite1.constraints[0].pointA);
// }
function selectingMode(){
  selectionMode = true;
  dragMode = false;
  constraintMode = false;
}
function draggingMode(){
  dragMode = true;
  selectionMode = false;
  constraintMode = false;
}
function constrainingMode(){
  constraintMode = true;
  selectionMode = false;
  dragMode = false;
}
function constrainingDeleteMode(){

  constraintDeleteMode = !constraintDeleteMode;
}
function removeFocus(){
  if (previousSelection){
    previousSelection.render.strokeStyle = "#000000"
    for(var i=0; i<previousSelection.parts.length;i++){
      previousSelection.parts[i].render.strokeStyle = "#000000";
    }
  }
}
function select(body){
  selected = body;
  console.log(body);
  selected.render.strokeStyle = "blue";
  for(var i=0; i<selected.parts.length;i++){
    selected.parts[i].render.strokeStyle = "blue";
  }
  if (selected != previousSelection){
    removeFocus();
    previousSelection = selected;
  }
  updateSliders(selected);
}
function updateSliders(body){
  for(var i = 0; i<compositeArray.length;i++){
    if(body == compositeArray[i].bodies[0]){
      document.getElementById("changeSpeed").value = compositeArray[i].motorSpeed*1000;
      document.getElementById("changeRotation").value = compositeArray[i].bodies[0].angle*(180/Math.PI);
      // document.getElementById("changeNumOfTeeth").value = compositeArray[i].numOfTeeth;
      // document.getElementById("changeToothHeight").value = compositeArray[i].toothHeight;
      // document.getElementById("changeToothWidth").value = compositeArray[i].toothWidthDegree*100;
      // document.getElementById("changeRadius").value = compositeArray[i].radius;
    }
  }
}
// function motorSet(){
//   for(var i=0;i<motors.length;i++){
//     if(selected == motors[i]){
//       motors[i] = selected;
//     }
//   }
// }
function addMotor(){
  for(var i = 0; i<compositeArray.length;i++){
    if(selected == compositeArray[i].bodies[0]){
      compositeArray[i].isMotor = true;
    }
  }
}
function removeMotor(){
  for(var i = 0; i<compositeArray.length;i++){
    if(selected == compositeArray[i].bodies[0]){
      compositeArray[i].isMotor = false;
      Body.setAngularVelocity(compositeArray[i].bodies[0],0);
    }
  }
}
function reverseMotor(){
  for(var i = 0; i<compositeArray.length;i++){
    if(selected == compositeArray[i].bodies[0]){
      compositeArray[i].motorDir = compositeArray[i].motorDir*-1;
    }
  }
}
function changeTimeInterval(value){
  timeInterval = value;
}
var rotationAngle = 0;
function rotateObject(value){
  for(var i = 0; i<compositeArray.length;i++){
    if(selected == compositeArray[i].bodies[0]){
      Body.setAngle(compositeArray[i].bodies[0],value*(Math.PI/180));
      //rotationAngle = value*(Math.PI/180);
    }
  }
}
///////////// Mouse Events ///////////////////////////////////

Events.on(mouseConstraint, 'startdrag', function(event) {
  //console.log(event.body);
  mouseConstraint.constraint.stiffness = 0.1;
  select(event.body);
  rotationAngle = selected.angle;
  var mousePosition = event.mouse.position;
  if (dragMode == true){
    //console.log('mousedown at ' + mousePosition.x + ' ' + mousePosition.y);
    //console.log('enddrag', event);
    Body.setPosition(event.body,mousePosition);
    for(var i=0; i<compositeArray.length;i++){
      if(Composite.get(compositeArray[i], event.body.id, "body")==event.body){
        clicked = true;
        clickedComposite = compositeArray[i];
        console.log(clickedComposite.label);
        //console.log(composite1.constraints[0].pointA.x);
        clickedComposite.constraints[0].pointA.x = mousePosition.x;
        clickedComposite.constraints[0].pointA.y = mousePosition.y;
        //console.log("it works");
      }
    }
  }
  else if (constraintMode == true){
    mouseConstraint.constraint.stiffness = 0;
    for(var i=0; i<compositeArray.length;i++){
      if(Composite.get(compositeArray[i], event.body.id, "body")==event.body){
        //console.log("it works");
        constraintStart = event.body;

      }
    }
  }
})
  Events.on(mouseConstraint, 'mousemove', function(event) {
    var mousePosition = event.mouse.position;
    if (dragMode == true){
      //console.log('mousedown at ' + mousePosition.x + ' ' + mousePosition.y);
      //console.log(Composite.get(composite1, event.body.id, "body"));
      if (clicked == true){
          clickedComposite.constraints[0].pointA.x = mousePosition.x;
          clickedComposite.constraints[0].pointA.y = mousePosition.y;
      }
    }
    else if(constraintMode == true){
      var compositeBodies = [];
      for(var i=0; i<compositeArray.length;i++){
        compositeBodies.push(compositeArray[i].bodies[0]);
      }
      constraintDestination = Query.point(compositeBodies, mousePosition)[0];
    }
  })
  Events.on(mouseConstraint, 'enddrag', function(event) {
    var mousePosition = event.mouse.position;
    if(dragMode == true){
      // console.log('mousedown at ' + mousePosition.x + ' ' + mousePosition.y);
      // console.log('enddrag', event);
      Body.setPosition(event.body,mousePosition);
      clicked = false;
    }
    else if(constraintMode == true){
      if(constraintDeleteMode){
        deleteConstraint();
      }
      else{
        if(constraintStart){
          if(constraintDestination){
            if(constraintDestination == constraintStart){
            }
            else{
              overlay2();
            }
          }
        }
      }
    }
  })




/////////////////// BOUNDARIES //////////////////////////////////

// add boundaries
// var offset = 5;
// World.add(engine.world, [
//   Bodies.rectangle(400, -offset, 800 + 2 * offset, 50, { isStatic: true }),
//   Bodies.rectangle(400, 600 + offset, 800 + 2 * offset, 50, { isStatic: true }),
//   Bodies.rectangle(800 + offset, 300, 50, 600 + 2 * offset, { isStatic: true }),
//   Bodies.rectangle(-offset, 300, 50, 600 + 2 * offset, { isStatic: true })
// ]);

///////////////// Animation /////////////////////////////////////

Events.on(engine, 'beforeUpdate', function(event) {
    //console.log(clickedComposite);
    counter += 1;
    // for(var i = 0; i<motors.length;i++){
    //   var rotationDirection = 1
    //   for(var j = 0; j<compositeArray.length;j++){
    //     if(motors[i] == compositeArray[j].bodies[0]){
    //       rotationDirection = compositeArray[j].motorDir;
    //     }
    //   }
    //   Body.setAngularVelocity(motors[i], rotationSpeed*rotationDirection);
    // }
    constraintStiffness();
    for(var i = 0; i<compositeArray.length;i++){

      if(compositeArray[i].isMotor == true){
        Body.setAngularVelocity(compositeArray[i].bodies[0], compositeArray[i].motorSpeed*compositeArray[i].motorDir);
      }
    }
    if (clicked == true){
      if(clickedComposite.shape == "rect"){
        Body.setAngle(clickedComposite.bodies[0], rotationAngle);
      }
    }
    // every 1.5 sec
    if (counter >= 60 * timeInterval) {
        //rotationSpeed = rotationSpeed *-1;
        // reset counter
        counter = 0;
        scaleFactor = 1;
    }
})

////////////////////// RUN /////////////////////////////

// run the engine
Engine.run(engine);