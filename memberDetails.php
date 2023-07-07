<?php

session_start();
include("db.php");
$username = $_SESSION['username'];


// Check if the user is already a PhilHealth member
$query = "SELECT PIN 
          FROM loginCredentials 
          WHERE username = '$username' AND PIN IS NOT NULL";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) == 0) {
    header("location: profile.php");
    exit;
} else {
    $row = mysqli_fetch_assoc($result);
    $PIN = $row['PIN'];
    
    $query = "SELECT * 
              FROM members_profile 
              WHERE PIN = '$PIN'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    $depQuery = "SELECT * 
              FROM dependents_profile 
              WHERE PIN = '$PIN'";
    $depResult = mysqli_query($connection, $depQuery);
    $dependentRecords = [];
    // Loop through the dependent records
    for ($i = 1; $depRow = mysqli_fetch_assoc($depResult); $i++) {
        $dependentRecords[$i] = [
            'DepFullName' => $depRow['DepFullName'],
            'DepBirthdate' => $depRow['DepBirthdate'],
            'DepCitizenship' => $depRow['DepCitizenship'],
            'WithDisability' => $depRow['WithDisability'],
            'Relationship' => $depRow['Relationship']
        ];
    }
    $numberOfDependents = count($dependentRecords);


    // Retrieve member details from the form
    $KonsultaProvider = $row['KonsultaProvider'];
    $MemFullName = $row['MemFullName'];
    $MothersMaidenName = $row['MothersMaidenName'];
    $SpouseFullName = $row['SpouseFullName'];
    $BirthDate = $row['BirthDate'];
    $BirthPlace = $row['BirthPlace'];

    $Sex = ($row['Sex'] == 'M') ? "Male" : "Female";

    $CivilStatus = $row['CivilStatus'];
    if ($CivilStatus == 'S') {
        $CivilStatus = "Single";
    } elseif ($CivilStatus == 'M') {
        $CivilStatus = "Married";
    } elseif ($CivilStatus == 'LS') {
        $CivilStatus = "Legally Separated";
    } elseif ($CivilStatus == 'A') {
        $CivilStatus = "Annulled";
    } elseif ($CivilStatus == 'W') {
        $CivilStatus = "Widow/er";
    }

    $Citizenship = $row['Citizenship'];
    if ($Citizenship == 'F') {
        $Citizenship = "Filipino";
    } elseif ($Citizenship == 'FN') {
        $Citizenship = "Foreign National";
    } elseif ($Citizenship == 'DC') {
        $Citizenship = "Dual Citizen";
    }

    $PhilsysID = $row['PhilsysID'];
    $TIN = $row['TIN'];

    $PermanentAddress = $row['PermanentAddress'];
    $ZipCodeP = trim(substr($PermanentAddress, strrpos($PermanentAddress, ",") + 1));
    $lastCommaIndex = strrpos($PermanentAddress, ",");
    $PermanentAddress = substr($PermanentAddress, 0, $lastCommaIndex);

    $MailingAddress = $row['MailingAddress'];
    $ZipCodeM = trim(substr($MailingAddress, strrpos($MailingAddress, ",") + 1));
    $lastCommaIndex = strrpos($MailingAddress, ",");
    $MailingAddress = substr($MailingAddress, 0, $lastCommaIndex);

    $Landline = $row['Landline'];
    $MobileNum = $row['MobileNum'];
    $BizDirectLine = $row['BizDirectLine'];
    $Email = $row['Email'];

    $MemberType = $row['MemberType'];
    if ($MemberType == 'EP') {
        $MemberType = "Employed Private";
    } elseif ($MemberType == 'EG') {
        $MemberType = "Employed Government";
    } elseif ($MemberType == 'PP') {
        $MemberType = "Professional Practitioner";
    } elseif ($MemberType == 'SEI-I') {
        $MemberType = "Self-Earning Individual (Individual)";
    } elseif ($MemberType == 'SEI-SP') {
        $MemberType = "Self-Earning Individual (Sole Proprietor)";
    } elseif ($MemberType == 'SEI-GES') {
        $MemberType = "Self-Earning Individual (Group Enrollment)";
    } elseif ($MemberType == 'K') {
        $MemberType = "Kasambahay";
    } elseif ($MemberType == 'FD') {
        $MemberType = "Family Driver";
    } elseif ($MemberType == 'MW-LB') {
        $MemberType = "Migrant Worker (Land-Based)";
    } elseif ($MemberType == 'MW-SB') {
        $MemberType = "Migrant Worker (Sea-Based)";
    } elseif ($MemberType == 'LM') {
        $MemberType = "Lifetime Member";
    } elseif ($MemberType == 'FDC') {
        $MemberType = "Filipinos with Dual Citizenship / Living Abroad";
    } elseif ($MemberType == 'FN') {
        $MemberType = "Foreign National";
    } elseif ($MemberType == 'L') {
        $MemberType = "Listahanan";
    } elseif ($MemberType == '4PS') {
        $MemberType = "4Ps/MCCT";
    } elseif ($MemberType == 'SC') {
        $MemberType = "Senior Citizen";
    } elseif ($MemberType == 'P') {
        $MemberType = "PAMANA";
    } elseif ($MemberType == 'KIA') {
        $MemberType = "KIA/KIPO";
    } elseif ($MemberType == 'B') {
        $MemberType = "Bangsamoro/Normalization";
    } elseif ($MemberType == 'LGU-S') {
        $MemberType = "LGU-sponsored";
    } elseif ($MemberType == 'NGA-S') {
        $MemberType = "NGA-sponsored";
    } elseif ($MemberType == 'P-S') {
        $MemberType = "Private-sponsored";
    } elseif ($MemberType == 'PWD') {
        $MemberType = "Person with Disability";
    }

    $Contributor = $row['Contributor'];
    $Profession = $row['Profession'];
    $MonthlyIncome = $row['MonthlyIncome'];
    $IncomeProof = $row['IncomeProof'];
    $POS = $row['POS'];
}
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
                                <input type="text" name="PIN" value="<?php echo $PIN; ?>" readonly>
                                <span>PhilHealth Identification Number</span>
                            </div>
                            <div class="input__div">
                                <input type="text" name="KonsultaProvider" value="<?php echo $KonsultaProvider; ?>" readonly>
                                <span>Preferred KonSulta Provider</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="MemFullName" value="<?php echo $MemFullName; ?>" readonly>
                                <span>Member's Fullname (LN, FN MN)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="MothersMaidenName" value="<?php echo $MothersMaidenName; ?>" readonly>
                                <span>Mother's Maiden Name (LN, FN MN)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="SpouseFullName" value="<?php echo $SpouseFullName; ?>" readonly>
                                <span>Spouse Fullname if married (LN, FN MN)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div birthdate">
                                <input type="text" name="BirthDate" value="<?php echo $BirthDate; ?>" readonly>
                                <span>Birth Date</span>
                            </div>
                            <div class="input__div birthplace">
                                <input type="text" name="BirthPlace" value="<?php echo $BirthPlace; ?>" readonly>
                                <span>Place of Birth (City/Municipality/Province/Country)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="Sex" value="<?php echo $Sex; ?>" readonly>
                                    <span>Sex </span>
                            </div>
                            <div class="input__div">
                                <input type="text" name="CivilStatus" value="<?php echo $CivilStatus; ?>" readonly>
                                    <span> Civil Status </span>
                                </select>
                            </div>
                            <div class="input__div">
                                <input type="text" name="Citizenship" value="<?php echo $Citizenship; ?>" readonly>
                                    <span> Citizenship </span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="PhilsysID" value="<?php echo $PhilsysID; ?>" readonly>
                                <span> Philsys ID number (Optional)</span>
                            </div>
                            <div class="input__div">
                                <input type="text" name="TIN" value="<?php echo $TIN; ?>" readonly>
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
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="PermanentAddress" value="<?php echo $PermanentAddress; ?>" readonly>
                                <span> Unit/Blk/Lot/City etc.</span>
                            </div>

                            <div class="input__div1">
                                <input type="text" name="ZipCodeP" value="<?php echo $ZipCodeP; ?>" readonly>
                                <span> Zip Code </span>
                            </div>
                        </div>

                        <h3 class="form__label">Mailing Address&nbsp;&nbsp;&nbsp; </h3>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="MailingAddress" value="<?php echo $MailingAddress; ?>" readonly>
                                <span> Unit/Blk/Lot/City etc.</span>
                            </div>
                            <div class="input__div1">
                                <input type="text" name="ZipCodeM" value="<?php echo $ZipCodeM; ?>" readonly>
                                <span> Zip Code </span>
                            </div>
                        </div>

                        <h3 class="form__label">Contact Details</h3>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="Landline" value="<?php echo $Landline; ?>" readonly>
                                <span>Home Phone Number(Landline)</span>
                            </div>
                        </div>

                        <div class="input__text">
                             <div class="input__div">
                                <input type="text" name="MobileNum" value="<?php echo $MobileNum; ?>" readonly>
                                <span>Mobile Number (Required)</span>
                            </div>
                        </div>

                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="BizDirectLine" value="<?php echo $BizDirectLine; ?>" readonly>
                                <span>Business (Direct Line)</span>
                            </div>
                       </div>

                       <div class="input__text">
                        <div class="input__div">
                            <input type="text" name="Email" value="<?php echo $Email; ?>" readonly>
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
                        <div id="depformMD">
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
                                    <input type="radio" id="selectedDirectContributor" name="Contributor">
                                    <span>Direct Contributor</span>
                                </label>
                                <label>
                                    <input type="radio" id="selectedIndirectContributor" name="Contributor">
                                    <span>Indirect Contributor</span>
                                </label>
                            </form>
                        </div>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="MemberType" value="<?php echo $MemberType; ?>" readonly>
                                <span>MEMBER TYPE</span>
                            </div>
                        </div>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="text" name="Profession" value="<?php echo $Profession; ?>" readonly>
                                <span>Profession (Except Employed, Lifetime Members, and Sea-Based Migrant Worker)</span>
                            </div>
                        </div>
                        <div class="input__text">
                            <div class="input__div">
                                <input type="number" name="MonthlyIncome" value="<?php echo $MonthlyIncome; ?>" readonly>
                                <span>MONTHLY INCOME</span>
                            </div>
                            <div class="input__div">
                                <input type="text" name="IncomeProof" value="<?php echo $IncomeProof; ?>" readonly>
                                <span>Proof of Income</span>
                            </div>
                        </div>
                        <h3 class="form__label">For PhilHealth Use only:</h3>
                        <div class="radio__container" id="POS">
                            <form>
                                <label>
                                    <input type="radio" name="POS" id="yesPOS">
                                    <span>Point of Service (POS) Financially Incapable</span>
                                </label>
                                <label>
                                    <input type="radio" name="POS" id="noPOS">
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
    <script>
        var contributorValue = <?php echo json_encode($Contributor); ?>;
        var selectedDirectContributor = document.getElementById('selectedDirectContributor');
        var selectedIndirectContributor = document.getElementById('selectedIndirectContributor');
        if (contributorValue === 'D') {
            selectedDirectContributor.checked = true;
            selectedIndirectContributor.disabled = true;
        } else {
            selectedIndirectContributor.checked = true;
            selectedDirectContributor.disabled = true;
        }

        var POSvalue = <?php echo json_encode($POS); ?>;
        var yesPOS = document.getElementById('yesPOS');
        var noPOS = document.getElementById('noPOS');
        if (POSvalue === 'Y') {
            yesPOS.checked = true;
            noPOS.disabled = true;
        } else {
            noPOS.checked = true;
            yesPOS.disabled = true;
        }

        var numberOfDependents = <?php echo json_encode($numberOfDependents); ?>;
        var dependentRecords = <?php echo json_encode($dependentRecords); ?>;
        
        for (let i = 1; i <= numberOfDependents; i++) {
            var newDependentElement = document.createElement('div');

            var citizenshipValue = dependentRecords[i]['DepCitizenship'];
            // Map citizenship code to corresponding value
            if (citizenshipValue === 'F') {
                citizenshipValue = 'Filipino';
            } else if (citizenshipValue === 'FN') {
                citizenshipValue = 'Foreign National';
            } else if (citizenshipValue === 'DC') {
                citizenshipValue = 'Dual Citizen';
            } else {
                citizenshipValue = 'Unknown'; // Set default value if necessary
            }

            var WithDisability = dependentRecords[i]['WithDisability'];
            if (WithDisability == 'Y'){
                WithDisability = "With Disability";
            } else {
                WithDisability = "Without Disability";
            }

            var Relationship = dependentRecords[i]['Relationship'];
            if (Relationship == 'S'){
                Relationship = "Spouse";
            } else if (Relationship == 'C'){
                Relationship = "Child";
            } else if (Relationship == 'P'){
                Relationship = "Parents";
            }


            newDependentElement.innerHTML = `
                <h3 class="form__label">
                    Dependent ${i} 
                </h3>
                <div class="input__text">
                    <div class="input__div">
                        <input type="text" name="DepFullName${i}" value="${dependentRecords[i]['DepFullName']}" readonly>
                        <span>Dependent's Fullname (LN, FN MN)</span>
                    </div>
                </div>
                <div class="input__text">
                    <div class="input__div">
                        <input type="text" name="DepBirthdate${i}" value="${dependentRecords[i]['DepBirthdate']}" readonly>
                        <span>Birth Date</span>
                    </div>
                    <div class="input__div">
                        <input type="text" name="DepCitizenship${i}" value="${citizenshipValue}" readonly>
                        <span>Citizenship</span>
                    </div>
                </div>
                <div class="input__text">
                    <div class="input__div">
                        <input type="text" name="WithDisability${i}" value="${WithDisability}" readonly>
                        <span>With Disability</span>
                    </div>
                    <div class="input__div">
                        <input type="text" name="Relationship${i}" value="${Relationship}" readonly>
                        <span>Relationship</span>
                    </div>
                </div>`;

            var depFormMD = document.getElementById('depformMD');
            depFormMD.appendChild(newDependentElement);
        }
    </script>
    <script src="main.js"></script>
</body>

</html>