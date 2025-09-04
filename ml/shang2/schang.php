<?php
// 简单配置
$imgDir = 'img/';
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

// 创建图片目录（如果不存在）
if(!is_dir($imgDir)) mkdir($imgDir, 0777, true);

// 为每个分类创建对应的文件夹
foreach(array_keys($categoryMap) as $dir) {
    if(!is_dir($dir)) mkdir($dir, 0777, true);
}

$msg = '';

// 处理表单提交
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // 基本验证，增加了分类验证
    if(empty($_POST['name']) || empty($_POST['price']) || empty($_FILES['img']['name']) || empty($_POST['category'])){
        $msg = '请填写完整信息、选择分类和图片';
    }else{
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $img = $_FILES['img'];
        
        // 验证分类是否有效
        if(!array_key_exists($category, $categoryMap)) {
            $msg = '无效的分类选择';
        } else {
            // 处理图片
            $imgExt = pathinfo($img['name'], PATHINFO_EXTENSION);
            $imgName = $name . '.' . $imgExt;
            $imgPath = $imgDir . $imgName;
            
            // 移动上传文件
            if(move_uploaded_file($img['tmp_name'], $imgPath)){
                // 根据分类保存价格到对应的TXT文件夹
                $txtDir = $category . '/';
                $txtPath = $txtDir . $name . '.txt';
                file_put_contents($txtPath, $price);
                $msg = '上传成功！分类: ' . $categoryMap[$category] . '，图片: ' . $imgName . '，价格已保存';
            }else{
                $msg = '图片上传失败，可能是权限问题';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商品上传（带分类）</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 20px auto; padding: 20px; }
        .container { padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #45a049; }
        .msg { margin: 15px 0; padding: 10px; border-radius: 4px; }
        .success { background: #dff0d8; color: #3c763d; }
        .error { background: #f2dede; color: #a94442; }
    </style>
</head>
<body>
    <div class="container">
        <h2>商品上传</h2>
        
        <?php if($msg): ?>
            <div class="msg <?php echo strpos($msg, '成功') !== false ? 'success' : 'error'; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>商品名称：</label>
                <input type="text" name="name" placeholder="输入商品名称">
            </div>
            
            <div class="form-group">
                <label>商品价格：</label>
                <input type="text" name="price" placeholder="输入价格">
            </div>
            
            <div class="form-group">
                <label>商品分类：</label>
                <select name="category">
                    <option value="">请选择分类</option>
                    <option value="xz">修正Correct</option>
                    <option value="bs">补水moisturizer</option>
                    <option value="bh">保护protect</option>
                    <option value="ksl">抗衰老Rejuvenation + Age Defense</option>
                    <option value="fs">防晒Sun Protection</option>
                    <option value="tl">提亮Brightening</option>
                    <option value="jm">洁面cleanse</option>
                    <option value="zdxzl">针对性治疗Specialty Targeted Treatments</option>
                    <option value="qjz">去角质exfoliate</option>
                    <option value="xf">爽肤tone</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>商品图片：</label>
                <input type="file" name="img">
            </div>
            
            <button type="submit">保存商品</button>
        </form>
    </div>
</body>
</html>
