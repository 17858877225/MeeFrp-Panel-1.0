<!-- Copyright © 2021 - 2025 ChmlFrp All rights reserved. -->
<!-- Apache-2.0 License - https://github.com/TechCat-Team/ChmlFrp-Frontend -->
<!doctype html>
<html lang="zh-Hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XunFrp | 讯联映射 - 免费,高速,稳定,不限流量的端口映射工具。</title>
    <meta name="description"
        content="XunFrp是一款不限流量,免费高速且稳定的端口映射工具.为您提供免费的内网穿透功能。可以用于MC联机，远程桌面，远程共享，游戏联机等任何需要用到公网IP的地方。">
    <meta name="keywords" content="免费高速内网穿透工具,XunFrp,内网穿透,免费frp,免费内网穿透,frp,端口映射,不限流量的映射">
    <link rel="icon" href="favicon.ico">
    <!-- TailwindCSS -->
    <link href="https://www.ChmlFrp.cn/css/output.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://www.ChmlFrp.cn/css/index.css" rel="stylesheet">
    <script src="https://www.ChmlFrp.cn/js/index.js"></script>
    
    <?php
    // 定义根目录
    if (!defined('ROOT')) {
        define('ROOT', dirname(__DIR__));
    }
    
    // 包含配置文件
    require_once(ROOT . "/configuration.php");
    
    // 获取数据库统计信息
    require_once(ROOT . "/core/Database.php");
    
    // 使用命名空间
    use chhcn\Database;
    
    // 初始化数据库连接
    $conn = null;
    $db = new \chhcn\Database();
    
    // 获取用户总数
    $user_result = Database::query("users", "SELECT COUNT(*) as count FROM users", "", true);
    $user_row = mysqli_fetch_assoc($user_result);
    $user_amount = $user_row['count'];
    
    // 获取隧道总数
    $tunnel_result = Database::query("proxies", "SELECT COUNT(*) as count FROM proxies", "", true);
    $tunnel_row = mysqli_fetch_assoc($tunnel_result);
    $tunnel_amount = $tunnel_row['count'];
    
    // 获取节点总数
    $node_result = Database::query("nodes", "SELECT COUNT(*) as count FROM nodes", "", true);
    $node_row = mysqli_fetch_assoc($node_result);
    $node_amount = $node_row['count'];
    ?>
</head>

<body class="overflow-x-hidden">
    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="#" class="-m-1.5 p-1.5 hover-scale">
                        <span class="sr-only">XunFrp</span>
                        <img class="h-8 w-auto float-animation" src="favicon.ico" alt="XunFrpLogo">
                    </a>
                </div>
                <div class="flex lg:hidden">
                    <button id="menuButton" onclick="toggleMenu()" type="button"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 hover:bg-gray-100 transition-colors duration-300">
                        <span class="sr-only">打开菜单</span>
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="#home"
                        class="text-sm/6 font-semibold text-gray-900 hover:text-indigo-600 transition-colors duration-300">首页</a>
                    <a href="#info"
                        class="text-sm/6 font-semibold text-gray-900 hover:text-indigo-600 transition-colors duration-300">介绍</a>
                    <a href="#features"
                        class="text-sm/6 font-semibold text-gray-900 hover:text-indigo-600 transition-colors duration-300">特色</a>
                    <a href="#dingjia"
                        class="text-sm/6 font-semibold text-gray-900 hover:text-indigo-600 transition-colors duration-300">定价</a>
                    <a href="#about"
                        class="text-sm/6 font-semibold text-gray-900 hover:text-indigo-600 transition-colors duration-300">关于</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="/?page=login"
                        class="text-sm/6 font-semibold text-gray-900 hover:text-indigo-600 transition-colors duration-300 group">
                        立即使用 <span class="inline-block group-hover:translate-x-1 transition-transform duration-300"
                            aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </nav>

            <!-- 手机版菜单 -->
            <div id="mobileMenu"
                class="lg:hidden fixed inset-0 z-50 transform translate-x-full transition-transform duration-300"
                data-state="closed">
                <div id="backdrop"
                    class="fixed inset-0 z-40 bg-gray-800 opacity-0 hidden transition-opacity duration-300"></div>
                <div
                    class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <a href="#" class="-m-1.5 p-1.5">
                            <span class="sr-only">XunFrp</span>
                            <img class="h-8 w-auto" src="favicon.ico" alt="XunFrpLogo">
                        </a>
                        <button onclick="toggleMenu()" type="button"
                            class="-m-2.5 rounded-md p-2.5 text-gray-700 hover:bg-gray-100 transition-colors duration-300">
                            <span class="sr-only">关闭菜单</span>
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <a href="#home"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 transition-colors duration-300">首页</a>
                                <a href="#info"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 transition-colors duration-300">介绍</a>
                                <a href="#features"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 transition-colors duration-300">特色</a>
                                <a href="#dingjia"
                                    class="text-sm/6 font-semibold text-gray-900 hover:text-indigo-600 transition-colors duration-300">特色</a>
                                <a href="#about"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 transition-colors duration-300">关于</a>
                            </div>
                            <div class="py-6">
                                <a href="https://panel.ChmlFrp.cn"
                                    class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 transition-colors duration-300">立即使用</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="relative isolate px-6 lg:px-8" id="home">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
            <div class="mx-auto mt-28 max-w-2xl py-32 sm:py-24 lg:py-24">
                <div class="hidden sm:mb-8 sm:flex sm:justify-center" data-aos="fade-down">
                    <div
                        class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20 transition-all duration-300 hover:shadow-md">
                        XunFrp Panel Version 3.x.x
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl animate__animated animate__fadeInUp"
                        data-aos="fade-up">
                        <span class="text-gradient">XunFrp</span> | 讯联映射
                    </h1>
                    <p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8 animate__animated animate__fadeInUp animate__delay-1s"
                        data-aos="fade-up" data-aos-delay="100">
                        完全重构，全面升级！免费.高速.稳定.不限流量的端口映射工具
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6 animate__animated animate__fadeInUp animate__delay-2s"
                        data-aos="fade-up" data-aos-delay="200">
                        <a href="/?page=panel"
                            class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors duration-300 btn-pulse">
                            管理面板</a>
                        <a href="https://docs.chcat.cn/docs/ChmlFrp/%E4%BD%BF%E7%94%A8%E6%96%87%E6%A1%A3/tutorial"
                            class="text-sm/6 font-semibold text-gray-900 group hover:text-indigo-600 transition-colors duration-300">
                            使用文档 <span class="inline-block group-hover:translate-x-1 transition-transform duration-300"
                                aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- 新增产品图 -->
            <div class="text-center" data-aos="zoom-in" data-aos-delay="300">
                <img src="/演示.png" alt="产品图"
                    class="mx-auto rounded-2xl shadow-2xl max-w-[1200px] w-[92vw] hover-scale transition-transform duration-500">
            </div>
            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
                aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
        </div>
    </div>

    <!-- 数据统计面板 -->
    <div class="py-24 sm:py-32" data-aos="fade-up">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="mt-6 text-lg leading-8 text-gray-600">数以万计用户的选择</p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-3">
                <!-- 总用户数 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover-scale transition-all duration-300"
                    data-aos="zoom-in" data-aos-delay="100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-lg bg-indigo-100 p-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">总用户数</p>
                            <p class="text-3xl font-bold text-gray-900"><?php echo $user_amount; ?></p>
                        </div>
                    </div>
                </div>

                <!-- 总隧道数 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover-scale transition-all duration-300"
                    data-aos="zoom-in" data-aos-delay="200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-lg bg-indigo-100 p-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">总隧道数</p>
                            <p class="text-3xl font-bold text-gray-900"><?php echo $tunnel_amount; ?></p>
                        </div>
                    </div>
                </div>

                <!-- 总节点数 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover-scale transition-all duration-300"
                    data-aos="zoom-in" data-aos-delay="300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-lg bg-indigo-100 p-3 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.25 14.25h13.5m-13.5 0a3 3 0 0 1-3-3m3 3a3 3 0 1 0 0 6h13.5a3 3 0 1 0 0-6m-16.5-3a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3m-19.5 0a4.5 4.5 0 0 1 .9-2.7L5.737 5.1a3.375 3.375 0 0 1 2.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 0 1 .9 2.7m0 0a3 3 0 0 1-3 3m0 3h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Zm-3 6h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">总节点数</p>
                            <p class="text-3xl font-bold text-gray-900"><?php echo $node_amount; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- 它可以干什么 -->
    <div class="container px-5 py-24 mx-auto flex flex-wrap" id="info">
        <div class="flex w-full mb-20 flex-wrap" data-aos="fade-up">
            <h1
                class="sm:text-3xl text-2xl font-medium title-font text-gray-900 lg:w-1/3 lg:mb-0 mb-4 animate__animated animate__fadeInLeft">
                为什么您需要端口映射？
            </h1>
            <p class="lg:pl-6 lg:w-2/3 mx-auto leading-relaxed text-base animate__animated animate__fadeInRight">
                游戏联机、远程桌面、建站、远程共享、文件传输、nas异地访问、远程控制智能家居、远程访问家里的路由器、自建游戏语音服务器等超多应用场景！无需公网IP、无需服务器、使用XunFrp将您的项目映射到公网！
            </p>
        </div>
        <div class="flex flex-wrap md:-m-2 -m-1">
            <!-- 第一列图片 -->
            <div class="flex flex-wrap w-1/2">
                <div class="md:p-2 p-1 w-1/2" data-aos="fade-up" data-aos-delay="50">
                    <img alt="个人建站"
                        class="w-full object-cover h-full object-center block hover:scale-105 transition-transform duration-500 rounded-lg shadow-md"
                        src="https://www.ChmlFrp.cn/images/web.webp">
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50 rounded-lg">
                        <span class="text-white font-semibold">个人建站</span>
                    </div>
                </div>
                <div class="md:p-2 p-1 w-1/2" data-aos="fade-up" data-aos-delay="100">
                    <img alt="远程桌面"
                        class="w-full object-cover h-full object-center block hover:scale-105 transition-transform duration-500 rounded-lg shadow-md"
                        src="https://www.ChmlFrp.cn/images/rdp.webp">
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50 rounded-lg">
                        <span class="text-white font-semibold">远程桌面</span>
                    </div>
                </div>
                <div class="md:p-2 p-1 w-full" data-aos="fade-up" data-aos-delay="150">
                    <img alt="游戏联机"
                        class="w-full h-full object-cover object-center block hover:scale-105 transition-transform duration-500 rounded-lg shadow-md"
                        src="https://www.ChmlFrp.cn/images/mc.webp">
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50 rounded-lg">
                        <span class="text-white font-semibold">游戏联机</span>
                    </div>
                </div>
            </div>

            <!-- 第二列图片 -->
            <div class="flex flex-wrap w-1/2">
                <div class="md:p-2 p-1 w-full" data-aos="fade-up" data-aos-delay="50">
                    <img alt="NAS访问"
                        class="w-full h-full object-cover object-center block hover:scale-105 transition-transform duration-500 rounded-lg shadow-md"
                        src="https://www.ChmlFrp.cn/images/nas.webp">
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50 rounded-lg">
                        <span class="text-white font-semibold">NAS访问</span>
                    </div>
                </div>
                <div class="md:p-2 p-1 w-1/2" data-aos="fade-up" data-aos-delay="100">
                    <img alt="SSH"
                        class="w-full object-cover h-full object-center block hover:scale-105 transition-transform duration-500 rounded-lg shadow-md"
                        src="https://www.ChmlFrp.cn/images/ssh.webp">
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50 rounded-lg">
                        <span class="text-white font-semibold">SSH</span>
                    </div>
                </div>
                <div class="md:p-2 p-1 w-1/2" data-aos="fade-up" data-aos-delay="150">
                    <img alt="游戏语音"
                        class="w-full object-cover h-full object-center block hover:scale-105 transition-transform duration-500 rounded-lg shadow-md"
                        src="https://www.ChmlFrp.cn/images/ts.webp">
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300 bg-black bg-opacity-50 rounded-lg">
                        <span class="text-white font-semibold">游戏语音</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 特色功能部分 -->
    <div class="py-24 sm:py-32" data-aos="fade-up" id="features">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">我们的特色功能</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">XunFrp 提供了一系列强大的功能，满足您的各种内网穿透需求</p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- 功能卡片1 - 不限流量 -->
                <div class="bg-gray-50 p-6 rounded-xl hover-scale transition-all duration-300" data-aos="fade-up"
                    data-aos-delay="100">
                    <div
                        class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">不限流量</h3>
                    <p class="text-gray-600">免费且不限流量使用，无需担心流量耗尽问题，让您的应用持续在线。</p>
                </div>

                <!-- 功能卡片2 - 高速稳定 -->
                <div class="bg-gray-50 p-6 rounded-xl hover-scale transition-all duration-300" data-aos="fade-up"
                    data-aos-delay="200">
                    <div
                        class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061A1.125 1.125 0 0 1 3 16.811V8.69ZM12.75 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061a1.125 1.125 0 0 1-1.683-.977V8.69Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">高速稳定</h3>
                    <p class="text-gray-600">采用高性能服务器节点，提供低延迟、高带宽的连接体验，确保您的服务稳定运行。</p>
                </div>

                <!-- 功能卡片3 - 安全可靠 -->
                <div class="bg-gray-50 p-6 rounded-xl hover-scale transition-all duration-300" data-aos="fade-up"
                    data-aos-delay="300">
                    <div
                        class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">安全可靠</h3>
                    <p class="text-gray-600">采用先进的加密技术保护您的数据传输安全，确保隐私不被泄露。</p>
                </div>

                <!-- 功能卡片4 - 免费域名 -->
                <div class="bg-gray-50 p-6 rounded-xl hover-scale transition-all duration-300" data-aos="fade-up"
                    data-aos-delay="400">
                    <div
                        class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">免费域名</h3>
                    <p class="text-gray-600">为所有用户提供免费、可自定义的三级域名，无需自己购买域名即可快速访问您的服务。</p>
                </div>

                <!-- 功能卡片5 - 控制面板 -->
                <div class="bg-gray-50 p-6 rounded-xl hover-scale transition-all duration-300" data-aos="fade-up"
                    data-aos-delay="500">
                    <div
                        class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">清爽无广</h3>
                    <p class="text-gray-600">完全无广告的清爽体验，采用naiveui开发的控制面板，功能强大，简约美观</p>
                </div>

                <!-- 功能卡片6 - 开放API及第三方生态 -->
                <div class="bg-gray-50 p-6 rounded-xl hover-scale transition-all duration-300" data-aos="fade-up"
                    data-aos-delay="600">
                    <div
                        class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">开放API</h3>
                    <p class="text-gray-600">提供完整的API接口，支持开发者进行二次开发，轻松集成到您的自动化工作流中。</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 使用步骤部分 -->
    <div class="bg-gray-50 py-24 sm:py-32" data-aos="fade-up">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">简单三步，快速开始</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">只需几分钟，您就可以将本地服务暴露到公网</p>
            </div>
            <div class="mt-16 flow-root">
                <div class="-my-8 divide-y divide-gray-200">
                    <!-- 步骤1 -->
                    <div class="py-8 sm:flex" data-aos="fade-right">
                        <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-6">
                            <span
                                class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-600 text-white text-xl font-bold">1</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">下载客户端</h3>
                            <p class="mt-2 text-gray-600">从我们的官网下载适合您操作系统的客户端程序，支持Windows、macOS、Linux和freeBSD等多种平台。</p>
                            <div class="mt-4">
                                <a href="https://panel.ChmlFrp.cn/tunnel/download"
                                    class="text-indigo-600 hover:text-indigo-500 font-medium inline-flex items-center transition-colors duration-300">
                                    下载客户端
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 步骤2 -->
                    <div class="py-8 sm:flex" data-aos="fade-right" data-aos-delay="100">
                        <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-6">
                            <span
                                class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-600 text-white text-xl font-bold">2</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">创建隧道</h3>
                            <p class="mt-2 text-gray-600">登录管理面板，创建新的隧道配置，填写您的本地服务地址和端口，选择合适的中转节点。</p>
                            <div class="mt-4">
                                <a href="https://panel.ChmlFrp.cn"
                                    class="text-indigo-600 hover:text-indigo-500 font-medium inline-flex items-center transition-colors duration-300">
                                    前往管理面板
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 步骤3 -->
                    <div class="py-8 sm:flex" data-aos="fade-right" data-aos-delay="200">
                        <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-6">
                            <span
                                class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-600 text-white text-xl font-bold">3</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">启动服务</h3>
                            <p class="mt-2 text-gray-600">获取配置文件并填写，再启动Frp软件，您的本地服务现在可以通过公网访问了！</p>
                            <div class="mt-4">
                                <a href="https://docs.chcat.cn/docs/ChmlFrp/%E4%BD%BF%E7%94%A8%E6%96%87%E6%A1%A3/tutorial"
                                    class="text-indigo-600 hover:text-indigo-500 font-medium inline-flex items-center transition-colors duration-300">
                                    查看详细文档
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 常见问题部分 -->
    <div class="py-24 sm:py-32" data-aos="fade-up">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">常见问题</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">以下是一些用户常问的问题，如果找不到您需要的答案，请前往文档或联系我们。</p>
            </div>
            <div class="mt-16 space-y-8">
                <!-- 问题1 -->
                <div class="bg-gray-50 p-6 rounded-xl hover-scale transition-all duration-300" data-aos="fade-up"
                    data-aos-delay="100">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer">
                            <h3 class="text-lg font-semibold text-gray-900">XunFrp是免费的吗？</h3>
                            <span class="ml-2 text-indigo-600 group-open:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </span>
                            <span class="ml-2 text-indigo-600 hidden group-open:inline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-4 text-gray-600">
                            <p>XunFrp基础班是完全免费的，我们不收取任何费用，也不限制流量使用。免费版已经足够大多数场景使用，如果有更高的需求，我们还提供了付费计划，可以提供更好、更快、更稳定的内网穿透。
                            </p>
                        </div>
                    </details>
                </div>

                <!-- 问题2 -->
                <div class="bg-gray-50 p-6 rounded-xl hover-scale transition-all duration-300" data-aos="fade-up"
                    data-aos-delay="150">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer">
                            <h3 class="text-lg font-semibold text-gray-900">支持哪些操作系统？</h3>
                            <span class="ml-2 text-indigo-600 group-open:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </span>
                            <span class="ml-2 text-indigo-600 hidden group-open:inline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-4 text-gray-600">
                            <p>XunFrp客户端支持多种操作系统，包括：</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1">
                                <li>Windows 7/8/10/11 (32位和64位)</li>
                                <li>macOS 10.13及以上版本</li>
                                <li>Linux (包括Debian、Ubuntu、CentOS等主流发行版)</li>
                                <li>ARM架构设备 (如树莓派、手机)</li>
                                <li>freeBSD</li>
                            </ul>
                        </div>
                    </details>
                </div>

                <!-- 问题3 -->
                <div class="bg-gray-50 p-6 rounded-xl hover-scale transition-all duration-300" data-aos="fade-up"
                    data-aos-delay="200">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer">
                            <h3 class="text-lg font-semibold text-gray-900">XunFrp安全吗？</h3>
                            <span class="ml-2 text-indigo-600 group-open:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </span>
                            <span class="ml-2 text-indigo-600 hidden group-open:inline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-4 text-gray-600">
                            <p>我们采取了多种措施来确保服务的安全性：</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1">
                                <p>网站数据安全措施：</p>
                                <ul class="list-disc pl-5 mt-2 space-y-1">
                                    <li>所有用户数据均储存于阿里云RDS上海数据中心</li>
                                    <li>用户重要数据采用行业标准加密储存</li>
                                    <li>所有数据传输都使用TLS加密</li>
                                    <li>随时的安全审计和漏洞修复</li>
                                    <li>WAF安全防火墙时刻待命</li>
                                </ul>
                                <p class="mt-2">映射隧道安全措施：</p>
                                <ul class="list-disc pl-5 mt-2 space-y-1">
                                    <li>不定期的安全审计和漏洞修复</li>
                                    <li>禁止有违规行为的黑名单IP</li>
                                    <li>基础的可疑行为防护</li>
                                    <li>可选的全部流量数据加密</li>
                                </ul>
                            </ul>
                            <p class="mt-2">
                                尽管如此，我们仍建议您不要在公网暴露敏感服务，或确保这些服务本身有足够的安全措施。我们并不能完全避免黑客攻击，请一定要做好足够的安全措施，例如设置高难度密码、使用WAF、时刻运行安全软件等。
                            </p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>

    <!-- 定价部分 -->
    <div class="py-24 sm:py-32" data-aos="fade-up" id="dingjia">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">定价</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">灵活多样的套餐选择，从免费到高级，总有一款适合您的需求</p>
            </div>
            
            <div class="mt-16 grid grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
                <?php
                // 获取套餐信息
                $groups_result = Database::query("groups", "SELECT * FROM groups ORDER BY id ASC", "", true);
                $groups = Database::toArray($groups_result);
                
                // 定义套餐对应的速率
                $speeds = [
                    1 => "8Mbps",
                    2 => "16Mbps",
                    3 => "24Mbps",
                    4 => "32Mbps",
                    5 => "32Mbps"
                ];
                
                // 定义套餐价格
                $prices = [
                    1 => "¥0",
                    2 => "¥8",
                    3 => "¥12",
                    4 => "¥18",
                    5 => "¥18"
                ];
                
                // 定义套餐周期
                $cycles = [
                    1 => "/永久",
                    2 => "/永久",
                    3 => "/永久",
                    4 => "/永久",
                    5 => "/永久"
                ];
                
                // 定义套餐按钮文本
                $buttons = [
                    1 => "开始使用",
                    2 => "升级套餐",
                    3 => "升级套餐",
                    4 => "升级套餐",
                    5 => "升级套餐"
                ];
                
                // 定义套餐按钮样式
                $button_styles = [
                    1 => "bg-gray-100 hover:bg-gray-200 text-gray-800",
                    2 => "bg-blue-100 hover:bg-blue-200 text-blue-800",
                    3 => "bg-indigo-600 hover:bg-indigo-500 text-white",
                    4 => "bg-gray-900 hover:bg-gray-800 text-white",
                    5 => "bg-gray-900 hover:bg-gray-800 text-white"
                ];
                
                // 定义套餐特性
                $features = [
                    1 => ["适合临时个人项目", "不限流量", "4条隧道", "1条免费域名"],
                    2 => ["适合网站、ssh、远程访问等服务", "不限流量", "8条隧道", "4条免费域名", "会员节点优先"],
                    3 => ["适合游戏机、团队共享等服务", "不限流量", "12条隧道", "8条免费域名", "会员节点优先", "官方技术支持"],
                    4 => ["适合文件传输等高带宽场景", "不限流量", "16条隧道", "16条免费域名", "会员节点优先", "官方技术支持"],
                    5 => ["适合文件传输等高带宽场景", "不限流量", "100条隧道", "100条免费域名", "会员节点优先", "官方技术支持"]
                ];
                
                foreach ($groups as $index => $group) {
                    $id = $group[0];
                    $name = $group[1];
                    $friendly_name = $group[2];
                    $traffic = round($group[3] / 1024, 0); // 转换为GB
                    $proxies = $group[4];
                    $inbound = $group[5];
                    $outbound = $group[6];
                    
                    // 推荐标签
                    $recommended = ($id == 3) ? '<span class="absolute top-0 right-0 bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-bl-lg rounded-tr-lg">推荐</span>' : '';
                    
                    echo '
                    <div class="bg-white p-6 rounded-xl shadow-sm hover-scale transition-all duration-300 relative border border-gray-200" data-aos="zoom-in" data-aos-delay="' . ($id * 100) . '">
                        ' . $recommended . '
                        <h3 class="text-xl font-semibold text-gray-900">' . htmlspecialchars($friendly_name) . '</h3>
                        <p class="text-sm text-gray-500 mb-4">' . $features[$id][0] . '</p>
                        <div class="flex items-baseline mb-6">
                            <span class="text-4xl font-bold text-gray-900">' . $prices[$id] . '</span>
                            <span class="text-gray-500 ml-1">' . $cycles[$id] . '</span>
                        </div>
                        <a href="/?page=login" class="block w-full py-2.5 text-center rounded-md ' . $button_styles[$id] . ' font-medium transition-colors duration-300 mb-6">
                            ' . $buttons[$id] . '
                        </a>
                        <ul class="space-y-3">';
                    
                    // 添加速率
                    echo '<li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            ' . $speeds[$id] . '速率
                        </li>';
                    
                    // 添加隧道数量
                    echo '<li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            ' . $proxies . '条隧道
                        </li>';
                    
                    // 添加其他特性
                    for ($i = 1; $i < count($features[$id]); $i++) {
                        echo '<li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                ' . $features[$id][$i] . '
                            </li>';
                    }
                    
                    echo '</ul>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- CTA部分 -->
    <div class="bg-indigo-600 py-16 sm:py-24" data-aos="fade-up" id="about">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">准备好开始了吗？</h2>
                <p class="mt-6 text-lg leading-8 text-indigo-200">立即注册账号，免费体验高速稳定的内网穿透服务</p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="/?page=register"
                        class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-colors duration-300">
                        免费注册
                    </a>
                    <!-- <a href="#"
                        class="text-sm font-semibold leading-6 text-white hover:text-indigo-200 transition-colors duration-300">
                        了解更多 <span aria-hidden="true">→</span>
                    </a> -->
                </div>
            </div>
        </div>
    </div>

    <!-- 页脚 -->
    <footer class="bg-gray-900" data-aos="fade-up">
        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                <!-- 产品 -->
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-white">产品</h3>
                    <ul class="mt-6 space-y-4">
                        <li><a href="https://docs.chcat.cn"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">文档</a>
                        </li>
                        <li><a href="robots.txt"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">Robots</a>
                        </li>
                    </ul>
                </div>

                <!-- 公司 -->
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-white">公司</h3>
                    <ul class="mt-6 space-y-4">
                        <li><a href="https://www.chcat.cn"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">关于我们</a>
                        </li>
                        <li><a href="https://www.chcat.cn/#cooperation"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">合作伙伴</a>
                        </li>
                    </ul>
                </div>

                <!-- 法律 -->
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-white">法律</h3>
                    <ul class="mt-6 space-y-4">
                        <li><a href="https://docs.chcat.cn/docs/The_Privacy"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">隐私政策</a>
                        </li>
                        <li><a href="https://docs.chcat.cn/docs/Term_of_service"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">服务条款</a>
                        </li>
                        <li><a href="https://docs.chcat.cn/docs/cooke"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">Cookie政策</a>
                        </li>
                    </ul>
                </div>

                <!-- 联系我们 -->
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-white">联系我们</h3>
                    <ul class="mt-6 space-y-4">
                        <li><a href="https://qm.qq.com/q/edvcmOJUd4"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">QQ群</a>
                        </li>
                        <li><a href="https://docs.chcat.cn"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">帮助中心</a>
                        </li>
                        <li><a href="mailto:chaoji@chcat.cn"
                                class="text-sm leading-6 text-gray-300 hover:text-white transition-colors duration-300">电子邮件</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-16 border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="flex flex-col">
                    <div class="flex items-center">
                        <a href="#" class="-m-1.5 p-1.5">
                            <span class="sr-only">XunFrp</span>
                            <img class="h-8 w-auto" src="favicon.ico" alt="ChmlFrpLogo">
                        </a>
                        <span class="ml-4 text-sm text-gray-400">© 2025 XunFrp. All rights reserved.</span>
                        <span class="ml-4 text-sm text-gray-400">杜绝违法内容，请遵循法律法规和政府要求合规使用XunFrp。</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 flex items-center">
                        <a href="https://www.xn--v6qw21h0gd43u.xn--fiqs8s/" target="_blank" rel="noopener noreferrer"
                            class="hover:text-gray-400 transition-colors duration-300 flex items-center">
                            CFU识别码：********
                        </a>
                        <!-- <a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener noreferrer"
                            class="hover:text-gray-400 transition-colors duration-300 flex items-center ml-4">
                            <img src="./images/icp.webp" class="w-3 h-3 mr-1" />
                            蜀ICP备XXXXXXX号-X
                        </a>
                        <a href="https://www.xn--v6qw21h0gd43u.xn--fiqs8s/" target="_blank" rel="noopener noreferrer"
                            class="hover:text-gray-400 transition-colors duration-300 flex items-center ml-4">
                            <img src="./images/wangan.webp" class="w-3 h-3 mr-1" />
                            蜀公网安备XXXXXXXXXXXX号
                        </a> -->
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="https://github.com/TechCat-Team"
                        class="text-gray-400 hover:text-white transition-colors duration-300">
                        <span class="sr-only">GitHub</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 获取数据并初始化计数器
            fetch('https://cf-v2.uapis.cn/panelinfo')
                .then(response => response.json())
                .then(data => {
                    const stats = {
                        user_amount: data.data.user_amount,
                        tunnel_amount: data.data.tunnel_amount,
                        node_amount: data.data.node_amount
                    };

                    // 存储数据到全局变量
                    window.statsData = stats;

                    // 初始化观察器
                    initIntersectionObserver();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    // 默认值以防API请求失败
                    window.statsData = {
                        user_amount: 40000,
                        tunnel_amount: 45000,
                        node_amount: 35
                    };
                    initIntersectionObserver();
                });

            function initIntersectionObserver() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // 当元素进入视口时启动计数器
                            startCounters();
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });

                // 观察统计部分
                const statsSection = document.querySelector('.py-24.sm\\:py-32');
                if (statsSection) {
                    observer.observe(statsSection);
                }
            }

            function startCounters() {
                // 为每个计数器元素启动动画
                document.querySelectorAll('.count-up').forEach(element => {
                    const targetKey = element.getAttribute('data-target');
                    const targetValue = window.statsData[targetKey];
                    smoothAnimateCount(element, targetValue);
                });
            }

            // 使用缓动函数实现平滑动画
            function smoothAnimateCount(element, target) {
                const duration = 2000;
                const startTime = performance.now();
                const startValue = 0;

                function updateCount(currentTime) {
                    const elapsedTime = currentTime - startTime;
                    const progress = Math.min(elapsedTime / duration, 1);

                    // 使用easeOutQuint缓动函数
                    const easedProgress = easeOutQuint(progress);
                    const currentValue = Math.floor(startValue + (target - startValue) * easedProgress);

                    element.textContent = currentValue.toLocaleString();

                    if (progress < 1) {
                        requestAnimationFrame(updateCount);
                    } else {
                        element.textContent = target.toLocaleString();
                    }
                }

                requestAnimationFrame(updateCount);
            }

            // 缓动函数
            function easeOutQuint(t) {
                return 1 - Math.pow(1 - t, 5);
            }
        });
    </script>
</body>

</html>