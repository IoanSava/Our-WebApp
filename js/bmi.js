var age = document.getElementById("age");
var height = document.getElementById("height");
var weight = document.getElementById("weight");
var male = document.getElementById("male");
var female = document.getElementById("female");
var form = document.getElementById("form");

function removeElementsByClass(className) {
    var elements = document.getElementsByClassName(className);
    while(elements.length > 0) {
        elements[0].parentNode.removeChild(elements[0]);
    }
}

function validateForm() {
    if (age.value == '' || height.value == '' || weight.value == '' || (male.checked == false && female.checked == false)) {
        alert("All fields are required!");
        document.getElementById("submit").removeEventListener("click", showResult);
    } else {
        removeElementsByClass("result");
        showResult();
    }
}

document.getElementById("submit").addEventListener("click", validateForm);

function calculateBmi() {
    var valuesOfFields = [age.value, height.value, weight.value];

    if(male.checked) {
        valuesOfFields.push("male");
    } else if(female.checked) {
        valuesOfFields.push("female");
    }

    return Number(valuesOfFields[2]) / ((Number(valuesOfFields[1]) / 100) * (Number(valuesOfFields[1]) / 100));
}

function diagnosis(bmiValue) {
    if (bmiValue < 18.5) {
        return 'Underweight';
    } else if (18.5 <= bmiValue && bmiValue <= 24.9) {
        return 'Healthy';
    } else if (25 <= bmiValue && bmiValue <= 29.9) {
        return 'Overweight';
    } else if (30 <= bmiValue && bmiValue <= 34.9) {
        return 'Obese';
    } else if (35 <= bmiValue) {
        return 'Extremely obese';
    }
}

function showResult() {
    //form.reset();
    
    var bmiValue = calculateBmi();
    var result = diagnosis(bmiValue);

    var h1 = document.createElement("h1");
    var h2 = document.createElement("h2");

    var resultText = document.createTextNode(result);
    var bmiText = document.createTextNode('BMI: ');
    var bmiValueText = document.createTextNode(parseFloat(bmiValue).toFixed(2));

    h1.appendChild(resultText);
    h1.classList.add("result");

    h2.appendChild(bmiText);
    h2.appendChild(bmiValueText);
    h2.classList.add("result");

    document.getElementById("bmi-container").appendChild(h1);
    document.getElementById("bmi-container").appendChild(h2);

    document.getElementById("submit").removeEventListener("click", showResult);
}