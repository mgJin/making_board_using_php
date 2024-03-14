<?php

include_once(__DIR__ . '/Common/functions.php');
include_once(__DIR__ . '/Common/middleware.php');
$routes = include_once(__DIR__ . '/Settings/routes.php');

//미들웨어를 여기서 실행을 시키고 리턴을 받은게 false면 return; 을 해서 종료를 시킨다.
//return false가 되면 boards 페이지로 보내는게 제일 좋을듯?
if (!(chk())) {
    return;
};


if ($_SERVER['REQUEST_METHOD'] != "GET") :
    run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $routes);
    return;
endif;
?>
<?php
$url = parse_url($_SERVER['REQUEST_URI']);
$url = $url['path'];
if (preg_match('/^\/adminpage(\/.*)?$/', $url)) : ?>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>관리자 페이지</title>
        <style>
            section {
                padding: 10px;
            }

            aside {
                padding: 10px;
                width: 20%;
                float: left;
            }

            article {
                padding: 10px;
                width: 70%;
                float: left;
            }

            li {
                list-style: none;
                padding: 10px;
                border: 1px solid #ddd;
                cursor: pointer;
            }

            li:hover {
                background-color: #f0f0f0;
            }

            a.infoA {
                font-weight: bold;
                text-decoration: none;
            }
        </style>
    </head>

    <body>
        <?php
            require(__DIR__.'/Settings/config.php');
        ?>
        <section>
            <aside>
                <ul class="managementList">
                    <li class="asideLI" onclick="onShow('')">Base</li>
                    <li class="asideLI" onclick="onShow('/rolemanagement')">RoleManagement</li>
                    <li class="asideLI" onclick="onShow('/usermanagement')">UserManagement</li>
                    <li class="asideLI" onclick="onShow('/boardmanagement')">Board management</li>
                </ul>
            </aside>
            <article>
                <?php run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $routes); ?>
            </article>
        </section>
        <?php ?>
        <script>
            // document.addEventListener('DOMContentLoaded', function() {
            //     let lastIndex = localStorage.getItem('lastShowContentIndex');
            //     if (lastIndex !== null) {
            //         let Managements = document.querySelectorAll(".managements");
            //         if (Managements[lastIndex]) {
            //             Managements[lastIndex].classList.add('active');
            //         }
            //     }
            //     let lis = document.querySelectorAll(".asideLI");
            //     lis.forEach(function(element, index) {
            //         element.addEventListener("click", function() {
            //             localStorage.setItem('lastShowContentIndex', index);
            //         })
            //     })
            // })

            function onShow(selected) {
                let url = "http://localhost:3000/adminpage" + selected
                window.location.replace(url);
            }
        </script>
    </body>

    </html>
<?php
else :
?>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Index</title>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <style>
            footer {
                clear: both;
            }
        </style>
    </head>

    <body>
        <header>
            <h1>Header Area</h1>
        </header>
        <main>
            <?php run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $routes); ?>
        </main>
        <footer>
            <h1>Footer Area</h1>
        </footer>
    </body>

    </html>
<?php endif; ?>