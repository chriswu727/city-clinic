<?php
session_start();

// 正确的账号和密码
$correct_username = '1';
$correct_password = '1';

// 获取用户提交的账号密码
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 验证账号密码
if ($username === $correct_username && $password === $correct_password) {
    // 验证成功，设置session
    $_SESSION['uil83'] = 'ok';
    // 跳转到ht1.html
    header('Location: ht1.php');
    exit();
} else {
    // 验证失败，跳回登录页并显示错误
    header('Location: admin.html?error=1');
    exit();
}
?>