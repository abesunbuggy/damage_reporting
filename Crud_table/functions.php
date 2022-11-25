<?php
function pdo_connect_mysql()
{
    $DATABASE_HOST = 'localhost:6033';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'FLAT_TIRE';
    $DATABASE_NAME = 'buggy2';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to database!');
    }
}
function template_header($title)
{
    echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Fleet Parts Management</h1>
            <a href="create.php"><i class="fa-regular fa-plus"></i>Create New</a>
    		<a href="read.php"><i class="fa-solid fa-table"></i>Show All</a>
    	</div>
    </nav>
EOT;
}
function template_footer()
{
    echo <<<EOT
    </body>
</html>
EOT;
}
