  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><a href="<?php echo base_url('admin/manageclass?sem='.$semester_id); ?>"><i class="fa fa-arrow-left"></i></a> <?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/manageclass?sem='.$semester_id); ?>">Manage Class</a></li>
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
                <h3 class="card-title p-3">Enroll</h3>
                 <div class="ml-auto p-3">
                  <a href="#" data-toggle="modal" data-target="#modalAddStudent" id="btnaddstudent" class="btn btn-primary btn-xs"><i class="nav-icon fas fa-plus"></i> Add Student</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12" style="display: flex;">
                    <div class="col-md-2">Course ID</div>
                    <div class="col-md-9"><?php echo $course[0]->course_id; ?></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="display: flex; margin-bottom: 20px; margin-top: 20px;">
                    <div class="col-md-2">Course Name</div>
                    <div class="col-md-9"><?php echo $course[0]->course_name; ?></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="display: flex; margin-bottom: 20px;">
                    <div class="col-md-2">KP</div>
                    <div class="col-md-9"><?php echo $course[0]->KP; ?></div>
                  </div>
                </div>

                <div class="col-md-12">
                  <table id="tablearticle" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>NRP</th>
                      <th>Full Name</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                     <?php 
                     if(isset($student)) { 
                     foreach ($student as $key => $value) { ?>
                      <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->nrp; ?></td>
                        <td><?php echo $value->full_name; ?></td>
                        <td class="d-flex justify-content-end">
                          <a href="<?php echo base_url('admin/removestudent/'.$course_open_id.'/'.$value->nrp.'/'.$semester_id); ?>" onclick="return confirm('Are you sure want to remove <?php echo $value->nrp; ?>?');" class="btn btn-xs btn-danger m-0"><i class="nav-icon fas fa-trash"></i> Remove</a></td>
                      </tr>
                     <?php } }
                     ?>
                    </tbody>
                    <tfoot>
                     <tr>
                      <th>No</th>
                      <th>Course ID</th>
                      <th>Course Name</th>
                      <th>Actions</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url('admin/enroll/'.$course_open_id.'/'.$semester_id); ?>" method="post" >
        <div class="modal-header">
          <h5 class="modal-title">Add Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">

                  <label for="course_name_info">Student</label>
              <div class="form-group">

                   <select style="width: 100%;" class="form-control select2" id="choosestudent" name="choosestudent" >
                    <?php foreach ($available_student as $key => $value) { ?>
                      <option value="<?php echo $value->nrp; ?>"><?php echo $value->full_name; ?></option>
                    <?php } ?>
                  </select>

              </div>
            </div>
         
        </div>
        <div class="modal-footer">
          <button type="submit" value="submit" id="btnSubmitStudent" name="btnSubmitStudent" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div> 

<div class="modal fade " id="modalAddClass" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url('admin/manageclass?sem='.$this->input->get('sem')); ?>" method="post" >
        <div class="modal-header">
          <h5 class="modal-title">Add Class</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="col-md-12">
              <label for="course_id">Course ID</label>
              <select class="form-control" name="course_id" required>
                <?php foreach ($course as $key => $value) { ?>
                  <option value="<?php echo $value->course_id; ?>"><?php echo $value->course_id.' - '.$value->course_name; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-2">
              <label for="KP">KP</label>
              <input type="text" class="form-control" id="KP" name="KP" required >
            </div>
          </div>

          
        </div>
        <div class="modal-footer">
          <button type="submit" value="submit" name="btnSubmitClass" class="btn btn-primary">Submit</button>
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