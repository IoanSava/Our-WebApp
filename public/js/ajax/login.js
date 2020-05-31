function sendAccountToServer() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    let jsonObject = {};
    jsonObject['email'] = email;
    jsonObject['password'] = password;

    var url = '/obis/public/UserController/authenticate';
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            var response = JSON.parse(xhr.responseText);
            if (xhr.status == 200) {
                var jwt = response["jwt"];
                localStorage.setItem('jwt', jwt);
                window.location.replace("administration");
            } else {
                updateMessage(response["message"])
            }
        }
    };

    xhr.open('POST', url, true);
    xhr.send(JSON.stringify(jsonObject));
}


function updateMessage(message) {
    var errorMessage = document.getElementsByClassName("error-message")[0];
    errorMessage.innerHTML = message;
}