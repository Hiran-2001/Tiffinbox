
<?php
include("header.php");
include("../dboperation.php");
$obj=new dboperation();
if(isset($_GET['did']))//did is the category id which is passed in the url from viewcategory.php page.
{
    $did=$_GET['did'];
    $sql="SELECT * from tbl_district where districtid=$did";
    $res=$obj->executequery($sql);
    $display=mysqli_fetch_array($res);//fetching the data from the database using mysqli_fetch_array() function.
    //mysqli_fetch_array() function is used to fetch a result row as an associative array, a numeric array, or both.
    // $display is an array which contains the data of the category which is to be edited.
}
?>
<br>
<div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">DISTRICT REGISTRATION</h6>
                            <form action="editdistrictaction.php" method="post">
                                <div class="mb-3">
                                    <span class="text-danger">*</span>
                                    <label for="district" class="form-label">DISTRICT</label>
                                    <input type="text" name="district" class="form-control" id="district"
                                      value="<?php echo $display["districtname"]?>"   aria-describedby="emailHelp"required minlength="3" 
                                      maxlength="50"
                                        pattern="[A-Za-z\s]+" 
                                         title="Name must contain only letters and spaces (3-50 characters)">

                                      <input type="hidden" name="distid" value="<?php echo $display['districtid'];?>">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">SUBMIT</button>
                            </form>
                        </div>
                    </div>
<?php
include_once("footer.php");
?>