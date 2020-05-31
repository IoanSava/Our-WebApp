function checkJWT() {
    var jwt = localStorage.getItem('jwt');

    var url = '/obis/public/UserController/checkJWT/' + jwt;
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.responseText) {
                var response = JSON.parse(xhr.responseText);
                alert(response["message"]);
                window.location.replace("login");
            }
        }
    };

    xhr.open('GET', url, true);
    xhr.send();
}


function getSelectedOption() {
    var radios = document.getElementsByName('radio');
    for (var i = 0; i < radios.length; ++i) {
        if (radios[i].checked) {
            return radios[i].value;
        }
    }
}


function updateForm() {
    var dataForm = document.getElementById("data-form");
    var userForm = document.getElementById("user-form");
    var option = getSelectedOption();
    if (option.includes("Row")) {
        dataForm.classList.remove("hidden");
        userForm.classList.add("hidden");
    } else {
        dataForm.classList.add("hidden");
        userForm.classList.remove("hidden");
    }
}


function updateMessage(message) {
    var resultMessage = document.getElementsByClassName("result-message")[0];
    resultMessage.innerHTML = message;
}


function submitForm(form) {
    let jsonObject = {};
    jsonObject['jwt'] = localStorage.getItem("jwt");
    for (var i = 0, element; element = form.elements[i++];) {
        if (element.type == "text" || element.type == "password" || element.value != "") {
            jsonObject[element.name] = element.value;
        }
    }

    var url = '/obis/public/';
    if (form.id == 'data-form') {
        url = url + "ChartController/";
    } else {
        url = url + "UserController/";
    }
    url = url + getSelectedOption();

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            var response = JSON.parse(xhr.responseText);
            updateMessage(response["message"]);
        }
    };

    xhr.open('POST', url, true);
    xhr.send(JSON.stringify(jsonObject));
}


checkJWT();