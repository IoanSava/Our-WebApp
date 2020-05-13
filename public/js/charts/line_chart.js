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

function getSelectedGender() {
    var select = document.getElementById("gender-selector");
    return select.options[select.selectedIndex].value;
}


function getSelectedStates() {
    var checkboxes = document.getElementsByName('checkbox');
    var states = [];
    for (var i = 0; i < checkboxes.length; ++i) {
        if (checkboxes[i].checked) {
            states.push(checkboxes[i].value);
        }
    }
    return states;
}

function exportCSV(gender, states) {
    window.open('/obis/public/LineChartController/exportCSV?gender=' + gender + '&states=' + states);
}

function exportSVG() {
    var stateAux = getSelectedStates();
    stateAux = stateAux.join('_');
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
    stateAux = stateAux.join('_');
    titleState = '-' + stateAux;
    var genderAux = getSelectedGender();
    titleGender = '-' + genderAux.charAt(0).toUpperCase() + genderAux.slice(1);

    var svg = document.querySelector('svg');
    var svgURL = new XMLSerializer().serializeToString(svg);
    var canvas = document.createElement('canvas');

    var width = svg.getAttribute("width");
    var height = svg.getAttribute("height");

    canvas.width = width;
    canvas.height = height;

    var img = new Image(width, height);

    img.onload = function() {
        ctx = canvas.getContext('2d');
        ctx.drawImage(this, 0, 0, width, height, 0, 0, width, height);
        var dataURL = canvas.toDataURL('image/webp');

        var a = document.createElement('a');
        a.href = dataURL;
        a.download = 'Line_Chart' + titleState + titleGender + '.webp';
        a.click();
    }
    img.src = 'data:image/svg+xml; charset=utf8, ' + encodeURIComponent(svgURL);
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