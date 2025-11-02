<?php
	if(isset($_POST["categoryid"])) 
	{
		$categoryid = $_POST["categoryid"];

		// You can replace this code with a database query to retrieve the states for the selected country
		include_once("../dboperation.php");
        $sql="select * from tbl_subscription where categoryid=$categoryid";
        $obj=new dboperation();
        $result=$obj->executequery($sql);
        $s=1;
?>

<?php
while($row=mysqli_fetch_array($result))
{
?>

<tr>
        <td><?php echo $s++; ?></td>
        <td><?php echo $row["subname"]; ?></td>
         <td><?php echo $row["day"]; ?></td>
          <td><?php echo $row["amount"]; ?></td>
        <td>
            <img src="../uploads/<?php echo $row['image']; ?> "style="width:150px;height:150px;" />         
        </td>
       
        <td>
        <a href="menudetails.php?subscriptionid=<?php echo $row["subscriptionid"];?>" class="btn btn-primary">view Menu details</a>

        </td>
      </tr>
      
      
      
      <?php
}
	}
?>

		
	


