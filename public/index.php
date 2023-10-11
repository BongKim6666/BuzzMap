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
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4My62EvC7_WneZqIJ54PBKoi6dpIpuAw&libraries=places&callback=initMap&v=weekly"
        defer></script>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/menu.css" />
    <link rel="stylesheet" href="./css/reset.css" />

</head>


<body onload="autoGetLocation()">

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

    <button id="locationButton"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M18 16.016c1.245.529 2 1.223 2 1.984 0 1.657-3.582 3-8 3s-8-1.343-8-3c0-.76.755-1.456 2-1.984" />
            <path fill="currentColor" fill-rule="evenodd"
                d="M11.262 17.675 12 17l-.738.675zm1.476 0 .005-.005.012-.014.045-.05.166-.186a38.19 38.19 0 0 0 2.348-2.957c.642-.9 1.3-1.92 1.801-2.933.49-.99.885-2.079.885-3.086C18 4.871 15.382 2 12 2S6 4.87 6 8.444c0 1.007.395 2.096.885 3.086.501 1.013 1.16 2.033 1.8 2.933a38.153 38.153 0 0 0 2.515 3.143l.045.05.012.014.005.005a1 1 0 0 0 1.476 0zM12 17l.738.674L12 17zm0-11a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"
                clip-rule="evenodd" />
        </svg></button>



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