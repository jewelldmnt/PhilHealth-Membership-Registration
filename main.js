/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll('section[id]')

const scrollActive = () => {
    const scrollY = window.pageYOffset
    sections.forEach(current => {
        const sectionHeight = current.offsetHeight,
            sectionTop = current.offsetTop - 58,
            sectionId = current.getAttribute('id'),
            sectionsClass = document.querySelector('.nav__menu a[href*=' + sectionId + ']')

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            sectionsClass.classList.add('active__link')
        } else {
            sectionsClass.classList.remove('active__link')
        }
    })
}
window.addEventListener('scroll', scrollActive)


/*=============== FOR REGISTRATION HTML ===============*/
var next_click = document.querySelectorAll(".next_button");
var main_form = document.querySelectorAll(".main__form");
var step_list = document.querySelectorAll(".progress__bar li");
var num = document.querySelector(".step__number");
let formnumber = 0;


next_click.forEach(function (nextClickForm) {
    nextClickForm.addEventListener('click', function () {
        /**
         * Handles the click event of the next button to navigate to 
         * the next form. Validates the current form before proceeding 
         * to the next one.
        */
        if (!validateForm()) {
            return false
        }
        formnumber++;
        updateForm();
        progressForward();
    });
});

var back_click = document.querySelectorAll(".back_button");
back_click.forEach(function (backClickForm) {
    backClickForm.addEventListener('click', function () {
        /**
         * Handles the click event of the back button to navigate 
         * to the previous form.
        */
        formnumber--;
        updateForm();
        progressBackward();
    });
});


function updateForm() {
    /**
     * Updates the active form based on the formnumber.
    */
    var test = document.querySelector("h3");

    main_form.forEach(function (mainform_number) {
        mainform_number.classList.remove('active');
    })
    main_form[formnumber].classList.add('active');

}

function progressForward() {
    /**
     * Moves the progress bar forward by highlighting the current step.
    */
    num.innerHTML = "Step " + (formnumber + 1);
    step_list[formnumber].classList.add('active');
}

function progressBackward() {
    /**
     * Moves the progress bar backward by removing the highlight from 
     * the current step.
    */
    var form_num = formnumber + 1;
    step_list[form_num].classList.remove('active');
    num.innerHTML = "Step " + form_num;
}


function validateForm() {
    /**
     * Validates the form inputs before proceeding to the next step.
     * Adds warning styles to the invalid inputs.
     * 
     * @returns {boolean} Returns true if all form inputs are valid, 
     * false otherwise.
    */
    var validate = true;
    var validate_inputs = document.querySelectorAll(".main__form.active input");
    validate_inputs.forEach(function (validate_input) {
        validate_input.classList.remove('warning');

        if (validate_input.hasAttribute('required') && (validate_input.offsetWidth !== 0 || validate_input.offsetHeight !== 0)) {
            if (validate_input.value.length == 0 || !validate_input.checkValidity()) {
                validate = false;
                validate_input.classList.add('warning');
            }
        }

        if (validate_input.value.length > 0 && validate_input.hasAttribute('pattern')) {
            var pattern = new RegExp(validate_input.getAttribute('pattern'));
            if (!pattern.test(validate_input.value)) {
                validate = false;
                validate_input.classList.add('warning');
            }
        }

    });

    var validate_selects = document.querySelectorAll(".main__form.active select");
    validate_selects.forEach(function (validate_select) {
        validate_select.classList.remove('warning');

        if (validate_select.hasAttribute('require') && (validate_select.offsetWidth !== 0 || validate_select.offsetHeight !== 0)) {
            if (validate_select.value == "") {
                validate = false;
                validate_select.classList.add('warning');
            }
        }
    });

    return validate;
}


function setMaxDateForBirthDateInputs() {
    /**
     * Sets the maximum date for birth date inputs to the current date.
     * Retrieves the current date and assigns it as the "max" attribute 
     * value for each birth date input element.
    */
    var today = new Date().toISOString().split('T')[0];
    var birthDateInputs = document.getElementsByClassName("birth__date");
    
    for (var i = 0; i < birthDateInputs.length; i++) {
        birthDateInputs[i].setAttribute("max", today);
    }
}

// Call the setMaxDateForBirthDateInputs function when the page loads
document.addEventListener("DOMContentLoaded", setMaxDateForBirthDateInputs);


/*=============== FOR PASSWORD TOGGLE ===============*/
var close_eye = document.getElementById("close-eye");
var newpass1 = document.getElementById("myPassword");
var newpass2 = document.getElementById("conpass");
var open_eye = document.getElementById("open-eye");

function togglePasswordVisibility(input, eyeIcon, openIconPath, closeIconPath) {
    /**
     * Toggles the visibility of a password input field and updates the eye icon accordingly.
     *
     * @param {HTMLInputElement} input - The password input field.
     * @param {HTMLImageElement} eyeIcon - The eye icon element.
     * @param {string} openIconPath - The path to the open eye icon image.
     * @param {string} closeIconPath - The path to the closed eye icon image.
    */
    if (input.type === "password") {
        input.type = "text";
        eyeIcon.src = closeIconPath;
    } else {
        input.type = "password";
        eyeIcon.src = openIconPath;
    }
}

if (open_eye) {
    open_eye.addEventListener('click', togglePasswordVisibility.bind(null, newpass1, open_eye, "/assets/login/eye-open.png", "/assets/login/eye-close.png"));
}

if (close_eye) {
    close_eye.addEventListener('click', togglePasswordVisibility.bind(null, newpass2, close_eye, "/assets/create/eye-open.png", "/assets/create/eye-close.png"));
}



/*=============== GETTING LOGIN INFORMATION ===============*/
function isLogIn(value) {
    /**
     * Sets the login state in the local storage and updates the 
     * navigation accordingly.
     *
     * @param {boolean} value - The login state value. `true` to 
     * hide the navigation, `false` to show it.
    */
    if (value) {
        localStorage.setItem("hideNavState", "true");
    }
    else {
        localStorage.setItem("hideNavState", "false");
    }
}

window.addEventListener("DOMContentLoaded", function () {
    /**
     * Handles the DOMContentLoaded event to update the navigation 
     * based on the login state stored in the local storage. If the 
     * login state is set to hide the navigation, the appropriate CSS 
     * classes and link are applied.
    */
    if (localStorage.getItem("hideNavState")) {
        document.querySelector(".profile__nav").classList.add("hide__nav");
        document.querySelector(".logIn__nav").classList.remove("hide__nav");
        localStorage.removeItem("hideNavState");

        document.querySelector(".registration__nav a").href = "registration.php#qualifications";
    }
});


/*=============== GETTING NEW LOGIN INFORMATION ===============*/
let create_acc_btn = document.getElementById("createsub");
if (create_acc_btn){
    create_acc_btn.addEventListener('click', function () {
        /**
         * Handles the click event of the create account submit button.
         * If the username exists and the passwords match, a success message 
         * is displayed and the user is redirected to the login page.
        */
        if (!isUsernameExists && newpass1.value == newpass2.value) {
            window.alert("Successfully created your account. Please log in to your account.");
            window.location.href = "loginAcc.php";
        }
    });
}

/*=============== PROFILE NAVIGATION OPTIONS ===============*/
let subMenu = document.getElementById("sub-menu-wrap");
function toggleMenu() {
    /**
     * Toggles the visibility of the profile submenu by adding or removing 
     * the "open__menu" CSS class.
    */
    subMenu.classList.toggle("open__menu");
}


/*=============== COPYING ADDRESS BY CHECKBOX ===============*/
let SameAs = document.getElementById("SameAs");
if (SameAs != null) {
    addEventListener('change', duplicate);
}

function duplicate() {
    /**
     * Handles the change event of the "SameAs" checkbox to copy the 
     * values from the permanent address fields to the corresponding 
     * mailing address fields if the checkbox is checked. If the checkbox 
     * is unchecked, the mailing address fields are cleared.
    */
    if (SameAs.checked) {
        document.getElementById('MailingAddress').value = document.getElementById('PermanentAddress').value;
        document.getElementById('ZipCodeM').value = document.getElementById('ZipCodeP').value;
    }

};

/*=============== ADDING/REMOVING DEPENDENT ===============*/
counter = 1;
function addMoreField() {
    /**
     * Adds a new dependent field to the form.
     * Increases the counter value for unique element IDs.
     * Creates and appends HTML elements for the new dependent 
     * field with input fields for dependent information.
    */
    counter += 1;
    var newDependent = document.createElement('div');
    newDependent.innerHTML = `
        <h3 class="form__label remove__dependent__div" id="label${counter}">
            Dependent ${counter} 
            <i class='bx bxs-trash remove__dependent' id="button${counter}" onclick="removeField()"></i>
        </h3>
        <div class="input__text" id="rowA${counter}">
            <div class="input__div">
                <input type="text" name="DepFullName${counter}" required require id="depFullName${counter}" placeholder="xxx" maxlength="50" value="">
                <span>Dependent's Fullname (LN, FN MN) <strong style="color: red;">*</strong></span>
            </div>
        </div>
        <div class="input__text" id="rowB${counter}">
            <div class="input__div birthdate">
                <input type="date" name="DepBirthdate${counter}"  class="birth__date" required require id="depBirthDate${counter}" value="">
                <span>Birth Date <strong style="color: red;">*</strong></span>
            </div>
            <div class="input__div">
                <select name="DepCitizenship${counter}"  required require id="depCitizenship${counter}">
                    <option value="" disabled selected hidden>Citizenship <strong style="color: red;">*</strong></option>
                    <option value='F'>Filipino</option>
                    <option value='DC'>Dual Citizen</option>
                    <option value='FN'>Foreign National</option>
                </select>
            </div>
        </div>
        <div class="input__text" id="rowC${counter}">
            <div class="input__div">
                <select name="WithDisability${counter}" required require id="withDisability${counter}">
                    <option value="" disabled selected hidden>With Disability<strong style="color: red;">*</strong></option>
                    <option value='Y'>Yes</option>
                    <option value='N'>No</option>
                </select>
            </div>
            <div class="input__div">
                <select name="Relationship${counter}" required require id="Relationship${counter}">
                    <option value="" disabled selected hidden>Relationship<strong style="color: red;">*</strong></option>
                    <option value='S'>Spouse</option>
                    <option value='C'>Children</option>
                    <option value='P'>Parents</option>
                </select>
            </div>
        </div>`;
    var form = document.getElementById('depform');
    form.appendChild(newDependent);
    setMaxDateForBirthDateInputs();
}


function removeField() {
    /**
     * Removes a dependent field from the form.
     * Removes the corresponding HTML elements for the 
     * dependent field based on the current counter value.
     * Decreases the counter value.
     * Refreshes the HTML elements of the previous dependent 
     * field to maintain consistent IDs.
    */
    document.getElementById('rowA' + counter).remove();
    document.getElementById('rowB' + counter).remove();
    document.getElementById('rowC' + counter).remove();
    document.getElementById('label' + counter).remove();

    counter -= 1;

    document.getElementById('rowA' + counter).refresh();
    document.getElementById('rowB' + counter).refresh();
    document.getElementById('rowC' + counter).refresh();
    document.getElementById('label' + counter).refresh();
}



/*================ TO DISPLAY MEMBER TYPE DEPENDING ON CONTRIBUTOR TYPE ================*/
function updateMemberTypeOptions() {
    /**
     * Updates the options of the MemberType select based on the 
     * selected contributor type (DirectContributor or IndirectContributor).
    */
    document.getElementById('DirectContributor').addEventListener('change', updateMemberTypeOptions);
    document.getElementById('IndirectContributor').addEventListener('change', updateMemberTypeOptions);

    var directRadio = document.getElementById('DirectContributor');
    var indirectRadio = document.getElementById('IndirectContributor');
    var memberTypeSelect = document.getElementById('MemberType');

    memberTypeSelect.innerHTML = '';

    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    defaultOption.hidden = true;
    defaultOption.innerText = 'Member Type *';
    memberTypeSelect.appendChild(defaultOption);

    if (directRadio.checked) {
        addOption(memberTypeSelect, 'Employed Private', 'EP');
        addOption(memberTypeSelect, 'Employed Government', 'EG');
        addOption(memberTypeSelect, 'Professional Practitioner', 'PP');
        addOption(memberTypeSelect, 'Self-Earning Individual (Individual)', 'SEI-I');
        addOption(memberTypeSelect, 'Self-Earning Individual (Sole Proprietor)', 'SEI-SP');
        addOption(memberTypeSelect, 'Self-Earning Individual (Group Enrollment Scheme)', 'SEI-GES');
        addOption(memberTypeSelect, 'Kasambahay', 'K');
        addOption(memberTypeSelect, 'Family Driver', 'FD');
        addOption(memberTypeSelect, 'Migrant Worker (Land-Based)', 'MW-LB');
        addOption(memberTypeSelect, 'Migrant Worker (Sea-Based)', 'MW-SB');
        addOption(memberTypeSelect, 'Lifetime Member', 'LM');
        addOption(memberTypeSelect, 'Filipinos with Dual Citizenship/Living Abroad', 'FDC ');
        addOption(memberTypeSelect, 'Foreign National', 'FN ');
    } else if (indirectRadio.checked) {
        addOption(memberTypeSelect, 'Listahanan', 'L');
        addOption(memberTypeSelect, '4Ps/MCCT', '4PS');
        addOption(memberTypeSelect, 'Senior Citizen', 'SC');
        addOption(memberTypeSelect, 'KIA/KIPO', 'P');
        addOption(memberTypeSelect, 'PAMANA', 'KIA');
        addOption(memberTypeSelect, 'Bangsamoro/Normalization', 'B');
        addOption(memberTypeSelect, 'LGU-sponsored', 'LGU-S');
        addOption(memberTypeSelect, 'NGA-sponsored', 'NGA-S');
        addOption(memberTypeSelect, 'Private-sponsored', 'P-S');
        addOption(memberTypeSelect, 'Person with Disability', 'PWD');
    }
}

function addOption(selectElement, optionText, value) {
    /**
     * Adds a new option to the specified select element with the given 
     * option text and value.
     * @param {HTMLSelectElement} selectElement - The select element to 
     * which the option will be added.
     * @param {string} optionText - The text to be displayed for the new 
     * option.
     * @param {string} value - The value to be assigned to the new option.
    */
    var option = document.createElement('option');
    option.value = value;
    option.innerText = optionText;
    selectElement.appendChild(option);
}


/*=== TO DISABLE TEXT INPUT IF MEMBER TYPE IS EMPLOYED, LIFETIME MEMBERS, OR SEA-BASED MIGRANT WORKERS ===*/
var memberTypeSelect = document.getElementById('MemberType');
var memberTypeIndirect = document.getElementById('IndirectContributor');
var memberTypeDirect = document.getElementById('DirectContributor');

if (memberTypeSelect != null && (memberTypeIndirect != null || memberTypeDirect  != null)) {
    [memberTypeSelect, memberTypeIndirect, memberTypeDirect].forEach(function (element) {
        element.addEventListener('change', function () {
            /**
             * Handles the change event for the member type selection, 
             * updating the form inputs based on the selected option.
             *
            */

            var professionInput = document.getElementById('Profession');
            var selectedOption = memberTypeSelect.value;

            if (selectedOption === 'EP' ||
                selectedOption === 'EG' ||
                selectedOption === 'LM' ||
                selectedOption === 'MW-LB' ||
                selectedOption == 'MW-SB') {
                professionInput.disabled = true;
                professionInput.value = 'Not Applicable';

            } else {
                professionInput.disabled = false;
                professionInput.value = '';
            }
        });
    });
}