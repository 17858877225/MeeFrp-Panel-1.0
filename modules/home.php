<?php
namespace chhcn;

use chhcn;

include(ROOT . "/core/Parsedown.php");

$markdown = new Parsedown();
$markdown->setSafeMode(true);
$markdown->setBreaksEnabled(true);
$markdown->setUrlsLinked(true);
//$page_title = "管理面板";
$rs = Database::querySingleLine("users", Array("username" => $_SESSION['user']));

if(!$rs) {
	exit("<script>location='?page=login';</script>");
}

$um = new chhcn\UserManager();
$ls = $um->getLimit($_SESSION['user']);
$inbound = round($ls['inbound'] / 1024 * 8);
$outbound = round($ls['outbound'] / 1024 * 8);
$speed_limit = "{$inbound}Mbps 上行 / {$outbound}Mbps 下行";
$traffic = $rs['traffic'] - round($um->getTodayTraffic($_SESSION['user']) / 1024 / 1024);
if($traffic < 0) {
	$traffic = 0;
}

// 获取用户密钥
$token = Database::querySingleLine("tokens", Array("username" => $_SESSION['user']))["token"] ?? "未知";

// 获取可用节点列表
$nodes = Database::toArray(Database::search("nodes", Array("group" => "{$rs['group']};", "status" => "200")));
?>
<style type="text/css">
.fix-text p {
	margin-bottom: 4px;
}
.fix-text pre {
	background: rgba(0,0,0,0.05);
	border-radius: 4px;
}
.fix-image img {
	max-width: 100%;
}
</style>

</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">用户信息</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class='text-primary'><?php echo htmlspecialchars($_SESSION['user']); ?></h3>
						<table style="width: 100%;font-size: 15px;margin-bottom: 16px;">
							<tr>
								<td style="width: 30%;"><b>注册邮箱</b></td>
								<td><?php echo htmlspecialchars($_SESSION['mail']); ?></td>
							</tr>
							<tr>
								<td style="width: 30%;"><b>注册时间</b></td>
								<td><?php echo date("Y-m-d", $rs['regtime']); ?></td>
							</tr>
							<tr>
								<td style="width: 30%;"><b>剩余流量</b></td>
								<td><?php echo htmlspecialchars(round($traffic / 1024, 2)); ?> GB</td>
							</tr>
							<tr>
								<td style="width: 30%;"><b>隧道数量</b></td>
								<td><?php echo htmlspecialchars($rs['proxies']); ?> 条</td>
							</tr>
							<tr>
								<td style="width: 30%;"><b>宽带速率</b></td>
								<td><?php echo htmlspecialchars($speed_limit); ?></td>
							</tr>
							<tr>
								<td style="width: 30%;"><b>访问密钥</b></td>
								<td><?php echo htmlspecialchars($token); ?></td>
							</tr>
						</table>
						<span>您可以通过每日签到获取免费流量</span>
                    </div>
                </div>
			</div>
			<div class="col-lg-8">
				<div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">可用节点</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">名称</th>
                                    <th class="text-center">IP地址</th>
                                    <th class="text-center">端口</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($nodes) > 0) {
                                    foreach ($nodes as $node) {
                                        echo "<tr>
                                            <td class='text-center'>{$node[0]}</td>
                                            <td class='text-center'>{$node[1]}</td>
                                            <td class='text-center'>{$node[4]}</td>
                                            <td class='text-center'>{$node[5]}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>暂无可用节点</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
				<div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">站点公告</h3>
                        </div>
                    </div>
                    <div class="card-body fix-text fix-image">
						<?php echo $markdown->text(Settings::get("broadcast", "暂时没有公告信息")); ?>
                    </div>
                </div>
				<div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">使用帮助</h3>
                        </div>
                    </div>
                    <div class="card-body fix-text fix-image">
						<?php echo $markdown->text(Settings::get("helpinfo", "暂时没有帮助信息")); ?>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>