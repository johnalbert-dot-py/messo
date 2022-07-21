<?php
session_start();
require_once("../../controllers/Home.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messo | Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans" rel="stylesheet">
    <link href="http://fonts.cdnfonts.com/css/helvetica-neue-9" rel="stylesheet">
    <link href="http://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">
    <link rel="icon" href="/views/assets/logo.png" type="image/png">

</head>

<body>

    <header>
        <nav>
            <h2>
                Messo
            </h2>
            <div class="items">
                <a href="/views/home/" class="active">
                    Home
                </a>
                <a href="/views/home/profile.php">
                    Profile
                </a>
                <a href="/views/logout.php">
                    Logout
                </a>
            </div>
        </nav>
    </header>
    <main id="app">
        <div class="container">
            <div class="greet">
                <h1>
                    Let’s find some other users!
                </h1>
            </div>

            <div class="list-of-users">

                <?php foreach ($context["users"] as $key => $user) : ?>
                    <div class="flat-card">
                        <div class="user-info">
                            <p class="username">
                                @<?= $user["username"] ?>
                            </p>
                            <p class="full-name">
                                <?= $user["first_name"] ?> <?= $user["last_name"] ?>
                            </p>
                            <p class='date-joined'>
                                Joined on <?php
                                            $time = strtotime($user["created_at"]);
                                            $formatted = date('M d, Y', $time);
                                            echo $formatted;
                                            ?>
                            </p>
                        </div>
                        <div class="user-action">
                            <?php if ($user['facebook_id']) : ?>
                                <button type="button" class="facebook">
                                    Add on Facebook
                                </button>
                            <?php elseif ($user["linked_in_id"]) : ?>
                                <button type="button" class="linkedin">
                                    Add to Contacts
                                </button>
                            <?php elseif ($user["microsoft_id"]) : ?>
                                <button type="disabled" class="normal">
                                    Microsoft User
                                </button>
                            <?php elseif ($user["apple_id"]) : ?>
                                <button type="disabled" class="normal">
                                    Apple User
                                </button>
                            <?php elseif ($user["google_id"]) : ?>
                                <button type="disabled" class="normal">
                                    Google User
                                </button>
                            <?php else : ?>
                                <button type="disabled" class="normal">
                                    Messo User
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- <div class="flat-card">
                    <div class="user-info">
                        <p class="username">
                            @johndoe123
                        </p>
                        <p class="full-name">
                            John Foo Doe
                        </p>
                        <p class='date-joined'>
                            Join on July 19, 2022
                        </p>
                    </div>
                    <div class="user-action">
                        <button type="button" class="facebook">
                            Add on Facebook
                        </button>
                    </div>
                </div>
                <div class="flat-card">
                    <div class="user-info">
                        <p class="username">
                            @johndoe123
                        </p>
                        <p class="full-name">
                            John Foo Doe 2
                        </p>
                        <p class='date-joined'>
                            Join on July 19, 2022
                        </p>
                    </div>
                    <div class="user-action">
                        <button type="button" class="google">
                            Email on Google
                        </button>
                    </div>
                </div>
                <div class="flat-card">
                    <div class="user-info">
                        <p class="username">
                            @johndoe123
                        </p>
                        <p class="full-name">
                            John Foo Doe 3
                        </p>
                        <p class='date-joined'>
                            Join on July 19, 2022
                        </p>
                    </div>
                    <div class="user-action">
                        <button type="button" class="apple">
                            Go To Apple Profile
                        </button>
                    </div>
                </div>
                <div class="flat-card">
                    <div class="user-info">
                        <p class="username">
                            @johndoe1234
                        </p>
                        <p class="full-name">
                            John Foo Doe 4
                        </p>
                        <p class='date-joined'>
                            Join on July 19, 2022
                        </p>
                    </div>
                    <div class="user-action">
                        <button type="button" class="linkedin">
                            Add Contact in LinkedIn
                        </button>
                    </div>
                </div> -->
            </div>
    </main>


    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        const social_details = <?= json_encode($context) ?>

        let nav = document.querySelector("nav");
        window.onscroll = (e) => {
            if (window.scrollY >= 65) {
                nav.classList.add("lighten");
            } else {
                nav.classList.remove("lighten");
            }
        }
    </script>
    <script src="./scripts/auth.js"></script>

</body>

</html>