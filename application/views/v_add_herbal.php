  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Form Tambah Data Herbal</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Kembali</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <form role="form" method="post" action="<?php echo base_url('index.php/herbal/add'); ?>" enctype="multipart/form-data">
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">SIMPLISIA</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                  <div class="card-body">
                    <div class="form-group">
                      <label for="namalatin">1. Nama Latin</label>
                      <input type="text" class="form-control" id="namalatin" name="namalatin" >
                    </div>
                    <div class="form-group">
                      <label for="namasimplisia">2. Nama Simplisia</label>
                      <input type="text" class="form-control" id="namasimplisia" name="namasimplisia" >
                    </div>
                    <div class="form-group">
                      <label for="suku">3. Suku</label>
                      <input type="text" class="form-control" id="suku" name="suku" >
                    </div>

                    <div class="form-group">
                      <label for="kandungan">4. Kandungan</label>
                      <div class="row">
                        <div class="col-md-11" id="containerkandungan">
                          <input type="text" class="form-control" id="kandungan" name="kandungan[]" >
                        </div>
                        <div class="col-md-1">
                          <button type="button" class="btn btn-primary" id="btnkandungan"><i class="fas fa-plus"></i></button>
                        </div>
                      </div>
                    </div>

                     <div class="form-group">
                      <label for="cacahan">5. Pemerian Simplisia (cacahan)</label>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-group">
                            <label>Pemerian Simplisia (cacahan)</label>
                            <div class="row">
                              <div class="col-md-11" id="containercacahan">
                                <input type="text" class="form-control" id="cacahan" name="cacahan[]" >
                              </div>
                              <div class="col-md-1">
                                <button type="button" class="btn btn-primary" id="btncacahan"><i class="fas fa-plus"></i></button>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="cacahan">Foto Simplisia</label>
                            <div class="row">
                              <div class="col-md-11" id="containerfoto">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="fotosimplisia[]">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                  </div>
                              </div>
                              <div class="col-md-1">
                                <button type="button" class="btn btn-primary" id="btnfotosimplisia"><i class="fas fa-plus"></i></button>
                              </div>
                            </div>                          
                          </div>
                          
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="cacahan">6. Pemerian Simplisia (mikroskopis)</label>
                      <div class="row">
                        <div class="col-md-11" id="containerfotomikroskopis">
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" id="exampleInputFile" name="fotomikroskopis[]">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                          <button type="button" class="btn btn-primary" id="btnfotomikroskopis"><i class="fas fa-plus"></i></button>
                        </div>
                      </div> 
                    </div>

                    <div class="form-group">
                      <label for="mikroskoppis">7. Mikroskopis (Fragmen Pengenal) </label>
                      <input type="text" class="form-control" id="mikroskoppis" name="mikroskoppis" >
                    </div>

                    <div class="form-group">
                      <label for="senyawa">8. Senyawa Identitas</label>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-group">
                            <label>Senyawa Identitas</label>                          
                            <input type="text" class="form-control" id="senyawa" name="senyawa" >
                          </div>
                          <div class="form-group">
                            <label for="cacahan">Struktur Kimia</label>
                             <div class="row">
                                <div class="col-md-11" id="containerfotostrukturkimia">
                                  <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="exampleInputFile" name="fotostrukturkimia[]">
                                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                  <button type="button" class="btn btn-primary" id="btnfotostrukturkimia"><i class="fas fa-plus"></i></button>
                                </div>
                              </div> 
                          </div>
          
                        </div>

                      </div>
                      
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-10">
                          <label for="mikroskoppis">9. Analisis Kromatografi Lapis Tipis</label>
                        </div>
                        <div class="col-md-2 text-right">
                          <button type="button" id="btnaddversion" class="btn btn-default btn-xs" ><i class="fas fa-plus"></i> Tambah Versi</button>
                        </div> 
                      </div>

                      <input type="hidden" id="jumlahversi" value="1"/>

                      <div id="kromatograficontainer">
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Versi 1</h3>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                              <label for="fasegerak1">Fase Gerak</label>
                              <input type="text" class="form-control" name="fasegerak[]" id="fasegerak" >
                            </div>                
                            <div class="form-group">
                              <label for="fasediam">Fase diam</label>
                              <input type="text" class="form-control" name="fasediam[]" id="fasediam" >
                            </div>                
                            <div class="form-group">
                              <label for="larutanuji">Larutan Uji</label>
                              <input type="text" class="form-control" id="larutanuji" name="larutanuji[]" >
                            </div>                
                            <div class="form-group">
                              <label for="larutanpembanding">Larutan Pembanding</label>
                              <input type="text" class="form-control" id="larutanpembanding" name="larutanpembanding[]" >
                            </div>     
                            <div class="form-group">
                              <label for="volumepenotolan">Volume Penotolan</label>
                              <input type="text" class="form-control" id="volumepenotolan" name="volumepenotolan[]" >
                            </div>
                            <div class="form-group">
                              <label for="deteksi">Deteksi</label>
                              <input type="text" class="form-control" id="deteksi" name="deteksi[]" >
                            </div>
                            <div class="form-group">
                              <label for="cacahan">Gambar KLT</label> 
                              <div class="col-md-12">                  
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="gambarklt[]">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                  </div>
                                </div>
                              </div>
                            </div>  
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="mikroskoppis">10. Parameter Nonspesifik</label>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-group">
                            <label for="susut_pengeringan">Susut pengeringan (%max)</label>
                            <input type="text" class="form-control" id="susut_pengeringan" name="susut_pengeringan" >
                          </div>
                          <div class="form-group">
                            <label for="abu_total">Abu total (%max)</label>
                            <input type="text" class="form-control" name="abu_total" id="abu_total" >
                          </div>
                          <div class="form-group">
                            <label for="abu_tidak_larut">Abut tidak larut asam (%max)</label>
                            <input type="text" class="form-control" id="abu_tidak_larut" name="abu_tidak_larut" >
                          </div>
                          <div class="form-group">
                            <label for="sari_larut_air">Sari larut air (%min)</label>
                            <input type="text" class="form-control" id="sari_larut_air" name="sari_larut_air" >
                          </div>
                          <div class="form-group">
                            <label for="sari_laut_etanol">Sari larut etanol (%min)</label>
                            <input type="text" class="form-control" id="sari_laut_etanol" name="sari_laut_etanol" >
                          </div>
                        </div>
                      </div>
                    </div>

                     <div class="form-group">
                      <label for="kandungan">11. Kandungan Kimia Simplisia</label>
                      <div class="row">
                        <div class="col-md-11" id="containerkandungankimia">
                          <input type="text" class="form-control" id="kandungan_kimia" name="kandungan_kimia[]" >
                        </div>
                        <div class="col-md-1">
                          <button type="button" class="btn btn-primary" id="btnkandungankimia"><i class="fas fa-plus"></i></button>
                        </div>
                      </div>
                    </div>

                  </div>
              </div>
              <!-- /.card -->

          
              <!-- Input addon -->
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Ekstrak</h3>
                </div>
                <div class="card-body">
                  
                    <div class="form-group">
                      <label for="bentuk">1. Bentuk</label>
                      <input type="text" class="form-control" id="bentuk" name="bentuk" >
                    </div>

                    <div class="form-group">
                      <label for="nama_ekstrak">2. Nama Ekstrak</label>
                      <input type="text" class="form-control" id="nama_ekstrak" name="nama_ekstrak" >
                    </div>

                    <div class="form-group">
                      <label for="rendemen">3. Rendemen (% min)</label>
                      <input type="text" class="form-control" id="rendemen" name="rendemen">
                    </div>

                    <div class="form-group">
                      <label>4. Identitas Ekstrak</label>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-group">
                            <label for="pemerian">Pemerian</label>
                            <input type="text" class="form-control" id="pemerian" name="pemerian" >
                          </div>

                          <div class="form-group">
                            <label for="senyawa_identitas">Senyawa Identitas</label>
                            <input type="text" class="form-control" id="senyawa_identitas" name="senyawa_identitas" >
                          </div>

                          <div class="form-group">
                            <label for="cacahan">Struktur Kimia</label>
                             <div class="row">
                                <div class="col-md-11" id="containerfotostrukturkimiaekstrak">
                                  <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="exampleInputFile" name="fotostrukturkimiaekstrak[]">
                                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                  <button type="button" class="btn btn-primary" id="btnfotostrukturkimiaekstrak"><i class="fas fa-plus"></i></button>
                                </div>
                              </div> 
                          </div>

                          <div class="form-group">
                            <label for="kadar_air">Kadar Air (% max)</label>
                            <input type="text" class="form-control" id="kadar_air" name="kadar_air" >
                          </div>


                          <div class="form-group">
                            <label for="abu_total_ekstrak">Abu total (%max)</label>
                            <input type="text" class="form-control" id="abu_total_ekstrak" name="abu_total_ekstrak" >
                          </div>


                          <div class="form-group">
                            <label for="abu_tidak_larut_asam">Abut tidak larut asam (%max)</label>
                            <input type="text" class="form-control" id="abu_tidak_larut_asam" name="abu_tidak_larut_asam" >
                          </div>

                        </div>
                      </div>
                    </div>
                    
                     <div class="form-group">
                      <label for="kandungan_kimia_ekstrak">5. Kandungan Kimia Ekstrak</label>
                      <div class="row">
                        <div class="col-md-11" id="containerkandungankimiaekstrak">
                          <input type="text" class="form-control" id="kandungan_kimia_ekstrak" name="kandungan_kimia_ekstrak[]" >
                        </div>
                        <div class="col-md-1">
                          <button type="button" class="btn btn-primary" id="btnkandungankimiaekstrak"><i class="fas fa-plus"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right" value="submit" name="btnsubmit">SUBMIT</button>
                  </div>
                  <!-- /.card-footer -->
                
              </div>
              <!-- /.card -->

            </div>
            <!--/.col (left) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
    </form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
