<?php
namespace chhcn;

use chhcn;

global $_config;
$module = $_GET['module'] ?? "";

$rs = Database::querySingleLine("users", Array("username" => $_SESSION['user']));
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>管理面板 :: <?php echo $_config['sitename']; ?> - <?php echo $_config['description']; ?></title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AdminLTE 3 CSS -->
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    
    <!-- 自定义样式 -->
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-hover: #2e59d9;
            --sidebar-bg: #343a40;
            --sidebar-hover: rgba(255,255,255,0.1);
            --sidebar-active: var(--primary-color);
        }
        
        /* 主色调调整 */
        .bg-primary, .btn-primary {
            background-color: var(--primary-color) !important;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover) !important;
        }
        
        /* 侧边栏样式调整 */
        .main-sidebar {
            background-color: var(--sidebar-bg);
        }
        
        .nav-sidebar > .nav-item > .nav-link.active {
            background-color: var(--sidebar-active);
            color: white;
        }
        
        .nav-sidebar .nav-item > .nav-link:hover {
            background-color: var(--sidebar-hover);
        }
        
        /* 顶部导航栏 */
        .main-header {
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        
        /* 内容区域 */
        .content-wrapper {
            background-color: #f4f6f9;
        }
        
        /* 卡片样式 */
        .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border: none;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        /* 响应式调整 */
        @media (max-width: 992px) {
            .main-sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar-open .main-sidebar {
                transform: translateX(0);
            }
            
            /* 确保移动设备上的导航按钮可点击 */
            .navbar-nav .nav-link[data-widget="pushmenu"] {
                position: relative;
                z-index: 100;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- 顶部导航栏 -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- 左侧导航链接 -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="?page=panel&module=home" class="nav-link">主页</a>
                </li>
            </ul>
            
            <!-- 右侧导航链接 -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?page=logout&csrf=<?php echo $_SESSION['token']; ?>" title="退出登录">
                        <i class="fas fa-sign-out-alt"></i> 登出
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- 侧边栏 -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- 品牌标志 -->
            <a href="?page=panel&module=home" class="brand-link text-center">
                <span class="brand-text font-weight-light"><?php echo $_config['sitename']; ?></span>
            </a>
            
            <!-- 侧边栏 -->
            <div class="sidebar">
                <!-- 用户面板 -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://www.loliapi.com/acg/pp/" class="img-circle elevation-2" alt="用户头像">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo htmlspecialchars($_SESSION['user']); ?></a>
                    </div>
                </div>
                <!-- 侧边栏菜单 -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="?page=panel&module=home" class="nav-link <?php echo $module == "home" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>管理面板</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=panel&module=profile" class="nav-link <?php echo $module == "profile" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-user"></i>
                <p>用户信息</p>
            </a>
        </li>
        
        <li class="nav-header">内网穿透</li>
        <li class="nav-item">
            <a href="?page=panel&module=proxies" class="nav-link <?php echo $module == "proxies" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-list"></i>
                <p>隧道列表</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=panel&module=addproxy" class="nav-link <?php echo $module == "addproxy" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-plus"></i>
                <p>创建隧道</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=panel&module=sign" class="nav-link <?php echo $module == "sign" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-check-square"></i>
                <p>每日签到</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=panel&module=download" class="nav-link <?php echo $module == "download" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-download"></i>
                <p>软件下载</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=panel&module=configuration" class="nav-link <?php echo $module == "configuration" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-file"></i>
                <p>配置文件</p>
            </a>
        </li>
        
        <?php if($rs['group'] == "admin"): ?>
        <li class="nav-header">管理员</li>
        <li class="nav-item">
            <a href="?page=panel&module=userlist" class="nav-link <?php echo $module == "userlist" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>用户管理</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=panel&module=groupmanage" class="nav-link <?php echo $module == "groupmanage" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>用户组管理</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=panel&module=nodes" class="nav-link <?php echo $module == "nodes" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-server"></i>
                <p>节点管理</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=panel&module=traffic" class="nav-link <?php echo $module == "traffic" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-paper-plane"></i>
                <p>流量统计</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=panel&module=tunnelmanage" class="nav-link <?php echo $module == "tunnelmanage" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-network-wired"></i>
                <p>隧道管理</p>
            </a>
        </li>
        
        <!-- 邀请码管理树形菜单 -->
       <li class="nav-item">
    <a href="?page=panel&module=invitecode" class="nav-link <?= $module == "invitecode" ? "active" : "" ?>">
        <i class="nav-icon fas fa-ticket-alt"></i>
        <p>未用邀请</p>
    </a>
</li>
<li class="nav-item">
    <a href="?page=panel&module=invitecode_stats" class="nav-link <?= $module == "invitecode_stats" ? "active" : "" ?>">
        <i class="nav-icon fas fa-ticket-alt"></i>
        <p>已用邀请</p>
    </a>
</li>
        <li class="nav-item">
            <a href="?page=panel&module=settings" class="nav-link <?php echo $module == "settings" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-wrench"></i>
                <p>站点设置</p>
            </a>
        </li>
     
             
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </aside>
        
        <!-- 内容区域 -->
        <div class="content-wrapper">
            <!-- 内容头部 -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?php echo ucfirst($module); ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="?page=panel&module=home">首页</a></li>
                                <li class="breadcrumb-item active"><?php echo ucfirst($module); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 主内容区 -->
            <section class="content">
                <div class="container-fluid">
                    <?php
                    $page = new chhcn\Pages();
                    if(isset($_GET['module']) && preg_match("/^[A-Za-z0-9\_\-]{1,16}$/", $_GET['module'])) {
                        $page->loadModule($_GET['module']);
                    } else {
                        $page->loadModule("home");
                    }
                    ?>
                </div>
            </section>
        </div>
        
        <!-- 页脚 -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b> <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="https://ch-h.cn" target="_blank" rel="noopener noreferrer"><?php echo $_config['sitename']; ?></a>.</strong></b>
            </div>
            
        </footer>
    </div>
    
    <!-- jQuery -->
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.bootcdn.net/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    
    <script>
        // 确保侧边栏功能正常
        $(document).ready(function() {
            // 启用侧边栏折叠功能
            $('[data-widget="pushmenu"]').on('click touchstart', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('body').toggleClass('sidebar-collapse');
                $('body').toggleClass('sidebar-open');
                return false;
            });
            
            // 响应式调整
            $(window).resize(function() {
                if ($(window).width() < 992) {
                    $('body').addClass('sidebar-collapse');
                }
            });
            
            // 初始化移动设备视图
            if ($(window).width() < 992) {
                $('body').addClass('sidebar-collapse');
            }
        });
    </script>
</body>
</html>