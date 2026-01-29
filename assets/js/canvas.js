/************************************************************************
 *
 * Eloquent JavaScript
 * by Marijn Haverbeke
 *
 * Chapter 19
 * Project: A Paint Program
 *
 * Just so you know, most of this code is Marijn's, comments are mine.
 * This exercise is meant to be a fun way of exploring how JavaScript can
 * interact with form elements while reviewing previous material in the
 * book. If you want to learn how to program with JavaScript, I sincerely
 * hope you check his book out. It's free online:
 *
 * http://eloquentjavascript.net/
 *
 * but I suggest buying it and marking it all up with your own notes
 * and thoughts.
 *
 * Now, TO THE CODE!!!
 *
 * Ryan Boone
 * falldowngoboone@gmail.com
 *
 ***********************************************************************/

// the core of the program; appends the paint interface to the
// DOM element given as an argument (parent)
function createPaint(parent) {
  var canvas = elt('canvas', {id: 'testCanvas', width: 239, height: 138});
  var cx = canvas.getContext('2d');

  cx.lineWidth = 4;

  var image = document.createElement('img');
  image.src = 'examen/default.png';
  image.onload = function() {
  // create pattern
  var ptrn = cx.createPattern(image, 'repeat');
  cx.fillStyle = ptrn;
  cx.fillRect(0, 0, 239, 138);
  }

  var toolbar = elt('div', {class: 'toolbar'});

  // calls the every function in controls, passing in context,
  // then appending the returned results to the toolbar
  for (var name in controls)
    toolbar.appendChild(controls[name](cx));

  var panel = elt('div', {class: 'picturepanel'}, canvas);
  parent.appendChild(elt('div', null, panel, toolbar));
}

/************************************************************************
 * helper functions
 ***********************************************************************/

// creates an element with a name and object (attributes)
// appends all further arguments it gets as child nodes
// string arguments create text nodes
//elt('div', {class: 'foo'}, 'Hello, world!');
function elt(name, attributes) {
  var node = document.createElement(name);
  if (attributes) {
    for (var attr in attributes)
      if (attributes.hasOwnProperty(attr))
        node.setAttribute(attr, attributes[attr]);
  }
  for (var i = 2; i < arguments.length; i++) {
    var child = arguments[i];

    // if this argument is a string, create a text node
    if (typeof child == 'string')
      child = document.createTextNode(child);
    node.appendChild(child);
  }
  return node;
}

// figures out canvas relative coordinates for accurate functionality
function relativePos(event, element) {
  var rect = element.getBoundingClientRect();
  return {x: Math.floor(event.clientX - rect.left),
          y: Math.floor(event.clientY - rect.top)};
}

// registers and unregisters listeners for tools
function trackDrag(onMove, onEnd) {
  function end(event) {
    removeEventListener('mousemove', onMove);
    removeEventListener('mouseup', end);
    if (onEnd)
      onEnd(event);
  }
  addEventListener('mousemove', onMove);
  addEventListener('mouseup', end);
}

// used by tools.Spray
// randomly positions dots
function randomPointInRadius(radius) {
  for (;;) {
    var x = Math.random() * 2 - 1;
    var y = Math.random() * 2 - 1;
    // uses the Pythagorean theorem to test if a point is inside a circle
    if (x * x + y * y <= 1)
      return {x: x * radius, y: y * radius};
  }
}

/************************************************************************
 * controls
 ***********************************************************************/

// holds static methods to initialize the various controls;
// Object.create() is used to create a truly empty object
var controls = Object.create(null);

controls.tool = function(cx) {
  var select = elt('select');

  // populate the tools
  for (var name in tools)
    select.appendChild(elt('option', null, name));

  // calls the particular method associated with the current tool
  cx.canvas.addEventListener('mousedown', function(event) {

    // is the left mouse button being pressed?
    if (event.which == 1) {

      // the event needs to be passed to the method to determine
      // what the mouse is doing and where it is
      tools[select.value](event, cx);
      // don't select when user is clicking and dragging
      event.preventDefault();
    }
  });

  return elt('span', null, 'Opción: ', select);
};

// color module
controls.color = function(cx) {
  var input = elt('input', {type: 'color'});

  // on change, set the new color style for fill and stroke
  input.addEventListener('change', function() {
    cx.fillStyle = input.value;
    cx.strokeStyle = input.value;
  });
  return elt('span', null, 'Color: ', input);
};

/*
// save
controls.save = function(cx) {
  // MUST open in a new window because of iframe security stuff
  var link = elt('a', {href: '/', target: '_blank'}, 'Save');
  function update() {
    try {
      link.href = cx.canvas.toDataURL();
    } catch(e) {
      // some browsers choke on big data URLs

      // also, if the server response doesn't include a header that tells the browser it
      // can be used on other domains, the script won't be able to look at it;
      // this is in order to prevent private information from leaking to a script;
      // pixel data, data URL or otherwise, cannot be extracted from a "tainted canvas"
      // and a SecurityError is thrown
      if (e instanceof SecurityError)
        link.href = 'javascript:alert(' +
          JSON.stringify('Can\'t save: ' + e.toString()) + ')';
      else
        window.alert("Nope.");
        throw e;
    }
  }
  link.addEventListener('mouseover', update);
  link.addEventListener('focus', update);
  return link;
};
*/
/************************************************************************
 * tools
 ***********************************************************************/

// drawing tools
var tools = Object.create(null);

// line tool
// onEnd is for the erase function, which uses it to reset
	// the globalCompositeOperation to source-over
tools.Dibujar = function(event, cx, onEnd) {
  cx.lineCap = 'round';

  // mouse position relative to the canvas
  var pos = relativePos(event, cx.canvas);
  trackDrag(function(event) {
    cx.beginPath();

    // move to current mouse position
    cx.moveTo(pos.x, pos.y);

    // update mouse position
    pos = relativePos(event, cx.canvas);

    // line to updated mouse position
    cx.lineTo(pos.x, pos.y);

    // stroke the line
    cx.stroke();
  }, onEnd);
};

// erase tool
tools.Borrar = function(event, cx) {

  // globalCompositeOperation determines how drawing operations
  // on a canvas affect what's already there
  // 'destination-out' makes pixels transparent, 'erasing' them
  // NOTE: this has been deprecated
  cx.globalCompositeOperation = 'destination-out';
  tools.Dibujar(event, cx, function() {
    cx.globalCompositeOperation = 'source-over';
  });
};

// text tool ...

// initialize the app
var myElem = document.getElementById('paint-app');
if (myElem === null) {} else{
  var appDiv = document.querySelector('#paint-app');
  createPaint(appDiv);
}
/************************************************************************
 * resources
 *
 * Canvas Rendering Context 2D API
 * https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D
 *
 * Eloquent JavaScript Ch 19, Project: A Paint Program
 * http://eloquentjavascript.net/19_paint.html
 ***********************************************************************/
