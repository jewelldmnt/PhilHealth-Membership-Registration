<?php
/**
 * Checks if the member already exists and redirects to memberDetails.php if so.
 * Retrieves member details from the form and inserts them into the members_profile 
 * table. Inserts dependent details into the dependents_profile table if any are 
 * provided. Updates the foreign key in the login_credentials table with the member's 
 * PIN. Redirects to memberDetails.php after successful insertion.
*/

function generateRandomString($length = 7) {
    /**
     * Generates a random string of specified length.
     *
     * @param int $length The length of the random string to be generated.
     * @return string The generated random string.
     */
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function generateRandomPIN($length = 12) {
    /**
     * Generates a random PIN of specified length that is not used in the database.
     *
     * @param int $length The length of the random PIN to be generated.
     * @return string The generated random PIN.
     */
    include("db.php");
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    do {
        $randomPIN = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPIN .= $characters[rand(0, $charactersLength - 1)];
        }
        $query = "SELECT COUNT(*) AS count FROM login_credentials WHERE PIN = '$randomPIN'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
    } while ($count > 0); // Loop until a unique PIN is generated
    return $randomPIN;
}

$randomPIN = generateRandomPIN();


session_start();
include("db.php");
$username = $_SESSION['username'];

// Check if the user is already a PhilHealth member
$query = "SELECT * 
          FROM login_credentials 
          WHERE username = '$username' AND PIN IS NULL";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) == 0) {
    header("location: memberDetails.php");
    exit;

} else {
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        // Retrieve member details from the form
        $PIN = $_POST['PIN'];
        $KonsultaProvider = $_POST['KonsultaProvider'];
        $MemFullName = $_POST['MemFullName'];
        $MothersMaidenName = $_POST['MothersMaidenName'];
        $SpouseFullName = $_POST['SpouseFullName'];
        $BirthDate = $_POST['BirthDate'];
        $BirthPlace = $_POST['BirthPlace'];
        $Sex = $_POST['Sex'];
        $CivilStatus = $_POST['CivilStatus'];
        $Citizenship = $_POST['Citizenship'];
        $PhilsysID = $_POST['PhilsysID'];
        $TIN = $_POST['TIN'];
        $PermanentAddress = $_POST['PermanentAddress'] . ', ' . $_POST['ZipCodeP'];
        $MailingAddress = $_POST['MailingAddress'] . ', '. $_POST['ZipCodeM'];
        $Landline = $_POST['Landline'];
        $MobileNum = $_POST['MobileNum'];
        $BizDirectLine = $_POST['BizDirectLine'];
        $Email = $_POST['Email'];
        $MemberType = $_POST['MemberType'];
        $Contributor = $_POST['Contributor'];
        $Profession = $_POST['Profession'];
        $MonthlyIncome = $_POST['MonthlyIncome'];
        $IncomeProof = $_POST['IncomeProof'];
        $POS = $_POST['POS'];
        
        // Insert member details into members_profile table
        $query = "INSERT INTO members_profile (PIN, 
                                               KonsultaProvider,
                                               MemFullName,
                                               MothersMaidenName,
                                               SpouseFullName,
                                               BirthDate,
                                               BirthPlace,
                                               Sex,
                                               CivilStatus,
                                               Citizenship,
                                               PhilsysID,
                                               TIN,
                                               PermanentAddress,
                                               MailingAddress,
                                               Landline,
                                               MobileNum,
                                               BizDirectLine,
                                               Email,
                                               MemberType,
                                               Contributor,
                                               Profession,
                                               MonthlyIncome,
                                               IncomeProof,
                                               POS) 
                   VALUES('$PIN',
                          '$KonsultaProvider',
                          '$MemFullName',
                          '$MothersMaidenName',
                          '$SpouseFullName',
                          '$BirthDate',
                          '$BirthPlace',
                          '$Sex',
                          '$CivilStatus',
                          '$Citizenship',
                          '$PhilsysID',
                          '$TIN',
                          '$PermanentAddress',
                          '$MailingAddress',
                          '$Landline',
                          '$MobileNum',
                          '$BizDirectLine',
                          '$Email',
                          '$MemberType',
                          '$Contributor',
                          '$Profession',
                          '$MonthlyIncome',
                          '$IncomeProof',
                          '$POS')";
        mysqli_query($connection, $query);

        // Check if the first dependent is not null
        $depFullName1 = $_POST['DepFullName1'];
        if (!empty($depFullName1)) {

            $counter = 1;
            $lastDependentNumber = $counter;
            while (isset($_POST['DepFullName' . $counter])) {
                $lastDependentNumber = $counter;
                $counter++;
            }

            for ($i = 1; $i <= $lastDependentNumber; $i++) {
                $DepFullName = $_POST['DepFullName' . $i];
                $DepBirthdate = $_POST['DepBirthdate' . $i];
                $DepCitizenship = $_POST['DepCitizenship' . $i];
                $WithDisability = $_POST['WithDisability' . $i];
                $Relationship = $_POST['Relationship' . $i];
                
                // Get the last 3 letters of the dependent's first name
                $depNamePart = substr(end(explode(' ', $DepFullName)), -3);
                // Get the last 3 letters of the member's first name
                $depMemNamePart = substr(end(explode(' ', $MemFullName)), -3);
                // Get the 3 letters of the birth month
                $birthMonth = date('M', strtotime($DepBirthdate));
                // Get the current year
                $currentYear = date('Y');
                // Get 7 random letters
                $randomString = generateRandomString();

                // Combine the pattern for the DepID
                $DepID = $depNamePart . $depMemNamePart . $birthMonth . $currentYear . $randomString;

                $depQuery = "INSERT INTO dependents_profile (DepID, DepFullName, DepBirthdate, DepCitizenship, WithDisability, Relationship, PIN) 
                             VALUES ('$DepID', '$DepFullName', '$DepBirthdate', '$DepCitizenship', '$WithDisability', '$Relationship', '$PIN')";
                mysqli_query($connection, $depQuery);
            }
        }
        
        // Update the foreign key in login_credentials table
        $fkquery = "UPDATE login_credentials SET PIN = '$PIN'
                    WHERE username = '$username'";
        mysqli_query($connection, $fkquery);
        header("location: memberDetails.php");
    }
}

mysqli_close($connection);
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
                        <a href="index.php#benefits" class="nav__link" onclick=isLogIn(true)">Benefits</a>
                    </li>

                    <li class="nav__item">
                        <a href="registration.php" class="nav__link active__link">Register</a>
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


    <!-- ============ <QUALIFICATIONS> ============ -->
    <div id="qualifications" class="overlay">
        <div class="popup">
            <h2>Qualifications</h2>
            <div class="content members">
                <h3 class="qualification__subtitle">PhilHealth Member</h3>
                <ul>
                    <li>
                        Members of the informal economy from the lower income segment who do not qualify for full
                        subsidy under the means test rule of the DSWD, whose premium contribution shall be subsidized by
                        the LGUs or shall be through cost-sharing mechanisms between/among LGUs, and/or legislative
                        sponsors, and/or other sponsors and/or the member, including the National Government;
                    </li>

                    <li>
                        Orphans, abandoned (children who have no known family willing and capable to take care of them
                        and are under the care of the DSWD, orphanages, churches and other institutions) and abused
                        minors, out-of-school youths, street children, persons with disability (PWD), senior citizens
                        and battered women under the care of the DSWD, or any of its accredited institutions run by NGOs
                        or any non-profit private organizations, whose premium contributions shall be paid for by the
                        DSWD;
                    </li>

                    <li>
                        Barangay health workers, nutrition scholars, barangay tanods, and other barangay workers and
                        volunteers, whose premium contributions shall be fully borne by the LGUs concerned; and
                    </li>

                    <li>
                        Un-enrolled women who are about to give birth, whose premium contributions shall be fully borne
                        by the National Government and/or LGUs and/or legislative sponsors or the DSWD if such woman is
                        an indigent as determined by it through the means test.
                    </li>
                </ul>
            </div>
            <div class="content dependents">
                <h3 class="qualification__subtitle">PhilHealth Member's Dependents</h3>
                <ul>
                    <li>
                        Legitimate spouse who is not a member
                    </li>

                    <li>
                        Child or children - legitimate, legitimated, acknowledged and illegitimate (as appearing in
                        birth certificate) adopted or stepchild or stepchildren below 21 years of age, unmarried and
                        unemployed.
                    </li>

                    <li>
                        Children who are twenty-one (21) years old or above but suffering from congenital disability,
                        either physical or mental, or any disability acquired that renders them totally dependent on the
                        member for support, as determined by the Corporation
                    </li>

                    <li>
                        Foster child as defined in Republic Act 10165 otherwise known as the Foster Care Act of 2012
                    </li>

                    <li>
                        Parents who are sixty (60) years old or above, not otherwise an enrolled member, whose monthly
                        income is below an amount to be determined by PhilHealth in accordance with the guiding
                        principles set forth in the NHI Act of 2013; and,
                    </li>

                    <li>
                        Parents with permanent disability regardless of age as determined by PhilHealth, that renders
                        them totally dependent on the member for subsistence.
                    </li>
                </ul>
            </div>
            <a class="close" href="#">&times;</a>
        </div>
    </div>
    <!-- ============ <END OF QUALIFICATIONS> ============ -->


    <!-- ============ <REGISTRATION> ============ -->
    <div class="registration__container container grid">
        <div class="card">
            <div class="form">
                <div class="left__side">

                    <!-- CURRENT STEP LABEL -->
                    <div class="steps__content">
                        <h3 class="step__number">Step 1</h3>
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

                <!-- ============ <REGISTRATION FORM> ============ -->
                <div class="right__side">
                    <form method="post">

                    
                        <!-- PERSONAL DETAILS -->
                        <div class="main__form active">
                            <div class="input__text">
                                <div class="input__div">
                                    <input type="text" name="PIN" required require id="PIN" value="<?php echo $randomPIN; ?>" readonly>
                                    <span>PhilHealth Identification Number <strong style="color: red;">*</strong></span>
                                </div>
                                <div class="input__div">
                                    <input type="text" name="KonsultaProvider" id="KonsultaProvider" placeholder="xxx"
                                        maxlength="40">
                                    <span>Preferred KonSulta Provider</span>
                                </div>
                            </div>

                            <div class="input__text">
                                <div class="input__div">
                                    <input type="text" name="MemFullName" required require id="MemFullName" placeholder="xxx" maxlength="50">
                                    <span>Member's Fullname (FN MN LN) <strong style="color: red;">*</strong></span>
                                </div>
                            </div>

                            <div class="input__text">
                                <div class="input__div">
                                    <input type="text" name="MothersMaidenName" required require id="MothersMaidenName" placeholder="xxx"
                                        maxlength="50">
                                    <span>Mother's Maiden Name (FN MN LN) <strong style="color: red;">*</strong></span>
                                </div>
                            </div>

                            <div class="input__text">
                                <div class="input__div">
                                    <input type="text" name="SpouseFullName" id="SpouseFullName" placeholder="xxx" maxlength="50">
                                    <span>Spouse Fullname if married (FN MN LN)</span>
                                </div>
                            </div>

                            <div class="input__text">
                                <div class="input__div birthdate">
                                    <input type="date" name="BirthDate" class="birth__date" required require id="BirthDate">
                                    <span>Birth Date <strong style="color: red;">*</strong></span>
                                </div>
                                <div class="input__div birthplace">
                                    <input type="text" name="BirthPlace" required require id="BirthPlace" placeholder="xxx" maxlength="50">
                                    <span>Place of Birth (City/Municipality/Province/Country) <strong
                                            style="color: red;">*</strong></span>
                                </div>
                            </div>

                            <div class="input__text">
                                <div class="input__div">
                                    <select name="Sex" required require id="Sex">
                                        <option value="" disabled selected hidden>Sex <strong style="color: red;">*</strong>
                                        </option>
                                        <option value="F">Female</option>
                                        <option value="M">Male</option>
                                    </select>
                                </div>
                                <div class="input__div">
                                    <select name="CivilStatus" required require id="CivilStatus">
                                        <option value="" disabled selected hidden>Civil Status <strong
                                                style="color: red;">*</strong></option>
                                        <option value="S">Single</option>
                                        <option value="M">Married</option>
                                        <option value="LS">Legally Separated</option>
                                        <option value="A">Annulled</option>
                                        <option value="W">Widow/er</option>
                                    </select>
                                </div>
                                <div class="input__div">
                                    <select name="Citizenship" required require id="Citizenship">
                                        <option value="" disabled selected hidden>Citizenship <strong
                                                style="color: red;">*</strong></option>
                                        <option value="F">Filipino</option>
                                        <option value="DC">Dual Citizen</option>
                                        <option value="FN">Foreign National</option>
                                    </select>
                                </div>
                            </div>

                            <div class="input__text">
                                <div class="input__div">
                                    <input name="PhilsysID" type="text" id="PhilsysID" placeholder="xxx" pattern=".{12}">
                                    <span> Philsys ID number (Optional)</span>
                                </div>
                                <div class="input__div">
                                    <input name="TIN" type="text" id="TIN" placeholder="xxx" pattern=".{9}">
                                    <span>Tax Payer Identification (TIN) (Optional)</span>
                                </div>
                            </div>

                            <div class="registration__buttons">
                                <button class="next_button">Next</button>
                            </div>
                        </div>
                        <!-- END OF PERSONAL DETAILS -->


                        <!-- ADDRESS AND CONTACT DETAILS -->
                        <div class="main__form">
                            <h3 class="form__label">Permanent Address <strong style="color: red;">*</strong></h3>
                            <div class="input__text">
                                <div class="input__div">
                                    <input name="PermanentAddress" type="text" required require id="PermanentAddress" placeholder="xxx" maxlength="100">
                                    <span> Unit/Blk/Lot/City etc.</span>
                                </div>

                                <div class="input__div1">
                                    <input type="text" name="ZipCodeP" required require id="ZipCodeP" placeholder="xxxx" maxlength="4">
                                    <span> Zip Code </span>
                                </div>
                            </div>

                            <h3 class="form__label">Mailing Address&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="SameAs" onclick="duplicate();" />
                                <label for="SameAs" class="check">Same as Above</label>
                            </h3>

                            <div class="input__text">
                                <div class="input__div">
                                    <input name="MailingAddress" type="text" required require id="MailingAddress" placeholder="xxx" maxlength="100">
                                    <span> Unit/Blk/Lot/City etc.</span>
                                </div>
                                <div class="input__div1">
                                    <input type="text" name="ZipCodeM" required require id="ZipCodeM" placeholder="xxxx" maxlength="4">
                                    <span> Zip Code </span>
                                </div>
                            </div>

                            <h3 class="form__label">Contact Details</h3>
                            <div class="input__text">
                                <div class="input__div">
                                    <input name="Landline" type="text" id="Landline" placeholder="xxxx-xxxx" maxlength="12">
                                    <span>Home Landline (02-XXXX-XXXX)</span>
                                </div>
                            </div>

                            <div class="input__text">
                                <div class="input__div">
                                    <input name="MobileNum" type="text" required require id="MobileNum" placeholder="xxxx-xxx-xxxx" maxlength="15" pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}">
                                    <span>Mobile Number (09XX-XXX-XXXX) <strong style="color: red;">*</strong></span>
                                </div>
                            </div>

                            <div class="input__text">
                                <div class="input__div">
                                    <input name="BizDirectLine" type="text" id="BizDirectLine" placeholder="xxx" maxlength="15">
                                    <span>Business Direct Line (Mobile no. or Tel no.)</span>
                                </div>
                            </div>

                            <div class="input__text">
                                <div class="input__div">
                                    <input name="Email" type="text" required require id="Email" placeholder="e.g@mail.com" maxlength="30" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" autocomplete="email">
                                    <span>E-mail Address <strong style="color: red;">*</strong></span>
                                </div>
                            </div>
                        
                            <div class="registration__buttons button_space">
                                <button class="back_button">Previous</button>
                                <button class="next_button">Next</button>
                            </div>
                        </div> 
    

                        <!-- DECLARATION OF DEPENDENTS -->
                        <div class="main__form">
                            <div id="depform">
                                <h3 class="form__label">Dependent 1</h3>
                                <div class="input__text">
                                    <div class="input__div">
                                        <input type="text" name="DepFullName1" required require id="depFullName1" placeholder="xxx" maxlength="50">
                                        <span>Dependent's Fullname (LN, FN MN) <strong style="color: red;">*</strong></span>
                                    </div>
                                </div>
                                <div class="input__text">
                                    <div class="input__div birthdate">
                                        <input type="date" name="DepBirthdate1" class="birth__date" required id="depBirthDate1">
                                        <span>Birth Date <strong style="color: red;">*</strong></span>
                                    </div>
                                    <div class="input__div">
                                        <select name="DepCitizenship1" required require id="depCitizenship1">
                                            <option value="" disabled selected hidden>Citizenship <strong
                                                    style="color: red;">*</strong></option>
                                            <option value='F'>Filipino</option>
                                            <option value='DC'>Dual Citizen</option>
                                            <option value='FN'>Foreign National</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="input__text">
                                    <div class="input__div">
                                        <select name="WithDisability1" required require id="withDisability1">
                                            <option value="" disabled selected hidden>With Disability<strong
                                                    style="color: red;">*</strong></option>
                                            <option value='Y'>Yes</option>
                                            <option value='N'>No</option>
                                        </select>
                                    </div>
                                    <div class="input__div">
                                        <select name="Relationship1" required require id="Relationship1">
                                            <option value="" disabled selected hidden>Relationship<strong
                                                    style="color: red;">*</strong></option>
                                            <option value='S'>Spouse</option>
                                            <option value='C'>Children</option>
                                            <option value='P'>Parents</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="add__button">
                                <button class="add_dependents" onclick="addMoreField()"><i class='bx bx-plus-circle'></i>  &nbsp;Add another Dependent</button>
                            </div>
                            <div class="registration__buttons button_space">
                                <button class="back_button">Previous</button>
                                <button class="next_button">Next</button>
                            </div>
                        </div>
                        <!-- END OF DECLARATION OF DEPENDENTS -->


                        <!-- MEMBER TYPE -->
                        <div class="main__form">
                            <h3 class="form__label">Contributor Type: <strong style="color: red;">*</strong></h3>
                            <div class="radio__container" id="Contributor">
                                <div class="form">
                                    <label>
                                        <input name="Contributor" value="D" type="radio" required id="DirectContributor" onclick="updateMemberTypeOptions();" name="ContributorType">
                                        <span>Direct Contributor</span>
                                    </label>
                                    <label>
                                        <input name="Contributor" value="I"  type="radio" required id="IndirectContributor" onclick="updateMemberTypeOptions();" name="ContributorType">
                                        <span>Indirect Contributor</span>
                                    </label>
                                </div>
                            </div>
                            <div class="input__text">
                                <div class="input__div">
                                    <select name="MemberType" required require id="MemberType">
                                        <option value="" disabled selected hidden>Member Type <strong style="color: red;">*</strong>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="input__text">
                                <div class="input__div">
                                    <input name="Profession" type="text" required require id="Profession" placeholder="xxx" maxlength="30">
                                    <span>Profession (Except Employed, Lifetime Members, and Sea-Based Migrant Worker) <strong style="color: red;">*</strong></span>
                                </div>
                            </div>
                            <div class="input__text">
                                <div class="input__div">
                                    <input type="number" name="MonthlyIncome" required require id="MonthlyIncome" placeholder="xxx" min="1" max="999999.99" step=".01" pattern="^\d+(?:\.\d{1,2})?$">
                                    <span>Monthly Income <strong style="color: red;">*</strong></span>
                                </div>
                                <div class="input__div">
                                    <input type="text" name="IncomeProof" required require id="IncomeProof" placeholder="xxx" maxlength="30">
                                    <span>Proof of Income <strong style="color: red;">*</strong></span>
                                </div>
                            </div>
                            <h3 class="form__label">For PhilHealth Use only: <strong style="color: red;">*</strong></h3>
                            <div class="radio__container" id="POS">
                                <div class="form">
                                    <label>
                                        <input type="radio" value="Y" required name="POS" id="TruePos">
                                        <span>Point of Service (POS) Financially Incapable</span>
                                    </label>
                                    <label>
                                        <input type="radio" value="N" required name="POS" id="NotPos">
                                        <span>Financially Capable</span>
                                    </label>
                                </div>
                            </div>
                            <div class="registration__buttons button_space">
                                <button class="back_button">Previous</button>
                                <input type="submit" class="submit_button"></input>
                            </div>
                        </div>
                        <!-- END OF MEMBER TYPE -->

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============ </REGISTRATION FORM> ============ -->


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