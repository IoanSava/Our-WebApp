google.charts.load('current', {
    packages: ['geochart']
});

google.charts.setOnLoadCallback(drawChart);


function loadData(gender, year) {
    var data = new FormData();
    data.append('gender', gender);
    data.append('year', year);
    data.append('chart_type', "geo");

    var url = '/obis/public/getChartData';
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            var response = JSON.parse(xhr.responseText);
            drawChart(response, gender, year);
        }
    };

    xhr.open('POST', url, true);
    xhr.send(data);
}


function getTitle(gender, year) {
    var title = 'USA obesity prevalence';
    if (gender != '' && year != '') {
        title = title.concat(" (", gender, ", ", year, ')');
    }
    return title;
}


function getOptions(title) {
    return {
        title: title,
        region: 'US',
        displayMode: 'regions',
        resolution: 'provinces',
        colorAxis: { colors: ['lightcyan', 'midnightblue'] },
        backgroundColor: {
            fill: 'ghostwhite',
            stroke: 'black',
            strokeWidth: 5
        },
        datalessRegionColor: 'lightsteelblue',
        tooltip: {
            textStyle: {
                color: 'navy',
                fontName: 'Gill Sans',
                fontSize: 14,
                italic: true
            }
        }
    };
}


function drawChart(chartData = '', gender = '', year = '') {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'State');
    data.addColumn('number', 'Percentage');

    if (chartData != '') {
        var jsonData = chartData;

        jsonData.forEach((record, index) => {
            var state = record.state;
            var value = parseFloat(record.data_value);
            data.addRows([
                [String(state), value]
            ]);
        });
    }

    var title = getTitle(gender, year);
    var options = getOptions(title);
    var chart = new google.visualization.GeoChart(document.getElementById('chart'));
    chart.draw(data, options);
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


function updateChart() {
    var gender = getSelectedGender();
    var year = getSelectedYear();
    loadData(gender, year);
}


updateChart();