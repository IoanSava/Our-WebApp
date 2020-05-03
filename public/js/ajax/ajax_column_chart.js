google.charts.load('current', {
    packages: ['corechart', 'bar']
});

google.charts.setOnLoadCallback(drawChart);


function load_data(gender, state) {
    $.ajax({
        url: '/obis/app/handlers/ColumnChartHandler.php',
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

    if (chart_data != '') {
        var jsonData = chart_data;

        jsonData.forEach((record, index) => {
            var year = record.year;
            var value = parseFloat(record.data_value);
            data.addRows([
                [String(year), value]
            ]);
        });
    }

    var title = 'USA obesity prevalence';
    if (gender != '' && state != '') {
        title = title.concat(" (", gender, ", ", state, ')');
    }

    var options = {
        chart: {
            title: title
        }
    };

    var chart = new google.charts.Bar(document.getElementById('chart'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
}


function updateChart() {
    var select = document.getElementById("gender-selector");
    var gender = select.options[select.selectedIndex].value;
    if (gender != '') {
        var radios = document.getElementsByName('radio');
        var state;
        for (var i = 0; i < radios.length; ++i) {
            if (radios[i].checked) {
                state = radios[i].value;
                break;
            }
        }
        load_data(gender, state);
    }
}