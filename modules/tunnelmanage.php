<?php
namespace chhcn;

use chhcn;

// 检查是否为管理员
$rs = Database::querySingleLine("users", Array("username" => $_SESSION['user']));
if($rs['group'] != "admin") {
    die('<div class="alert alert-danger">您没有权限访问此页面</div>');
}

// 处理删除隧道请求
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $csrf = $_GET['csrf'] ?? '';
    
    if($csrf != $_SESSION['token']) {
        echo '<div class="alert alert-danger">CSRF 验证失败</div>';
    } else {
        $result = Database::query("proxies", "DELETE FROM proxies WHERE id = $id", "", true);
        if($result) {
            echo '<div class="alert alert-success">隧道删除成功</div>';
        } else {
            echo '<div class="alert alert-danger">隧道删除失败</div>';
        }
    }
}

// 获取搜索参数
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$searchField = isset($_GET['field']) ? $_GET['field'] : 'username';

// 构建查询条件
$whereClause = '';
if(!empty($search)) {
    switch($searchField) {
        case 'username':
            $whereClause = "WHERE p.username LIKE '%$search%'";
            break;
        case 'name':
            $whereClause = "WHERE p.proxy_name LIKE '%$search%'";
            break;
        case 'protocol':
            $whereClause = "WHERE p.proxy_type LIKE '%$search%'";
            break;
        case 'local_port':
            $whereClause = "WHERE p.local_port LIKE '%$search%'";
            break;
        case 'remote_port':
            $whereClause = "WHERE p.remote_port LIKE '%$search%'";
            break;
    }
}

// 分页设置
$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
$perPage = 15;
$offset = ($page - 1) * $perPage;

// 获取总记录数
$countResult = Database::query("proxies", "SELECT COUNT(*) as total FROM proxies p $whereClause", "", true);
$totalRows = 0;
$totalPages = 0;

// 检查查询是否成功
if(is_object($countResult)) {
    $row = mysqli_fetch_assoc($countResult);
    if($row) {
        $totalRows = $row['total'];
        $totalPages = ceil($totalRows / $perPage);
    }
} else {
    echo '<div class="alert alert-danger">查询错误: ' . htmlspecialchars($countResult) . '</div>';
}

// 获取隧道列表
$query = "SELECT p.*, u.email FROM proxies p 
          LEFT JOIN users u ON p.username = u.username 
          $whereClause 
          ORDER BY p.id DESC 
          LIMIT $offset, $perPage";
$result = Database::query("proxies", $query, "", true);

// 检查查询是否成功
if(!is_object($result)) {
    echo '<div class="alert alert-danger">查询错误: ' . htmlspecialchars($result) . '</div>';
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">隧道管理</h3>
    </div>
    <div class="card-body">
        <!-- 搜索表单 -->
        <form method="get" class="mb-4">
            <input type="hidden" name="page" value="panel">
            <input type="hidden" name="module" value="tunnelmanage">
            <div class="row">
                <div class="col-md-3">
                    <select name="field" class="form-control">
                        <option value="username" <?php echo $searchField == 'username' ? 'selected' : ''; ?>>用户名</option>
                        <option value="name" <?php echo $searchField == 'name' ? 'selected' : ''; ?>>隧道名称</option>
                        <option value="protocol" <?php echo $searchField == 'protocol' ? 'selected' : ''; ?>>协议</option>
                        <option value="local_port" <?php echo $searchField == 'local_port' ? 'selected' : ''; ?>>本地端口</option>
                        <option value="remote_port" <?php echo $searchField == 'remote_port' ? 'selected' : ''; ?>>远程端口</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <input type="text" name="search" class="form-control" placeholder="搜索..." value="<?php echo $search; ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">搜索</button>
                </div>
            </div>
        </form>

        <!-- 隧道列表 -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>隧道名称</th>
                        <th>节点</th>
                        <th>协议</th>
                        <th>本地IP</th>
                        <th>本地端口</th>
                        <th>远程端口</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 检查结果是否为有效的mysqli_result对象
                    if(is_object($result) && mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $nodeInfo = Database::querySingleLine("nodes", Array("id" => $row['node']));
                            $nodeName = $nodeInfo ? $nodeInfo['name'] : '未知节点';
                            
                            // 确定状态显示
                            $status = $row['status'] == '0' ? 
                                '<span class="badge badge-success">启用</span>' : 
                                '<span class="badge badge-danger">禁用</span>';
                            
                            echo '<tr>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['proxy_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($nodeName) . '</td>';
                            echo '<td>' . htmlspecialchars($row['proxy_type']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['local_ip']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['local_port']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['remote_port']) . '</td>';
                            echo '<td>' . $status . '</td>';
                            echo '<td>';
                            echo '<div class="btn-group">';
                            echo '<a href="?page=panel&module=tunnelmanage&action=delete&id=' . $row['id'] . '&csrf=' . $_SESSION['token'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'确定要删除此隧道吗？\')">删除</a>';
                            
                            // 切换状态按钮
                            if($row['status'] == '0') {
                                echo '<a href="?page=panel&module=tunnelmanage&action=disable&id=' . $row['id'] . '&csrf=' . $_SESSION['token'] . '" class="btn btn-warning btn-sm">禁用</a>';
                            } else {
                                echo '<a href="?page=panel&module=tunnelmanage&action=enable&id=' . $row['id'] . '&csrf=' . $_SESSION['token'] . '" class="btn btn-success btn-sm">启用</a>';
                            }
                            
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="10" class="text-center">没有找到隧道记录</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- 分页 -->
        <?php if($totalPages > 1): ?>
        <div class="mt-3">
            <ul class="pagination justify-content-center">
                <?php if($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=panel&module=tunnelmanage&p=<?php echo $page-1; ?>&field=<?php echo $searchField; ?>&search=<?php echo $search; ?>">
                        上一页
                    </a>
                </li>
                <?php endif; ?>
                
                <?php
                // 显示页码
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2);
                
                for($i = $startPage; $i <= $endPage; $i++):
                ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=panel&module=tunnelmanage&p=<?php echo $i; ?>&field=<?php echo $searchField; ?>&search=<?php echo $search; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
                <?php endfor; ?>
                
                <?php if($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=panel&module=tunnelmanage&p=<?php echo $page+1; ?>&field=<?php echo $searchField; ?>&search=<?php echo $search; ?>">
                        下一页
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- 添加启用/禁用隧道功能 -->
<?php
if(isset($_GET['action']) && ($_GET['action'] == 'enable' || $_GET['action'] == 'disable') && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $csrf = $_GET['csrf'] ?? '';
    $action = $_GET['action'];
    
    if($csrf != $_SESSION['token']) {
        echo '<script>alert("CSRF 验证失败"); window.location.href="?page=panel&module=tunnelmanage";</script>';
    } else {
        $status = ($action == 'enable') ? '0' : '1';
        $result = Database::query("proxies", "UPDATE proxies SET status = '$status' WHERE id = $id", "", true);
        
        if($result) {
            $actionText = ($action == 'enable') ? '启用' : '禁用';
            echo '<script>alert("隧道' . $actionText . '成功"); window.location.href="?page=panel&module=tunnelmanage";</script>';
        } else {
            echo '<script>alert("操作失败"); window.location.href="?page=panel&module=tunnelmanage";</script>';
        }
    }
}
?> 