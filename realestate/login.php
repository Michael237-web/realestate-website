<?php
include_once 'config.php';

if(isset($_SESSION['user_id'])) {
    header('Location: admin/dashboard.php');
    exit();
}

$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $password = $_POST['password'];
    $query = "SELECT * FROM " . table('users') . " WHERE email = '$login' OR fullname = '$login'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: admin/dashboard.php');
            exit();
        } else {
            $error = 'Invalid password!';
        }
    } else {
        $error = 'Username or Email not found!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Login - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a0a1a;
            overflow: hidden;
            position: relative;
            padding: 12px;
        }

        /* ===== ANIMATED BACKGROUND ===== */
        .bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 50%, #0d1b2a 100%);
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            animation: orbFloat 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            top: -200px;
            right: -150px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            bottom: -150px;
            left: -100px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
            opacity: 0.3;
        }

        .orb-4 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #ffecd2, #fcb69f);
            top: 20%;
            left: 10%;
            animation-delay: -7s;
            opacity: 0.2;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(60px, -80px) scale(1.1); }
            50% { transform: translate(-40px, 40px) scale(0.9); }
            75% { transform: translate(50px, 60px) scale(1.05); }
        }

        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: particleFloat 15s linear infinite;
        }

        @keyframes particleFloat {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.4; }
            90% { opacity: 0.4; }
            100% { transform: translateY(-10vh) rotate(720deg); opacity: 0; }
        }

        /* ===== LOGIN WRAPPER - SCROLLABLE ===== */
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1000px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 30px 100px rgba(0, 0, 0, 0.5);
            margin: 0;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Custom scrollbar */
        .login-wrapper::-webkit-scrollbar {
            width: 4px;
        }

        .login-wrapper::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .login-wrapper::-webkit-scrollbar-thumb {
            background: rgba(102, 126, 234, 0.3);
            border-radius: 10px;
        }

        .login-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(102, 126, 234, 0.5);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ===== LEFT SIDE - IMAGE SLIDESHOW ===== */
        .login-image-side {
            position: relative;
            overflow: hidden;
            min-height: 420px;
            background: linear-gradient(135deg, #1a1a3e, #0d1b2a);
        }

        .image-slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: scale(1.05);
            transition: opacity 1s ease, transform 6s ease;
        }

        .slide.active {
            opacity: 1;
            transform: scale(1);
        }

        .slide::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(10, 10, 26, 0.65) 0%, rgba(26, 26, 62, 0.3) 100%);
        }

        .slide-content-overlay {
            position: absolute;
            bottom: 40px;
            left: 30px;
            right: 30px;
            z-index: 2;
            color: white;
        }

        .slide-content-overlay h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .slide-content-overlay p {
            font-size: 13px;
            opacity: 0.8;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            line-height: 1.5;
        }

        .slide-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            padding: 3px 14px;
            border-radius: 50px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 6px;
        }

        .slide-indicators {
            position: absolute;
            bottom: 14px;
            right: 30px;
            display: flex;
            gap: 8px;
            z-index: 3;
        }

        .slide-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .slide-indicator.active {
            background: #667eea;
            border-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.2);
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.3);
        }

        .slide-counter {
            position: absolute;
            top: 20px;
            right: 20px;
            color: rgba(255, 255, 255, 0.3);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            z-index: 3;
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            padding: 4px 12px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        /* ===== RIGHT SIDE - LOGIN FORM ===== */
        .login-form-side {
            padding: 35px 35px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.02);
            overflow-y: auto;
        }

        .login-form-side .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 14px;
            color: white;
            font-size: 22px;
            margin-bottom: 14px;
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.25);
            animation: pulseIcon 3s ease-in-out infinite;
            flex-shrink: 0;
        }

        @keyframes pulseIcon {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.04); }
        }

        .login-form-side h1 {
            font-size: 24px;
            font-weight: 800;
            color: white;
            margin-bottom: 3px;
            letter-spacing: -0.3px;
            flex-shrink: 0;
        }

        .login-form-side .subtitle {
            color: rgba(255, 255, 255, 0.4);
            font-size: 13px;
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .form-group {
            margin-bottom: 14px;
            flex-shrink: 0;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.2);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .input-wrapper input {
            width: 100%;
            padding: 11px 12px 11px 40px;
            border: 1.5px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.03);
            color: white;
            font-family: 'Inter', sans-serif;
        }

        .input-wrapper input::placeholder {
            color: rgba(255, 255, 255, 0.15);
            font-size: 13px;
        }

        .input-wrapper input:focus {
            border-color: #667eea;
            outline: none;
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.08);
        }

        .input-wrapper input:focus + i,
        .input-wrapper input:focus ~ i {
            color: #667eea;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .form-options .remember {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 12px;
            cursor: pointer;
        }

        .form-options .remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #667eea;
            cursor: pointer;
            border-radius: 3px;
        }

        .form-options .forgot-link {
            color: rgba(255, 255, 255, 0.3);
            font-size: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .form-options .forgot-link:hover {
            color: #667eea;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            font-size: 15px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.35);
        }

        .btn-login i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .btn-login:hover i {
            transform: translateX(3px);
        }

        .alert {
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 14px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: shake 0.4s ease-in-out;
            flex-shrink: 0;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            color: #fca5a5;
            border-left: 3px solid #ef4444;
        }

        .alert-error i {
            color: #ef4444;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        /* ===== DEMO CREDENTIALS ===== */
        .login-footer {
            margin-top: 16px;
            text-align: center;
            padding-top: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            flex-shrink: 0;
        }

        .demo-credentials-wrapper {
            display: inline-block;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.25), rgba(118, 75, 162, 0.25));
            border: 2px solid rgba(102, 126, 234, 0.4);
            border-radius: 16px;
            padding: 14px 24px;
            transition: all 0.4s ease;
            box-shadow: 0 4px 30px rgba(102, 126, 234, 0.2);
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 420px;
        }

        .demo-credentials-wrapper::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #667eea);
            background-size: 300% 300%;
            border-radius: 18px;
            z-index: -1;
            animation: gradientBorder 4s ease-in-out infinite;
            opacity: 0.5;
        }

        .demo-credentials-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            border-radius: 14px;
            pointer-events: none;
        }

        @keyframes gradientBorder {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .demo-credentials-wrapper:hover {
            transform: translateY(-3px) scale(1.02);
            border-color: rgba(102, 126, 234, 0.7);
            box-shadow: 0 8px 40px rgba(102, 126, 234, 0.35);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.35), rgba(118, 75, 162, 0.35));
        }

        .demo-label {
            display: block;
            font-size: clamp(10px, 1.2vw, 12px);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: clamp(6px, 1vw, 10px);
            position: relative;
            z-index: 1;
        }

        .demo-label i {
            color: #667eea;
            margin-right: 6px;
            animation: pulseLabel 2s ease-in-out infinite;
        }

        @keyframes pulseLabel {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .demo-credentials {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: clamp(6px, 1vw, 12px);
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .demo-item {
            display: flex;
            align-items: center;
            gap: clamp(4px, 0.8vw, 8px);
            background: rgba(255, 255, 255, 0.1);
            padding: clamp(4px, 0.6vw, 6px) clamp(10px, 1.5vw, 18px) clamp(4px, 0.6vw, 6px) clamp(6px, 1vw, 12px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            flex: 0 1 auto;
        }

        .demo-item:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: scale(1.05);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .demo-item .label {
            font-size: clamp(8px, 0.9vw, 10px);
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .demo-item .label i {
            font-size: clamp(9px, 1vw, 11px);
            color: rgba(255, 255, 255, 0.4);
            margin-right: 4px;
        }

        .demo-item .value {
            font-size: clamp(12px, 1.5vw, 16px);
            font-weight: 700;
            font-family: 'Inter', monospace;
            letter-spacing: 0.5px;
            padding: clamp(1px, 0.3vw, 2px) clamp(6px, 1vw, 12px);
            border-radius: 6px;
            background: rgba(0, 0, 0, 0.3);
            white-space: nowrap;
        }

        .demo-item .value.username {
            color: #93c5fd;
            border: 1px solid rgba(147, 197, 253, 0.25);
            text-shadow: 0 0 20px rgba(147, 197, 253, 0.15);
        }

        .demo-item .value.password {
            color: #a78bfa;
            border: 1px solid rgba(167, 139, 250, 0.25);
            text-shadow: 0 0 20px rgba(167, 139, 250, 0.15);
        }

        .demo-divider {
            color: rgba(255, 255, 255, 0.15);
            font-size: clamp(12px, 1.2vw, 18px);
            font-weight: 100;
            flex-shrink: 0;
        }

        .demo-hint {
            display: block;
            font-size: clamp(8px, 0.9vw, 10px);
            color: rgba(255, 255, 255, 0.4);
            margin-top: clamp(6px, 0.8vw, 10px);
            letter-spacing: 0.3px;
            position: relative;
            z-index: 1;
            background: rgba(102, 126, 234, 0.08);
            padding: clamp(3px, 0.5vw, 5px) clamp(10px, 1.5vw, 18px);
            border-radius: 20px;
            border: 1px solid rgba(102, 126, 234, 0.08);
            transition: all 0.3s ease;
            display: inline-block;
        }

        .demo-hint:hover {
            background: rgba(102, 126, 234, 0.15);
            border-color: rgba(102, 126, 234, 0.2);
            color: rgba(255, 255, 255, 0.6);
        }

        .demo-hint i {
            font-size: clamp(8px, 0.8vw, 10px);
            color: #667eea;
            animation: pulseHint 2s ease-in-out infinite;
        }

        .demo-hint i:first-child {
            animation-delay: 0s;
        }

        .demo-hint i:last-child {
            animation-delay: 0.5s;
        }

        @keyframes pulseHint {
            0%, 100% { opacity: 0.3; transform: translateY(0); }
            50% { opacity: 1; transform: translateY(-2px); }
        }

        .demo-hint strong {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ============================================================
           RESPONSIVE BREAKPOINTS
           ============================================================ */
        
        @media (max-width: 992px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                max-width: 440px;
                max-height: 85vh;
                border-radius: 24px;
            }
            .login-image-side {
                min-height: 200px;
            }
            .slide-content-overlay {
                bottom: 20px;
                left: 16px;
                right: 16px;
            }
            .slide-content-overlay h2 {
                font-size: 16px;
            }
            .slide-content-overlay p {
                font-size: 11px;
            }
            .slide-indicators {
                right: 16px;
                bottom: 8px;
                gap: 6px;
            }
            .slide-indicator {
                width: 7px;
                height: 7px;
            }
            .slide-counter {
                top: 12px;
                right: 12px;
                font-size: 10px;
                padding: 3px 10px;
            }
            .login-form-side {
                padding: 24px 20px 20px;
            }
            .demo-credentials-wrapper {
                max-width: 100%;
                padding: 12px 18px;
            }
        }

        @media (max-width: 768px) {
            .login-wrapper {
                max-height: 80vh;
                border-radius: 20px;
            }
            .login-image-side {
                min-height: 160px;
            }
            .login-form-side {
                padding: 20px 16px 16px;
            }
            .login-form-side .logo-icon {
                width: 38px;
                height: 38px;
                font-size: 16px;
                margin-bottom: 8px;
            }
            .login-form-side h1 {
                font-size: 20px;
            }
            .login-form-side .subtitle {
                font-size: 12px;
                margin-bottom: 14px;
            }
            .form-group {
                margin-bottom: 12px;
            }
            .form-group label {
                font-size: 10px;
            }
            .input-wrapper input {
                padding: 9px 10px 9px 34px;
                font-size: 13px;
                border-radius: 10px;
            }
            .input-wrapper i {
                font-size: 13px;
                left: 10px;
            }
            .form-options {
                margin-bottom: 14px;
            }
            .form-options .remember,
            .form-options .forgot-link {
                font-size: 11px;
            }
            .btn-login {
                padding: 11px;
                font-size: 14px;
                border-radius: 10px;
            }
            .btn-login i {
                font-size: 14px;
            }
            .login-footer {
                margin-top: 12px;
                padding-top: 12px;
            }
            .demo-credentials-wrapper {
                padding: 10px 16px;
                border-radius: 14px;
            }
            .demo-item .value {
                font-size: 13px;
            }
            .slide-content-overlay .slide-badge {
                font-size: 9px;
                padding: 2px 10px;
            }
            .slide-content-overlay p {
                display: none;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 8px;
            }
            .login-wrapper {
                border-radius: 18px;
                max-height: 75vh;
            }
            .login-image-side {
                min-height: 130px;
            }
            .login-form-side {
                padding: 16px 14px 14px;
            }
            .login-form-side .logo-icon {
                width: 32px;
                height: 32px;
                font-size: 14px;
                border-radius: 8px;
                margin-bottom: 6px;
            }
            .login-form-side h1 {
                font-size: 18px;
                margin-bottom: 2px;
            }
            .login-form-side .subtitle {
                font-size: 11px;
                margin-bottom: 12px;
            }
            .form-group {
                margin-bottom: 10px;
            }
            .form-group label {
                font-size: 9px;
            }
            .input-wrapper input {
                padding: 7px 8px 7px 30px;
                font-size: 12px;
                border-radius: 8px;
                min-height: 36px;
            }
            .input-wrapper i {
                font-size: 12px;
                left: 8px;
            }
            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
                margin-bottom: 12px;
            }
            .form-options .remember,
            .form-options .forgot-link {
                font-size: 11px;
            }
            .btn-login {
                padding: 10px;
                font-size: 13px;
                border-radius: 8px;
                min-height: 38px;
            }
            .btn-login i {
                font-size: 13px;
            }
            .login-footer {
                margin-top: 10px;
                padding-top: 10px;
            }
            .demo-credentials-wrapper {
                padding: 8px 12px;
                border-radius: 10px;
            }
            .demo-label {
                font-size: 9px;
                margin-bottom: 4px;
            }
            .demo-credentials {
                gap: 4px;
            }
            .demo-item {
                padding: 2px 6px 2px 4px;
                border-radius: 6px;
            }
            .demo-item .label {
                font-size: 7px;
            }
            .demo-item .label i {
                font-size: 8px;
            }
            .demo-item .value {
                font-size: 11px;
                padding: 1px 4px;
            }
            .demo-divider {
                font-size: 10px;
            }
            .demo-hint {
                font-size: 8px;
                padding: 2px 10px;
                margin-top: 4px;
            }
            .demo-hint i {
                font-size: 8px;
            }
            .slide-content-overlay h2 {
                font-size: 13px;
            }
            .slide-content-overlay {
                bottom: 12px;
                left: 12px;
                right: 12px;
            }
            .slide-content-overlay .slide-badge {
                font-size: 8px;
                padding: 1px 8px;
                margin-bottom: 2px;
            }
            .slide-indicators {
                right: 12px;
                bottom: 6px;
                gap: 4px;
            }
            .slide-indicator {
                width: 6px;
                height: 6px;
            }
            .slide-counter {
                top: 8px;
                right: 8px;
                font-size: 8px;
                padding: 2px 8px;
            }
            .alert {
                padding: 8px 10px;
                font-size: 12px;
                margin-bottom: 10px;
                border-radius: 8px;
            }
        }

        @media (max-width: 360px) {
            .login-wrapper {
                max-height: 70vh;
                border-radius: 16px;
            }
            .login-image-side {
                min-height: 100px;
            }
            .login-form-side {
                padding: 12px 10px 10px;
            }
            .login-form-side h1 {
                font-size: 16px;
            }
            .login-form-side .subtitle {
                font-size: 10px;
                margin-bottom: 10px;
            }
            .input-wrapper input {
                font-size: 11px;
                padding: 5px 6px 5px 26px;
                min-height: 32px;
            }
            .input-wrapper i {
                font-size: 11px;
                left: 6px;
            }
            .btn-login {
                font-size: 12px;
                padding: 8px;
                min-height: 34px;
            }
            .demo-credentials-wrapper {
                padding: 6px 8px;
                border-radius: 8px;
            }
            .demo-label {
                font-size: 8px;
                margin-bottom: 3px;
            }
            .demo-item {
                padding: 2px 4px 2px 3px;
            }
            .demo-item .label {
                font-size: 6px;
            }
            .demo-item .label i {
                font-size: 7px;
            }
            .demo-item .value {
                font-size: 10px;
                padding: 1px 3px;
            }
            .demo-divider {
                font-size: 8px;
            }
            .demo-hint {
                font-size: 7px;
                padding: 2px 6px;
                margin-top: 3px;
            }
            .demo-hint i {
                font-size: 7px;
            }
            .slide-content-overlay h2 {
                font-size: 11px;
            }
            .slide-content-overlay .slide-badge {
                font-size: 7px;
                padding: 1px 6px;
            }
        }

        /* Landscape phones */
        @media (max-height: 600px) and (orientation: landscape) {
            .login-wrapper {
                max-height: 92vh;
            }
            .login-image-side {
                min-height: 120px;
            }
            .login-form-side {
                padding: 12px 16px 12px;
            }
            .login-form-side .logo-icon {
                width: 28px;
                height: 28px;
                font-size: 12px;
                margin-bottom: 4px;
            }
            .login-form-side h1 {
                font-size: 16px;
                margin-bottom: 1px;
            }
            .login-form-side .subtitle {
                font-size: 11px;
                margin-bottom: 8px;
            }
            .form-group {
                margin-bottom: 8px;
            }
            .form-group label {
                font-size: 9px;
                margin-bottom: 2px;
            }
            .input-wrapper input {
                padding: 5px 8px 5px 28px;
                font-size: 12px;
                min-height: 30px;
            }
            .form-options {
                margin-bottom: 10px;
            }
            .btn-login {
                padding: 7px;
                font-size: 12px;
                min-height: 32px;
            }
            .login-footer {
                margin-top: 8px;
                padding-top: 8px;
            }
            .demo-credentials-wrapper {
                padding: 6px 12px;
                max-width: 100%;
            }
            .demo-label {
                font-size: 9px;
                margin-bottom: 4px;
            }
            .demo-credentials {
                gap: 4px;
            }
            .demo-item {
                padding: 2px 6px 2px 4px;
            }
            .demo-item .value {
                font-size: 11px;
            }
            .demo-hint {
                display: none;
            }
            .slide-content-overlay {
                display: none;
            }
            .slide-indicators {
                bottom: 6px;
                right: 12px;
            }
            .slide-counter {
                top: 8px;
                right: 8px;
                font-size: 8px;
                padding: 2px 8px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
            .orb { animation: none !important; }
            .particle { animation: none !important; opacity: 0.05 !important; }
            .slide { transition: opacity 0.8s ease !important; }
            .login-wrapper { animation: none !important; opacity: 1 !important; transform: none !important; }
            .btn-login::before { display: none !important; }
            .demo-credentials-wrapper::before { animation: none !important; }
            .demo-hint i { animation: none !important; }
            .demo-label i { animation: none !important; }
        }
    </style>
</head>
<body>

<div class="bg-container">
    <div class="bg-gradient"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>
</div>

<div class="particles" id="particles"></div>

<div class="login-wrapper" id="loginWrapper">
    <div class="login-image-side">
        <div class="image-slideshow" id="slideshow">
            <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80');">
                <div class="slide-content-overlay">
                    <span class="slide-badge"><i class="fas fa-crown"></i> Premium</span>
                    <h2>Find Your Luxury Home</h2>
                    <p>Discover exquisite properties in Kenya's most prestigious neighborhoods</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&q=80');">
                <div class="slide-content-overlay">
                    <span class="slide-badge"><i class="fas fa-building"></i> Modern</span>
                    <h2>Modern Living Spaces</h2>
                    <p>Contemporary apartments designed for comfort and style</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1523217582562-09d0def993a6?w=800&q=80');">
                <div class="slide-content-overlay">
                    <span class="slide-badge"><i class="fas fa-umbrella-beach"></i> Coastal</span>
                    <h2>Beachfront Properties</h2>
                    <p>Experience coastal living at its finest</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80');">
                <div class="slide-content-overlay">
                    <span class="slide-badge"><i class="fas fa-paint-brush"></i> Design</span>
                    <h2>Elegant Interiors</h2>
                    <p>Beautifully designed homes with attention to detail</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=800&q=80');">
                <div class="slide-content-overlay">
                    <span class="slide-badge"><i class="fas fa-city"></i> Urban</span>
                    <h2>City Living</h2>
                    <p>Prime locations in the heart of Nairobi</p>
                </div>
            </div>
        </div>

        <div class="slide-counter" id="slideCounter">01 / 05</div>

        <div class="slide-indicators" id="slideIndicators">
            <span class="slide-indicator active" data-index="0"></span>
            <span class="slide-indicator" data-index="1"></span>
            <span class="slide-indicator" data-index="2"></span>
            <span class="slide-indicator" data-index="3"></span>
            <span class="slide-indicator" data-index="4"></span>
        </div>
    </div>

    <div class="login-form-side">
        <div class="logo-icon">
            <i class="fas fa-building"></i>
        </div>
        <h1>Welcome Back</h1>
        <p class="subtitle">Sign in to your <?php echo SITE_NAME; ?> account</p>

        <?php if($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <label for="login">Username or Email</label>
                <div class="input-wrapper">
                    <input type="text" id="login" name="login" required placeholder="Enter your username or email" autofocus>
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <div class="form-options">
                <label class="remember">
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-login">
                <span>Sign In</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <!-- ===== FULLY RESPONSIVE DEMO CREDENTIALS ===== -->
        <div class="login-footer">
            <div class="demo-credentials-wrapper">
                <div class="demo-label">
                    <i class="fas fa-key"></i> Use These Credentials To Login
                </div>
                <div class="demo-credentials">
                    <div class="demo-item">
                        <span class="label"><i class="fas fa-user"></i> User</span>
                        <span class="value username">admin</span>
                    </div>
                    <span class="demo-divider">|</span>
                    <div class="demo-item">
                        <span class="label"><i class="fas fa-lock"></i> Pass</span>
                        <span class="value password">admin123</span>
                    </div>
                </div>
                <div class="demo-hint">
                    <i class="fas fa-arrow-up"></i>
                    Use these credentials to <strong>sign in</strong>
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        'use strict';

        function createParticles() {
            const container = document.getElementById('particles');
            if (!container) return;
            const count = window.innerWidth < 480 ? 15 : 30;
            for (let i = 0; i < count; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                const size = Math.random() * 3 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.animationDuration = (Math.random() * 20 + 10) + 's';
                particle.style.animationDelay = (Math.random() * 10) + 's';
                container.appendChild(particle);
            }
        }
        createParticles();

        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.slide-indicator');
        const counter = document.getElementById('slideCounter');
        let slideInterval;

        function goToSlide(index) {
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;
            
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            indicators.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            
            currentSlide = index;
            if (counter) {
                counter.textContent = String(index + 1).padStart(2, '0') + ' / ' + String(slides.length).padStart(2, '0');
            }
        }

        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        indicators.forEach((dot) => {
            dot.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                goToSlide(index);
                resetInterval();
            });
        });

        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, 5000);
        }

        goToSlide(0);
        slideInterval = setInterval(nextSlide, 5000);

        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                const container = document.getElementById('particles');
                if (container) {
                    container.innerHTML = '';
                    createParticles();
                }
            }, 500);
        });

        // Fix: Ensure scrolling works on touch devices
        var loginWrapper = document.getElementById('loginWrapper');
        if (loginWrapper) {
            // Enable touch scrolling
            loginWrapper.addEventListener('touchmove', function(e) {
                e.stopPropagation();
            }, { passive: true });
        }

    })();
</script>

</body>
</html>