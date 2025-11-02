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
          <a href="subscriptionedit.php?subscriptionid=<?php echo $row["subscriptionid"];?>" class="btn btn-primary">Edit</a>
          <a href="subscriptiondelete.php?did=<?php echo $row["subscriptionid"];?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
        <a href="food_add_sub.php?subscriptionid=<?php echo $row["subscriptionid"];?>" class="btn btn-primary">Add Menu</a>

        </td>
      </tr>
      
      
      
      <?php
}
	}
?>

		
	


