<?php

require_once __DIR__ . '/../../models/User.php';

session_start();

if (isset($_POST['submit_button'])) {
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['name'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setName($name);

        $user->register();

        $_SESSION['user'] = $user;
        setcookie('userId', $user->getId(), time() + 60 * 60 * 24 * 30, '/');

        header('Location: ../index.php');
        return;
    }
    if (empty($_POST['email'])) {
        $email_err = "メールを入力してください";
    }
    if (empty($_POST['password'])) {
        $password_err = "パスワードを入力してください";
    }
    if (empty($_POST['name'])) {
        $name_err = "名前を入力してください";
    }
}

?>
<html>

<body>
    <h2>ユーザー登録</h2>
    <form action="./register.php" method="post">
        <p>
            <label>
                ユーザー名
                <input type="text" name="name" value="<?php if (!empty($_POST['name'])) {
                                                            echo $_POST['name'];
                                                        } ?>">
            </label>
        </p>
        <?php if (isset($name_err)) : ?>
            <p style="color:red"><?php echo $name_err ?></p>
        <?php endif ?>
        <p>
            <label>
                メールアドレス
                <input type="text" name="email" value="<?php if (!empty($_POST['email'])) {
                                                            echo $_POST['email'];
                                                        } ?>">
            </label>
        </p>
        <?php if (isset($email_err)) : ?>
            <p style="color:red"><?php echo $email_err ?></p>
        <?php endif ?>
        <p>
            <label>
                パスワード
                <input type="password" name="password">
            </label>
        </p>
        <?php if (isset($password_err)) : ?>
            <p style="color:red"><?php echo $password_err ?></p>
        <?php endif ?>

        <a href="./login.php">ログインはこちら</a>

        <p>
            <input type="submit" name="submit_button" value="登録">
        </p>

        <a href="../index.php">戻る</a>

    </form>

</body>

</html>