<?php
/**
 * 编辑用户组页面
 */
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">编辑用户组</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=panel&module=home">首页</a></li>
                    <li class="breadcrumb-item"><a href="?page=panel&module=groupmanage">用户组管理</a></li>
                    <li class="breadcrumb-item active">编辑用户组</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">编辑用户组 - <?php echo $group['friendly_name']; ?></h3>
                    </div>
                    <form method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">组名</label>
                                <input type="text" class="form-control" id="name" value="<?php echo $group['name']; ?>" disabled>
                                <small class="form-text text-muted">用户组名称不能修改</small>
                            </div>
                            <div class="form-group">
                                <label for="friendly_name">显示名称</label>
                                <input type="text" class="form-control" id="friendly_name" name="friendly_name" value="<?php echo $group['friendly_name']; ?>" placeholder="请输入用户组显示名称" required>
                                <small class="form-text text-muted">用户组显示名称将在前台显示给用户</small>
                            </div>
                            <div class="form-group">
                                <label for="traffic">流量上限（MB）</label>
                                <input type="number" class="form-control" id="traffic" name="traffic" value="<?php echo $group['traffic']; ?>" placeholder="请输入用户组流量上限" required>
                                <small class="form-text text-muted">此用户组的流量上限，单位为MB</small>
                            </div>
                            <div class="form-group">
                                <label for="proxies">代理数量上限</label>
                                <input type="number" class="form-control" id="proxies" name="proxies" value="<?php echo $group['proxies']; ?>" placeholder="请输入用户组代理数量上限" required>
                                <small class="form-text text-muted">此用户组可创建的代理数量上限</small>
                            </div>
                            <div class="form-group">
                                <label for="inbound">入站带宽（KB/s）</label>
                                <input type="number" class="form-control" id="inbound" name="inbound" value="<?php echo $group['inbound']; ?>" placeholder="请输入用户组入站带宽限制" required>
                                <small class="form-text text-muted">此用户组的入站带宽限制，单位为KB/s</small>
                            </div>
                            <div class="form-group">
                                <label for="outbound">出站带宽（KB/s）</label>
                                <input type="number" class="form-control" id="outbound" name="outbound" value="<?php echo $group['outbound']; ?>" placeholder="请输入用户组出站带宽限制" required>
                                <small class="form-text text-muted">此用户组的出站带宽限制，单位为KB/s</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="edit" class="btn btn-info">更新</button>
                            <a href="?page=panel&module=groupmanage" class="btn btn-default">返回</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 