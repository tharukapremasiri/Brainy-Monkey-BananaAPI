const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');

// Set canvas dimensions to full screen
function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

resizeCanvas();  // Set the initial size

// Monkey object
let monkey = {
    x: 0,
    y: canvas.height * 0.85,  // Initial Y position relative to screen height
    width: 50,
    height: 50,
    speed: 0.0025,  // Reduced speed for smoother movement
    t: 0,  // Parameter for Bezier curve position
    coins: 0,
    lives: 3
};

// Path control points (Bezier curve) scaled to the screen size
let startPoint = { x: canvas.width * 0.05, y: canvas.height * 0.85 };
let controlPoint1 = { x: canvas.width * 0.15, y: canvas.height * 0.75 };
let controlPoint2 = { x: canvas.width * 0.25, y: canvas.height * 0.95 };
let endPoint = { x: canvas.width * 0.35, y: canvas.height * 0.85 };

// Extend the path with more curves to increase the length
let startPoint2 = { x: canvas.width * 0.35, y: canvas.height * 0.85 };
let controlPoint1_2 = { x: canvas.width * 0.45, y: canvas.height * 0.70 };
let controlPoint2_2 = { x: canvas.width * 0.55, y: canvas.height * 0.85 };
let endPoint2 = { x: canvas.width * 0.65, y: canvas.height * 0.75 };

let startPoint3 = { x: canvas.width * 0.65, y: canvas.height * 0.75 };
let controlPoint1_3 = { x: canvas.width * 0.75, y: canvas.height * 0.65 };
let controlPoint2_3 = { x: canvas.width * 0.85, y: canvas.height * 0.85 };
let endPoint3 = { x: canvas.width * 0.95, y: canvas.height * 0.85 };

// Function to get the point on the Bezier curve
function getBezierPoint(t, p0, p1, p2, p3) {
    let x = Math.pow(1 - t, 3) * p0.x + 3 * Math.pow(1 - t, 2) * t * p1.x + 3 * (1 - t) * Math.pow(t, 2) * p2.x + Math.pow(t, 3) * p3.x;
    let y = Math.pow(1 - t, 3) * p0.y + 3 * Math.pow(1 - t, 2) * t * p1.y + 3 * (1 - t) * Math.pow(t, 2) * p2.y + Math.pow(t, 3) * p3.y;
    return { x: x, y: y };
}

// Function to draw the road with a wider path
function drawPath() {
    ctx.beginPath();
    ctx.lineWidth = canvas.width * 0.06;  // Scale the path width relative to screen width
    ctx.strokeStyle = '#8B4513';  // Brown color for the road
    ctx.moveTo(startPoint.x, startPoint.y);

    // First curve
    ctx.bezierCurveTo(controlPoint1.x, controlPoint1.y, controlPoint2.x, controlPoint2.y, endPoint.x, endPoint.y);

    // Second curve
    ctx.bezierCurveTo(controlPoint1_2.x, controlPoint1_2.y, controlPoint2_2.x, controlPoint2_2.y, endPoint2.x, endPoint2.y);

    // Third curve (newly added)
    ctx.bezierCurveTo(controlPoint1_3.x, controlPoint1_3.y, controlPoint2_3.x, controlPoint2_3.y, endPoint3.x, endPoint3.y);

    ctx.stroke();
}

// Function to draw the background (sky and grass)
function drawBackground() {
    // Sky
    ctx.fillStyle = '#87CEEB';  // Light blue sky
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Grass
    ctx.fillStyle = '#228B22';  // Green grass
    ctx.fillRect(0, canvas.height * 0.85, canvas.width, canvas.height * 0.15);  // Grass height is 15% of the screen
}

// Function to draw the monkey
function drawMonkey() {
    ctx.fillStyle = 'brown';
    ctx.fillRect(monkey.x - monkey.width / 2, monkey.y - monkey.height / 2, monkey.width, monkey.height);
}

// Function to move the monkey along the path
function moveMonkeyAlongPath() {
    if (monkey.t <= 1) {
        monkey.t += monkey.speed;  // Move along the first curve
    } else if (monkey.t > 1 && monkey.t <= 2) {
        monkey.t += monkey.speed;  // Move along the second curve
    } else if (monkey.t > 2 && monkey.t <= 3) {
        monkey.t += monkey.speed;  // Move along the third curve
    } else {
        monkey.t = 0;  // Reset to start of the path
    }

    // Move along the first curve
    if (monkey.t <= 1) {
        const newPosition = getBezierPoint(monkey.t, startPoint, controlPoint1, controlPoint2, endPoint);
        monkey.x = newPosition.x;
        monkey.y = newPosition.y;
    }
    // Move along the second curve
    else if (monkey.t <= 2) {
        const newPosition = getBezierPoint(monkey.t - 1, startPoint2, controlPoint1_2, controlPoint2_2, endPoint2);
        monkey.x = newPosition.x;
        monkey.y = newPosition.y;
    }
    // Move along the third curve (newly added)
    else {
        const newPosition = getBezierPoint(monkey.t - 2, startPoint3, controlPoint1_3, controlPoint2_3, endPoint3);
        monkey.x = newPosition.x;
        monkey.y = newPosition.y;
    }
}

// Resize the canvas when the window is resized
window.addEventListener('resize', () => {
    resizeCanvas();
    // Recalculate the path control points after resizing
    startPoint = { x: canvas.width * 0.05, y: canvas.height * 0.85 };
    controlPoint1 = { x: canvas.width * 0.15, y: canvas.height * 0.75 };
    controlPoint2 = { x: canvas.width * 0.25, y: canvas.height * 0.95 };
    endPoint = { x: canvas.width * 0.35, y: canvas.height * 0.85 };

    startPoint2 = { x: canvas.width * 0.35, y: canvas.height * 0.85 };
    controlPoint1_2 = { x: canvas.width * 0.45, y: canvas.height * 0.70 };
    controlPoint2_2 = { x: canvas.width * 0.55, y: canvas.height * 0.85 };
    endPoint2 = { x: canvas.width * 0.65, y: canvas.height * 0.75 };

    startPoint3 = { x: canvas.width * 0.65, y: canvas.height * 0.75 };
    controlPoint1_3 = { x: canvas.width * 0.75, y: canvas.height * 0.65 };
    controlPoint2_3 = { x: canvas.width * 0.85, y: canvas.height * 0.85 };
    endPoint3 = { x: canvas.width * 0.95, y: canvas.height * 0.85 };
});

// Game loop to render the background, path, and monkey
function gameLoop() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);  // Clear the canvas
    drawBackground();  // Draw sky and grass
    drawPath();  // Draw the road
    moveMonkeyAlongPath();  // Move the monkey along the path
    drawMonkey();  // Draw the monkey at the new position

    requestAnimationFrame(gameLoop);  // Keep the game loop running
}

gameLoop();  // Start the game
