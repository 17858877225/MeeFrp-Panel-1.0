<?php
namespace chhcn;

use chhcn;

global $_config;

if(isset($_GET['link']) && $_GET['link'] !== "") {
    $um = new chhcn\UserManager();
    if($um->resetPass($_GET['link'])) {
        exit("<script>alert('密码重置成功，请使用新密码登录。');location='?page=login';</script>");
    } else {
        exit("<script>alert('无效的找回密码链接，请重新获取。');location='?page=login';</script>");
    }
}
?>
<!DOCTYPE HTML>
<html lang="zh_CN">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=11">
        <meta name="msapplication-TileColor" content="#F1F1F1">
        <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.bootcdn.net/ajax/libs/popper.js/2.11.7/cjs/popper.min.js"></script>
        <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/js/bootstrap.min.js"></script>
        <?php if($_config['recaptcha']['enable']) echo '<script src="https://www.recaptcha.net/recaptcha/api.js?render=' . $_config['recaptcha']['sitekey'] . '" defer></script>'; ?>
        <title>找回密码 :: <?php echo $_config['sitename']; ?> - <?php echo $_config['description']; ?></title>
        <style type="text/css">
            :root {
                --primary-color: #4e73df;
                --primary-hover: #2e59d9;
                --text-color: #5a5c69;
                --light-bg: #f8f9fc;
            }
            
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                color: var(--text-color);
            }
            
            .auth-container {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: 2rem;
            }
            
            .auth-card {
                width: 100%;
                max-width: 450px;
                background: white;
                border-radius: 12px;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                transition: all 0.3s ease;
            }
            
            .auth-card:hover {
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }
            
            .auth-header {
                padding: 2rem;
                background: var(--primary-color);
                color: white;
                text-align: center;
            }
            
            .auth-header h2 {
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
            
            .auth-body {
                padding: 2rem;
            }
            
            .form-control {
                padding: 0.75rem 1rem;
                border-radius: 8px;
                border: 1px solid #d1d3e2;
                transition: all 0.3s;
            }
            
            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            }
            
            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
                padding: 0.75rem;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s;
            }
            
            .btn-primary:hover {
                background-color: var(--primary-hover);
                border-color: var(--primary-hover);
                transform: translateY(-2px);
            }
            
            .input-group-text {
                background-color: var(--light-bg);
                border: 1px solid #d1d3e2;
            }
            
            .auth-footer {
                padding: 1rem 2rem;
                background-color: var(--light-bg);
                text-align: center;
                border-top: 1px solid #e3e6f0;
            }
            
            .auth-footer a {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
            }
            
            .auth-footer a:hover {
                text-decoration: underline;
            }
            
            .copyright {
                position: fixed;
                bottom: 16px;
                left: 0;
                right: 0;
                color: rgba(255, 255, 255, 0.8);
                font-size: 14px;
                text-align: center;
            }
            
            .alert {
                border-radius: 8px;
                margin-bottom: 1.5rem;
            }
            
            .divider {
                display: flex;
                align-items: center;
                margin: 1.5rem 0;
                color: #b7b9cc;
            }
            
            .divider::before, .divider::after {
                content: "";
                flex: 1;
                border-bottom: 1px solid #e3e6f0;
            }
            
            .divider::before {
                margin-right: 1rem;
            }
            
            .divider::after {
                margin-left: 1rem;
            }
            
            @media (max-width: 576px) {
                .auth-container {
                    padding: 1rem;
                }
                
                .auth-card {
                    border-radius: 8px;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h2><?php echo $_config['sitename']; ?></h2>
                    <p><?php echo $_config['description']; ?></p>
                </div>
                
                <div class="auth-body">
                    <?php
                    if(isset($data['status']) && isset($data['message'])) {
                        $alertType = $data['status'] ? "success" : "danger";
                        echo '<div class="alert alert-' . $alertType . ' alert-dismissable fade show"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' . $data['message'] . '</div>';
                    }
                    ?>
                    
                    <form method="POST" action="?action=findpass&page=findpass">
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
                        
                        <div class="mb-4">
                            <label for="username" class="form-label">账号或邮箱</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                <input type="text" class="form-control" name="username" id="username" placeholder="请输入您的账号或邮箱" required>
                            </div>
                            <small class="text-muted">我们将发送密码重置链接到您的注册邮箱</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">找回密码</button>
                    </form>
                </div>
                
                <div class="auth-footer">
                    <?php if($_config['register']['enable']): ?>
                        <p>
                            <a href="?page=register">注册新账号</a> &middot; 
                            <a href="?page=login">返回登录</a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <p class="copyright">&copy; <?php echo date("Y") . " {$_config['sitename']}"; ?></p>
        
        <?php
        if($_config['recaptcha']['enable']) {
            echo <<<EOF
        <script type="text/javascript">
            window.onload = function() {
                grecaptcha.ready(function() {
                    grecaptcha.execute('{$_config['recaptcha']['sitekey']}', {action:'validate_captcha'}).then(function(token) {
                        document.getElementById('g-recaptcha-response').value = token;
                    });
                });
            }
        </script>
EOF;
        }
        ?>
    </body>
</html>