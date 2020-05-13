google.charts.load('current', {
    packages: ['corechart']
});

google.charts.setOnLoadCallback(drawChart);


function loadData(gender, states) {
    $.ajax({
        url: '/obis/public/LineChartController/getData',
        method: "POST",
        data: {
            gender: gender,
            states: states
        },
        dataType: "JSON",
        success: function(data) {
            drawChart(data, gender, states);
        }
    });
}


function getTitle(gender, states) {
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
}


function drawChart(chartData = '', gender = '', states = []) {
    // add headers
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Year');
    states.forEach((state) => {
        data.addColumn('number', state);
    });

    if (chartData != '') {
        var jsonData = chartData;


        var yearArray = [];
        for (aux in jsonData[states[0]]) {
            yearArray.push(String(jsonData[states[0]][aux]['year']));
        }

        var index = 0;

        for (year in yearArray) {
            var dataValueArray = [];
            dataValueArray.push(yearArray[year]);
            for (stateIndex in states) {
                var aux = jsonData[states[stateIndex]][index.toString()]['data_value'];
                dataValueArray.push(parseFloat(aux));
            }
            ++index;
            data.addRows([dataValueArray]);
        }
    }

    var title = getTitle(gender, states);
    var options = getOptions(title);
    var chart = new google.visualization.LineChart(document.getElementById('chart'));
    chart.draw(data, options);
}


function updateChart() {
    var gender = getSelectedGender();
    var states = getSelectedStates();
    loadData(gender, states);
}


updateChart();