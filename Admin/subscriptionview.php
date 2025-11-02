


<?php
  include("header.php");
  ?>
	<script src="../jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function() {
            //alert("a")
			$("#categoryid").change(function() {
               // alert("a")
				var categoryid = $(this).val();

                // alert(district_id)

                
				$.ajax({
					url: "getsubscription.php",
					method: "POST",
					data: { categoryid: categoryid },
					success: function(response) 
                    {
						$("#sub").html(response);
					},
					error: function() 
                    {
						$("#sub").html("Error occurred while getting location!");
					}
				});
			});
		});
	</script>






</head>
<body>
   
        <?php
        include_once("../dboperation.php");
        $sql="select * from tbl_category";
        $obj=new dboperation();
        $result=$obj->executequery($sql);
        ?>

<br><br>
<div class="col-md-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">View Subscription details</h4>
      <p class="card-description">Select a category to view details</p>
     
        <div class="form-group">
          <label>Select a category</label>
          <select class="form-control" name="categoryid" id="categoryid" onchange="this.form.submit()">
            <option value="">--------Select category-----------</option>
            <?php
            while ($r = mysqli_fetch_array($result)) 
            { ?>
              <option value="<?php echo $r["categoryid"]; ?>">
                <?php echo $r["category_name"]; ?>
              </option>
            <?php } ?>


          </select>
        </div>
      
   

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Sl.No</th>
        </th> Name</th>
        <th>Image</th>

        <th>Day</th>
        <th>Amount</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="sub">
     
      
     
    </tbody>
  </table>




  </div>
  </div>
  </div></div></div>
</body>
</html>


            

<?php
  include("footer.php");
  ?>