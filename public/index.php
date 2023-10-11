<?php

require_once __DIR__ . '/../models/User.php';

session_start();

if (isset($_COOKIE['userId'])) {

    $user = new User();
    $result = $user->getById($_COOKIE['userId'])->getName();
}



?>

<!DOCTYPE html>
<html>

<head>
    <title>Buzz Map </title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4My62EvC7_WneZqIJ54PBKoi6dpIpuAw&libraries=places&callback=initMap"
        defer></script>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/menu.css" />
    <link rel="stylesheet" href="./css/reset.css" />

</head>

<body>

    <div id="navArea">
        <nav>
            <div class="inner">
                <?php if (!isset($result)) : ?>
                <h1>ようこそ、ゲストさん</h1>
                <?php else : ?>
                <h1>おかえり、<?php echo $result ?> さん</h1>
                <?php endif; ?>


                <ul>

                    <?php if (!isset($result)) : ?>
                    <li>
                        <a href="../public/user/register.php">
                            <small>会員登録されていない方</small>
                            <h2>会員登録</h2>
                        </a>
                    </li>

                    <li>
                        <a href="../public/user/login.php">
                            <small>会員登録済みの方はログインが必要です</small>
                            <h2>ログイン</h2>
                        </a>
                    </li>

                    <?php else : ?>
                    <li>
                        <a href="#">
                            <h2>マイページ</h2>
                        </a>
                    </li>

                    <li>
                        <a href="../public/user/logout.php">
                            <h2>ログアウト</h2>
                        </a>
                    </li>

                    <?php endif; ?>


                    <li><a href="#">
                            <h2>ヘルプ</h2>
                        </a></li>
                    <li><a href="#">
                            <h2>お問い合わせ</h2>
                        </a></li>
                </ul>
            </div>
        </nav>
        <div class="toggle-wrapper">
            <div class="toggle-btn">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>


        <div id="mask"></div>
    </div>

    <input type="text" id="addressInput" placeholder="住所を入力">

    <div id="map"></div>



    <script src="js/index.js"></script>
    <script>
    let nav = document.querySelector("#navArea");
    let btn = document.querySelector(".toggle-btn");
    let mask = document.querySelector("#mask");

    btn.onclick = () => {
        nav.classList.toggle("open");
    };

    mask.onclick = () => {
        nav.classList.toggle("open");
    };
    </script>

</body>

</html>