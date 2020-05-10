function compareButtonEvents() {
    // Get the modal
    var compareModal = document.getElementById("compare_modal");

    // Get the button that opens the modal
    var compareButton = document.getElementById("compare_button");

    // Get the <span> element that closes the modal
    var compareSpan = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    compareButton.onclick = function() {
        compareModal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    compareSpan.onclick = function() {
        compareModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == compareModal) {
            compareModal.style.display = "none";
        }
    }
}

function checkboxlimit(checkgroup, limit) {
    var checkgroup = checkgroup;
    var limit = limit;
    for (var i = 0; i < checkgroup.length; ++i) {
        checkgroup[i].onclick = function() {
            var checkedcount = 0;
            for (var i = 0; i < checkgroup.length; ++i)
                checkedcount += (checkgroup[i].checked) ? 1 : 0;
            if (checkedcount > limit) {
                alert("You can only select a maximum of " + limit + " checkboxes");
                this.checked = false;
            }
        }
    }
}

function exportCSV(gender, states) {
    window.open('/obis/public/LineChartController/exportCSV?gender=' + gender + '&states=' + states);
}

function exportSVG() {
    var stateAux = getSelectedStates();
    stateAux = stateAux.toString();
    stateAux = stateAux.replace(/\s+/g, '_');
    titleState = '-' + stateAux;
    var genderAux = getSelectedGender();
    titleGender = '-' + genderAux.charAt(0).toUpperCase() + genderAux.slice(1);

    var svg = document.getElementsByTagName('svg')[0];
    var clone = svg.cloneNode(true);
    var svgDocType = document.implementation.createDocumentType('svg', "-//W3C//DTD SVG 1.1//EN", "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd");
    var svgDoc = document.implementation.createDocument('http://www.w3.org/2000/svg', 'svg', svgDocType);
    svgDoc.replaceChild(clone, svgDoc.documentElement);
    var svgData = (new XMLSerializer()).serializeToString(svgDoc);
    var a = document.createElement('a');
    a.href = 'data:image/svg+xml; charset=utf8, ' + encodeURIComponent(svgData.replace(/></g, '>\n\r<'));
    a.download = 'Line_Chart' + titleState + titleGender + '.svg';
    a.click();
}


function exportWEBP() {
    var stateAux = getSelectedStates();
    stateAux = stateAux.toString();
    stateAux = stateAux.replace(/\s+/g, '_');
    titleState = '-' + stateAux;
    var genderAux = getSelectedGender();
    titleGender = '-' + genderAux.charAt(0).toUpperCase() + genderAux.slice(1);

    var svg = document.getElementsByTagName('svg')[0];
    var clone = svg.cloneNode(true);
    var svgDocType = document.implementation.createDocumentType('svg', "-//W3C//DTD SVG 1.1//EN", "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd");
    var svgDoc = document.implementation.createDocument('http://www.w3.org/2000/svg', 'svg', svgDocType);
    svgDoc.replaceChild(clone, svgDoc.documentElement);
    var svgData = (new XMLSerializer()).serializeToString(svgDoc);
    var a = document.createElement('a');
    a.href = 'data:image/webp; charset=utf8, ' + encodeURIComponent(svgData.replace(/></g, '>\n\r<'));
    a.download = 'Line_Chart' + titleState + titleGender + '.webp';
    a.click();
}


function exportData(format) {
    var gender = getSelectedGender();
    if (format == 'csv') {
        var states = getSelectedStates();
        exportCSV(gender, states);
    } else if (format == 'svg') {
        exportSVG();
    } else if (format == 'webp') {
        exportWEBP();
    }
}


checkboxlimit(document.forms.compare_modal.checkbox, 4);
compareButtonEvents();