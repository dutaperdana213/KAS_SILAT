<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title><?= $title ?> - <?= SCHOOL_NAME ?> - <?= PERGURUAN ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts Premium -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* CSS Variables */
        :root {
            --primary-dark: #0a0f1f;
            --primary-medium: #1a1f35;
            --accent-gold: #ffd700;
            --accent-orange: #ffa500;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --shadow-premium: 0 20px 40px rgba(0, 0, 0, 0.25);
            --gradient-gold: linear-gradient(135deg, #ffd700, #ffa500);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 16px;
            background: linear-gradient(-45deg, #0a0f1f, #1a1f35, #2a1f3f);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            position: relative;
        }
        
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Simple overlay */
        .pattern-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(255,215,0,0.03) 0%, transparent 30%),
                        radial-gradient(circle at 80% 70%, rgba(102,126,234,0.03) 0%, transparent 30%);
            pointer-events: none;
            z-index: 1;
        }
        
        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
            animation: fadeIn 0.6s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Login Card */
        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: var(--shadow-premium);
            padding: 30px 25px;
            border-radius: 24px;
            position: relative;
            overflow: hidden;
        }
        
        /* Gold accent line */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, #ffd700, #ffa500, #ffd700, transparent);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        
        /* Logo */
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto 10px;
            background: var(--gradient-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3px;
            box-shadow: 0 10px 20px rgba(255, 215, 0, 0.2);
        }
        
        .logo-wrapper img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }
        
        .logo-wrapper i {
            font-size: 32px;
            color: white;
        }
        
        .logo-container h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 2px;
            letter-spacing: 1px;
        }
        
        .logo-container .subtitle {
            font-size: 0.75rem;
            color: #64748b;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        
        .logo-container .perguruan {
            font-size: 0.9rem;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 600;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Form */
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        
        .form-group i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            z-index: 10;
            transition: color 0.3s;
        }
        
        .form-group.focused i {
            color: #ffd700;
        }
        
        .form-control {
            width: 100%;
            height: 45px;
            padding: 0 14px 0 42px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.9rem;
            transition: all 0.3s;
            background: #f8fafc;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-control:focus {
            border-color: #ffd700;
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
            outline: none;
            background: white;
        }
        
        .form-control::placeholder {
            color: #cbd5e1;
            font-size: 0.85rem;
        }
        
        /* Button */
        .btn-login {
            background: linear-gradient(135deg, #0a0f1f, #1a1f35);
            border: 1.5px solid #ffd700;
            color: #ffd700;
            height: 45px;
            font-weight: 600;
            width: 100%;
            font-size: 0.95rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            margin-top: 15px;
            border-radius: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #1a1f35, #0a0f1f);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.2);
            transform: translateY(-2px);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login i {
            font-size: 0.95rem;
        }
        
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .login-footer small {
            color: #94a3b8;
            font-size: 0.7rem;
            display: block;
            line-height: 1.4;
        }
        
        .login-footer .school-name {
            color: #ffd700;
            font-weight: 600;
        }
        
        /* Alert */
        .alert {
            margin-bottom: 15px;
            padding: 10px 12px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            border-radius: 10px;
            border-left: 3px solid;
            background: rgba(254, 242, 242, 0.95);
            animation: slideIn 0.3s ease;
        }
        
        .alert-danger {
            color: #991b1b;
            border-left-color: #f87171;
        }
        
        .alert-success {
            color: #166534;
            border-left-color: #86efac;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .alert i {
            font-size: 1rem;
        }
        
        .alert ul {
            margin: 0;
            padding-left: 16px;
        }
        
        /* Loading spinner */
        .fa-spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive */
        @media (max-width: 360px) {
            .login-container {
                max-width: 320px;
            }
            
            .login-card {
                padding: 25px 20px;
            }
            
            .logo-wrapper {
                width: 60px;
                height: 60px;
            }
            
            .logo-wrapper i {
                font-size: 28px;
            }
            
            .logo-container h2 {
                font-size: 1.4rem;
            }
            
            .logo-container .subtitle {
                font-size: 0.7rem;
            }
            
            .logo-container .perguruan {
                font-size: 0.8rem;
            }
            
            .form-control {
                height: 42px;
            }
            
            .btn-login {
                height: 42px;
                font-size: 0.9rem;
            }
        }
        
        /* Dark mode */
        @media (prefers-color-scheme: dark) {
            :root {
                --glass-bg: rgba(26, 32, 44, 0.95);
            }
            
            .form-control {
                background: #2d3748;
                border-color: #4a5568;
                color: #e2e8f0;
            }
            
            .logo-container .subtitle {
                color: #a0aec0;
            }
            
            .login-footer small {
                color: #718096;
            }
        }
        
        /* Shake animation */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-3px); }
            40%, 80% { transform: translateX(3px); }
        }
        
        .shake {
            animation: shake 0.4s ease;
        }
    </style>
</head>
<body>
    <div class="pattern-overlay"></div>
    
    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo-container">
                <div class="logo-wrapper">
                    <?php if (file_exists(BASE_PATH . 'assets/img/logo-perguruan.png')): ?>
                        <img src="<?= BASE_URL ?>/assets/img/logo-perguruan.png" alt="Logo">
                    <?php elseif (file_exists(BASE_PATH . 'assets/img/logo-perguruan.jpg')): ?>
                        <img src="<?= BASE_URL ?>/assets/img/logo-perguruan.jpg" alt="Logo">
                    <?php else: ?>
                        <i class="fas fa-fist-raised"></i>
                    <?php endif; ?>
                </div>
                
                <h2>LOGIN KAS</h2>
                <div class="subtitle">EKSTRAKURIKULER SILAT</div>
                <div class="perguruan">SINGA BARWANG</div>
            </div>
            
            <!-- Alert -->
            <?php if ($flash = $this->getFlash()): ?>
                <div class="alert <?= $flash['type'] === 'error' ? 'alert-danger' : 'alert-success' ?>">
                    <i class="fas fa-<?= $flash['type'] === 'error' ? 'exclamation-circle' : 'check-circle' ?>"></i>
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
            <?php endif; ?>
            
            <!-- Form -->
            <form action="<?= BASE_URL ?>/auth/login" method="POST" id="loginForm">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                </div>
                
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                
                <button type="submit" class="btn-login" id="loginButton">
                    <i class="fas fa-sign-in-alt"></i> LOGIN
                </button>
            </form>
            
            <!-- Footer -->
            <div class="login-footer">
                <small>© <?= date('Y') ?> <span class="school-name"><?= SCHOOL_NAME ?></span> - Singa Barwang</small>
                <small class="mt-1">Sistem Informasi Kas v1.0</small>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Auto hide alert
            setTimeout(function() {
                $('.alert').fadeOut(300);
            }, 3000);
            
            // Input focus effect
            $('.form-control').on('focus', function() {
                $(this).closest('.form-group').addClass('focused');
            }).on('blur', function() {
                $(this).closest('.form-group').removeClass('focused');
            });
            
            // Form validation
            $('#loginForm').on('submit', function(e) {
                let username = $('#username').val().trim();
                let password = $('#password').val().trim();
                let errors = [];
                
                if (!username) errors.push('Username harus diisi');
                if (!password) errors.push('Password harus diisi');
                
                if (errors.length > 0) {
                    e.preventDefault();
                    
                    let errorHtml = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i><ul>';
                    errors.forEach(err => errorHtml += '<li>' + err + '</li>');
                    errorHtml += '</ul></div>';
                    
                    $('.logo-container').after(errorHtml);
                    $('.login-card').addClass('shake');
                    
                    setTimeout(() => {
                        $('.login-card').removeClass('shake');
                        $('.alert').fadeOut(300);
                    }, 3000);
                    
                    return false;
                }
                
                // Loading
                $('#loginButton').html('<i class="fas fa-spinner fa-spin"></i> LOGIN...').prop('disabled', true);
            });
        });
    </script>
</body>
</html>