  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Home</a></li>
               <li class="breadcrumb-item ">Master</li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Manage Student Data</h3>
                <div class="ml-auto p-3">
                  <a href="#" data-toggle="modal" data-target="#modalAddStudent" id="btnaddstudent" class="btn btn-primary btn-xs"><i class="nav-icon fas fa-plus"></i> Add New Student</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tablearticle" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>NRP</th>
                    <th>Student Name</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>

                   <?php 
                   foreach ($student as $key => $value) { ?>
                    <tr>
                      <td><?php echo $key+1; ?></td>
                      <td><?php echo $value->nrp; ?></td>
                      <td><?php echo $value->full_name; ?></td>
                      <td class="d-flex justify-content-end">
                        <a href="#" studentid="<?php echo $value->nrp; ?>" class="btn btn-xs btn-primary mr-1 studentedit"><i class="nav-icon fas fa-edit"></i> Edit</a> 
                        <a href="<?php echo base_url('admin/delstudent/'.$value->nrp); ?>" onclick="return confirm('Are you sure want to delete <?php echo $value->full_name; ?>?');" class="btn btn-xs btn-danger m-0"><i class="nav-icon fas fa-trash"></i> Delete</a></td>
                    </tr>
                   <?php }
                   ?>
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>No</th>
                    <th>NRP</th>
                    <th>Student Name</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <div class="modal fade " id="modalAddStudent" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url('admin/student'); ?>" method="post" >
        <div class="modal-header">
          <h5 class="modal-title">Add Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" id="hiddenid" name="hiddenid"/>
            <div class="col-md-2">
              <label for="nrp">NRP</label>
              <input type="text" maxlength="15" class="form-control" id="nrp" name="nrp" required placeholder="">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <label for="student_name">Student Name</label>
              <input type="text" class="form-control" id="student_name" name="student_name" required placeholder="">
            </div>
          </div>

          
        </div>
        <div class="modal-footer">
          <button type="submit" value="submit" name="btnSubmit" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div> 

<style type="text/css">
  iframe {
    width: 100% !important;
    height: 100% !important;
  }
</style>