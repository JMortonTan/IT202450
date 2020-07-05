// Collect The Square game
// Credit: Ben Centra
// http://bencentra.com/2017-07-11-basic-html5-canvas-games.html


// Get a reference to the canvas DOM element
var canvas = document.getElementById('canvas');
// Get the canvas drawing context
var context = canvas.getContext('2d');

// Your score
var score = 0;

// Chain
var chain = 0;
var poison = false;

// Properties for your square
var x = 50; // X position
var y = 100; // Y position
var speed = 6; // Distance to move each frame
var sideLength = 50; // Length of each side of the square

// FLags to track which keys are pressed
var down = false;
var up = false;
var right = false;
var left = false;

// Properties for the target square
var targetX = 0;
var targetY = 0;
var targetLength = 25;

// Properties for the antitarget square
var antitargetX = 0;
var antitargetY = 0;
var antitargetLength = 25;

// Determine if number a is within the range b to c (exclusive)
function isWithin(a, b, c) {
    return (a > b && a < c);
}

// Countdown timer (in seconds)
var countdown = 30;
// ID to track the setTimeout
var id = null;

// Listen for keydown events
canvas.addEventListener('keydown', function(event) {
    event.preventDefault();
    console.log(event.key, event.keyCode);
    if (event.keyCode === 40) { // DOWN
        down = true;
    }
    if (event.keyCode === 38) { // UP
        up = true;
    }
    if (event.keyCode === 37) { // LEFT
        left = true;
    }
    if (event.keyCode === 39) { // RIGHT
        right = true;
    }
});

// Listen for keyup events
canvas.addEventListener('keyup', function(event) {
    event.preventDefault();
    console.log(event.key, event.keyCode);
    if (poison = false) {
        if (event.keyCode === 40) { // DOWN
            down = false;
        }
        if (event.keyCode === 38) { // UP
            up = false;
        }
        if (event.keyCode === 37) { // LEFT
            left = false;
        }
        if (event.keyCode === 39) { // RIGHT
            right = false;
        }
    }

    if (poison = true) {
        if (event.keyCode === 40) { // DOWN
            up = false;
        }
        if (event.keyCode === 38) { // UP
            down = false;
        }
        if (event.keyCode === 37) { // LEFT
            right = false;
        }
        if (event.keyCode === 39) { // RIGHT
            left = false;
        }
    }
});

// Show the start menu
function menu() {
    erase();
    context.fillStyle = '#000000';
    context.font = '36px Arial';
    context.textAlign = 'center';
    context.fillText('Collect the Square!', canvas.width / 2, canvas.height / 4);
    context.font = '24px Arial';
    context.fillText('Click to Start', canvas.width / 2, canvas.height / 2);
    context.font = '18px Arial'
    context.fillText('Use the arrow keys to move', canvas.width / 2, (canvas.height / 4) * 3);
    // Start the game on a click
    canvas.addEventListener('click', startGame);
}

// Start the game
function startGame() {
    // Reduce the countdown timer ever second
    id = setInterval(function() {
        countdown--;
    }, 1000)
    // Stop listening for click events
    canvas.removeEventListener('click', startGame);
    // Put the target at a random starting point
    moveTarget();
    // Kick off the draw loop
    draw();
}

// Show the game over screen
function endGame() {
    // Stop the countdown
    clearInterval(id);
    // Display the final score
    erase();
    context.fillStyle = '#000000';
    context.font = '24px Arial';
    context.textAlign = 'center';
    context.fillText('Final Score: ' + score, canvas.width / 2, canvas.height / 2);
}

// Move the target square to a random position
function moveTarget() {
    targetX = Math.round(Math.random() * canvas.width - targetLength);
    targetY = Math.round(Math.random() * canvas.height - targetLength)

    antitargetX = Math.round(Math.random() * canvas.width - targetLength);
    antitargetY = Math.round(Math.random() * canvas.height - targetLength)
}

// Clear the canvas
function erase() {
    context.fillStyle = '#FFFFFF';
    context.fillRect(0, 0, 600, 400);
}

// The main draw loop
function draw() {
    erase();
    // Move the square
    if (down) {
        y += speed;
    }
    if (up) {
        y -= speed;
    }
    if (right) {
        x += speed;
    }
    if (left) {
        x -= speed;
    }
    // Keep the square within the bounds
    if (y + sideLength > canvas.height) {
        y = canvas.height - sideLength;
    }
    if (y < 0) {
        y = 0;
    }
    if (x < 0) {
        x = 0;
    }
    if (x + sideLength > canvas.width) {
        x = canvas.width - sideLength;
    }
    // Collide with the target
    if (isWithin(targetX, x, x + sideLength) || isWithin(targetX + targetLength, x, x + sideLength)) { // X
        if (isWithin(targetY, y, y + sideLength) || isWithin(targetY + targetLength, y, y + sideLength)) { // Y
            // Respawn the targets
            moveTarget();
            // Increase the score
            score++;
            // Increase the player speed
            speed++;
            // Update Chain count
            chain++;
            // Cure poison
            poison = false;
            if (chain = 3) {
                //Reset chain
                chain = 0;
                countdown++;
            }
        }
    }
    // Collide with the antitarget
    if (isWithin(antitargetX, x, x + sideLength) || isWithin(antitargetX + antitargetLength, x, x + sideLength)) { // X
        if (isWithin(antitargetY, y, y + sideLength) || isWithin(antitargetY + targetLength, y, y + sideLength)) { // Y
            // Respawn the targets
            moveTarget();
            // Decrease the score
            score--;
            // Decrease the player speed
            speed--;
            // Update Chain count
            chain--;
        }
        if (chain = -3) {
            //Reset chain
            chain = 0;
            poison = true;
        }
    }

    // Draw the square
    context.fillStyle = '#0000FF';
    context.fillRect(x, y, sideLength, sideLength);

    // Draw the target
    context.fillStyle = '#228B22';
    context.fillRect(targetX, targetY, targetLength, targetLength);

    // Draw the anti-target
    context.fillStyle = '#FF0000';
    context.fillRect(antitargetX, antitargetY, antitargetLength, antitargetLength);

    // Draw the score and time remaining
    if (poison = true) {
        context.fillStyle = '#00FF00';
    }
    else {
        context.fillStyle = '#000000';
    }

    context.font = '24px Arial';
    context.textAlign = 'left';
    context.fillText('Score: ' + score, 10, 24);
    context.fillText('Time Remaining: ' + countdown, 10, 50);
    context.fillText('Speed: ' + speed, 10, 75)
    // End the game or keep playing
    if (countdown <= 0) {
        endGame();
    } else {
        window.requestAnimationFrame(draw);
    }
}

// Start the game
menu();
canvas.focus();