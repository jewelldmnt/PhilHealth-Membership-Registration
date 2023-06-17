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
            sectionsClass.classList.add('active-link')
        } else {
            sectionsClass.classList.remove('active-link')
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

function updateTextInputStatus() {
    var memberTypeSelect = document.getElementById('membertype');
    var professionInput = document.getElementById('profession');
    var monthlyIncomeInput = document.getElementById('monthly_income');
    var incomeProofInput = document.getElementById('income_proof');
    var selectedOption = memberTypeSelect.value;

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
    } else {
        professionInput.disabled = false;
        professionInput.value = '';

        monthlyIncomeInput.disabled = false;

        incomeProofInput.disabled = false;
        incomeProofInput.value = '';
    }
}