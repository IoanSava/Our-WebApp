<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>RO Obesity Prevalence Visualizer</title>
    <script src="https://kit.fontawesome.com/fdbc1f14fa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/obis/public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/obis/public/css/validation.css" />
</head>

<body>

    <main id="mainid">
        <header>
            <span class="deprecated">&#9776;</span>
            <h1>Obesity Prevalence Visualizer</h1>
            <div class="logo-image"></div>
        </header>
        <div class="container">
            <div class="message">
                <h1 class="greeting">&#128531; Oops! It appears there has been a problem<br>when sending the form!&nbsp;The problem was:<br><?= $data['message'] ?></h1>
                <button class="redirect" onclick="location.href = '../home/contact'">
                    <div id="second-part"></div><span id="first-part">Return to contact form</span>
                </button>
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

</body>

</html>