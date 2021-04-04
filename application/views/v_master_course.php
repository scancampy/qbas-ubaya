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
                <h3 class="card-title p-3">Manage Course Data</h3>
                <div class="ml-auto p-3">
                  <a href="#" data-toggle="modal" data-target="#modalAddCourse" id="btnaddcourse" class="btn btn-primary btn-xs"><i class="nav-icon fas fa-plus"></i> Add New Course</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tablearticle" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Course Alias</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>

                   <?php 
                   foreach ($course as $key => $value) { ?>
                    <tr>
                      <td><?php echo $key+1; ?></td>
                      <td><?php echo $value->course_id; ?></td>
                      <td><?php echo $value->course_name; ?></td>
                      <td><?php echo $value->course_short_name; ?></td>
                      <td class="d-flex justify-content-end">
                        <a href="#" courseid="<?php echo $value->course_id; ?>" class="btn btn-xs btn-primary mr-1 courseedit"><i class="nav-icon fas fa-edit"></i> Edit</a> 
                        <a href="<?php echo base_url('admin/delcourse/'.$value->course_id); ?>" onclick="return confirm('Are you sure want to delete <?php echo $value->course_name; ?>?');" class="btn btn-xs btn-danger m-0"><i class="nav-icon fas fa-trash"></i> Delete</a></td>
                    </tr>
                   <?php }
                   ?>
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>No</th>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Course Alias</th>
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

  <div class="modal fade " id="modalAddCourse" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url('admin/semester'); ?>" method="post" >
        <div class="modal-header">
          <h5 class="modal-title">Add Semester</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" id="hiddenid" name="hiddenid"/>
            <label for="semester_name">Semester Name</label>
            <input type="text" class="form-control" id="semester_name" name="semester_name" required placeholder="ex. GASAL 2020/2021">
          </div>

          <div class="form-group">
            <label for="article_type">Semester Status</label>
            <div class="form-check">
              <input class="form-check-input" id="active_semester" type="radio" name="is_active" value="1" checked>
              <label class="form-check-label">Active</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" id="inactive_semester" type="radio" name="is_active" value="0" >
              <label class="form-check-label">Inactive</label>
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