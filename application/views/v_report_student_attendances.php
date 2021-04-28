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
                <h3 class="card-title p-3"><?php echo $title; ?></h3>  

                <div class="ml-auto p-3">
                  <form method="get" id="formreport" action="<?php echo base_url('report/student'); ?>">
                    <div class="form-group " >
                      <select class="form-control" id="selectcourse" name="selectcourse">
                        <option value="-">All Course</option>
                        <?php foreach ($mycourse as $key => $value) { ?>
                          <option <?php if($this->input->get('selectcourse') == $value->course_id) { echo 'selected'; } ?> value="<?php echo $value->course_id; ?>" ><?php echo $value->course_short_name.' '.$value->KP; ?></option>
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
                      <th>Course</th>
                      <th>Schedule</th>
                      <th>KP</th>
                      <th>Att. Status</th>
                      <th>Log time</th>
                    </tr>
                  </thead>
                  <tbody>

                   <?php 
                   foreach ($myatt as $key => $value) { ?>
                    <tr>
                      <td><?php echo $key+1; ?></td>
                      <td><?php echo $value->course_short_name; ?></td>
                      <td><?php echo strftime("%d %b %Y %H:%M", strtotime($value->start_date));   ?></td>
                      <td><?php echo $value->KP; ?></td>
                      <td><?php if($value->is_absence == 1 ) { ?><i class="fas fa-check"></i><?php } else { ?>
                        -
                      <?php } ?></td>
                      <td><?php if($value->is_absence == 1 ) {  echo strftime("%d %b %Y %H:%M", strtotime($value->absence_date));  } ?></td>
                    </tr>
                   <?php } 
                   ?>
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>No</th>
                      <th>Course</th>
                      <th>Schedule</th>
                      <th>KP</th>
                      <th>Att. Status</th>
                      <th>Log time</th>
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
      <form action="<?php echo base_url('admin/course'); ?>" method="post" >
        <div class="modal-header">
          <h5 class="modal-title">Add Course</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" id="hiddenid" name="hiddenid"/>
            <div class="col-md-2">
              <label for="course_id">Course ID</label>
              <input type="text" maxlength="15" class="form-control" id="course_id" name="course_id" required placeholder="">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <label for="course_name">Course Name</label>
              <input type="text" class="form-control" id="course_name" name="course_name" required placeholder="">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-3">
              <label for="course_short_name">Course Short Name</label>
              <input type="text" maxlength="30" class="form-control" id="course_short_name" name="course_short_name" required placeholder="">
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