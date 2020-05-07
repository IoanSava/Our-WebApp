google.charts.load('current', {
    packages: ['corechart']
});

google.charts.setOnLoadCallback(drawChart);


function load_data(gender, states) {
    $.ajax({
        url: '/obis/app/handlers/LineChartHandler.php',
        method: "POST",
        data: {
            gender: gender,
            state: states
        },
        dataType: "JSON",
        success: function(data) {
            drawChart(data, gender, states);
        }
    });
}


function drawChart(chart_data = '', gender = '', states = []) {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Year');
    states.forEach((state) => {
        data.addColumn('number', state);
    });

    if (chart_data != '') {
        var jsonData = chart_data;


        var year_array = [];
        for (aux in jsonData[states[0]]) {
            year_array.push(String(jsonData[states[0]][aux]['year']));
        }

        var value_array;
        var index = 0;
        var aux;
        for (elem in year_array) {
            value_array = [];
            value_array.push(year_array[elem]);
            for (index_in_states in states) {
                aux = jsonData[states[index_in_states]][index.toString()]['data_value']
                value_array.push(parseFloat(aux));
            }
            index++;
            data.addRows([value_array]);
        }
    }

    var title = 'USA obesity prevalence';
    if (gender != '' && states != []) {
        title = title.concat(" (", gender, ", ", states, ')');
    }

    var options = {
        title: title,
        vAxis: {
            title: 'Percentage'
        },
        hAxis: {
            title: 'Year'
        }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart'));
    chart.draw(data, options);
}


function updateChart() {
    var select = document.getElementById("gender-selector");
    var gender = select.options[select.selectedIndex].value;
    if (gender != '') {
        var checkboxes = document.getElementsByName('checkbox');
        var states = [];
        for (var i = 0; i < checkboxes.length; ++i) {
            if (checkboxes[i].checked) {
                states.push(checkboxes[i].value);
            }
        }
        load_data(gender, states);
    }
}