<?php
  include('header.php');
  ?>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">District Registration</h6>
                            <form action="districtaction.php" method="POST">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">District</label>
                                    <input type="text" name="districtname" class="form-control" id="districtid"
                                        aria-describedby="emailHelp">
                                  
                                </div>

                                
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div> 

                    <?php
  include('footer.php');
  ?>