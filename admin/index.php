<?php
session_start();
include '../settings/connect.php'; // قاعدة البيانات
include '../common/function.php';
include '../common/head.php';
// إذا تم إرسال الفورم
if(isset($_POST['login'])){
    $email = htmlspecialchars($_POST['email']);
    $password = sha1($_POST['password']); // تحويل كلمة المرور إلى SHA1

    // تحقق من قاعدة البيانات
    $stmt = $con->prepare("SELECT * FROM tbladmin WHERE Email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if($admin){
        $_SESSION['admin_id'] = $admin['adminID'];
        $_SESSION['admin_name'] = $admin['Fname'];
        header('Location: dashboard.php'); // بعد تسجيل الدخول نذهب للداشبورد
        exit;
    } else {
        $error = "Email or Password is incorrect!";
    }
}
?>


    <style>
        body {
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-box h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 30px;
        }
        .login-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            background: #4CAF50;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-box button:hover {
            background: #388E3C;
        }
        .error {
            color: red;
            margin-bottom: 20px;
            text-align: center;
        }
        @media(max-width: 480px){
            .login-box { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
