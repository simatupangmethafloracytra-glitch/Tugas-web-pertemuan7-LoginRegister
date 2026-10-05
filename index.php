<?php
require 'functions.php';
redirect(sudahLogin() ? 'dashboard.php' : 'login.php');
