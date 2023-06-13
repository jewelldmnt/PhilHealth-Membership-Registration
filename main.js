/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll('section[id]')

const scrollActive = () =>{
    const scrollY = window.pageYOffset
    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight,
                sectionTop = current.offsetTop - 58,
                sectionId = current.getAttribute('id'),
                sectionsClass = document.querySelector('.nav__menu a[href*=' + sectionId + ']')

        if(scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
            sectionsClass.classList.add('active-link')
        }else{
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


    num.innerHTML = formnumber + 1;
    step_list[formnumber].classList.add('active');
}

function progress_backward() {
    var form_num = formnumber + 1;
    step_list[form_num].classList.remove('active');
    num.innerHTML = form_num;
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
            if (validate_input.value.length == 0) {
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
