<?php
session_start();

include("db.php");

$username = $_SESSION['username'];



?>

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

    <title>PhilHealth Membership Registration</title>
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
                        <a href="registration.php" class="nav__link">Register</a>
                    </li>

                    <li class="nav__item">
                        <a href="#" class="nav__link" onclick="toggleMenu()">
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

    <!-- ============ <FORM> ============ -->
    <div class="registration__container container grid">
        <div class="card">
            <div class="form">
                <div class="left__side">

                    <!-- CURRENT STEP LABEL -->
                    <div class="steps__content">
                        <h3 class="step__number" style="opacity: 0;">Step 1</h3>
                        <h3 id="memDetails__title">Member's Details</h3>
                    </div>
                    <!-- PROGRESS BAR LABEL  -->
                    <ul class="progress__bar">
                        <li class="active">Personal Details</li>
                        <li>
                            <p>Address and Contact Details</p>
                        </li>
                        <li>
                            <p>Declaration of Dependents</p>
                        </li>
                        <li>
                            <p>Member Type</p>
                        </li>
                    </ul>
                </div>

                <!-- ============ <FORM REVIEW> ============ -->
                <div class="right__side">
                    <!-- PERSONAL DETAILS -->
                    <div class="main__form active">
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" placeholder="xxx" maxlength="12" value="123456666999" readonly>
                                <span>PhilHealth Identification Number</span>
                            </div>
                            <div class="input__div">
                                <input type="text" placeholder="xxx" maxlength="40" value="AJ JA" readonly>
                                <span>Preferred KonSulta Provider</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="memFullName"placeholder="xxx" maxlength="50" value="Bernard Batumbakal" readonly>
                                <span>Member's Fullname (LN, FN MN)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="memMother" placeholder="xxx" maxlength="50" value="Jewell Batumbakal" readonly>
                                <span>Mother's Maiden Name (LN, FN MN)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="memMotherSpouse" placeholder="xxx" maxlength="50" value="Spouse Rebil" readonly>
                                <span>Spouse Fullname if married (LN, FN MN)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div birthdate">
                                <input type="text" id="memBirthDate" value="2003/11/15" readonly>
                                <span>Birth Date</span>
                            </div>
                            <div class="input__div birthplace">
                                <input type="text" id="memBirthPlace" placeholder="xxx" maxlength="50" value="Old Sta.Mesa" readonly>
                                <span>Place of Birth (City/Municipality/Province/Country)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="memSex" placeholder="xxx" value="Secret" readonly>
                                    <span>Sex </span>
                            </div>
                            <div class="input__div">
                                <input type="text" id="memCivStatus" placeholder="xxx" value="Complicated" readonly>
                                    <span> Civil Status </span>
                                </select>
                            </div>
                            <div class="input__div">
                                <input type="text" id="memCitizenship" placeholder="xxx" value="Japaneze" readonly>
                                    <span> Citizenship </span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="memPhilsysID" placeholder="xxx" maxlength="12" value="66666999999" readonly>
                                <span> Philsys ID number (Optional)</span>
                            </div>
                            <div class="input__div">
                                <input type="text" id="memTin" placeholder="xxx" maxlength="9" value="666669999" readonly>
                                <span>Tax Payer Identification (TIN) (Optional)</span>
                            </div>
                        </div>

                        <div class="registration__buttons">
                            <button class="next_button">Next</button>
                        </div>
                    </div>
                    <!-- END OF PERSONAL DETAILS -->


                    <!-- ADDRESS AND CONTACT DETAILS -->
                    <div class="main__form" id="addresscontact">
                        <h3 class="form__label">Permanent Address</h3>
                        <div class="input__text" id ="PermanentAddress">
                            <div class="input__div">
                                <input type="text" id="PermanentAddress1" placeholder="xxx" maxlength="100" value="PasigManilaQuezonCaloocan" readonly>
                                <span> Unit/Blk/Lot/City etc.</span>
                            </div>

                            <div class="input__div1">
                                <input type="text" id="PermanentAddress2" placeholder="xxxx" maxlength="4" value="6969" readonly>
                                <span> Zip Code </span>
                            </div>
                        </div>

                        <h3 class="form__label">Mailing Address&nbsp;&nbsp;&nbsp; </h3>
                        <div class="input__text" id ="MailingAddress">
                            <div class="input__div">
                                <input type="text" id="MailingAddress1" placeholder="xxx" maxlength="100" value="PasigManilaQuezonCaloocan" readonly>
                                <span> Unit/Blk/Lot/City etc.</span>
                            </div>
                            <div class="input__div1">
                                <input type="text" id="MailingAddress2" placeholder="xxxx" maxlength="4" value="6699" readonly>
                                <span> Zip Code </span>
                            </div>
                        </div>

                        <h3 class="form__label">Contact Details</h3>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="Landline" placeholder="xxxx-xxxx" maxlength="12" value="6666-9999" readonly>
                                <span>Home Phone Number(Landline)</span>
                            </div>
                        </div>

                        <div class="input__text">
                             <div class="input__div">
                                <input type="text" id="MobileNum" placeholder="xxx-xxxx-xxxx" maxlength="15" value="+639296666999" readonly>
                                <span>Mobile Number (Required)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="BizDirectLine" placeholder="xxx-xxxx-xxxx" maxlength="15" value="+639296666999" readonly>
                                <span>Business (Direct Line)</span>
                            </div>
                       </div>

                       <div class="input__text">
                        <div class="input__div">
                            <input type="text" id="Email" placeholder="xxx" maxlength="30" value="e.g@mail.com" readonly>
                            <span>E-mail Address (Required for OFW)</span>
                        </div>
                      </div>
                      <div class="registration__buttons button_space">
                        <button class="back_button">Previous</button>
                        <button class="next_button">Next</button>
                    </div>
                </div>
                    <!-- END OF ADDRESS AND CONTACT DETAILS -->


                    <!-- DECLARATION OF DEPENDENTS -->
                    <div class="main__form" id="dependentform">
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="depFullName" placeholder="xxx" maxlength="50" value="Bernard Angelo Resurreccion" readonly>
                                <span>Dependent's Fullname (LN, FN MN)</span>
                            </div>
                        </div>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="depBirthDate" value="2003/11/15" readonly>
                                <span>Birth Date</span>
                            </div>
                            <div class="input__div">
                                <input type="text" id="Citizenship" placeholder="xxx" maxlength="50" value="Filipino" readonly>
                                <span>Citizenship</span>
                            </div>
                        </div>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="withDisability" placeholder="xxx" maxlength="50" value="Yes" readonly>
                                <span>With Disability</span>
                            </div>
                            <div class="input__div">
                                <div class="input__div">
                                    <input type="text" id="Relationship" placeholder="xxx" maxlength="50" value="Pusa" readonly>
                                    <span>Relationship</span>
                                </div>
                            </div>
                        </div>
                        <div class="registration__buttons button_space">
                            <button class="back_button">Previous</button>
                            <button class="next_button">Next</button>
                        </div>
                    </div>
                    <!-- END OF DECLARATION OF DEPENDENTS -->


                    <!-- MEMBER TYPE -->
                    <div class="main__form">
                        <h3 class="form__label">Contributor Type:</h3>
                        <div class="radio__container" id="Contributor">
                            <form>
                                <label>
                                    <input type="radio" id="DirectContributor" name="ContributorType" checked>
                                    <span>Direct Contributor</span>
                                </label>
                                <label>
                                    <input type="radio" id="IndirectContributor" name="ContributorType" disabled>
                                    <span>Indirect Contributor</span>
                                </label>
                            </form>
                        </div>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="MemberType" placeholder="xxx" maxlength="30" value="pokpok" readonly>
                                <span>MEMBER TYPE</span>
                            </div>
                        </div>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" id="Profession" placeholder="xxx" maxlength="30" value="pwet" readonly>
                                <span>Profession (Except Employed, Lifetime Members, and Sea-Based Migrant Worker)</span>
                            </div>
                        </div>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="number" id="MonthlyIncome" placeholder="xxx" min="1" max="999999.99" step=".01" pattern="^\d+(?:\.\d{1,2})?$" value="666.69" readonly>
                                <span>MONTHLY INCOME</span>
                            </div>
                            <div class="input__div">
                                <input type="text" id="IncomeProof" placeholder="xxx" maxlength="30" value="AUQ SABE" readonly>
                                <span>Proof of Income</span>
                            </div>
                        </div>
                        <h3 class="form__label">For PhilHealth Use only:</h3>
                        <div class="radio__container" id="POS">
                            <form>
                                <label>
                                    <input type="radio" name="POSType" id="TruePos" disabled>
                                    <span>Point of Service (POS) Financially Incapable</span>
                                </label>
                                <label>
                                    <input type="radio" name="POSType" id="NotPos" checked>
                                    <span>Financially Incapable</span>
                                </label>
                            </form>
                        </div>
                        <div class="registration__buttons button_space">
                            <button class="back_button">Previous</button>
                        </div>
                    </div>
                    <!-- END OF MEMBER TYPE -->
                </div>
            </div>
        </div>
    </div>
    <!-- ============ </FORM REVIEW> ============ -->


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