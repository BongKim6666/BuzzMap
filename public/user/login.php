<?php

require_once __DIR__ . '/../../models/User.php';

session_start();

if (isset($_POST['submit_button'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);

        $result = $user->login();

        if ($result['isSucceeded']) {
            $_SESSION['user'] = $user;
            setcookie('userId', $user->getId(), time() + 60 * 60 * 24, '/');
            header('Location: ../index.php');
            return;
        }
    }

    $err_message = 'ログイン失敗しました、メールアドレスとパスワードを確認してください！';
}

?>
<html>

<body>
    <h2>ログイン</h2>
    <form action="./login.php" method="post">
        <p>
            <label>
                メールアドレス
                <input type="text" name="email" value="<?php if (!empty($_POST['email'])) {
                                                            echo $_POST['email'];
                                                        } ?>">
            </label>
        </p>
        <p>
            <label>
                パスワード
                <input type="password" name="password">
            </label>
        </p>
        <?php if (isset($err_message)) : ?>
            <p style="color:red"><?php echo $err_message ?></p>
        <?php endif ?>
        <a href="./register.php">ユーザー登録はこちら</a>

        <p>
            <input type="submit" name="submit_button" value="ログイン">
        </p>

        <a href="../index.php">戻る</a>

    </form>
</body>

</html>