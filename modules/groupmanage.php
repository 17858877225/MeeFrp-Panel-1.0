<?php
namespace chhcn;

use chhcn;

// 用户组管理模块
$rs = Database::querySingleLine("users", Array("username" => $_SESSION['user']));

// 检查是否为管理员
if(!$rs || $rs['group'] !== "admin") {
    exit("<script>location='?page=panel';</script>");
}

// 处理添加用户组
if(isset($_GET['action']) && $_GET['action'] === 'add') {
    // 添加调试信息
    error_log("处理添加用户组请求: " . print_r($_POST, true));
    
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
        Database::insert("groups", [
            'name' => $name,
            'friendly_name' => $friendly_name,
            'traffic' => $traffic,
            'proxies' => $proxies,
            'inbound' => $inbound,
            'outbound' => $outbound
        ]);
        
        exit("<script>alert('用户组添加成功'); location='?page=panel&module=groupmanage';</script>");
    }
    // 使用正确的路径包含页面
    include(dirname(dirname(__FILE__)) . "/pages/addgroup.php");
    exit;
}

// 处理编辑用户组
if(isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $group = Database::querySingleLine("groups", Array("id" => $id));
    
    if(!$group) {
        exit("<script>alert('用户组不存在'); location='?page=panel&module=groupmanage';</script>");
    }
    
    if(isset($_POST['edit'])) {
        $friendly_name = $_POST['friendly_name'];
        $traffic = $_POST['traffic'];
        $proxies = $_POST['proxies'];
        $inbound = $_POST['inbound'];
        $outbound = $_POST['outbound'];
        
        // 更新用户组
        Database::update("groups", [
            'friendly_name' => $friendly_name,
            'traffic' => $traffic,
            'proxies' => $proxies,
            'inbound' => $inbound,
            'outbound' => $outbound
        ], "`id` = ?", [$id]);
        
        exit("<script>alert('用户组更新成功'); location='?page=panel&module=groupmanage';</script>");
    }
    
    include(dirname(dirname(__FILE__)) . "/pages/editgroup.php");
    exit;
}

// 处理删除用户组
if(isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // 获取用户组名称
    $group = Database::querySingleLine("groups", Array("id" => $id));
    if(!$group) {
        exit("<script>alert('用户组不存在'); location='?page=panel&module=groupmanage';</script>");
    }
    
    // 检查是否有用户使用该组
    $users = Database::toArray(Database::search("users", Array("group" => $group['name'])));
    if(count($users) > 0) {
        exit("<script>alert('该用户组下有用户，无法删除'); location='?page=panel&module=groupmanage';</script>");
    }
    
    // 删除用户组
    Database::delete("groups", "`id` = ?", [$id]);
    
    exit("<script>alert('用户组删除成功'); location='?page=panel&module=groupmanage';</script>");
}

// 处理设置用户组流量
if(isset($_GET['action']) && $_GET['action'] === 'setTraffic' && isset($_GET['group'])) {
    $group_name = $_GET['group'];
    $group = Database::querySingleLine("groups", Array("name" => $group_name));
    
    if(!$group) {
        exit("<script>alert('用户组不存在'); location='?page=panel&module=groupmanage';</script>");
    }
    
    if(isset($_POST['set_traffic'])) {
        $traffic = $_POST['traffic'];
        
        // 更新指定用户组所有用户的流量
        Database::query("users", "UPDATE `users` SET `traffic` = ? WHERE `group` = ?", true, [$traffic, $group_name]);
        
        exit("<script>alert('用户组流量设置成功'); location='?page=panel&module=groupmanage';</script>");
    }
    
    include(dirname(dirname(__FILE__)) . "/pages/setgrouptraffic.php");
    exit;
}

// 显示用户组列表
$groups = Database::toArray(Database::query("groups", "SELECT * FROM `groups`", true));
include(dirname(dirname(__FILE__)) . "/pages/groupmanage.php"); 