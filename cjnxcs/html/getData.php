<?php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['file'])) {
    echo json_encode(["error" => "缺少文件名"]);
    exit;
}

$fileName = urldecode($_GET['file']);
$fileName = basename($fileName);

$filePath = dirname(__DIR__) . "/nr/" . $fileName . ".txt";

if (!file_exists($filePath)) {
    echo json_encode(["error" => "文件不存在: " . $filePath]);
    exit;
}

$content = file_get_contents($filePath);
$lines = preg_split('/\r\n|\r|\n/', $content); // 兼容各种换行
$result = [];
$currentKey = null; // 用于跟踪当前处理的key

foreach ($lines as $line) {
    $line = trim($line, " \t"); // 只去除首尾空格和制表符，保留换行相关格式
    if ($line === '') {
        // 如果是空行且有当前key，保留空行作为内容的一部分
        if ($currentKey !== null) {
            $result[$currentKey] .= "\n";
        }
        continue;
    }

    // 检查是否是新的key-value行（包含中文冒号）
    if (strpos($line, "：") !== false) {
        // 如果有正在处理的key，先保存之前的内容
        if ($currentKey !== null) {
            // 去除末尾可能多余的换行
            $result[$currentKey] = rtrim($result[$currentKey], "\n");
        }
        // 解析新的key和value
        list($key, $value) = explode("：", $line, 2);
        $currentKey = trim($key);
        $result[$currentKey] = trim($value) . "\n"; // 初始值加换行，方便后续拼接
    } else {
        // 不是新的key行，属于当前key的多行内容
        if ($currentKey !== null) {
            $result[$currentKey] .= $line . "\n";
        }
    }
}

// 处理最后一个key的内容（去除末尾多余的换行）
if ($currentKey !== null) {
    $result[$currentKey] = rtrim($result[$currentKey], "\n");
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>
