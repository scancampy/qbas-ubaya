  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengaturan Data Herbal</h1>
          </div>
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
                <h3 class="card-title">Data Herbal</h3>
                <a href="<?php echo base_url('index.php/herbal/add'); ?>" class="btn btn-flat btn-info btn-sm float-right"><i class="fas fa-plus"></i> Tambah Data</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Latin</th>
                    <th>Nama Simplisia</th>
                    <th>Suku</th>
                    <th>Kandungan</th>
                    <th width="20%">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($herbal as $key => $value) { ?>
                      <tr>
                        <td><?php echo $value->latin; ?></td>
                        <td><?php echo $value->simplisia; ?></td>
                        <td><?php echo $value->suku; ?></td>
                        <td><?php echo $value->mikroskopis; ?></td>
                        <td class="text-center"><a href="<?php echo base_url('index.php/herbal/edit/'.$value->id); ?>" class="btn btn-sm btn-primary"> <i class="fas fa-pen"></i> Edit</a>
                        <a href="<?php echo base_url('index.php/herbal/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?');"> <i class="fas fa-trash"></i> Hapus</a>
                      </td>
                      </tr> 
                    <?php } ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nama Latin</th>
                    <th>Nama Simplisia</th>
                    <th>Suku</th>
                    <th>Kandungan</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
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
