<?php
// 定义数据文件路径
$filePath = 'lx.txt';
$records = array();

// 检查文件是否存在
if (file_exists($filePath) && is_readable($filePath)) {
    // 读取文件内容
    $content = file_get_contents($filePath);
    
    // 按行分割内容
    $lines = explode("\n", trim($content));
    
    // 反转数组，使最新的数据显示在前面
    $records = array_reverse($lines);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>表单数据展示</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .records-container {
            max-width: 90%;
            margin: 2rem auto;
        }
        
        .record-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .record-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .header-section {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="header-section text-white py-6 px-4 shadow-md">
        <div class="max-width: 90%; margin: 0 auto;">
            <h1 class="text-2xl md:text-3xl font-bold flex items-center">
                <i class="fa fa-database mr-3"></i>表单数据展示系统
            </h1>
            <p class="mt-2 opacity-90">所有提交记录（最新数据在最上方）</p>
        </div>
    </div>
    
    <div class="records-container">
        <?php if (!empty($records)): ?>
            <div class="grid grid-cols-1 gap-4 mt-6">
                <?php foreach ($records as $index => $record): ?>
                    <?php
                    // 分割记录数据
                    $fields = explode('、', $record);
                    
                    // 确保有足够的字段
                    if (count($fields) >= 7) {
                        list($datetime, $name, $phone, $contactMethod, $contactTime, $project, $remarks) = $fields;
                    } else {
                        // 处理格式不正确的记录
                        $datetime = $record;
                        $name = $phone = $contactMethod = $contactTime = $project = $remarks = '数据格式不正确';
                    }
                    ?>
                    
                    <div class="record-card bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-3">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800"><?php echo htmlspecialchars($name); ?></h3>
                                <p class="text-sm text-gray-500">提交时间: <?php echo htmlspecialchars($datetime); ?></p>
                            </div>
                            <span class="mt-2 md:mt-0 inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                                记录 #<?php echo ($index + 1); ?>
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="flex items-start">
                                <i class="fa fa-phone text-blue-500 mt-1 mr-2 w-4 text-center"></i>
                                <div>
                                    <p class="text-gray-500">电话号码</p>
                                    <p class="font-medium"><?php echo htmlspecialchars($phone); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fa fa-comments text-blue-500 mt-1 mr-2 w-4 text-center"></i>
                                <div>
                                    <p class="text-gray-500">联系方式</p>
                                    <p class="font-medium"><?php echo htmlspecialchars($contactMethod); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fa fa-clock-o text-blue-500 mt-1 mr-2 w-4 text-center"></i>
                                <div>
                                    <p class="text-gray-500">联系时间</p>
                                    <p class="font-medium"><?php echo htmlspecialchars($contactTime); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i class="fa fa-list-alt text-blue-500 mt-1 mr-2 w-4 text-center"></i>
                                <div>
                                    <p class="text-gray-500">感兴趣项目</p>
                                    <p class="font-medium"><?php echo htmlspecialchars($project); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!empty($remarks) && $remarks !== '数据格式不正确'): ?>
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-start">
                                    <i class="fa fa-comment text-blue-500 mt-1 mr-2 w-4 text-center"></i>
                                    <div>
                                        <p class="text-gray-500">备注信息</p>
                                        <p class="font-medium"><?php echo htmlspecialchars($remarks); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow p-8 text-center mt-6">
                <div class="text-gray-400 text-5xl mb-4">
                    <i class="fa fa-file-text-o"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">暂无记录</h3>
                <p class="text-gray-500">尚未有任何提交的表单数据</p>
            </div>
        <?php endif; ?>
    </div>
    
    <footer class="mt-10 py-4 text-center text-gray-500 text-sm">
        <p>数据展示系统 &copy; <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
    