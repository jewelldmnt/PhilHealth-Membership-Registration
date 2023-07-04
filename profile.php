<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ============ FONT AWESOME ============ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- ============ BOX ICONS ============ -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- ============ css ============ -->
    <link rel="stylesheet" href=".\style\css\style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>PhilHealth Member's Profile</title>
</head>

<body>
    <!-- ============ <HEADER> ============ -->    
        <header class="header">
            <nav class="nav container">
                <a href="#" class="nav__logo">
                    <img src="assets/PhilHealth-logo.png" alt="" class="nav__logo-icon">
                    PhilHealth
                </a>
    
                <!-- ============ <NAVIGATION MENU> ============ -->    
                <div class="nav__menu" id="nav--menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="index.php" class="nav__link" onclick="isLogIn(true)">Home</a>
                        </li>
    
                        <li class="nav__item">
                            <a href="index.php#about" class="nav__link" onclick="isLogIn(true)">About</a>
                        </li>
    
                        <li class="nav__item">
                            <a href="index.php#benefits" class="nav__link" onclick="isLogIn(true)">Benefits</a>
                        </li>
    
                        <li class="nav__item">
                            <a href="registration.php#qualifications" class="nav__link">Register</a>
                        </li>
    
                        <li class="nav__item">
                            <a href="#" class="nav__link active__link-profile" onclick="toggleMenu()">
                                <i class='bx bxs-user-circle' id="profile__icon"></i>
                                <i class='bx bx-chevron-down'></i>
                            </a>
                            <div class="sub__menu__wrap" id="sub-menu-wrap">
                                <div class="sub__menu">
                                    <a href="profile.php" class="sub__menu__opt">
                                        <i class='bx bxs-user sub__menu-icon'></i>
                                        Profile
                                    </a>
                                    <hr>
                                    <a href="memberDetails.php" class="sub__menu__opt">
                                        <i class='bx bxs-file sub__menu-icon'></i>
                                        Personal Details
                                    </a>
                                    <hr>
                                    <a href="index.php" class="sub__menu__opt">
                                        <i class="fa-solid fa-right-from-bracket sub__menu-icon"></i>
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </li>   
                    </ul>
                </div>
                <!-- ============ </NAVIGATION MENU> ============ --> 
            </nav>
        </header>
        <!-- ============ </HEADER> ============ --> 

    <!-- ============ <PROFILE> ============ -->
        <div class="profile__container container grid">
        <!-- ACCOUNT -->
            <div class="left__column">
                <img src="/assets/profile/profile-icon.png" class="profile__icon-profile"></img>
                <a class="change__icon"><u>Edit Profile Picture</u></a>
            </div>
            <div class="right__column">
                <div class="username">
                    <input type="text" class="profile__input" value="BERNARD ANGELO RESURRECCION">
                    <label class="profile__input-label">Username</label>
                    <a class="changed__option"><u><nobr>Change Username?</nobr></u></a>
                </div>
                <div class="password">
                    <input type="text" class="profile__input" value="SECRET BAT KO SASABIHIN">
                    <label class="profile__input-label">Password</label>
                    <a class="changed__option"><u><nobr>Change Password?</nobr></u></a>
                </div>
                <div class="pin">
                    <input type="text" class="profile__input" value="69-69-69-69-69-420-420-420-420-420">
                    <label class="profile__input-label">PIN</label>
                </div>
            </div>
        <!-- END OF ACCOUNT -->    
        </div>

    <!-- ============ </PROFILE> ============ -->


    <!-- ============ <FOOTER> ============ -->
    <footer class="footer">
        <div class="footer__container">
            <span class="footer__copy">
                &#169; Polytechnic University of the Philippines | BSCS 2-3 Group 1
            </span>
        </div>
    </footer>
    <!-- ============ </FOOTER> ============ -->

    <!--=============== MAIN JS ===============-->
    <script src="main.js"></script>
</body>

</html>