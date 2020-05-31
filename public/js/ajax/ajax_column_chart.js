google.charts.load('current', {
    packages: ['corechart']
});

google.charts.setOnLoadCallback(drawChart);


function loadData(gender, state) {
    var data = new FormData();
    data.append('gender', gender);
    data.append('state', state);
    data.append('chart_type', "column");

    var url = '/obis/public/getChartData';
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            var response = JSON.parse(xhr.responseText);
            drawChart(response, gender, state);
        }
    };

    xhr.open('POST', url, true);
    xhr.send(data);
}


function getTitle(gender, state) {
    var title = 'USA obesity prevalence';
    if (gender != '' && state != '') {
        title = title.concat(" (", gender, ", ", state, ')');
    }
    return title;
}


function getOptions(title) {
    return {
        title: title,
        titleTextStyle: {
            fontName: 'Gill Sans',
            fontSize: 18
        },
        vAxis: {
            title: "Percentage",
            minValue: 0,
            textStyle: {
                fontName: 'Gill Sans',
                bold: true
            },
            titleTextStyle: {
                fontName: 14,
                fontSize: 'Gill Sans',
                bold: true
            }
        },
        backgroundColor: {
            stroke: 'black',
            strokeWidth: 5,
            fill: 'ghostwhite'
        },
        colors: ['cornflowerblue'],
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        },
        hAxis: {
            title: "Year",
            textStyle: {
                fontName: 'Gill Sans',
                bold: true
            },
            titleTextStyle: {
                fontName: 14,
                fontSize: 'Gill Sans',
                bold: true
            }
        }
    };
}


function drawChart(chartData = '', gender = '', state = '') {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Year');
    data.addColumn('number', '%');
    data.addColumn({ role: 'style' });

    if (chartData != '') {
        var jsonData = chartData;

        jsonData.forEach((record, index) => {
            var year = record.year;
            var value = parseFloat(record.data_value);
            data.addRows([
                [String(year), value, 'stroke-color: darkblue; stroke-width: 5;']
            ]);
        });
    }

    var title = getTitle(gender, state);
    var options = getOptions(title);
    var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
    chart.draw(data, options);
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


function updateChart() {
    var gender = getSelectedGender();
    var state = getSelectedState();
    loadData(gender, state);
}


updateChart();