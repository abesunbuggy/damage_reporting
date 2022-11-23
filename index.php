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
    die("Error inserting user details into database: " .  $e->getMessage());
    echo "DB Connection Failed: " . $e->getMessage();
}

$status = "";
try {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $prefix = strtoupper($_POST['prefix']);
        $fleetId = $_POST['fleetId'];


        if (empty($prefix) || empty($fleetId)) {
            $status = "All fields are compulsory.";
        } else {
            if (strlen($prefix) >= 255 || !preg_match("/^[a-z]{2}$/i", $prefix)) {
                $status = "Please enter a valid prefix ie: QA";
            } else {

                $sql = "INSERT INTO Fleet (prefix, fleetId) VALUES (:prefix, :fleetId)";
                if (!$sql) {
                    echo "Enter a different value";
                } else {
                }


                $stmt = $pdo->prepare($sql);

                $stmt->execute(['prefix' => $prefix, 'fleetId' => $fleetId]);

                $status = "Created Fleet: " . $prefix . "-" . $fleetId;
                $prefix = "";
                $fleetId = "";
            }
        }
    }
} catch (Exception $e) {
    die("Insert error, Please insert a Unique value go back:  " . $status . " already exists");
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
                <label for="name">Prefix</label>
                <input type="text" name="prefix" id="prefix" class="gt-input" value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $prefix ?>">
            </div>

            <div class="form-group">
                <label for="fleetId">Fleet Id</label>
                <input type="text" name="fleetId" id="fleetId" class="gt-input" value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $fleetId ?>">
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