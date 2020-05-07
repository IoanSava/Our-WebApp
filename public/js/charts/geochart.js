function selectYearButtonEvents() {
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


function getSelectedYear() {
    var radios = document.getElementsByName('radio');
    for (var i = 0; i < radios.length; ++i) {
        if (radios[i].checked) {
            return radios[i].value;
        }
    }
}


function exportCSV(gender, year) {
    window.open('/obis/public/GeoChartController/exportCSV?gender=' + gender + '&year=' + year);
}


function exportSVG() {
    var yearAux = getSelectedYear();
    titleYear = '-' + yearAux.toString();
    var genderAux = getSelectedGender();
    titleGender = '-' + genderAux.charAt(0).toUpperCase() + genderAux.slice(1);

    var svg = document.getElementsByTagName('svg')[0];
    var clone = svg.cloneNode(true);
    var svgDocType = document.implementation.createDocumentType('svg', "-//W3C//DTD SVG 1.1//EN", "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd");
    var svgDoc = document.implementation.createDocument('http://www.w3.org/2000/svg', 'svg', svgDocType);
    svgDoc.replaceChild(clone, svgDoc.documentElement);
    var svgData = (new XMLSerializer()).serializeToString(svgDoc);
    var a = document.createElement('a');
    const baseTitle = '-USA_obesity_prevalence';
    a.href = 'data:image/svg+xml; charset=utf8, ' + encodeURIComponent(svgData.replace(/></g, '>\n\r<'));
    a.download = 'Ranking-Chart' + baseTitle + titleGender + titleYear + '.svg';
    a.click();
}


function exportData(format) {
    var gender = getSelectedGender();
    if (gender != '') {
        if (format == 'csv') {
            var year = getSelectedYear();
            exportCSV(gender, year);
        } else if (format == 'svg') {
            exportSVG();
        }
    } else {
        alert("You didn't specifed a gender");
    }
}

selectYearButtonEvents();