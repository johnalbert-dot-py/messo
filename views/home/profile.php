<?php
session_start();
require_once("../../controllers/Profile.php");
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
</head>

<body>

    <header>
        <nav>
            <h2>
                Messo
            </h2>
            <div class="items">
                <a href="/views/home/">
                    Home
                </a>
                <a href="/views/home/profile.php" class="active">
                    Profile
                </a>
                <a href="/views/logout.php">
                    Logout
                </a>
            </div>
        </nav>
    </header>
    <main id="app">
        <div class="container" style="display: flex; align-items: center; justify-content: center">
            <div class="card" style="width: 60%;">
                <form @submit="updateUser" style="width: 100%">
                    <div class="field">
                        <label for="username">Username</label>
                        <input disabled type="text" placeholder="Enter your Username" name="username" value="<?= $context["username"] ?>" required>
                    </div>
                    <div class="field" style="margin-top: 10px">
                        <label for="username">First Name</label>
                        <input disabled type="text" placeholder="Enter your First Name" name="first_name" value="<?= $context["first_name"] ?>" required>
                    </div>
                    <div class="field" style="margin-top: 10px">
                        <label for="username">Last Name</label>
                        <input disabled type="text" placeholder="Enter your Last Name" name="last_name" value="<?= $context["last_name"] ?>" required>
                    </div>
                    <div class="field" style="margin-top: 10px">
                        <label for="username">LinkedIn ID</label>
                        <input disabled type="text" placeholder="" name="linked-in-id" value="<?= $context["linked_in_id"] ? $context["linked_in_id"] : "N/A" ?>" required>
                    </div>
                    <div class="field" style="margin-top: 10px">
                        <label for="username">Microsoft ID</label>
                        <input disabled type="text" placeholder="" name="microsoft-id" value="<?= $context["microsoft_id"] ? $context["microsoft_id"] : "N/A" ?>" required>
                    </div>
                    <div class="field" style="margin-top: 10px">
                        <label for="username">Apple ID</label>
                        <input disabled type="text" placeholder="" name="apple-id" value="<?= $context["apple_id"] ? $context["apple_id"] : "N/A" ?>" required>
                    </div>
                    <div class="field" style="margin-top: 10px">
                        <label for="username">Facebook ID</label>
                        <input disabled type="text" placeholder="" name="facebook-id" value="<?= $context["facebook_id"] ? $context["facebook_id"] : "N/A" ?>" required>
                    </div>
                    <div class="field" style="margin-top: 10px">
                        <label for="username">Google ID</label>
                        <input disabled type="text" placeholder="" name="google-id" value="<?= $context["google_id"] ? $context["google_id"] : "N/A" ?>" required>
                    </div>
                    <!-- <button type="submit" class="btn btn-md btn-dark">Login</button> -->
                </form>
            </div>
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