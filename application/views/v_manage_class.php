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
                <?php if(isset($course_open)) { ?>
                <div class="mb-3 col-md-12 d-flex flex-row-reverse">
                  <a href="#" data-toggle="modal" data-target="#modalAddClass" id="btnaddcourse" class="btn btn-primary "><i class="nav-icon fas fa-plus"></i> Add Class</a>
                </div>
              <?php } ?>
                <div class="col-md-12">
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
                     if(isset($course_open)) { 
                     foreach ($course_open as $key => $value) { ?>
                      <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->course_id; ?></td>
                        <td><?php echo $value->course_name; ?></td>
                        <td><?php echo $value->KP; ?></td>
                        <td class="d-flex justify-content-end">
                          <a href="#" data-toggle="modal" data-target="#modalAddLecturer" courseopenid="<?php echo $value->id; ?>" class="btn btn-xs btn-primary mr-1 lectureredit"><i class="nav-icon fas fa-chalkboard-teacher"></i> Lecturer</a>

                          <a href="<?php echo base_url('admin/enroll/'.$value->id.'/'.$this->input->get('sem')); ?>" class="btn btn-xs btn-primary mr-1 "><i class="nav-icon fas fa-user-graduate"></i> Enroll</a>

                          <a href="<?php echo base_url('admin/schedule/'.$value->id.'/'.$this->input->get('sem')); ?>" class="btn btn-xs btn-primary mr-1"><i class="nav-icon fas fa-calendar-alt"></i> Schedule</a>                        

                          <a href="<?php echo base_url('admin/delcourseopen/'.$this->input->get('sem').'/'.$value->id); ?>" onclick="return confirm('Are you sure want to delete <?php echo $value->course_id.' KP '.$value->KP; ?>?');" class="btn btn-xs btn-danger m-0"><i class="nav-icon fas fa-trash"></i> Delete</a></td>
                      </tr>
                     <?php } }
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
      <form action="<?php echo base_url('admin/manageclass?sem='.$this->input->get('sem')); ?>" method="post" >
        <div class="modal-header">
          <h5 class="modal-title">Add Lecturer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <input type="hidden" id="course_open_hidden_id" name="course_open_hidden_id"/>
                <div class="col-md-12">
                  <label for="course_id_info">Course ID</label>
                  <input type="text" maxlength="15" class="form-control" id="course_id_info" name="course_id_info" disabled placeholder="">
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <div class="col-md-12">
                  <label for="kp_info">KP</label>
                  <input type="text" class="form-control" id="kp_info" name="kp_info"  disabled>
                </div>
              </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                <div class="col-md-12">
                  <label for="semester_info">Semester</label>
                  <input type="text" value="<?php echo $current_semester[0]->semester_name; ?>" maxlength="15" class="form-control" id="semester_info" name="semester_info" disabled placeholder="">
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <label for="course_name_info">Course Name</label>
              <input type="text" class="form-control" id="course_name_info" name="course_name_info"  disabled>
            </div>
          </div>
          <hr/>

          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="course_name_info">Lecturer</label>
                      <select  class="form-control" id="chooselecturer" name="chooselecturer" >
                        <?php foreach ($lecturer as $key => $value) { ?>
                          <option value="<?php echo $value->npk; ?>"><?php echo $value->full_name; ?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="btnaddlecturer">&nbsp;</label>
                    <input type="button" class="btn btn-primary form-control" id="btnaddlecturer" value="add" />
                  </div>
                </div>
              </div>
               
            </div>
            <div class="col-md-12">
              <table id="tablelecturer" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>NPK</th>
                        <th>Lecturer Name</th>
                        <th>Remove</th>
                      </tr>
                    </thead>
                    <tbody id="containerlecturer">
                      <tr>
                        <td colspan="4">No data</td>
                      </tr>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" value="submit" id="btnSubmitLecturer" name="btnSubmitLecturer" class="btn btn-primary">Save changes</button>
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