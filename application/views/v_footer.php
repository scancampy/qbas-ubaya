 <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url('plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo base_url('plugins/bs-custom-file-input/bs-custom-file-input.min.js'); ?>"></script>

<!-- SweetAlert2 -->
<script src="<?php echo base_url('plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>

<!-- DataTables -->
<script src="<?php echo base_url('plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('js/adminlte.min.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('js/demo.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();

  <?php if(isset($js)) { echo $js; } ?>

  <?php if(isset($alert)) { echo $alert; } ?>
});
</script>
</body>
</html>