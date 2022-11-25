<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the part id exists, for example update.php?id=1 will get the part with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $prefix = isset($_POST['prefix']) ? $_POST['prefix'] : '';
        $partName = isset($_POST['partName']) ? $_POST['partName'] : '';
        $partNumber = isset($_POST['partNumber']) ? $_POST['partNumber'] : '';
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
        $laborHours = isset($_POST['laborHours']) ? $_POST['laborHours'] : '';
        $shopRate = isset($_POST['shopRate']) ? $_POST['shopRate'] : '';
        $totalCost = isset($_POST['totalCost']) ? $_POST['totalCost'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE parts SET id = ?, prefix = ?, partName = ?,  partNumber = ?, quantity = ?, laborHours = ?, shopRate = ?, totalCost = ? WHERE id = ?');
        $stmt->execute([$id, $prefix, $partName, $partNumber, $quantity, $laborHours, $shopRate, $totalCost, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the part from the newParts table
    $stmt = $pdo->prepare('SELECT * FROM newParts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $part = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$part) {
        exit('part doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?= template_header('Read') ?>

<div class="content update">
    <h2>Update part #<?= $part['id'] ?></h2>
    <form action="update.php?id=<?= $part['id'] ?>" method="POST">
        <label for="id">ID</label>
        <label for="name">prefix</label>
        <input type="text" name="id" placeholder="26" value="<?= $part['id'] ?>" id="id">
        <input type="text" name="prefix" placeholder="John Doe" value="<?= $part['prefix'] ?>" id="prefix">
        <label for="partName">Part Name</label>
        <label for="partNumber">partNumber</label>
        <input type="text" name="partName" placeholder="partName" value="<?= $part['partName'] ?>" id="partName">
        <input type="number" name="partNumber" placeholder="2025550143" value="<?= $part['partNumber'] ?>" id="partNumber">
        <label for="quantity">quantity</label>
        <label for="laborHours">laborHours</label>
        <input type="number" name="quantity" placeholder="quantity" value="<?= $part['quantity'] ?>" id="quantity">
        <input type="number" name="laborHours" value="<?= $part['laborHours'] ?>" id="laborHours">
        <label for="shopRate">shopRate</label>
        <label for="totalCost">totalCost</label>
        <input type="number" name="shopRate" value="<?= $part['shopRate'] ?>" placeholder="shopRate" id="shopRate">
        <input type="number" name="totalCost" id="totalCost" value="<?= $part['totalCost'] ?>">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>