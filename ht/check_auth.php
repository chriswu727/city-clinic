<?php
session_start();

// 检查session中uil83是否存在且值为ok
if (!isset($_SESSION['uil83']) || $_SESSION['uil83'] !== 'ok') {
    // 未登录，跳转到登录页
    header('Location: admin.html');
    exit();
}
?>