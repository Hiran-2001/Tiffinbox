<?php
include_once("../dboperation.php");
$obj = new dboperation();

if (isset($_POST['submit'])) {

   echo $sid = $_POST['subid']; // hidden field
    $day_no         = $_POST['n'];         // numeric
    $breakfast_id   = $_POST['bf']; // breakfast food ID
    $lunch_id       = $_POST['l'];
    $dinner_id      = $_POST['d'];

    /* --- three plain INSERTs --- */

    $r1 = " INSERT INTO tbl_mealplandetails (mealtypeid,foodid,daynum,subscriptionid)
            VALUES (1,'$breakfast_id','$day_no','$sid')";
    $obj->executequery($r1);


    $r2 = " INSERT INTO tbl_mealplandetails (mealtypeid,foodid,daynum,subscriptionid)
            VALUES (2,'$lunch_id','$day_no','$sid')";
    $obj->executequery($r2);

    
    $r3 = " INSERT INTO tbl_mealplandetails (mealtypeid,foodid,daynum,subscriptionid)
            VALUES (3,'$dinner_id','$day_no','$sid')";
    $obj->executequery($r3);
   
    
    echo "<script>
            alert('Day $day_no meal plan saved!');
            window.location = 'food_add_sub.php?subscriptionid=$sid';
          </script>";
}
?>