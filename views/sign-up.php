<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/services/config.php");
$details = [];
if (isset($_GET["error"]) && isset($_GET["using"])) {
    if ($_GET["error"] == ERROR_CODE::$ALREADY_EXISTS && $_GET["using"] == "linked-in") {
        $details["error"] = "This LinkedIn account has already owned by other user.";
    }

    if ($_GET["error"] == ERROR_CODE::$ALREADY_EXISTS && $_GET["using"] == "google") {
        $details["error"] = "This Google account has already owned by other user.";
    }

    if ($_GET["error"] == ERROR_CODE::$ALREADY_EXISTS && $_GET["using"] == "microsoft") {
        $details["error"] = "This Microsoft account has already owned by other user.";
    }
}

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
    <link rel="icon" href="./assets/logo.png" type="image/png">

</head>

<body>

    <main id="app">
        <div class="card card-sm">
            <img class="card-bg-image" src="./assets/logo.png" />

            <div class="title">
                <h1>Let's make it Easy!</h1>
                <p>Select a social platform to easily create your account.</p>
            </div>
            <template v-if="page_error_message != ''">
                <div class="error-message">
                    {{ page_error_message }}
                </div>
            </template>

            <div class="fields" style="width: 75%">

                <div class="social-logins">
                    <button class="social-btn facebook" type="button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="24" fill="#1877F2" />
                            <path d="M23.5 12.0698C23.5 5.71857 18.3513 0.569849 12 0.569849C5.64872 0.569849 0.5 5.71857 0.5 12.0698C0.5 17.8098 4.70538 22.5674 10.2031 23.4301V15.3941H7.2832V12.0698H10.2031V9.53626C10.2031 6.65407 11.92 5.06204 14.5468 5.06204C15.805 5.06204 17.1211 5.28665 17.1211 5.28665V8.11672H15.671C14.2424 8.11672 13.7969 9.00319 13.7969 9.91263V12.0698H16.9863L16.4765 15.3941H13.7969V23.4301C19.2946 22.5674 23.5 17.8098 23.5 12.0698Z" fill="white" />
                        </svg>

                        <span>
                            Sign Up with Facebook
                        </span>

                    </button>
                    <form method="GET" action="social-login/google-auth.php">
                        <input type="hidden" name="redirect" value="sign-up">
                        <button class="social-btn google" type="submit">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="24" height="24" transform="translate(0.5)" fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M23.54 12.2614C23.54 11.4459 23.4668 10.6618 23.3309 9.90909H12.5V14.3575H18.6891C18.4225 15.795 17.6123 17.013 16.3943 17.8284V20.7139H20.1109C22.2855 18.7118 23.54 15.7636 23.54 12.2614Z" fill="#4285F4" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4999 23.4998C15.6049 23.4998 18.2081 22.4701 20.1108 20.7137L16.3942 17.8282C15.3645 18.5182 14.0472 18.926 12.4999 18.926C9.50469 18.926 6.96946 16.903 6.06514 14.1848H2.2231V17.1644C4.11537 20.9228 8.00446 23.4998 12.4999 23.4998Z" fill="#34A853" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.06523 14.1851C5.83523 13.4951 5.70455 12.758 5.70455 12.0001C5.70455 11.2421 5.83523 10.5051 6.06523 9.81506V6.83551H2.22318C1.44432 8.38801 1 10.1444 1 12.0001C1 13.8557 1.44432 15.6121 2.22318 17.1646L6.06523 14.1851Z" fill="#FBBC05" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4999 5.07386C14.1883 5.07386 15.7042 5.65409 16.8961 6.79364L20.1945 3.49523C18.2029 1.63955 15.5997 0.5 12.4999 0.5C8.00446 0.5 4.11537 3.07705 2.2231 6.83545L6.06514 9.815C6.96946 7.09682 9.50469 5.07386 12.4999 5.07386Z" fill="#EA4335" />
                            </svg>

                            <span>
                                Sign Up with Google
                            </span>
                        </button>
                    </form>
                    <button class="social-btn apple" type="button">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="24" transform="translate(0.5)" fill="black" />
                            <path d="M21.7806 18.424C21.4328 19.2275 21.0211 19.9672 20.5441 20.6473C19.8939 21.5743 19.3615 22.216 18.9512 22.5724C18.3151 23.1573 17.6337 23.4569 16.9039 23.4739C16.3801 23.4739 15.7483 23.3248 15.0129 23.0224C14.2751 22.7214 13.597 22.5724 12.977 22.5724C12.3268 22.5724 11.6294 22.7214 10.8835 23.0224C10.1365 23.3248 9.53466 23.4824 9.07453 23.498C8.37475 23.5278 7.67725 23.2198 6.98102 22.5724C6.53665 22.1848 5.98084 21.5204 5.31499 20.5791C4.6006 19.574 4.01326 18.4084 3.55313 17.0795C3.06035 15.6442 2.81332 14.2543 2.81332 12.9087C2.81332 11.3673 3.14639 10.0379 3.81351 8.92386C4.33781 8.02902 5.03531 7.32314 5.90829 6.80495C6.78127 6.28675 7.72453 6.02269 8.74033 6.00579C9.29614 6.00579 10.025 6.17772 10.9308 6.51561C11.834 6.85464 12.414 7.02656 12.6682 7.02656C12.8583 7.02656 13.5026 6.82553 14.5948 6.42475C15.6276 6.05307 16.4993 5.89917 17.2134 5.95979C19.1485 6.11596 20.6023 6.87877 21.5691 8.25305C19.8385 9.30165 18.9824 10.7703 18.9994 12.6544C19.0151 14.122 19.5474 15.3432 20.5938 16.3129C21.068 16.7629 21.5975 17.1108 22.1867 17.3578C22.0589 17.7283 21.924 18.0833 21.7806 18.424ZM17.3426 0.960146C17.3426 2.11041 16.9224 3.1844 16.0848 4.17848C15.0739 5.36025 13.8513 6.04313 12.5254 5.93537C12.5085 5.79738 12.4987 5.65214 12.4987 5.49952C12.4987 4.39527 12.9794 3.21351 13.8331 2.24725C14.2593 1.75802 14.8014 1.35123 15.4587 1.02673C16.1146 0.707068 16.735 0.530288 17.3185 0.500015C17.3355 0.653787 17.3426 0.807569 17.3426 0.960131V0.960146Z" fill="white" />
                        </svg>


                        <span>
                            Sign Up with Apple
                        </span>

                    </button>
                    </button>
                    <form method="GET" action="social-login/microsoft-auth.php">
                        <input type="hidden" name="redirect" value="sign-up">
                        <button class="social-btn microsoft" type="submit">
                            <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 3.40625V10.5312H8.57812V2.23438L0 3.40625ZM0 18.6406L8.57812 19.8125V11.6094H0V18.6406ZM9.51562 19.9531L21 21.5V11.6094H9.51562V19.9531ZM9.51562 2.09375V10.5312H21V0.5L9.51562 2.09375Z" fill="black" />
                            </svg>

                            <span>
                                Sign Up with Microsoft
                            </span>
                        </button>
                    </form>

                    <form method="GET" action="social-login/linkedin-auth.php">
                        <input type="hidden" name="redirect" value="sign-up">
                        <button class="social-btn linkedin" type="submit">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.875 0.125H1.33203C0.601562 0.125 0 0.769531 0 1.54297V18C0 18.7734 0.601562 19.375 1.33203 19.375H17.875C18.6055 19.375 19.25 18.7734 19.25 18V1.54297C19.25 0.769531 18.6055 0.125 17.875 0.125ZM5.80078 16.625H2.96484V7.47266H5.80078V16.625ZM4.38281 6.18359C3.4375 6.18359 2.70703 5.45312 2.70703 4.55078C2.70703 3.64844 3.4375 2.875 4.38281 2.875C5.28516 2.875 6.01562 3.64844 6.01562 4.55078C6.01562 5.45312 5.28516 6.18359 4.38281 6.18359ZM16.5 16.625H13.6211V12.1562C13.6211 11.125 13.6211 9.75 12.1602 9.75C10.6562 9.75 10.4414 10.9102 10.4414 12.1133V16.625H7.60547V7.47266H10.3125V8.71875H10.3555C10.7422 7.98828 11.6875 7.21484 13.0625 7.21484C15.9414 7.21484 16.5 9.14844 16.5 11.5977V16.625Z" fill="white" />
                            </svg>
                            <span>
                                Sign Up with LinkedIn
                            </span>
                        </button>
                    </form>
                </div>
                <span class="or-line">
                    <div></div>or <div></div>
                </span>
                <button type="submit" class="btn btn-md btn-dark" style="width: 100%" onclick="window.location.href = 'sign-up-form.php'">Sign Up</button>
            </div>
            <span style="text-align: center; margin-top: 20px">
                Already have an account? <a href="index.php">Log In</a>
            </span>
        </div>
    </main>

    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        const social_details = <?php echo $details == [] ? "{}" : json_encode($details) ?>
    </script>
    <script src="./scripts/auth.js"></script>

</body>

</html>