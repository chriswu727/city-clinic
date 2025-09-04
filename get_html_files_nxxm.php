<?php
header('Content-Type: application/json');

$htmlDir = 'cjnx/html/';
$files = [];

// 检查目录是否存在
if (is_dir($htmlDir)) {
    // 扫描目录
    $scannedFiles = scandir($htmlDir);
    
    foreach ($scannedFiles as $file) {
        // 只处理.html文件
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $files[] = [
                'name' => basename($file, '.html'),
                'path' => $htmlDir . $file
            ];
        }
    }
}

// 返回JSON格式的文件列表
echo json_encode($files);
?>