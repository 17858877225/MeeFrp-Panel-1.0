<?php
namespace chhcn;

use chhcn;

// 检查是否为管理员
$rs = Database::querySingleLine("users", Array("username" => $_SESSION['user']));
if(!$rs || $rs['group'] !== "admin") {
    exit("<script>location='?page=panel';</script>");
}

// 处理添加用户组
if(isset($_POST['add'])) {
    $name = $_POST['name'];
    $friendly_name = $_POST['friendly_name'];
    $traffic = $_POST['traffic'];
    $proxies = $_POST['proxies'];
    $inbound = $_POST['inbound'];
    $outbound = $_POST['outbound'];
    
    // 检查组名是否已存在
    $check = Database::querySingleLine("groups", Array("name" => $name));
    if($check) {
        exit("<script>alert('该用户组名称已存在'); history.back();</script>");
    }
    
    // 添加用户组
    $result = Database::insert("groups", [
        'name' => $name,
        'friendly_name' => $friendly_name,
        'traffic' => $traffic,
        'proxies' => $proxies,
        'inbound' => $inbound,
        'outbound' => $outbound
    ]);
    
    if($result === true) {
        exit("<script>alert('用户组添加成功'); location='?page=panel&module=groupmanage';</script>");
    } else {
        exit("<script>alert('用户组添加失败: " . htmlspecialchars($result) . "'); history.back();</script>");
    }
} else {
    // 如果没有提交表单，重定向到用户组管理页面
    exit("<script>location='?page=panel&module=groupmanage';</script>");
}
?> 