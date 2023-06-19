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

next_click.forEach(function (next_click_form) {
    next_click_form.addEventListener('click', function () {
        if (!validateform()) {
            return false
        }
        formnumber++;
        updateform();
        progress_forward();
        contentchange();
    });
});

var back_click = document.querySelectorAll(".back_button");
back_click.forEach(function (back_click_form) {
    back_click_form.addEventListener('click', function () {
        formnumber--;
        updateform();
        progress_backward();
        contentchange();
    });
});

var submit_click = document.querySelectorAll(".submit_button");
submit_click.forEach(function (submit_click_form) {
    submit_click_form.addEventListener('click', function () {
        shownname.innerHTML = username.value;
        formnumber++;
        updateform();
    });
});

var username = document.querySelector("#user_name");
var email = document.querySelector("#user_email");
var phone = document.querySelector("#user_phone");

var shownname = document.querySelector(".shown_name");
var shownemail = document.querySelector(".shown_email");
var shownphone = document.querySelector(".shown_phone");

var submit_click = document.querySelectorAll(".submit_button");
submit_click.forEach(function (submit_click_form) {
    submit_click_form.addEventListener('click', function () {
        shownname.innerHTML = username.value;
        formnumber++;
        updateform();
    });
});

function updateform() {
    var test = document.querySelector("h3");

    main_form.forEach(function (mainform_number) {
        mainform_number.classList.remove('active');
    })
    main_form[formnumber].classList.add('active');

}

function progress_forward() {
    // step_list.forEach(list => {

    //     list.classList.remove('active');

    // }); 

    num.innerHTML = "Step " + (formnumber + 1);
    step_list[formnumber].classList.add('active');
}

function progress_backward() {
    var form_num = formnumber + 1;
    step_list[form_num].classList.remove('active');
    num.innerHTML = "Step " + form_num;
}

var step_num_content = document.querySelectorAll(".step-number-content");

function contentchange() {
    step_num_content.forEach(function (content) {
        content.classList.remove('active');
        content.classList.add('d-none');
    });
    step_num_content[formnumber].classList.add('active');
}


function validateform() {
    var validate = true;
    var validate_inputs = document.querySelectorAll(".main__form.active input");

    validate_inputs.forEach(function (validate_input) {
        validate_input.classList.remove('warning');

        if (validate_input.hasAttribute('require') && (validate_input.offsetWidth !== 0 || validate_input.offsetHeight !== 0)) {
            if (validate_input.value.length == 0 || !validate_input.checkValidity()) {
                validate = false;
                validate_input.classList.add('warning');
            }
        }

        if (validate_input.hasAttribute('optional') && (validate_input.offsetWidth !== 0 || validate_input.offsetHeight !== 0)) {
            if (validate_input.value.length > 0 && !validate_input.value.match(validate_input.getAttribute('pattern'))) {
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

var today = new Date().toISOString().split('T')[0];
var birthDateInputs = document.getElementsByClassName("birth__date");
for (var i = 0; i < birthDateInputs.length; i++) {
    birthDateInputs[i].setAttribute("max", today);
}



/*=============== FOR PASSWORD TOGGLE ===============*/
let eyeicon = document.getElementById("eyeicon");
let newpass1 = document.getElementById("myPassword");
let newpass2 = document.getElementById("conpass");
let coneyeicon = document.getElementById("coneyeicon");

if (eyeicon != null)
    eyeicon.onclick = function () {
        if (newpass1.type == "password") {
            newpass1.type = "text";
            eyeicon.src = "/assets/login/eye-open.png"
        } else {
            newpass1.type = "password";
            eyeicon.src = "/assets/login/eye-close.png"
        }
    }

if (coneyeicon != null)
    coneyeicon.onclick = function () {
        if (newpass2.type == "password") {
            newpass2.type = "text";
            coneyeicon.src = "/assets/create/eye-open.png"
        } else {
            newpass2.type = "password";
            coneyeicon.src = "/assets/create/eye-close.png"
        }
    }


/*=============== GETTING LOGIN INFORMATION ===============*/
function logIn(isLogIn) {
    if (isLogIn) {
        localStorage.setItem("hideNavState", "true");
    }
    else {
        localStorage.setItem("hideNavState", "false");
    }
}

window.addEventListener("DOMContentLoaded", function () {
    if (localStorage.getItem("hideNavState")) {
        document.querySelector(".profile__nav").classList.add("hide__nav");
        document.querySelector(".logIn__nav").classList.remove("hide__nav");
        localStorage.removeItem("hideNavState");

        document.querySelector(".registration__nav a").href = "registration.html#qualifications";
    }
});


/*=============== GETTING NEW LOGIN INFORMATION ===============*/
let createsub = document.getElementById("createsub")

if (createsub != null)
    createsub.onclick = function () {
        if (newpass1.value != newpass2.value) {
            window.alert("Passwords do not match!! Please recheck your information");
            return false;
        }
        else {
            action = loginAcc.html;
        }
    }


/*=============== PROFILE NAVIGATION OPTIONS ===============*/
let subMenu = document.getElementById("sub-menu-wrap");

function toggleMenu() {
    subMenu.classList.toggle("open__menu");
}


/*=============== COPYING ADDRESS BY CHECKBOX ===============*/
let SameAs = document.getElementById("SameAs");
let Address1 = document.getElementById("Address1");
let Address2 = document.getElementById("Address2");
let MailAddress1 = document.getElementById("MailAddress1");
let MailAddress2 = document.getElementById("MailAddress2");

SameAs.onclick = function () {
    if (SameAs.checked) {
        document.getElementById('MailAddress1').value = document.getElementById('Address1').value;
        document.getElementById('MailAddress2').value = document.getElementById('Address2').value;
    }
    else {
        document.getElementById('MailAddress1').value = '';
        document.getElementById('MailAddress2').value = '';
    }

};


/*=============== ADDING/REMOVING DEPENDENT ===============*/
counter = 1;
function add_more_field() {
    counter += 1;
    var newDependent = document.createElement('div');
    newDependent.innerHTML = `
        <h3 class="form__label" id="label${counter}">
            Dependent ${counter} 
            <i class='bx bxs-trash remove__dependent' id="${counter}" onclick="remove_field(this)"></i>
        </h3>
        <div class="input__text" id="rowA${counter}">
            <div class="input__div">
                <input type="text" required require id="depFullName${counter}" placeholder="xxx" maxlength="50" value="">
                <span>Dependent's Fullname (LN, FN MN) <strong style="color: red;">*</strong></span>
            </div>
        </div>
        <div class="input__text" id="rowB${counter}">
            <div class="input__div birthdate">
                <input type="date" required require id="depBirthDate${counter}" value="">
                <span>Birth Date <strong style="color: red;">*</strong></span>
            </div>
            <div class="input__div">
                <select required require id="depCitizenship${counter}">
                    <option value="" disabled selected hidden>Citizenship <strong style="color: red;">*</strong></option>
                    <option>Filipino</option>
                    <option>Dual Citizen</option>
                    <option>Foreign National</option>
                </select>
            </div>
        </div>
        <div class="input__text" id="rowC${counter}">
            <div class="input__div">
                <select required require id="withDisability${counter}">
                    <option value="" disabled selected hidden>With Disability<strong style="color: red;">*</strong></option>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="input__div">
                <select required require id="Relationship${counter}">
                    <option value="" disabled selected hidden>Relationship<strong style="color: red;">*</strong></option>
                    <option>Spouse</option>
                    <option>Children</option>
                    <option>Parents</option>
                </select>
            </div>
        </div>`;
    var form = document.getElementById('depform');
    form.appendChild(newDependent);
}


function remove_field(button) {
    let number = button.id;
    let rowA = document.getElementById('rowA' + number);
    let rowB = document.getElementById('rowB' + number);
    let rowC = document.getElementById('rowC' + number);
    let h3 = document.getElementById('label' + number);

    rowA.remove();
    rowB.remove();
    rowC.remove();
    h3.remove();
    button.remove();
    counter -= 1;
}


/*================ TO DISPLAY MEMBER TYPE DEPENDING ON CONTRIBUTOR TYPE ================*/
document.getElementById('direct').addEventListener('change', updateMemberTypeOptions);
document.getElementById('indirect').addEventListener('change', updateMemberTypeOptions);

function updateMemberTypeOptions() {
    var directRadio = document.getElementById('direct');
    var indirectRadio = document.getElementById('indirect');
    var memberTypeSelect = document.getElementById('membertype');

    memberTypeSelect.innerHTML = '';

    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    defaultOption.hidden = true;
    defaultOption.innerText = 'Member Type *';
    memberTypeSelect.appendChild(defaultOption);

    if (directRadio.checked) {
        addOption(memberTypeSelect, 'Employed Private');
        addOption(memberTypeSelect, 'Employed Government');
        addOption(memberTypeSelect, 'Professional Practitioner');
        addOption(memberTypeSelect, 'Self-Earning Individual (Individual)');
        addOption(memberTypeSelect, 'Self-Earning Individual (Sole Proprietor)');
        addOption(memberTypeSelect, 'Self-Earning Individual (Group Enrollment Scheme)');
        addOption(memberTypeSelect, 'Kasambahay');
        addOption(memberTypeSelect, 'Family Driver');
        addOption(memberTypeSelect, 'Migrant Worker (Land-Based)');
        addOption(memberTypeSelect, 'Migrant Worker (Sea-Based)');
        addOption(memberTypeSelect, 'Lifetime Member');
        addOption(memberTypeSelect, 'Filipinos with Dual Citizenship/Living Abroad');
        addOption(memberTypeSelect, 'Foreign National');
    } else if (indirectRadio.checked) {
        addOption(memberTypeSelect, 'Listahanan');
        addOption(memberTypeSelect, '4Ps/MCCT');
        addOption(memberTypeSelect, 'Senior Citizen');
        addOption(memberTypeSelect, 'KIA/KIPO');
        addOption(memberTypeSelect, 'PAMANA');
        addOption(memberTypeSelect, 'Bangsamoro/Normalization');
        addOption(memberTypeSelect, 'LGU-sponsored');
        addOption(memberTypeSelect, 'NGA-sponsored');
        addOption(memberTypeSelect, 'Private-sponsored');
        addOption(memberTypeSelect, 'Person with Disability');
    }
}

function addOption(selectElement, optionText) {
    var option = document.createElement('option');
    option.innerText = optionText;
    selectElement.appendChild(option);
}


/*=== TO DISABLE TEXT INPUT IF MEMBER TYPE IS EMPLOYED, LIFETIME MEMBERS, OR SEA-BASED MIGRANT WORKERS ===*/
document.getElementById('membertype').addEventListener('change', updateTextInputStatus);
document.getElementById('indirect').addEventListener('change', updateTextInputStatus);
document.getElementById('direct').addEventListener('change', updateTextInputStatus);

function updateTextInputStatus() {
    var memberTypeSelect = document.getElementById('membertype');
    var professionInput = document.getElementById('profession');
    var monthlyIncomeInput = document.getElementById('monthly_income');
    var incomeProofInput = document.getElementById('income_proof');
    var selectedOption = memberTypeSelect.value;
    var directRadio = document.getElementById('direct');
    var indirectRadio = document.getElementById('indirect');


    if (selectedOption === 'Employed Private' ||
        selectedOption === 'Employed Government' ||
        selectedOption === 'Lifetime Member' ||
        selectedOption === 'Migrant Worker (Sea-Based)') {
        professionInput.disabled = true;
        professionInput.value = 'Not Applicable';

        monthlyIncomeInput.disabled = true;
        monthlyIncomeInput.value = "";

        incomeProofInput.disabled = true;
        incomeProofInput.value = 'Not Applicable';
    } else if (directRadio.checked || indirectRadio.checked) {
        professionInput.disabled = false;
        professionInput.value = '';

        monthlyIncomeInput.disabled = false;
        monthlyIncomeInput.value = '';

        incomeProofInput.disabled = false;
        incomeProofInput.value = '';
    } else {
        professionInput.disabled = false;
        professionInput.value = '';

        monthlyIncomeInput.disabled = false;

        incomeProofInput.disabled = false;
        incomeProofInput.value = '';
    }
}