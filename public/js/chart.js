/* --- Charts --- */

function loadLineChart() {
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawLineChart);
}

function drawLineChart() {
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Percentage'],
        ['2001', 17.4],
        ['2002', 17.6],
        ['2003', 17.8],
        ['2004', 18],
        ['2005', 18.3],
        ['2006', 18.5],
        ['2007', 18.8]
    ]);

    var options = {
        title: 'USA obesity prevalence',
        curveType: 'function',
        legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart'));

    chart.draw(data, options);
}

function loadColumnChart() {
    google.charts.load('current', { 'packages': ['bar'] });
    google.charts.setOnLoadCallback(drawColumnChart);
}

function drawColumnChart() {
    var data = google.visualization.arrayToDataTable([
        ['Year', '%'],
        ['2001', 17.4],
        ['2002', 17.6],
        ['2003', 17.8],
        ['2004', 18],
        ['2005', 18.3],
        ['2006', 18.5],
        ['2007', 18.8]
    ]);

    var options = {
        chart: {
            title: 'USA obesity prevalence'
        }
    };

    var chart = new google.charts.Bar(document.getElementById('chart'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
}

function loadRanking() {
    google.charts.load('current', { 'packages': ['table'] });
    google.charts.setOnLoadCallback(drawRanking);
}

function drawRanking() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Year');
    data.addColumn('number', 'Percentage');
    data.addRows([
        ['2001', 17.4],
        ['2002', 17.6],
        ['2003', 17.8],
        ['2004', 18],
        ['2005', 18.3],
        ['2006', 18.5],
        ['2007', 18.8]
    ]);

    var table = new google.visualization.Table(document.getElementById('chart'));

    table.draw(data, { showRowNumber: true, width: '100%', height: '100%' });
}

function delete_anchor_by_id(anchor_id) {
    var anchor = document.getElementById(anchor_id);

    if (anchor != null) {
        anchor.remove();
    }
}

function add_anchor(anchor_id, text) {
    var anchor = document.getElementById(anchor_id);

    if (anchor == null) {
        var new_anchor = document.createElement('a');
        var textNode = document.createTextNode(text);
        new_anchor.appendChild(textNode);
        new_anchor.id = anchor_id;
        var container = document.getElementById("options");
        container.insertBefore(new_anchor, container.firstChild);
    }
}

function exportButtonEvents() {
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function compareButtonEvents() {
    // Get the modal
    var cmodal = document.getElementById("compare_modal");

    // Get the button that opens the modal
    var cbtn = document.getElementById("compare_button");

    // Get the <span> element that closes the modal
    var cspan = document.getElementsByClassName("cclose")[0];

    // When the user clicks the button, open the modal 
    cbtn.onclick = function() {
        cmodal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    cspan.onclick = function() {
        cmodal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == cmodal) {
            cmodal.style.display = "none";
        }
    }
}

function changeToLineChartMode() {
    delete_anchor_by_id("view_line_chart_button");

    add_anchor("view_ranking_button", "View ranking");
    add_anchor("view_column_chart_button", "View column chart");
    add_anchor("compare_button", "Compare");

    document.getElementById("view_column_chart_button").addEventListener("click", changeToColumnChartMode);
    document.getElementById("view_ranking_button").addEventListener("click", changeToRankingMode);
    compareButtonEvents();

    loadLineChart();
}

function changeToColumnChartMode() {
    delete_anchor_by_id("compare_button");
    delete_anchor_by_id("view_column_chart_button");

    add_anchor("view_ranking_button", "View ranking");
    add_anchor("view_line_chart_button", "View line chart");

    document.getElementById("view_line_chart_button").addEventListener("click", changeToLineChartMode);
    document.getElementById("view_ranking_button").addEventListener("click", changeToRankingMode);

    loadColumnChart();
}

function changeToRankingMode() {
    delete_anchor_by_id("compare_button");
    delete_anchor_by_id("view_ranking_button");

    add_anchor("view_column_chart_button", "View column chart");
    add_anchor("view_line_chart_button", "View line chart");

    document.getElementById("view_line_chart_button").addEventListener("click", changeToLineChartMode);
    document.getElementById("view_column_chart_button").addEventListener("click", changeToColumnChartMode);

    loadRanking();
}

loadLineChart();
exportButtonEvents();
compareButtonEvents();

document.getElementById("view_column_chart_button").addEventListener("click", changeToColumnChartMode);
document.getElementById("view_ranking_button").addEventListener("click", changeToRankingMode);