google.charts.load('current', {
    packages: ['geochart']
});

google.charts.setOnLoadCallback(drawChart);


function loadData(gender, year) {
    $.ajax({
        url: '/obis/public/GeoChartController/sendData',
        method: "POST",
        data: {
            gender: gender,
            year: year
        },
        dataType: "JSON",
        success: function(data) {
            drawChart(data, gender, year);
        }
    });
}


function drawChart(chart_data = '', gender = '', year = '') {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'State');
    data.addColumn('number', 'Percentage');

    if (chart_data != '') {
        var jsonData = chart_data;

        jsonData.forEach((record, index) => {
            var state = record.state;
            var value = parseFloat(record.data_value);
            data.addRows([
                [String(state), value]
            ]);
        });
    }

    var title = 'USA obesity prevalence';
    if (gender != '' && year != '') {
        title = title.concat(" (", gender, ", ", year, ')');
    }

    var options = {
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
    var radios = document.getElementsByName('radio');
    var year = getSelectedYear();
    loadData(gender, year);
}


updateChart();