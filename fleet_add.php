<?php

$dbHost = "localhost:6033";
$dbUser = "root";
$dbPassword = "FLAT_TIRE";
$dbName = "buggy2";
$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}


try {
    $dsn = "mysql:host=" . $dbHost . ";dbname=" . $dbName;
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
} catch (PDOException $e) {
    if (str_contains($e, '1062 Duplicate entry')) {
        header("Location: index.php");
    }
    die("Error inserting details into database: " .  $e->getMessage());
    echo "DB Connection Failed: " . $e->getMessage();
}

$status = "";
try {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fleetPrefix = strtoupper($_POST['fleetPrefix']);
        $sunbuggyId = $_POST['sunbuggyId'];


        if (empty($fleetPrefix) || empty($sunbuggyId)) {
            $status = "All fields are compulsory.";
        } else {
            if (strlen($fleetPrefix) >= 255 || !preg_match("/^[a-z]{2}$/i", $fleetPrefix)) {
                $status = "Please enter a valid fleetPrefix ie: QA";
            } else {

                $sql = "INSERT INTO fleet (fleetPrefix, sunbuggyId) VALUES (:fleetPrefix, :sunbuggyId)";
                if (!$sql) {
                    echo "Enter a different value";
                } else {
                }


                $stmt = $pdo->prepare($sql);

                $stmt->execute(['fleetPrefix' => $fleetPrefix, 'sunbuggyId' => $sunbuggyId]);

                $status = "Created Fleet: " . $fleetPrefix . "-" . $sunbuggyId;
                $fleetPrefix = "";
                $sunbuggyId = "";
            }
        }
    }
} catch (Exception $e) {
    if ($e->getMessage() == "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'RA-001' for key 'cannotHaveSame'") {
        echo "failed: duplicate entry  please <a href=\"javascript:history.go(-1)\">GO BACK</a> ";
    } else {
        echo $e->getMessage();
    }
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Fleet add</title>
</head>

<body>

    <div class="container">
        <h1>Insert Fleet Here</h1>

        <form action="" method="POST" class="main-form">
            <div class="form-group">
                <label for="name">Fleet Prefix</label>
                <input type="text" name="fleetPrefix" id="fleetPrefix" class="gt-input" value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $fleetPrefix ?>">
            </div>

            <div class="form-group">
                <label for="sunbuggyId">Sunbuggy Id</label>
                <input type="text" name="sunbuggyId" id="sunbuggyId" class="gt-input" value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $sunbuggyId ?>">
            </div>
            <input type="submit" class="gt-button" value="Submit">

            <div class="form-status">
                <?php echo $status ?>
            </div>
        </form>
    </div>

    <script src="main.js"></script>

</body>

</html>