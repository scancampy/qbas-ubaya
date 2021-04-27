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
                <h3 class="card-title p-3">Generate Absence Log</h3>
                <div class="ml-auto p-3">
                  <form method="post" action="<?php echo base_url('admin/generateabsence') ?>">
                  <button type="submit" name="btngenerate" value="submit"  class="btn btn-primary "><i class="nav-icon fas fa-clipboard-check"></i> Generate Absence</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tablearticle" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="10%">No</th>
                    <th width="20%">Log Date</th>
                    <th>Logs</th>
                  </tr>
                  </thead>
                  <tbody>

                   <?php 
                   foreach ($logs as $key => $value) { ?>
                    <tr>
                      <td><?php echo $key+1; ?></td>
                      <td><?php echo strftime("%d-%m-%Y %H:%M:%S", strtotime($value->generate_date)); ?></td>
                      <td>
 <?php echo $value->logs; ?></td>
                    </tr>
                   <?php }
                   ?>
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>No</th>
                    <th>Log Date</th>
                    <th>Logs</th>
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


<style type="text/css">
  iframe {
    width: 100% !important;
    height: 100% !important;
  }
</style>