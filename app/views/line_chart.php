<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Line Chart</title>
    <link rel="stylesheet" type="text/css" href="/obis/public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/obis/public/css/charts/chart.css" />
    <link rel="stylesheet" type="text/css" href="/obis/public/css/charts/line_chart.css" />
</head>

<body>
    <nav id="sidenav">
        <a href="javascript:void(0)" class="closeButton" onclick="closeNavBar()">&times;</a>
        <a href="../home/index">HOME</a>
        <a href="../home/about">ABOUT</a>
        <a href="../home/statistics">STATISTICS</a>
        <a href="../home/bmi">BODY MASS INDEX</a>
        <a href="../home/diets">DIETS</a>
        <a href="../home/contact">CONTACT</a>
    </nav>

    <main id="mainid">
        <header>
            <span onclick="openNavBar()" id="openNav">&#9776;</span>
            <h1>Obesity Prevalence Visualizer</h1>
            <div class="logo-image"> </div>
        </header>

        <div class="container">
            <div id="chart"></div>
            <div id="options">
                <div class="choicebox">
                    <select name="gender" id="gender-selector" onchange="updateChart()">
                        <option value="female">FEMALE</option>
                        <option value="male">MALE</option>
                    </select>
                </div>
                <br>
                <a id="compare_button">COMPARE</a>
                <form id="compare_modal" class="modal" onchange="updateChart()">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <p class="title">Compare</p>

                        <?php
                        $first = true;
                        foreach ($data as $state => $state_abbr) {
                        ?>
                            <label class="container-btn">
                                <?= $state ?>
                                <?php if ($first == true) { $first = false; ?>
                                    <input type="checkbox" checked="checked" name="checkbox" value="<?= $state_abbr ?>">
                                <?php } else { ?>
                                    <input type="checkbox" name="checkbox" value="<?= $state_abbr ?>">
                                <?php } ?>
                                <span class="checkmark"></span>
                            </label>
                        <?php } ?>

                    </div>
                </form>
              
                <a id="export_button">EXPORT</a>
                <div id="export_modal" class="modal">
                    <div class="modal-content emodal-content">
                        <span class="export_close">&times;</span>
                        <p class="title">Export</p>
                        <button class="btn webp-button" onclick="exportData('webp')"></button>
                        <button class="btn csv-button" onclick="exportData('csv')"></button>
                        <button class="btn svg-button" onclick="exportData('svg')"></button>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="column">
                <span class="dot dot-ad"></span>
                <div>
                    <h3>Address</h3>
                    <p>Gen. Berthelot</p>
                </div>
            </div>

            <div class="column">
                <span class="dot dot-ph"></span>
                <div>
                    <h3>Phone</h3>
                    <p>0711223344</p>
                </div>
            </div>

            <div class="column">
                <span class="dot dot-em"></span>

                <div>
                    <h3>Email</h3>
                    <p>ourwebapp@info.uaic.ro</p>
                </div>
            </div>
        </footer>
    </main>

    <script src="/obis/public/js/charts/chart.js"></script>
    <script src="/obis/public/js/charts/line_chart.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="/obis/public/js/ajax/ajax_line_chart.js"></script>
    <script src="/obis/public/js/menu.js"></script>
</body>

</html>