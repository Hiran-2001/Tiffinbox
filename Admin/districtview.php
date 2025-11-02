<?php
  include('header.php');
  include("../dboperation.php");
  $obj=new dboperation();
  $s="select * from tbl_district";
  $res=$obj->executequery($s);  
  ?>
<div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">District</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">District Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                      while($r=mysqli_fetch_array($res))
                                      {
                                      ?>
                                    <tr>
                                      <td> <?php echo$r["districtname"];?></td>  
                                      <td><a href="deletedistrict.php?did=<?php echo$r["districtid"];?>">Delete</a href></td>
                                      <td><a href="editdistrict.php?did=<?php echo$r["districtid"];?>">Edit</a href></td>
                                    </tr>
                                    <?php
                                      }
                                      ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                     <?php
  include('footer.php');
  ?>