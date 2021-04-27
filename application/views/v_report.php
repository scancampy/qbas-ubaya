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
                  <form method="get" id="formreport" action="<?php echo base_url('report'); ?>">
                    <div class="form-group " >
                      <select class="form-control" id="selectcourse" name="selectcourse">
                        <option value="-">Choose Course</option>
                        <?php foreach ($current as $key => $value) { ?>
                          <option <?php if($this->input->get('selectcourse') == $value->course_open_id) { echo 'selected'; } ?> value="<?php echo $value->course_open_id; ?>" ><?php echo $value->course_short_name.' '.$value->KP; ?></option>
                        <?php } ?>
                      </select>
                     </div>       
                   </form>
                </div>      
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php 
                 if(isset($skedul) == 0) { ?>
                    <div class="alert alert-info" role="alert">
  Choose Course First
</div>
                <?php } ?>
             
                <?php if($this->input->get('selectcourse') != null) {
                  if($this->input->get('selectcourse') != '-') {
                  ?>
                <div class="row">
                  <div class="col-md-12" style="display: flex;">
                    <div class="col-md-2">Course ID</div>
                    <div class="col-md-9"><?php echo $class->course_id; ?></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="display: flex; margin-bottom: 20px; margin-top: 20px;">
                    <div class="col-md-2">Course Name</div>
                    <div class="col-md-9"><?php echo $class->course_name; ?></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="display: flex; margin-bottom: 20px;">
                    <div class="col-md-2">KP</div>
                    <div class="col-md-9"><?php echo $class->KP; ?></div>
                  </div>
                </div>
                
                <table id="tablearticle" class="table table-bordered table-striped">
                  <thead>
                   <tr>
                      <th>No</th>
                      <th>Date & Time</th>
                      <th>Methods</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                   <?php 

                   foreach ($skedul as $key => $value) { ?>
                    <tr>
                      <td><?php echo $key+1; ?></td>
                      <td><?php echo strftime("%d %b %Y %H:%M", strtotime($value->start_date)); ?></td>
                      <td>
                        <?php if($value->methods == 'simple') { ?>
                          <span class="badge badge-primary">Simple</span>
                        <?php } else if($value->methods == 'auto') { ?>
                          <span class="badge badge-success">Auto</span>
                        <?php }  else if($value->methods == 'manual') { ?>
                          <span class="badge badge-info">Manual</span>
                        <?php } else if($value->methods == 'authenticator') { ?>
                          <span class="badge badge-warning">Authenticator</span>
                        <?php } ?>
                        </td>
                      <td class="d-flex justify-content-end">
                        <a href="<?php echo base_url('report/attendances/'.$this->input->get('selectcourse').'/'.$value->id); ?>" scheduleid="<?php echo $value->id; ?>" class="btn btn-xs btn-primary mr-1 viewreport"><i class="nav-icon fas fa-book"></i> View Attd.</a> </td>
                    </tr>
                   <?php } 
                   ?>
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>No</th>
                    <th>Date & Time</th>
                    <th>Methods</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>

                 <?php } else { ?>
<div class="alert alert-info" role="alert">
  Choose course first.
</div>
                 <?php } } ?>
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