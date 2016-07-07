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
    Mouse = Matter.Mouse;

// create a Matter.js engine
var engine = Engine.create(document.body, {
  render: {
    options: {
      height: window.innerHeight,
      width: window.innerWidth,
      wireframes: false,
      showAngleIndicator: true
    }
  }
});

// gravity init
engine.world.gravity.x = 0;
engine.world.gravity.y = 3;

///////////////////// VARIABLES //////////////////////////////////////

var mouseConstraint = MouseConstraint.create(engine);

var clicked = false;
var clickedComposite;
var counter = 0;
var rotationSpeed = 0.04;

var xValues = [];
var yValues = [];
var steps = 40;
var centerX = 300;
var centerY = 300;
var radius = 75;
var verts2 = [];
var conversionFactor = (360/(2*Math.PI));
var gearGroup;
var toothHeight = 25;
var toothWidthDegree = 3;
var changeToothWidth = (toothWidthDegree/conversionFactor);

////////////////////// GEAR GENERATION ///////////////////////////////

for (var i = 0; i < steps; i++) {
  xValues[i] = (centerX + radius * Math.cos(2 * Math.PI * i / steps));
  yValues[i] = (centerY + radius * Math.sin(2 * Math.PI * i / steps));
}
for (var i = 0; i < steps; i++) {
  verts2.push({ x: xValues[i], y: yValues[i] });
  if(i%2 == 0 && i<steps){
    verts2.push({x:(centerX + (radius+toothHeight) * Math.cos((2 * Math.PI * i / steps)+changeToothWidth)), y: (centerY + (radius+toothHeight) * Math.sin((2 * Math.PI * i / steps)+changeToothWidth))})
    verts2.push({x:(centerX + (radius+toothHeight) * Math.cos((2 * Math.PI * (i+1) / steps)-changeToothWidth)), y: (centerY + (radius+toothHeight) * Math.sin((2 * Math.PI * (i+1) / steps)-changeToothWidth))})
  }
}
gearGroup = Bodies.fromVertices(centerX, centerY, [verts2]);

//////////////// COMPOSITES //////////////////////////////////////

var composite1 = Composite.create({
            bodies:[Bodies.fromVertices(centerX, centerY, [verts2])],
            constraints:[]
          })
var composite2 = Composite.create({
            bodies:[Bodies.fromVertices(250, 150, [verts2])],
            constraints:[]
          })

//////////////// CONSTRAINTS //////////////////////////////////////

var constraint1 = Constraint.create({pointA: { x: 300, y: 300 },bodyB: composite1.bodies[0]})
var jointConstraint1 = Constraint.create({pointA: { x: 300, y: 300 } ,BodyA: composite1.bodies[0] ,bodyB: composite2.bodies[0]})
var constraint2 = Constraint.create({pointA: { x: 250, y: 150 },bodyB: composite2.bodies[0]})
Composite.add(composite2, constraint2);
Composite.add(composite1, constraint1);
Composite.add(composite1, jointConstraint1);

var compositeArray = [composite1,composite2];

//////////////////////// ADD TO WORLD //////////////////////

World.add(engine.world,[composite1,composite2] );
World.add(engine.world, mouseConstraint);

////////////////// MODIFICATION FUNCTIONS ////////////////////////////

function changeSpeed(value){
  rotationSpeed = value/1000;
}
function changeScale(value){
  Composite.scale(composite1,value/100,value/100,composite1.constraints[0].pointA);
}

///////////// Mouse Events ///////////////////////////////////

Events.on(mouseConstraint, 'enddrag', function(event) {
  var mousePosition = event.mouse.position;
  console.log('mousedown at ' + mousePosition.x + ' ' + mousePosition.y);
  console.log('enddrag', event);
  Body.setPosition(event.body,mousePosition);
  clicked = false;
})


Events.on(mouseConstraint, 'startdrag', function(event) {
  var mousePosition = event.mouse.position;
  //console.log('mousedown at ' + mousePosition.x + ' ' + mousePosition.y);
  //console.log('enddrag', event);
  Body.setPosition(event.body,mousePosition);
  for(var i=0; i<compositeArray.length;i++){
    console.log(compositeArray[i]);
    if(Composite.get(compositeArray[i], event.body.id, "body")==event.body){
      clicked = true;
      clickedComposite = compositeArray[i];
      //console.log(composite1.constraints[0].pointA.x);
      clickedComposite.constraints[0].pointA.x = mousePosition.x;
      clickedComposite.constraints[0].pointA.y = mousePosition.y;
      //console.log("it works");
    }
  }
})


Events.on(mouseConstraint, 'mousemove', function(event) {
  var mousePosition = event.mouse.position;
  //console.log('mousedown at ' + mousePosition.x + ' ' + mousePosition.y);
  //console.log(Composite.get(composite1, event.body.id, "body"));
  if (clicked == true){
      clickedComposite.constraints[0].pointA.x = mousePosition.x;
      clickedComposite.constraints[0].pointA.y = mousePosition.y;
  }
})


/////////////////// BOUNDARIES //////////////////////////////////

// add boundaries
var offset = 5;
World.add(engine.world, [
  Bodies.rectangle(400, -offset, 800 + 2 * offset, 50, { isStatic: true }),
  Bodies.rectangle(400, 600 + offset, 800 + 2 * offset, 50, { isStatic: true }),
  Bodies.rectangle(800 + offset, 300, 50, 600 + 2 * offset, { isStatic: true }),
  Bodies.rectangle(-offset, 300, 50, 600 + 2 * offset, { isStatic: true })
]);

///////////////// Animation /////////////////////////////////////

Events.on(engine, 'beforeUpdate', function(event) {
    counter += 1;
    Body.setAngularVelocity(composite1.bodies[0], rotationSpeed);
    // every 1.5 sec
    if (counter >= 60 * 1.5) {

        // reset counter
        counter = 0;
        scaleFactor = 1;
    }
})

////////////////////// RUN /////////////////////////////

// run the engine
Engine.run(engine);