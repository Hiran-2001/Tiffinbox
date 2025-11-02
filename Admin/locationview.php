


<?php
  include("header.php");
  ?>
	<script src="../jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function() {
            //alert("a")
			$("#districtid").change(function() {
               // alert("a")
				var district_id = $(this).val();

                // alert(district_id)

                
				$.ajax({
					url: "getlocation.php",
					method: "POST",
					data: { districtid: district_id },
					success: function(response) 
                    {
						$("#location").html(response);
					},
					error: function() 
                    {
						$("#location").html("Error occurred while getting location!");
					}
				});
			});
		});
	</script>






</head>
<body>
   
        <?php
        include_once("../dboperation.php");
        $sql="select * from tbl_district";
        $obj=new dboperation();
        $result=$obj->executequery($sql);
        ?>


<div class="col-md-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">View Location</h4>
      <p class="card-description">Select a district to view locations</p>
     
        <div class="form-group">
          <label>Select a District</label>
          <select class="form-control" name="districtid" id="districtid" onchange="this.form.submit()">
            <option value="">--------Select District-----------</option>
            <?php
            while ($r = mysqli_fetch_array($result)) 
            { ?>
              <option value="<?php echo $r["districtid"]; ?>">
                <?php echo $r["districtname"]; ?>
              </option>
            <?php } ?>


          </select>
        </div>
      
   

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Sl.No</th>
        <th>Location Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="location">
     
      
     
    </tbody>
  </table>




  </div>
  </div>
</body>
</html>

<?php
  include("footer.php");
  ?>