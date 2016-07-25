<?php
session_id($_GET['PHPSESSID']);
session_start();
echo "session_value：".$_SESSION['url'];