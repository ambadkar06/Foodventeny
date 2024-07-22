<?php
// PHP code to handle role-based redirection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    
    if ($role == 'organizer') {
        header('Location: http://localhost:8081/admin.php');
        exit();
    } elseif ($role == 'vendor') {
        header('Location: http://localhost:8081/redirect.php');
        exit();
    } else {
        echo "Invalid role selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Foodventeny Festival</title>
    <style>
        body {
            background: 
                linear-gradient(#0007, #0000),
                #123;
            margin: 0;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        @keyframes firework {
            0% { transform: translate(var(--x), var(--initialY)); width: var(--initialSize); opacity: 1; }
            50% { width: 0.5vmin; opacity: 1; }
            100% { width: var(--finalSize); opacity: 0; }
        }

        .firework,
        .firework::before,
        .firework::after {
            --initialSize: 0.5vmin;
            --finalSize: 45vmin;
            --particleSize: 0.2vmin;
            --color1: yellow;
            --color2: khaki;
            --color3: white;
            --color4: lime;
            --color5: gold;
            --color6: mediumseagreen;
            --y: -30vmin;
            --x: -50%;
            --initialY: 60vmin;
            content: "";
            animation: firework 2s infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, var(--y));
            width: var(--initialSize);
            aspect-ratio: 1;
            background: 
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 50% 0%,
                radial-gradient(circle, var(--color2) var(--particleSize), #0000 0) 100% 50%,
                radial-gradient(circle, var(--color3) var(--particleSize), #0000 0) 50% 100%,
                radial-gradient(circle, var(--color4) var(--particleSize), #0000 0) 0% 50%,
                radial-gradient(circle, var(--color5) var(--particleSize), #0000 0) 80% 90%,
                radial-gradient(circle, var(--color6) var(--particleSize), #0000 0) 95% 90%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 90% 70%,
                radial-gradient(circle, var(--color2) var(--particleSize), #0000 0) 100% 60%,
                radial-gradient(circle, var(--color3) var(--particleSize), #0000 0) 55% 80%,
                radial-gradient(circle, var(--color4) var(--particleSize), #0000 0) 70% 77%,
                radial-gradient(circle, var(--color5) var(--particleSize), #0000 0) 22% 90%,
                radial-gradient(circle, var(--color6) var(--particleSize), #0000 0) 45% 90%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 33% 70%,
                radial-gradient(circle, var(--color2) var(--particleSize), #0000 0) 10% 60%,
                radial-gradient(circle, var(--color3) var(--particleSize), #0000 0) 31% 80%,
                radial-gradient(circle, var(--color4) var(--particleSize), #0000 0) 28% 77%,
                radial-gradient(circle, var(--color5) var(--particleSize), #0000 0) 13% 72%,
                radial-gradient(circle, var(--color6) var(--particleSize), #0000 0) 80% 10%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 95% 14%,
                radial-gradient(circle, var(--color2) var(--particleSize), #0000 0) 90% 23%,
                radial-gradient(circle, var(--color3) var(--particleSize), #0000 0) 100% 43%,
                radial-gradient(circle, var(--color4) var(--particleSize), #0000 0) 85% 27%,
                radial-gradient(circle, var(--color5) var(--particleSize), #0000 0) 77% 37%,
                radial-gradient(circle, var(--color6) var(--particleSize), #0000 0) 60% 7%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 22% 14%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 45% 20%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 33% 34%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 10% 29%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 31% 37%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 28% 7%,
                radial-gradient(circle, var(--color1) var(--particleSize), #0000 0) 13% 42%;
            background-size: var(--initialSize) var(--initialSize);
            background-repeat: no-repeat;
        }

        .firework::before {
            --x: -50%;
            --y: -50%;
            --initialY: -50%;
            transform: translate(-50%, -50%) rotate(40deg) scale(1.3) rotateY(40deg);
        }

        .firework::after {
            --x: -50%;
            --y: -50%;
            --initialY: -50%;
            transform: translate(-50%, -50%) rotate(170deg) scale(1.15) rotateY(-30deg);
        }

        .firework:nth-child(2) {
            --x: 30vmin;
        }

        .firework:nth-child(2),
        .firework:nth-child(2)::before,
        .firework:nth-child(2)::after {
            --color1: pink;
            --color2: violet;
            --color3: fuchsia;
            --color4: orchid;
            --color5: plum;
            --color6: lavender;  
            --finalSize: 40vmin;
            left: 30%;
            top: 60%;
            animation-delay: -0.25s;
        }

        .firework:nth-child(3) {
            --x: -30vmin;
            --y: -50vmin;
        }

        .firework:nth-child(3),
        .firework:nth-child(3)::before,
        .firework:nth-child(3)::after {
            --color1: cyan;
            --color2: lightcyan;
            --color3: lightblue;
            --color4: PaleTurquoise;
            --color5: SkyBlue;
            --color6: lavender;
            --finalSize: 35vmin;
            left: 70%;
            top: 60%;
            animation-delay: -0.4s;
        }

        h1, h2, p {
            color: #fff;
            text-align: center;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        label, select, button {
            font-size: 1.2em;
            margin: 10px;
        }

        select, button {
            padding: 10px;
        }
    </style>
</head>
<body>
    <!-- Firework Animation -->
    <div class="firework"></div>
    <div class="firework"></div>
    <div class="firework"></div>

    <!-- Main Content -->
    <h1>Welcome to Foodventeny Festival</h1>
    <p>Join us for an exciting festival featuring a variety of vendors, entertainment, and more!</p>

    <h2>Who are you?</h2>
    <form method="post" action="">
        <label style="color: white;" for="role">Select your role:</label>
        <select name="role" id="role">
            <option value="">Select you role</option>
            <option value="organizer">Organizer</option>
            <option value="vendor">Vendor</option>
        </select>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
