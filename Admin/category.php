<?php
  include_once('header.php');
  ?>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Category Registration</h6>
                            <form action="categoryaction.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">category</label>
                                    <input type="text" name="category" class="form-control" id="categoryid"
                                        aria-describedby="emailHelp">

                                        
                                     <label for="exampleInputEmail1" class="form-label">image</label>
                                    <input type="file" name="image" class="form-control" id="categoryid"
                                        aria-describedby="emailHelp">
                                  
                                </div>

                                
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                
                            </form>
                        </div>
                    </div> 

                    <?php
  include_once('footer.php');
  ?>