<?php
/**
 * 用户组管理页面
 */
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">用户组管理</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=panel&module=home">首页</a></li>
                    <li class="breadcrumb-item active">用户组管理</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">用户组列表</h3>
                        <div class="card-tools">
                            <a href="?page=panel&module=groupmanage&action=add" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> 添加用户组
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>组名</th>
                                    <th>显示名称</th>
                                    <th>流量上限(MB)</th>
                                    <th>代理数量上限</th>
                                    <th>入站带宽(KB/s)</th>
                                    <th>出站带宽(KB/s)</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($groups as $group): ?>
                                <tr>
                                    <td><?php echo $group[0]; ?></td>
                                    <td><?php echo $group[1]; ?></td>
                                    <td><?php echo $group[2]; ?></td>
                                    <td><?php echo $group[3]; ?></td>
                                    <td><?php echo $group[4]; ?></td>
                                    <td><?php echo $group[5]; ?></td>
                                    <td><?php echo $group[6]; ?></td>
                                    <td>
                                        <a href="?page=panel&module=groupmanage&action=edit&id=<?php echo $group[0]; ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> 编辑
                                        </a>
                                        <a href="?page=panel&module=groupmanage&action=setTraffic&group=<?php echo $group[1]; ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-tachometer-alt"></i> 设置流量
                                        </a>
                                        <a href="?page=panel&module=groupmanage&action=delete&id=<?php echo $group[0]; ?>" class="btn btn-sm btn-danger" onclick="return confirm('确定要删除该用户组吗？');">
                                            <i class="fas fa-trash"></i> 删除
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 