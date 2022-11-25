<?php
include 'DBController.php';
$db_handle = new DBController();
$countryResult = $db_handle->runQuery("SELECT DISTINCT Country FROM tbl_user ORDER BY Country ASC");
?>
<div class="search-box">
    <select id="Place" name="country[]" multiple="multiple">
        <option value="0" selected="selected">Select Country</option>
        <?php
        if (!empty($countryResult)) {
            foreach ($countryResult as $key => $value) {
                echo '<option value="' . $countryResult[$key]['Country'] . '">' . $countryResult[$key]['Country'] . '</option>';
            }
        }
        ?>
    </select>
    <button id="Filter">Search</button>
</div>