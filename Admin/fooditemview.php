<?php
  include('header.php');
  include("../dboperation.php");
  $obj=new dboperation();
  $s="select * from tbl_fooditem";
  $res=$obj->executequery ($s);  
  ?>
<div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">FOOD ITEMS</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Food Name</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Food Price</th>

                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                      while($r=mysqli_fetch_array($res))
                                      {
                                      ?>
                                    <tr>
                                      <td> <?php echo$r["foodname"];?></td>
                                      <td>
                                                    <img src="../uploads/<?php echo $r['image']; ?> "style="width:150px;height:150px;" />         
                                                </td>
                                      

                                      <td><a href="fooditemdelete.php?did=<?php echo$r["foodid"];?>">Delete</a href></td>

                                      <td><a href="fooditemedit.php?did=<?php echo$r["foodid"];?>">Edit</a href></td>
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