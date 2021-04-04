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
<?php if(count($current) > 0) { ?>
    <div class="callout callout-warning">
                  <p>To record your class attendances:</p>
                  <?php if($current[0]['methods'] == 'simple') { ?>
                  <ol>
                    <li>open QBAS app</li>
                    <li>login with your credentials</li>
                    <li>tick "checkbox" and then press "attend button"</li>
                  </ol>
                <?php } else if($current[0]['methods'] == 'auto') { ?>
                  <ol>
                    <li>click on request QR code button below</li>
                    <li>open QBAS app</li>
                    <li>login with your credentials</li>                    
                    <li>scan shown QR from this website with QBAS mobile app</li>
                  </ol>
                <?php } else if($current[0]['methods'] == 'authenticator') { ?>
                  <ol>
                    <li>open QBAS app</li>
                    <li>login with your credentials</li>
                    <li>click on request code button</li>
                    <li>enter shown codes into class code input below</li>
                    <li>click submit button to record your attendances</li>
                  </ol>
                <?php } else { ?>
                  <ol>
                    <li>click on show QR button</li>
                    <li>shows the QR code to student</li>
                    <li>instruct student to scan shown QR with QBAS app</li>
                  </ol>
                <?php } ?>
                </div>
      </div><!-- /.container-fluid -->
    <?php  } ?>
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Class in Progress</h3>
              </div>
              <div class="card-body">
                <?php if(count($current) ==0) { ?>
                <p>No class at the moment</p>
              <?php } else { ?>
              <div class="row">
                <form method="post" action="<?php echo base_url('dashboard'); ?>" >
                <div class="col-12">
                  <dl class="row">
                    <dt class="col-sm-4">Course</dt>
                    <dd class="col-sm-8"><?php echo $current[0]['course_name']; ?></dd>
                    <dt class="col-sm-4">KP</dt>
                    <dd class="col-sm-8"><?php echo $current[0]['kp']; ?></dd>
                    <dt class="col-sm-4">Class Schedule</dt>

                 
                    <dd class="col-sm-8"><?php echo strftime("%A, %d %B %Y at %H:%M", strtotime($current[0]['start_date'])); ?> 
                   </dd>
                   <dt class="col-sm-4">Attendances</dt>
                   <dd class="col-sm-8">
<?php if(isset($absence)) { 
  $persen = number_format((count($absence)/count($studentlist))*100, 2,',','.');
  echo count($absence).'/'.count($studentlist).' ('.$persen.'%)'; } ?>
                   </dd>
                  </dl>
                </div>
                <div class="col-12">
                  <?php if($current[0]['methods'] == 'manual') { ?>
                  <button class="btn btn-primary btnqr" data-toggle="modal" data-target="#myModal" attid="<?php echo $current[0]['id']; ?>" type="button"> <i class="nav-icon fas fa-qrcode"></i> Show QR</button>
                <?php }  ?>
                </div>
              </form>
              </div>
            <?php } ?>
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
                      <th>Abs. Methods</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(count($upcoming) == 0 ) { ?>
                      <tr>
                        <td colspan="5" class="text-center">No class available</td>
                      </tr>
                    <?php } ?>
                    <?php foreach ($upcoming as $key => $value) { ?>
                      <tr>
                        <td><?php echo $value['course_name']; ?></td>
                        <td><?php echo $value['kp']; ?></td>
                        <td><?php echo strftime("%A, %d %B %Y", strtotime($value['start_date'])); ?></td>
                        <td><?php echo substr( $value['start_date'], -8); ?></td>
                        <td><span class="badge badge-primary"><?php echo $value['methods']; ?></span></td>
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
              <h4 class="modal-title">Class QR Code</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-12 text-center">
                  <img src="" id="qrimage" class="col-6" />
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