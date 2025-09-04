<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>JPG图片上传</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }
        .upload-container {
            padding: 20px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }
        input[type="file"] {
            margin: 10px 0;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
        .note {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>JPG图片上传</h1>
    <div class="upload-container">
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/jpeg" required>
            <p class="note">仅支持JPG格式图片</p>
            <button type="submit" name="upload">上传图片</button>
        </form>
    </div>

    <?php
    // 检查是否提交了上传请求
    if (isset($_POST['upload'])) {
        // 目标文件夹
        $targetDir = '../img/sy/';
        // 确保目标文件夹存在，如果不存在则创建
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        // 目标文件路径
        $targetFile = $targetDir . 'tt.jpg';
        
        // 获取文件信息
        $fileInfo = @getimagesize($_FILES["image"]["tmp_name"]);
        
        // 检查文件是否是JPG图片
        $isJpg = false;
        if($fileInfo !== false) {
            // 检查MIME类型是否为JPG
            if($fileInfo['mime'] == 'image/jpeg') {
                $isJpg = true;
            }
        }
        
        if($isJpg) {
            // 尝试移动上传的文件
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo '<div class="message success">JPG图片上传成功，已保存为 tt.jpg</div>';
            } else {
                echo '<div class="message error">上传失败，请重试</div>';
            }
        } else {
            echo '<div class="message error">请上传有效的JPG图片文件</div>';
        }
    }
    ?>
</body>
</html>
