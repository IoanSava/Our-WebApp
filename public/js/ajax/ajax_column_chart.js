google.charts.load('current', {
    packages: ['corechart']
});

google.charts.setOnLoadCallback(drawChart);


function loadData(gender, state) {
    $.ajax({
        url: '/obis/public/ColumnChartController/sendData',
        method: "POST",
        data: {
            gender: gender,
            state: state
        },
        dataType: "JSON",
        success: function(data) {
            drawChart(data, gender, state);
        }
    });
}


function drawChart(chart_data = '', gender = '', state = '') {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Year');
    data.addColumn('number', '%');
    data.addColumn({ role: 'style' });

    if (chart_data != '') {
        var jsonData = chart_data;

        jsonData.forEach((record, index) => {
            var year = record.year;
            var value = parseFloat(record.data_value);
            data.addRows([
                [String(year), value, 'stroke-color: darkblue; stroke-width: 5;']
            ]);
        });
    }

    var title = 'USA obesity prevalence';
    if (gender != '' && state != '') {
        title = title.concat(" (", gender, ", ", state, ')');
    }

    var options = {
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
    if (gender != '') {
        var state = getSelectedState();
        loadData(gender, state);
    }
}