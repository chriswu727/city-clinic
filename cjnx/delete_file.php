<?php
header('Content-Type: application/json');

// 定义存储HTML文件的目录
$htmlDir = 'html/';
$response = ['success' => false, 'message' => ''];

// 检查是否接收到文件名参数
if (!isset($_POST['filename'])) {
    $response['message'] = '未提供文件名';
    echo json_encode($response);
    exit;
}

$filename = $_POST['filename'];
$filePath = $htmlDir . $filename;

// 验证文件扩展名，确保只能删除HTML文件
$extension = pathinfo($filePath, PATHINFO_EXTENSION);
if (strtolower($extension) !== 'html') {
    $response['message'] = '只能删除HTML文件';
    echo json_encode($response);
    exit;
}

// 验证文件路径，防止目录遍历攻击
if (strpos(realpath($filePath), realpath($htmlDir)) !== 0) {
    $response['message'] = '无效的文件路径';
    echo json_encode($response);
    exit;
}

// 检查文件是否存在
if (!file_exists($filePath) || !is_file($filePath)) {
    $response['message'] = '文件不存在';
    echo json_encode($response);
    exit;
}

// 尝试删除文件
if (unlink($filePath)) {
    $response['success'] = true;
    $response['message'] = '文件删除成功';
} else {
    $response['message'] = '无法删除文件，请检查权限';
}

echo json_encode($response);
?>
