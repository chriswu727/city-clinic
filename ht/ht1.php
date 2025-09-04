<?php include 'check_auth.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理面板</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Microsoft YaHei', sans-serif;
            background-color: #f5f5f5;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* 左侧导航栏 */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #fff;
            padding: 20px 0;
        }
        
        .logo {
            text-align: center;
            padding: 10px 0 30px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 20px;
        }
        
        .nav-menu {
            list-style: none;
        }
        
        .nav-item {
            padding: 15px 25px;
            cursor: pointer;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .nav-item:hover {
            background-color: #34495e;
        }
        
        .nav-item.active {
            background-color: #34495e;
            border-left: 4px solid #3498db;
        }
        
        .nav-item i {
            margin-right: 10px;
        }
        
        /* 右侧内容区 */
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #ecf0f1;
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .content-body {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            min-height: calc(100vh - 160px);
        }
        
        iframe {
            width: 100%;
            height: 100%;
            border: none;
            min-height: calc(100vh - 160px);
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- 左侧导航栏 -->
        <div class="sidebar">
            <div class="logo">
                <h2>后台管理系统</h2>
            </div>
            <ul class="nav-menu">
                <li class="nav-item active" data-url="../ml/suju/display.php">
                    <i>📊</i>客户留言
                </li>
                <li class="nav-item" data-url="../cj/cj1.html">
                    <i>📝</i>新增医美项目
                </li>
                <li class="nav-item" data-url="../cjnx/cj1.html">
                    <i>📝</i>新增女性项目
                </li>
                <li class="nav-item" data-url="../cj/x.html">
                    <i>👥</i>删除医美项目
                </li>
                <li class="nav-item" data-url="../cjnx/xx.html">
                    <i>👥</i>删除女性项目
                </li>
                <li class="nav-item" data-url="syimg.php">
                    <i>📊</i>上传首页图片
                </li>
                 <li class="nav-item" data-url="../ml/hdong/cj.php">
                    <i>⚙️</i>修改活动1
                </li>
                 <li class="nav-item" data-url="../ml/hdong/cj2.php">
                    <i>⚙️</i>修改活动2
                </li>
                 <li class="nav-item" data-url="../jsao/cj.php">
                    <i>📈</i>修改首页介绍第1
                </li>
                <li class="nav-item" data-url="../jsao/cj2.php">
                    <i>📈</i>修改首页介绍第2
                </li>
                 <li class="nav-item" data-url="../ml/shang/he.html">
                    <i>📝</i>商品管理系统01
                </li>
                 <li class="nav-item" data-url="../ml/shang2/he.html">
                    <i>📝</i>商品管理系统02
                </li>
                 <li class="nav-item" data-url="../ml/shang3/he.html">
                    <i>📝</i>商品管理系统03
                </li>
                 <li class="nav-item" data-url="../ml/shang4/he.html">
                    <i>📝</i>商品管理系统04
                </li>
                 <li class="nav-item" data-url="../ml/shang5/he.html">
                    <i>📝</i>商品管理系统05
                </li>
                 <li class="nav-item" data-url="../ml/shang6/he.html">
                    <i>📝</i>商品管理系统06
                </li>
                 <li class="nav-item" data-url="../ml/shang7/he.html">
                    <i>📝</i>商品管理系统07
                </li>
                 <li class="nav-item" data-url="../ml/shang8/he.html">
                    <i>📝</i>商品管理系统08
                </li>
                
                <!-- <li class="nav-item" data-url="../ml/shang9/he.html">-->
                <!--    <i></i>商品管理系统09-->
                <!--</li>-->
                
                
                
                
                
            </ul>
        </div>
        
        <!-- 右侧内容区 -->
        <div class="main-content">
            <div class="content-header">
                <h3>控制面板</h3>
                <div class="user-info">
                    <span>管理员</span>
                    <a href="logout.php" class="logout-btn">退出登录</a>
                </div>
            </div>
            <div class="content-body">
                <iframe id="contentFrame" src="../ml/suju/display.php"></iframe>
            </div>
        </div>
    </div>

    <script>
        // 导航菜单点击事件
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                // 移除所有active类
                document.querySelectorAll('.nav-item').forEach(nav => {
                    nav.classList.remove('active');
                });
                
                // 给当前点击项添加active类
                this.classList.add('active');
                
                // 更新iframe内容
                const url = this.getAttribute('data-url');
                document.getElementById('contentFrame').src = url;
                
                // 更新标题
                const title = this.textContent.trim();
                document.querySelector('.content-header h3').textContent = title;
            });
        });
    </script>
</body>
</html>