<?php
// Web-based Terminal using PHP
// SECURITY WARNING: This script allows command execution on your server.
// Only use in secure environments and add proper authentication.

// Set proper headers
header('Content-Type: text/html; charset=UTF-8');

// Basic authentication function - REPLACE with your own secure authentication
function authenticate() {
  
    return true; 
}

// Check authentication
if (!authenticate()) {
    header('HTTP/1.0 403 Forbidden');
    echo '<h1>Access Denied</h1>';
    exit;
}

// Process command if submitted
$output = '';
$command = '';
$workingDir = getcwd(); // Default working directory

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command'])) {
    $command = trim($_POST['command']);
    
    if (!empty($command)) {
        // Change directory command handling
        if (preg_match('/^cd\s+(.+)$/', $command, $matches)) {
            $newDir = $matches[1];
            // Handle relative or absolute paths
            if ($newDir[0] === '/') {
                $targetDir = $newDir;
            } else {
                $targetDir = $workingDir . '/' . $newDir;
            }
            
            if (is_dir($targetDir)) {
                $workingDir = realpath($targetDir);
                $output = "Changed directory to: $workingDir";
            } else {
                $output = "Error: Directory '$newDir' not found.";
            }
        } else {
            // For other commands, execute them in the current working directory
            $descriptorSpec = array(
                0 => array("pipe", "r"),  // stdin
                1 => array("pipe", "w"),  // stdout
                2 => array("pipe", "w")   // stderr
            );
            
            // Add 2>&1 to capture both stdout and stderr
            $process = proc_open("cd $workingDir && $command 2>&1", $descriptorSpec, $pipes);
            
            if (is_resource($process)) {
                // Close stdin
                fclose($pipes[0]);
                
                // Read stdout
                $output = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                
                // Close process
                proc_close($process);
            } else {
                $output = "Error: Failed to execute command.";
            }
        }
    }
}

// Save the current working directory in session
session_start();
$_SESSION['working_dir'] = $workingDir;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Web Terminal</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #1e1e1e;
            color: #f0f0f0;
            margin: 0;
            padding: 10px;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }
        .terminal {
            background-color: #121212;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            min-height: 300px;
            max-height: 500px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .prompt {
            display: flex;
            margin-bottom: 10px;
        }
        .prompt-text {
            color: #4CAF50;
            margin-right: 10px;
            padding-top: 8px;
        }
        #command {
            flex: 1;
            background-color: #2d2d2d;
            color: #f0f0f0;
            border: 1px solid #3e3e3e;
            padding: 8px;
            font-family: 'Courier New', Courier, monospace;
            border-radius: 3px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 15px;
            margin-left: 5px;
            cursor: pointer;
            border-radius: 3px;
        }
        button:hover {
            background-color: #45a049;
        }
        .title {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }
        .output {
            color: #f0f0f0;
        }
        .command-text {
            color: #ff79c6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">PHP Web Terminal</h1>
        
        <div class="terminal" id="terminal">
            <div class="output">Current directory: <?php echo htmlspecialchars($workingDir); ?></div>
            <?php if (!empty($command)): ?>
                <div class="command-text">$ <?php echo htmlspecialchars($command); ?></div>
                <div class="output"><?php echo nl2br(htmlspecialchars($output)); ?></div>
            <?php endif; ?>
        </div>
        
        <form method="post" class="prompt">
            <span class="prompt-text">$</span>
            <input type="text" name="command" id="command" autocomplete="off" autofocus>
            <button type="submit">Execute</button>
        </form>
    </div>

    <script>
        // Auto-scroll to bottom of terminal
        const terminal = document.getElementById('terminal');
        terminal.scrollTop = terminal.scrollHeight;
        
        // Focus command input when page loads
        document.getElementById('command').focus();
        
        // Submit form on Enter key
        document.getElementById('command').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    </script>
</body>
</html>