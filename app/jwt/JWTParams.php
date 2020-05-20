<?php

define('JWT_KEY', "MYJWTKEYNOTES");
define('JWT_ISS', "http://localhost/obis");
define('JWT_AUD', "http://localhost/obis");
define('JWT_IAT', time());
define('JWT_EXP', time() + 3600);
