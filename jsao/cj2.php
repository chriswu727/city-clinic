<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>信息提交表单</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        .file-upload {
            margin: 10px 0;
        }
        .note {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <h1>修改首页介绍第2</h1>
    
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">标题</label>
            <input type="text" id="title" name="title" required>
        </div>
        
        <div class="form-group">
            <label for="intro">简介</label>
            <textarea id="intro" name="intro" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="content">主文案</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        
        <div class="form-group">
            <label for="notes">链接</label>
            <textarea id="notes" name="notes"></textarea>
        </div>
        
        <div class="form-group">
            <label for="image">上传图片</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/jpg,image/png" required class="file-upload">
            <p class="note">支持JPG、JPEG、PNG格式图片</p>
        </div>
        
        <button type="submit" name="save">保存</button>
    </form>

    <?php
    if (isset($_POST['save'])) {
        // 收集表单数据
        $title = trim($_POST['title'] ?? '');
        $intro = trim($_POST['intro'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        
        // 验证必填字段
        if (empty($title) || empty($intro) || empty($content)) {
            echo '<div class="message error">标题、简介和主文案为必填项，请补充完整</div>';
            exit;
        }
        
        // 处理图片上传
        $imageError = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            // 检查文件扩展名
            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png'];
            
            if (!in_array($fileExtension, $allowedExts)) {
                $imageError = '请上传有效的图片文件（支持 JPG、JPEG、PNG 格式）';
            } else {
                // 验证是否真的是图片文件
                $fileInfo = @getimagesize($_FILES["image"]["tmp_name"]);
                if($fileInfo === false) {
                    $imageError = '上传的文件不是有效的图片文件';
                } else {
                    // 检查MIME类型
                    $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!in_array($fileInfo['mime'], $allowedMimes)) {
                        $imageError = '图片格式不正确，请上传 JPG、JPEG 或 PNG 格式';
                    } else {
                        // 保存图片为sj2.扩展名（保持原扩展名）
                        $targetFile = 'sj2.' . $fileExtension;
                        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                            $imageError = '图片上传失败，请重试';
                        }
                    }
                }
            }
        } else {
            $imageError = '请上传图片文件';
        }
        
        // 如果图片处理有错误，显示错误信息
        if (!empty($imageError)) {
            echo '<div class="message error">' . $imageError . '</div>';
            exit;
        }
        
        // 准备要写入文件的数据
        $data = "s2p标题：{$title}\n";
        $data .= "s2p简介：{$intro}\n";
        $data .= "s2p主文案：{$content}\n";
        $data .= "s2p备注：{$notes}\n";
        
        // 写入到sj2.txt文件
        if (file_put_contents('sj2.txt', $data) !== false) {
            echo '<div class="message success">信息保存成功！</div>';
        } else {
            echo '<div class="message error">信息保存失败，请检查文件权限</div>';
        }
    }
    ?>
</body>
</html>
