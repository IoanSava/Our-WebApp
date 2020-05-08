google.charts.load('current', {
    packages: ['corechart']
});

google.charts.setOnLoadCallback(drawChart);


function loadData(gender, states) {
    $.ajax({
        url: '/obis/public/LineChartController/sendData',
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

    var title = 'USA Obesity Prevalence';
    if (gender != '' && states != []) {
        if (states.length > 1) {
            title = title.concat(" (", gender, ", ");
            for (var i = 0; i < states.length - 1; i++) {
                title = title.concat(states[i], ', ');
            }
            title = title.concat(states[i], ')');
        } else {
            title = title.concat(" (", gender, ", ", states, ')');
        }
    }

    var options = {
        title: title,
        titleTextStyle: {
            fontName: 'Gill Sans',
            fontSize: 18
        },
        vAxis: {
            title: 'Percentage',
            minValue: 0,
            textStyle: {
                fontName: 'Gill Sans',
                bold: true
            },
        },
        lineWidth: 7,
        hAxis: {
            title: 'Year',
            minValue: 0,
            textStyle: {
                fontName: 'Gill Sans',
                bold: true
            },
        },
        colorAxis: { colors: ['lightcyan', 'midnightblue'] },
        backgroundColor: {
            fill: 'ghostwhite',
            stroke: 'black',
            strokeWidth: 5
        },
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart'));
    chart.draw(data, options);
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


function updateChart() {
    var gender = getSelectedGender();
    var states = getSelectedStates();
    loadData(gender, states);
}

updateChart();