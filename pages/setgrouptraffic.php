<?php
/**
 * 设置用户组流量页面
 */
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">设置用户组流量</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=panel&module=home">首页</a></li>
                    <li class="breadcrumb-item"><a href="?page=panel&module=groupmanage">用户组管理</a></li>
                    <li class="breadcrumb-item active">设置用户组流量</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">批量设置 "<?php echo $group['friendly_name']; ?>" 用户组的流量</h3>
                    </div>
                    <form method="post">
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <h5><i class="icon fas fa-exclamation-triangle"></i> 警告!</h5>
                                此操作将会修改该用户组下<strong>所有用户</strong>的流量值，请谨慎操作。
                            </div>
                            <div class="form-group">
                                <label for="traffic">流量值（MB）</label>
                                <input type="number" class="form-control" id="traffic" name="traffic" value="<?php echo $group['traffic']; ?>" placeholder="请输入要设置的流量值" required>
                                <small class="form-text text-muted">此流量值将应用到该用户组下的所有用户，单位为MB</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="set_traffic" class="btn btn-warning">设置流量</button>
                            <a href="?page=panel&module=groupmanage" class="btn btn-default">返回</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 