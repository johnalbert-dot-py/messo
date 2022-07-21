<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . "/controllers/Sign-Up.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messo | Sign Up</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans" rel="stylesheet">
    <link href="http://fonts.cdnfonts.com/css/helvetica-neue-9" rel="stylesheet">
    <link href="http://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">
    <link rel="icon" href="/views/assets/logo.png" type="image/png">

</head>

<body>

    <main id="app">
        <div class="card card-sm">
            <img class="card-bg-image" src="./assets/logo.png" />

            <div class="title">
                <h1>Let's get started.</h1>
                <p>Please fill up all the field to continue.</p>
            </div>

            <div class="fields">
                <form @submit="signUp">
                    <input type="hidden" name="linked-in-id" value="<?= isset($context['id']) ? $context['id'] : '' ?>" />
                    <input type="hidden" name="microsoft-id" v-model="microsoft_id" />
                    <div class="field">
                        <label for="username">Username</label>
                        <input type="text" placeholder="Enter your Username" name="username" v-model="username" required>
                        <span class="error" v-cloak>{{ username_error }}</span>
                    </div>
                    <div class="field">
                        <label for="first_name">First Name</label>
                        <input type="text" placeholder="Enter your First Name" name="first_name" v-model="first_name" required>
                        <span class="error" v-cloak>{{ first_name_error }}</span>
                    </div>
                    <div class="field">
                        <label for="last_name">Last Name</label>
                        <input type="text" placeholder="Enter your Last Name" name="last_name" v-model="last_name" required>
                        <span class="error" v-cloak>{{ last_name_error }}</span>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" placeholder="Enter your Password" name="password" v-model="password" required>
                        <span class="error" v-cloak>{{ password_error }}</span>
                    </div>
                    <div class="field">
                        <label for="confirm_password">Confirmation Password</label>
                        <input type="password" placeholder="Enter your Confirmation Password" name="confirm_password" v-model="confirm_password" required>
                        <span class="error" v-cloak>{{ confirm_password_error }}</span>
                    </div>
                    <button type="submit" class="btn btn-md btn-dark" style="width: 100%">Continue</button>
                </form>
            </div>
            <span style="text-align: center; margin-top: 20px">
                Already have an account? <a href="index.html">Log In</a>
            </span>
        </div>
    </main>

    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        const social_details = <?php echo json_encode($context) ?>
    </script>
    <script src="./scripts/auth.js"></script>

</body>

</html>