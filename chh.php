<?php
$db_host = 'localhost';
$db_user = ''; // 根据实际情况修改
$db_pass = ''; // 根据实际情况修改
$db_name = ''; // 根据您的数据库名修改

// 创建数据库连接
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// 检查连接
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 设置字符集
$conn->set_charset("utf8mb4");
?>