<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RO Obesity Prevalence Visualizer</title>
    <link rel="stylesheet" type="text/css" href="/obis/public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/obis/public/css/statistics-gender.css" />
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
                <a id="compare_button">Compare</a>
                <div id="compare_modal" class="modal">
                    <div class="modal-content">
                        <span class="compare_close">&times;</span>
                        <p class="title">Compare</p>
                        <!-- <form action="/action_page.php"> -->
                        <label class="container-btn">
                            <?= $data[0] ?>
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                        </label>
                        <?php
                        for ($i = 1; $i < count($data); ++$i) {
                        ?>
                            <label class="container-btn">
                                <?= $data[$i] ?>
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        <?php } ?>
                        <input class="submit-btn" type="submit" value="Submit">
                        <!-- </form> -->
                    </div>
                </div>
                <div id="select_modal" class="modal">
                    <div class="modal-content">
                        <span class="select_close">&times;</span>
                        <p class="title">Select state</p>
                        <label class="container-radio">
                            <?= $data[0] ?>
                            <input type="radio" checked="checked" name="radio">
                            <span class="checkmark-radio"></span>
                        </label>
                        <?php
                        for ($i = 1; $i < count($data); ++$i) {
                        ?>
                            <label class="container-radio">
                                <?= $data[$i] ?>
                                <input type="radio" name="radio">
                                <span class="checkmark-radio"></span>
                            </label>
                        <?php } ?>
                        <input class="submit-radio" type="submit" value="Submit">
                    </div>
                </div>
                <a id="view_column_chart_button">View column chart</a>
                <a id="view_ranking_button">View Ranking</a>
                <a id="export_button">EXPORT</a>
                <div id="export_modal" class="modal">
                    <div class="modal-content emodal-content">
                        <span class="export_close">&times;</span>
                        <p class="title">Export</p>
                        <button class="btn webp-button"></button>
                        <button class="btn csv-button"></button>
                        <button class="btn svg-button"></button>
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
    <script src="/obis/public/js/menu.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="/obis/public/js/chart.js"></script>
</body>

</html>