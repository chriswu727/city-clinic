<?php
// 设置响应类型为JSON
header("Content-Type: application/json; charset=UTF-8");

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
 'xf' => '爽肤tone'
];

// 定义图片目录
$imageDir = 'img/';

// 初始化返回数据
$response = [
    'success' => false,
    'categories' => [],
    'message' => ''
];

// 检查图片目录是否存在
if (!is_dir($imageDir)) {
    $response['message'] = '图片目录（img/）不存在';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

// 遍历每个分类目录
$allProductsFound = false;
foreach ($categoryMap as $dir => $categoryName) {
    // 检查分类目录是否存在
    if (!is_dir($dir)) {
        continue; // 跳过不存在的目录
    }
    
    // 获取目录下所有txt文件
    $txtFiles = glob($dir . '/*.txt');
    if (empty($txtFiles)) {
        continue; // 跳过没有txt文件的目录
    }
    
    $allProductsFound = true;
    $products = [];
    
    // 遍历txt文件，提取商品信息
    foreach ($txtFiles as $file) {
        // 获取商品名（去掉路径和.txt后缀）
        $productName = basename($file, '.txt');
        
        // 读取价格
        $priceContent = trim(file_get_contents($file));
        $price = is_numeric($priceContent) ? '¥' . $priceContent : '价格无效';
        
        // 处理商品图片路径 - 检查多种可能的图片格式
        $imageFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $imagePath = '';
        $imageExists = false;
        
        foreach ($imageFormats as $ext) {
            $checkPath = $imageDir . $productName . '.' . $ext;
            if (file_exists($checkPath)) {
                $imagePath = $checkPath;
                $imageExists = true;
                break;
            }
        }
        
        // 如果没找到图片，使用默认路径
        if (!$imageExists) {
            $imagePath = $imageDir . $productName . '.jpg';
        }
        
        // 组装单个商品数据
        $products[] = [
            'name' => $productName,
            'price' => $price,
            'image_path' => $imagePath,
            'image_exists' => $imageExists
        ];
    }
    
    // 添加分类数据
    $response['categories'][$dir] = [
        'name' => $categoryName,
        'products' => $products
    ];
}

// 检查是否找到任何商品
if (!$allProductsFound) {
    $response['message'] = '未找到任何商品数据';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

// 成功返回数据
$response['success'] = true;
$response['message'] = '商品加载成功';

// 输出JSON（确保中文正常显示）
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;
    