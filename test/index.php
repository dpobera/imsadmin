<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap5.0.1.min.css" />
</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <a class="navbar-brand" href="https://sourcecodester.com">Sourcecodester</a>
    </div>
  </nav>
  <div class="col-md-3"></div>
  <div class="col-md-6 well">
    <h3 class="text-primary">PHP - Passing Data To Bootstrap Modal</h3>
    <hr style="border-top:1px dotted #ccc;" />
    <div class="col-md-8">
      <table class="table table-bordered">
        <thead class="alert-info">
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Address</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require 'conn.php';
          $query = mysqli_query($conn, "SELECT * FROM `class_tb` LIMIT 10") or die(mysqli_error());
          while ($fetch = mysqli_fetch_array($query)) {
          ?>
            <tr>
              <td><?php echo $fetch['class_id'] ?></td>
              <td><?php echo $fetch['class_name'] ?></td>

              <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_modal<?php echo $fetch['mem_id'] ?>">Open Modal</button></td>
            </tr>

            <div class="modal fade" id="form_modal<?php echo $fetch['mem_id'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title">User Details</h3>
                  </div>
                  <div class="modal-body">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <label>Firstname</labe />
                          <input type="text" class="form-control" value="<?php echo $fetch['class_id'] ?>" disabled="disabled" />
                      </div>
                      <div class="form-group">
                        <label>Lastname</labe />
                          <input type="text" class="form-control" value="<?php echo $fetch['lastname'] ?>" disabled="disabled" />
                      </div>

                    </div>
                  </div>
                  <div style="clear:both;"></div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                  </div>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-4">
      <form method="POST" action="insert.php">
        <div class="form-group">
          <label>Firstname</label>
          <input type="text" class="form-control" name="firstname" required="required" />
        </div>
        <div class="form-group">
          <label>Lastname</label>
          <input type="text" class="form-control" name="lastname" required="required" />
        </div>
        <div class="form-group">
          <label>Gender</label>
          <select name="gender" class="form-control" required="required">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="form-group">
          <label>Age</label>
          <input type="number" class="form-control" name="age" required="required" />
        </div>
        <div class="form-group">
          <label>Address</label>
          <input type="text" class="form-control" name="address" required="required" />
        </div>

        <center><button class="btn btn-primary" name="insert">Insert</button></center>
      </form>
    </div>
  </div>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>