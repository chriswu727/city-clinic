<?php
// 处理删除请求
$message = '';
$messageType = '';

// 定义分类与文件夹的映射关系
$categoryMap = [
 'xz' => '修正Correct',
 'bs' => '补水moisturizer',
 'bh' => '保护protect',
 'ksl' => '抗衰老Rejuvenation + Age Defense',
 'fs' => '防晒Sun Protection',
 'tl' => '提亮Brightening',
 'jm' => '洁面cleanse',
 'zdxzl' => '针对性治疗Specialty Targeted Treatments',
 'qjz' => '去角质exfoliate',
 'xf' => '爽肤tone',
];

$imageDir = 'img/';

// 处理删除操作
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['category']) && isset($_GET['name'])) {
    $category = $_GET['category'];
    $productName = $_GET['name'];
    
    // 验证分类是否有效
    if (!array_key_exists($category, $categoryMap)) {
        $message = "无效的分类";
        $messageType = "error";
    } else {
        $deleted = false;
        
        // 删除TXT文件
        $txtFile = $category . '/' . $productName . '.txt';
        if (file_exists($txtFile)) {
            unlink($txtFile);
            $deleted = true;
        }
        
        // 删除图片文件（检查多种格式）
        $imageFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        foreach ($imageFormats as $ext) {
            $imageFile = $imageDir . $productName . '.' . $ext;
            if (file_exists($imageFile)) {
                unlink($imageFile);
                $deleted = true;
            }
        }
        
        if ($deleted) {
            $message = "商品 '$productName' 已成功删除";
            $messageType = "success";
        } else {
            $message = "删除失败，商品文件不存在";
            $messageType = "error";
        }
    }
}

// 获取所有商品数据
$categories = [];
foreach ($categoryMap as $dir => $categoryName) {
    if (!is_dir($dir)) {
        continue;
    }
    
    $txtFiles = glob($dir . '/*.txt');
    if (empty($txtFiles)) {
        continue;
    }
    
    $products = [];
    foreach ($txtFiles as $file) {
        $productName = basename($file, '.txt');
        $products[] = $productName;
    }
    
    $categories[] = [
        'dir' => $dir,
        'name' => $categoryName,
        'products' => $products
    ];
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品删除管理系统</title>
    <!-- 引入Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- 引入Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <style type="text/tailwindcss">
        @layer utilities {
            .delete-container {
                @apply max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden;
            }
            .delete-header {
                @apply bg-red-600 text-white p-5 border-b border-red-500;
            }
            .category-card {
                @apply mb-4 bg-gray-50 rounded-lg overflow-hidden transition-all hover:shadow-md;
            }
            .category-header {
                @apply bg-gray-100 px-4 py-3 font-medium text-gray-800 border-b border-gray-200;
            }
            .product-item {
                @apply px-4 py-3 flex items-center justify-between border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors;
            }
            .delete-btn {
                @apply text-red-600 hover:text-red-800 font-medium flex items-center transition-colors cursor-pointer;
            }
            .delete-btn:hover {
                @apply underline;
            }
            .message {
                @apply p-4 mb-0 rounded-t-none text-center;
            }
            .success {
                @apply bg-green-50 text-green-700 border border-green-200;
            }
            .error {
                @apply bg-red-50 text-red-700 border border-red-200;
            }
            .empty-state {
                @apply text-center py-12 text-gray-500;
            }
        }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-8 min-h-screen">
    <div class="delete-container">
        <!-- 头部 -->
        <div class="delete-header">
            <h1 class="text-2xl font-bold flex items-center">
                <i class="fa fa-trash mr-3"></i>商品删除管理系统
            </h1>
            <p class="text-red-100 mt-1">谨慎操作：删除的商品将无法恢复</p>
        </div>
        
        <!-- 消息提示 -->
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php if ($messageType == 'success'): ?>
                    <i class="fa fa-check-circle mr-2"></i>
                <?php else: ?>
                    <i class="fa fa-exclamation-circle mr-2"></i>
                <?php endif; ?>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <!-- 分类和商品列表 -->
        <div class="p-4 md:p-6">
            <?php if (empty($categories)): ?>
                <div class="empty-state">
                    <i class="fa fa-folder-open-o text-5xl mb-4 opacity-30"></i>
                    <p>当前没有可删除的商品</p>
                </div>
            <?php else: ?>
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <div class="category-header">
                            <span><?php echo $category['name']; ?></span>
                            <span class="ml-2 text-sm font-normal text-gray-500">
                                (<?php echo count($category['products']); ?>个商品)
                            </span>
                        </div>
                        
                        <div class="products-list">
                            <?php foreach ($category['products'] as $product): ?>
                                <div class="product-item">
                                    <span class="text-gray-700"><?php echo $product; ?></span>
                                    <span class="delete-btn" 
                                          onclick="confirmDelete('<?php echo $category['dir']; ?>', '<?php echo addslashes($product); ?>')">
                                        <i class="fa fa-trash-o mr-1"></i> 删除
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // 单次确认删除函数
        function confirmDelete(category, name) {
            // 显示确认对话框
            if (confirm(`确定要永久删除商品 "${name}" 吗？\n此操作将删除所有相关文件，且无法恢复！`)) {
                // 跳转到指定格式的URL
                window.location.href = `x.php?action=delete&category=${encodeURIComponent(category)}&name=${encodeURIComponent(name)}`;
            }
        }
    </script>
</body>
</html>
