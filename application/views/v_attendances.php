  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Attendances</h1>
            <strong>Current server time: <span id="clock"></span></strong>
          </div>
        </div>

    <div class="callout callout-warning">
                  <p>To input class attendances:</p>
                  <ol>
                    <li>click on request QR code button</li>
                    <li>scan shown QR with QBAS mobile app</li>
                  </ol>
                </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Current Class</h3>
              </div>
              <div class="card-body">
                <?php if(count($current) ==0) { ?>
                <p>No class at the moment</p>
              <?php } ?>
              <div class="row">
                <div class="col-12">
                  <dl class="row">
                    <dt class="col-sm-4">Course</dt>
                    <dd class="col-sm-8"><?php echo $current[0]['course_name']; ?></dd>
                    <dt class="col-sm-4">KP</dt>
                    <dd class="col-sm-8"><?php echo $current[0]['kp']; ?></dd>
                    <dt class="col-sm-4">Class Schedule</dt>
                    <dd class="col-sm-8"><?php echo strftime("%A, %d %B %Y at %H:%M", strtotime($current[0]['start_date'])); ?> 
                    <?php 
                    $late = strtotime('now') - strtotime($current[0]['start_date']); 
                    if($late > 0) { echo '('.(floor($late/60)).' minutes late)'; } ?></dd>
                  </dl>
                </div>
                <div class="col-12">
                  <button class="btn btn-primary btnqr" data-toggle="modal" data-target="#myModal" attid="<?php echo $current[0]['id']; ?>" attnrp="<?php echo $user->nrp; ?>" attopenid="<?php echo $current[0]['course_open_id']; ?>"> <i class="nav-icon fas fa-qrcode"></i> Request QR</button>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Upcoming Class</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                  <thead>                  
                    <tr>
                      <th >Course</th>
                      <th>KP</th>
                      <th>Date</th>
                      <th>Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($upcoming) == 0 ) { ?>
                      <tr>
                        <td colspan="4" class="text-center">No class available</td>
                      </tr>
                    <?php } ?>
                    <?php foreach ($upcoming as $key => $value) { ?>
                      <tr>
                        <td><?php echo $value['course_name']; ?></td>
                        <td><?php echo $value['kp']; ?></td>
                        <td><?php echo strftime("%A, %d %B %Y", strtotime($value['start_date'])); ?></td>
                        <td><?php echo substr( $value['start_date'], -8); ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Request QR Code</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-12 text-center">
                  <img src="" id="qrimage" />
                </div>
              </div>
              <p>Instructions:</p>
              <ol>
                <li>Open QBAS mobile app</li>
                <li>Press SCAN QR button to start the camera</li>
                <li>Move smartphone camera viewfinder to target QR code</li>
                <li>If success, attendances will be recorded</li>
              </ol>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->