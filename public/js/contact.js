"use strict";

document.querySelectorAll('.input-area').forEach(element => {
    element.addEventListener('blur', function() {
        if (this.value != "") {
            this.classList.add('has-value');
        } else {
            this.classList.remove('has-value');
        }
    })
});

var input = document.querySelectorAll('.wrap-input,.input-area');

document.querySelectorAll('.validate-form')[0].addEventListener('submit', function(event) {
    for (var i = 0; i < input.length; i++) {
        if (validate(input[i]) == false) {
            showValidate(input[i]);
            event.preventDefault();
        }
    }
});

document.querySelectorAll('.validate-form,.input-area').forEach(element => {
    element.addEventListener('focus', function() { hideValidate(this); });
});


function validate(elem) {
    if (elem.getAttribute('type') == 'name' || elem.getAttribute('name') == 'user_name') {
        if (elem.value.trim().match(/^([A-Z][a-z]+\ [A-Z][a-z]+)$/) == null) {
            return false;
        }
    } else {
        if (elem.getAttribute('type') == 'email' || elem.getAttribute('name') == 'user_mail') {
            if (elem.value.trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        } else {
            if (elem.getAttribute('type') == 'tel' || elem.getAttribute('name') == 'user_phone') {
                if (elem.value.trim().match(/^([0-9]{4}\-[0-9]{3}\-[0-9]{3})$/) == null) {
                    return false;
                }
            } else {
                if (elem.value == '') {
                    return false;
                }
            }
        }
    }
    return true;
}

function showValidate(elem) {
    var alert = elem.parentNode;

    alert.classList.add('alert-validate');
}

function hideValidate(elem) {
    var alert = elem.parentNode;

    alert.classList.remove('alert-validate');
}