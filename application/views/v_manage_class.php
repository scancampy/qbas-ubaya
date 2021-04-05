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
                <h3 class="card-title p-3">Manage Class</h3>
                <div class="ml-auto p-3">
                  <form method="get" id="formsemester" action="<?php echo base_url('admin/manageclass'); ?>">
                     <div class="form-group">
                      <select class="form-control" id="selectsemester" name="sem">
                        <option value="-">Choose Semester</option>
                        <?php foreach ($semester as $key => $value) { ?>
                          <option value="<?php echo $value->id; ?>" <?php if($this->input->get('sem') == $value->id) { echo 'selected'; } ?>><?php echo $value->semester_name; ?><?php if($value->is_active==1) { echo ' (active)'; } ?></option>
                        <?php } ?>
                      </select>
                     </div>
                  </form>
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
                    <th>KP</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>

                   <?php 
                   foreach ($course_open as $key => $value) { ?>
                    <tr>
                      <td><?php echo $key+1; ?></td>
                      <td><?php echo $value->course_id; ?></td>
                      <td><?php echo $value->course_name; ?></td>
                      <td><?php echo $value->KP; ?></td>
                      <td class="d-flex justify-content-end">
                        <a href="#" courseopenid="<?php echo $value->id; ?>" class="btn btn-xs btn-primary mr-1 lectureredit"><i class="nav-icon fas fa-chalkboard-teacher"></i> Lecturer</a>

                        <a href="<?php echo base_url('admin/enroll/'.$value->id); ?>" class="btn btn-xs btn-primary mr-1 "><i class="nav-icon fas fa-user-graduate"></i> Enroll</a>

                        <a href="<?php echo base_url('admin/schedule/'.$value->id); ?>" class="btn btn-xs btn-primary mr-1"><i class="nav-icon fas fa-calendar-alt"></i> Schedule</a>                        

                        <a href="<?php echo base_url('admin/delcourseopen/'.$value->id); ?>" onclick="return confirm('Are you sure want to delete <?php echo $value->course_id.' KP '.$value->KP; ?>?');" class="btn btn-xs btn-danger m-0"><i class="nav-icon fas fa-trash"></i> Delete</a></td>
                    </tr>
                   <?php }
                   ?>
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>No</th>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>KP</th>
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

  <div class="modal fade " id="modalAddLecturer" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url('admin/lecturer'); ?>" method="post" >
        <div class="modal-header">
          <h5 class="modal-title">Add Lecturer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" id="hiddenid" name="hiddenid"/>
            <div class="col-md-2">
              <label for="npk">NPK</label>
              <input type="text" maxlength="15" class="form-control" id="npk" name="npk" required placeholder="">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <label for="full_name">Lecturer Name</label>
              <input type="text" class="form-control" id="full_name" name="full_name" required placeholder="">
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