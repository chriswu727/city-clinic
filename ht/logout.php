<?php
session_start();

// 清除session
$_SESSION = array();

// 如果要彻底销毁session，同时删除session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 最后销毁session
session_destroy();

// 跳转到登录页
header('Location: admin.html');
exit();
?>