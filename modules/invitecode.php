<?php
namespace chhcn;

use chhcn;

//$page_title = "用户列表1";
$um = new chhcn\UserManager();
$rs = Database::querySingleLine("users", Array("username" => $_SESSION['user']));

if(!$rs || $rs['group'] !== "admin") {
	exit("<script>location='?page=panel';</script>");
}

// 包含数据库连接文件
require_once '.../../chh.php';
// 初始化变量
$stats = [];
$error = '';

try {
    // 获取总邀请码数量
    $total_query = "SELECT COUNT(*) as total FROM invitecode";
    $total_result = $conn->query($total_query);
    $stats['total'] = $total_result->fetch_assoc()['total'];

    // 获取已使用的邀请码数量
    $used_query = "SELECT COUNT(*) as used FROM invitecode WHERE user IS NOT NULL";
    $used_result = $conn->query($used_query);
    $stats['used'] = $used_result->fetch_assoc()['used'];

    // 计算未使用的邀请码数量
    $stats['unused'] = $stats['total'] - $stats['used'];

    // 获取所有未使用邀请码
    $unused_query = "SELECT * FROM invitecode WHERE user IS NULL ORDER BY code DESC";
    $unused_result = $conn->query($unused_query);
    $stats['unused_list'] = $unused_result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    $error = "操作出错: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>邀请码使用统计</title>
    <style>
        :root {
            --primary-color: #3498db;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --light-color: #f8f9fa;
            --dark-color: #2c3e50;
            --border-color: #e0e0e0;
            --shadow-color: rgba(0,0,0,0.1);
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: var(--light-color);
            color: var(--dark-color);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px var(--shadow-color);
        }
        h1 {
            color: var(--dark-color);
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 3px 10px var(--shadow-color);
            text-align: center;
            transition: all 0.3s ease;
            border-top: 4px solid transparent;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
        .stat-card.total {
            border-top-color: var(--primary-color);
        }
        .stat-card.used {
            border-top-color: var(--success-color);
        }
        .stat-card.unused {
            border-top-color: var(--danger-color);
        }
        .stat-card h3 {
            margin-top: 0;
            color: var(--dark-color);
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
        .stat-value {
            font-size: 2.8rem;
            font-weight: bold;
            margin: 15px 0;
            font-family: 'Arial', sans-serif;
        }
        .stat-card.total .stat-value { color: var(--primary-color); }
        .stat-card.used .stat-value { color: var(--success-color); }
        .stat-card.unused .stat-value { color: var(--danger-color); }
        .stat-card p {
            color: #666;
            margin: 0;
            font-size: 0.95rem;
        }
        .table-container {
            margin-top: 40px;
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px var(--shadow-color);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        th {
            background-color: #f5f7fa;
            color: var(--dark-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        tr:hover {
            background-color: #f8fafc;
        }
        .section-title {
            margin: 50px 0 20px;
            color: var(--dark-color);
            font-size: 1.5rem;
            font-weight: 500;
            position: relative;
            padding-left: 15px;
        }
        .section-title:before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            bottom: 5px;
            width: 4px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }
        .error {
            color: var(--danger-color);
            background-color: #fdecea;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 25px;
            border-left: 4px solid var(--danger-color);
            display: flex;
            align-items: center;
        }
        .error:before {
            content: '!';
            display: inline-block;
            width: 24px;
            height: 24px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            margin-right: 10px;
            font-weight: bold;
        }
        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #95a5a6;
            font-style: italic;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .no-data:before {
            content: '🛈';
            display: block;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            th, td {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        
        
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="stats-grid">
            <div class="stat-card total">
                <h3>总邀请码数量</h3>
                <div class="stat-value"><?= $stats['total'] ?? 0 ?></div>
                <p>系统中所有的邀请码总数</p>
            </div>
            
            <div class="stat-card used">
                <h3>已使用邀请码</h3>
                <div class="stat-value"><?= $stats['used'] ?? 0 ?></div>
                <p>已被用户使用的邀请码数量</p>
            </div>
            
            <div class="stat-card unused">
                <h3>未使用邀请码</h3>
                <div class="stat-value"><?= $stats['unused'] ?? 0 ?></div>
                <p>尚未被使用的可用邀请码数量</p>
            </div>
        </div>
        
        <h2 class="section-title">未使用的邀请码列表</h2>
        <div class="table-container">
            <?php if (!empty($stats['unused_list'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>邀请码</th>
                            <th>状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['unused_list'] as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['code']) ?></td>
                                <td><span style="color: var(--danger-color); font-weight: 500;">未使用</span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">当前没有未使用的邀请码</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>