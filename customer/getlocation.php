<?php
if (isset($_POST["districtid"])) {
    $districtid = $_POST["districtid"];

    include_once("../dboperation.php");
    $sql = "SELECT * FROM tbl_location WHERE districtid = $districtid";
    $obj = new dboperation();
    $result = $obj->executequery($sql);
    $s = 1;
?>
<option selected disabled>Select location</option>
<?php
    while ($row = mysqli_fetch_array($result)) {
?>
       <option value="<?php echo $row['locationid'];?>"><?php echo $row['locationname'];?></option>;
<?php
    }
}
?>
