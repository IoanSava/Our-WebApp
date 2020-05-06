function selectStateButtonEvents() {
    // Get the modal
    var selectModal = document.getElementById("select_modal");

    // Get the button that opens the modal
    var selectButton = document.getElementById("select_button");

    // Get the <span> element that closes the modal
    var selectSpan = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    selectButton.onclick = function() {
        selectModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    selectSpan.onclick = function() {
        selectModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == selectModal) {
            selectModal.style.display = "none";
        }
    }
}


function getSelectedGender() {
    var select = document.getElementById("gender-selector");
    return select.options[select.selectedIndex].value;
}


function getSelectedState() {
    var radios = document.getElementsByName('radio');
    for (var i = 0; i < radios.length; ++i) {
        if (radios[i].checked) {
            return radios[i].value;
        }
    }
}


function exportDataAsCSV(gender, state) {
    window.open('/obis/public/ColumnChartController/exportCSV?gender=' + gender + '&state=' + state);
}


function exportData(format) {
    if (format != 'csv') {
        alert("exported in another format")
        return;
    }

    var gender = getSelectedGender();
    if (gender != '') {
        var state = getSelectedState();
        exportDataAsCSV(gender, state);
    } else {
        alert("You didn't specifed a gender");
    }
}


selectStateButtonEvents();