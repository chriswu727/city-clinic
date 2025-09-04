<?php
// 检查表单是否提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据并确保变量已定义
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $contactMethod = isset($_POST['contactMethod']) ? trim($_POST['contactMethod']) : '';
    $contactTime = isset($_POST['contactTime']) ? trim($_POST['contactTime']) : '';
    $project = isset($_POST['project']) ? trim($_POST['project']) : '';
    $remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';
    
    // 验证电话不能为空
    if (empty($phone)) {
        echo "<script>alert('电话不能为空，请返回填写'); history.back();</script>";
        exit;
    }
    
    // 获取当前日期和时间，格式为 Y/m/d H:i:s（年/月/日 时:分:秒）
    $datetime = date("Y/m/d H:i:s");
    
    // 拼接内容，使用 . 连接变量和字符串
    $content = $datetime . "、" . $name . "、" . $phone . "、" . $contactMethod . "、" . $contactTime . "、" . $project . "、" . $remarks . "\n";
    
    // 定义文件路径
    $filePath = 'suju/lx.txt';
    
    // 检查目录是否存在，不存在则创建
    $dir = dirname($filePath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    // 尝试写入文件
    if (file_put_contents($filePath, $content, FILE_APPEND | LOCK_EX)) {
        // 写入成功，显示成功页面，并添加1秒后自动返回的功能
        echo '
        <!DOCTYPE html>
        <html lang="zh-CN">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>提交成功</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
            <style>
                .success-animation {
                    animation: success 1s ease-in-out;
                }
                @keyframes success {
                    0% { transform: scale(0.8); opacity: 0; }
                    50% { transform: scale(1.2); }
                    100% { transform: scale(1); opacity: 1; }
                }
                .countdown {
                    color: #3B82F6;
                    font-weight: bold;
                }
            </style>
        </head>
        <body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
            <div class="text-center p-8 bg-white rounded-xl shadow-lg max-w-md w-full">
                <div class="success-animation text-green-500 text-6xl mb-4">
                    <i class="fa fa-check-circle"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">提交成功</h2>
                <p class="text-gray-600 mb-6">您的信息已成功提交，我们会尽快与您联系</p>
                <p class="text-gray-500 mb-6">
                    <span id="countdown" class="countdown">1</span> 秒后自动返回表单页面...
                </p>
                <a href="index.html" class="inline-block bg-primary hover:bg-primary/90 text-white font-medium py-2 px-6 rounded-md transition duration-200">
                    立即返回
                </a>
            </div>

            <script>
                // 1秒后自动返回上一页面
                setTimeout(function() {
                    window.location.href = "联系我们.html";
                }, 1000);

                // 倒计时显示
                let seconds = 1;
                const countdownElement = document.getElementById("countdown");
                const countdownInterval = setInterval(function() {
                    seconds--;
                    countdownElement.textContent = seconds;
                    if (seconds <= 0) {
                        clearInterval(countdownInterval);
                    }
                }, 1000);
            </script>
        </body>
        </html>
        ';
    } else {
        // 写入失败
        echo "<script>alert('提交失败，请稍后再试'); history.back();</script>";
    }
} else {
    // 不是POST请求，重定向到表单页面
    header("Location: index.html");
    exit;
}
?>
