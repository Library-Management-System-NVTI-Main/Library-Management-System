<?php
session_start();
<<<<<<< HEAD
require_once 'config.php'; // Database connection file

// If user is already logged in, redirect to appropriate dashboard
if (isset($_SESSION['user_id'])) {
    switch ($_SESSION['role']) {
        case 'Admin':
            header("Location: admin/dashboard.php");
            break;
        case 'Publisher':
            header("Location: publisher/dashboard.php");
            break;
        case 'Reader':
            header("Location: reader/dashboard.php");
            break;
    }
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $role = trim($_POST['role']);
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $bio = trim($_POST['bio'] ?? '');
    
    // Validation
    if (empty($role) || empty($full_name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!in_array($role, ['Reader', 'Publisher'])) {
        $error = "Invalid role selected.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $error = "Email address is already registered.";
            } else {
                // Hash the password
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $stmt = $pdo->prepare("
                    INSERT INTO users (role_name, email, password_hash, full_name, bio, is_active, is_verified) 
                    VALUES (?, ?, ?, ?, ?, 1, 0)
                ");
                
                $stmt->execute([$role, $email, $password_hash, $full_name, $bio]);
                
                $success = "Registration successful! Please login to continue.";
                
                // Optional: Send verification email here
                // sendVerificationEmail($email, $full_name);
            }
        } catch (PDOException $e) {
            $error = "Registration failed. Please try again later.";
            error_log("Registration error: " . $e->getMessage());
        }
    }
}
?>
=======
require_once 'root/config.php'; // 1. Connect to Database

// 2. Security: Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'backend/register-backend.php';
?>

>>>>>>> b16211537480d09c174732c4d55bbad02b632427
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Readify</title>
    <style>
<<<<<<< HEAD
=======
        /* Exact styles from your previous file */
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --bg-primary: #0a0e27;
            --bg-secondary: #151937;
            --bg-card: #1a1f3a;
            --accent-primary: #6366f1;
            --accent-secondary: #8b5cf6;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --shadow-glow: 0 0 40px rgba(99, 102, 241, 0.3);
        }
        
<<<<<<< HEAD
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
=======
        * { margin: 0; padding: 0; box-sizing: border-box; }
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
<<<<<<< HEAD
            line-height: 1.6;
=======
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
<<<<<<< HEAD
            position: relative;
=======
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
            overflow-x: hidden;
        }

        .bg-animation {
            position: fixed;
<<<<<<< HEAD
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-animation::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
=======
            top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
        }
        .bg-animation::before {
            content: ''; position: absolute; width: 200%; height: 200%;
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
            background: radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 50%);
            animation: drift 20s ease-in-out infinite alternate;
        }
<<<<<<< HEAD

        @keyframes drift {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-50px, 50px); }
        }
=======
        @keyframes drift { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-50px, 50px); } }
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
        
        .register-container {
            background: var(--bg-card);
            border-radius: 24px;
<<<<<<< HEAD
            padding: 50px 40px;
=======
            padding: 40px;
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
            max-width: 500px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: var(--shadow-glow);
<<<<<<< HEAD
            position: relative;
            z-index: 1;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        
        .logo p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--text-primary);
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .required {
            color: var(--danger);
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select,
        textarea {
            width: 100%;
            padding: 14px 16px;
=======
        }
        
        h2 { text-align: center; margin-bottom: 20px; font-size: 1.8rem; }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo h1 { font-size: 2.2rem; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: var(--text-secondary); font-size: 0.9rem; }
        .required { color: var(--danger); }
        
        input, select, textarea {
            width: 100%; padding: 12px;
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
            background: var(--bg-secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--text-primary);
<<<<<<< HEAD
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        select {
            cursor: pointer;
        }
        
        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .login-link {
            text-align: center;
            margin-top: 24px;
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        
        .login-link a {
            color: var(--accent-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .login-link a:hover {
            color: var(--accent-secondary);
        }

        .back-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-home a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-home a:hover {
            color: var(--text-primary);
        }
        
        @media (max-width: 576px) {
            .register-container {
                padding: 30px 24px;
            }
            
            .logo h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
        }
=======
            font-family: inherit;
        }
        input:focus { outline: none; border-color: var(--accent-primary); }
        
        .btn {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; border: none; border-radius: 12px;
            font-weight: 600; cursor: pointer; margin-top: 10px;
        }
        .btn:hover { transform: translateY(-2px); }
        
        .alert { padding: 14px; border-radius: 12px; margin-bottom: 20px;text-align: center; }
        .alert-error { background: rgba(239, 68, 68, 0.1); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); }
        .alert-success { background: rgba(16, 185, 129, 0.1); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3); }
        
        .login-link { text-align: center; margin-top: 20px; color: var(--text-muted); font-size: 0.9rem; }
        .login-link a { color: var(--accent-primary); text-decoration: none; }
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
    </style>
</head>
<body>
    <div class="bg-animation"></div>
    
    <div class="register-container">
        <div class="logo">
            <h1>📚 Readify</h1>
            <p>Your Digital Bookshelf</p>
        </div>
        
        <h2>Create Account</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
<<<<<<< HEAD
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
=======
            <div class="alert alert-success"><?php echo $success; ?></div>
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
        <?php endif; ?>
        
        <?php if (!$success): ?>
        <form method="POST" action="">
            <div class="form-group">
<<<<<<< HEAD
                <label for="role">I want to register as <span class="required">*</span></label>
                <select name="role" id="role" required>
=======
                <label>Register as <span class="required">*</span></label>
                <select name="role" required>
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
                    <option value="">-- Select Role --</option>
                    <option value="Reader" <?php echo (isset($_POST['role']) && $_POST['role'] == 'Reader') ? 'selected' : ''; ?>>Reader</option>
                    <option value="Publisher" <?php echo (isset($_POST['role']) && $_POST['role'] == 'Publisher') ? 'selected' : ''; ?>>Publisher</option>
                </select>
            </div>
            
            <div class="form-group">
<<<<<<< HEAD
                <label for="full_name">Full Name <span class="required">*</span></label>
                <input type="text" name="full_name" id="full_name" 
                       value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" 
                       placeholder="Enter your full name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <input type="email" name="email" id="email" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                       placeholder="Enter your email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" name="password" id="password" 
                       placeholder="At least 8 characters" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                <input type="password" name="confirm_password" id="confirm_password" 
                       placeholder="Re-enter your password" required>
            </div>
            
            <div class="form-group">
                <label for="bio">Bio (Optional)</label>
                <textarea name="bio" id="bio" 
                          placeholder="Tell us about yourself..."><?php echo isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : ''; ?></textarea>
=======
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="full_name" value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Date of Birth <span class="required">*</span></label>
                <input type="date" name="dob" value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>" required>
                <small style="color: var(--text-muted); font-size: 0.8rem;">Used to personalize your book recommendations.</small>
            </div>

            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Password <span class="required">*</span></label>
                <input type="password" name="password" placeholder="Min. 8 characters" required>
            </div>
            
            <div class="form-group">
                <label>Confirm Password <span class="required">*</span></label>
                <input type="password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <label>Bio (Optional)</label>
                <textarea name="bio"><?php echo isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : ''; ?></textarea>
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
            </div>
            
            <button type="submit" class="btn">Create Account</button>
        </form>
        <?php endif; ?>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Sign In</a>
        </div>
<<<<<<< HEAD

        <div class="back-home">
            <a href="index.php">← Back to Home</a>
        </div>
=======
>>>>>>> b16211537480d09c174732c4d55bbad02b632427
    </div>
</body>
</html>