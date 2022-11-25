<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "prefix" exists, if not default the value to blank, basically the same for all variables
    $prefix = isset($_POST['prefix']) ? $_POST['prefix'] : '';
    $partName = isset($_POST['partName']) ? $_POST['partName'] : '';
    $partNumber = isset($_POST['partNumber']) ? $_POST['partNumber'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $laborHours = isset($_POST['laborHours']) ? $_POST['laborHours'] : '';
    $shopRate = isset($_POST['shopRate']) ? $_POST['shopRate'] : '';
    $totalCost = isset($_POST['totalCost']) ? $_POST['totalCost'] : '';
    // Insert new record into the newParts () table
    $stmt = $pdo->prepare('INSERT INTO newParts (id, prefix,partName, partNumber,quantity,laborHours,shopRate,totalCost
        ) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $prefix, $partName, $partNumber, $quantity, $laborHours, $shopRate, $totalCost]);
    // Output message
    $msg = 'Created Successfully!';
}

?>
<?= template_header('Create') ?>

<div class="content update">
    <h2>Create Contact</h2>
    <form action="create.php" method="POST">
        <label for="id">ID</label>
        <label for="name">prefix</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="prefix" placeholder="EX: UA" id="prefix">
        <label for="partName">Part Name</label>
        <label for="partNumber">partNumber</label>
        <input type="text" name="partName" placeholder="partName" id="partName">
        <input type="number" name="partNumber" placeholder="2025550143" id="partNumber">
        <label for="quantity">quantity</label>
        <label for="laborHours">laborHours</label>
        <input type="number" name="quantity" placeholder="quantity" id="quantity">
        <input type="number" name="laborHours" id="laborHours">
        <label for="shopRate">shopRate</label>
        <label for="totalCost">totalCost</label>
        <input type="number" name="shopRate" placeholder="shopRate" id="shopRate">
        <input type="number" name="totalCost" id="totalCost">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>