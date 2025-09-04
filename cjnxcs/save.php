<?php
// 确保nr目录存在
if (!file_exists('nr')) {
    mkdir('nr', 0777, true);
}

// 确保html目录存在
if (!file_exists('html')) {
    mkdir('html', 0777, true);
}

// 获取表单数据
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$text1 = isset($_POST['text1']) ? trim($_POST['text1']) : '';
$text2 = isset($_POST['text2']) ? trim($_POST['text2']) : '';
$text3 = isset($_POST['text3']) ? trim($_POST['text3']) : '';
$text4 = isset($_POST['text4']) ? trim($_POST['text4']) : '';
$text5 = isset($_POST['text5']) ? trim($_POST['text5']) : '';
$text6 = isset($_POST['text6']) ? trim($_POST['text6']) : '';
$text7 = isset($_POST['text7']) ? trim($_POST['text7']) : '';
$text8 = isset($_POST['text8']) ? trim($_POST['text8']) : '';

$text9 = isset($_POST['text9']) ? trim($_POST['text9']) : '';
$text10 = isset($_POST['text10']) ? trim($_POST['text10']) : '';
$text11 = isset($_POST['text11']) ? trim($_POST['text11']) : '';
$text12 = isset($_POST['text12']) ? trim($_POST['text12']) : '';
$text13 = isset($_POST['text13']) ? trim($_POST['text13']) : '';
$text14 = isset($_POST['text14']) ? trim($_POST['text14']) : '';
$text15 = isset($_POST['text15']) ? trim($_POST['text15']) : '';
$text16 = isset($_POST['text16']) ? trim($_POST['text16']) : '';
$text17 = isset($_POST['text17']) ? trim($_POST['text17']) : '';
$text18 = isset($_POST['text18']) ? trim($_POST['text18']) : '';
$text19 = isset($_POST['text19']) ? trim($_POST['text19']) : '';
$text20 = isset($_POST['text20']) ? trim($_POST['text20']) : '';
$text21 = isset($_POST['text21']) ? trim($_POST['text21']) : '';
$text22 = isset($_POST['text22']) ? trim($_POST['text22']) : '';
// 验证标题是否为空
if (empty($title)) {
    die("错误：标题不能为空");
}

// 处理图片上传
$imageIds = ['spc文o@图片1', 'spc文o@图片2', 'spc文o@图片3','spc文o@图片4','spc文o@图片5'];
// 修改：使用标题的纯值作为文件夹名称，去掉固定前缀
$uploadDir = 'img/' . $title . '/';

// 创建图片保存目录
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

foreach ($imageIds as $imageId) {
    if (isset($_FILES[$imageId]) && $_FILES[$imageId]['error'] == UPLOAD_ERR_OK) {
        $fileInfo = $_FILES[$imageId];
        
        // 验证文件类型
        $fileExtension = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
        if (strtolower($fileExtension) != 'jpg') {
            die("错误：{$imageId} 必须是.jpg文件");
        }
        
        // 构建目标文件路径
        $targetFile = $uploadDir . $imageId . '.jpg';
        
        // 移动上传的文件
        if (!move_uploaded_file($fileInfo['tmp_name'], $targetFile)) {
            die("错误：无法保存 {$imageId} 文件");
        }
    }
}

// 准备要写入的内容
$content = "spc文o@标题：$title\n\n";

// 每个文本字段单独处理
if (!empty($text1)) $content .= "spc文o@文本1：$text1\n\n";
if (!empty($text2)) $content .= "spc文o@文本2：$text2\n\n";
if (!empty($text3)) $content .= "spc文o@文本3：$text3\n\n";
if (!empty($text4)) $content .= "spc文o@文本4：$text4\n\n";
if (!empty($text5)) $content .= "spc文o@文本5：$text5\n\n";
if (!empty($text6)) $content .= "spc文o@文本6：$text6\n\n";
if (!empty($text7)) $content .= "spc文o@文本7：$text7\n\n";
if (!empty($text8)) $content .= "spc文o@文本8：$text8\n\n";

if (!empty($text9)) $content .= "spc文o@文本9：$text9\n\n";
if (!empty($text10)) $content .= "spc文o@文本10：$text10\n\n";
if (!empty($text11)) $content .= "spc文o@文本11：$text11\n\n";
if (!empty($text12)) $content .= "spc文o@文本12：$text12\n\n";
if (!empty($text13)) $content .= "spc文o@文本13：$text13\n\n";
if (!empty($text14)) $content .= "spc文o@文本14：$text14\n\n";
if (!empty($text15)) $content .= "spc文o@文本15：$text15\n\n";
if (!empty($text16)) $content .= "spc文o@文本16：$text16\n\n";
if (!empty($text17)) $content .= "spc文o@文本17：$text17\n\n";
if (!empty($text18)) $content .= "spc文o@文本18：$text18\n\n";
if (!empty($text19)) $content .= "spc文o@文本19：$text19\n\n";
if (!empty($text20)) $content .= "spc文o@文本20：$text20\n\n";
if (!empty($text21)) $content .= "spc文o@文本21：$text21\n\n";
if (!empty($text22)) $content .= "spc文o@文本22：$text22\n\n";
// 创建文件并写入内容
$filename = 'nr/' . $title . '.txt';
if (file_put_contents($filename, $content)) {
    // 复制模板到html文件夹，使用标题作为文件名
    $htmlFilename = 'html/' . $title . '.html';
    if (copy('moban.html', $htmlFilename)) {
        echo "文档保存成功！HTML文件已生成。<a href='cj1.html'>继续创建</a>";
    } else {
        echo "文档保存成功，但HTML文件生成失败。<a href='cj1.html'>继续创建</a>";
    }
} else {
    echo "保存失败，请检查目录权限";
}
?>
