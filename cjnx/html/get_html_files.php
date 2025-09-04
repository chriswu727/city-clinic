<?php
header('Content-Type: application/json');

// 关键修改：将目录改为当前文件夹（当前脚本所在目录），用"./"表示
$htmlDir = '../../cj/html/';
$files = [];

// 检查当前目录是否存在（理论上当前目录必然存在，可保留做容错）
if (is_dir($htmlDir)) {
    // 扫描当前目录下的所有文件
    $scannedFiles = scandir($htmlDir);
    
    foreach ($scannedFiles as $file) {
        // 只筛选.html后缀的文件
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $files[] = [
                'name' => basename($file, '.html'), // 文件名（去掉.html后缀）
                'path' => $htmlDir . $file         // 文件路径（当前目录+文件名）
            ];
        }
    }
}

// 返回JSON格式的HTML文件列表
echo json_encode($files);
?>