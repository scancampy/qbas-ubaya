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

    <form role="form" method="post" action="<?php echo base_url('index.php/herbal/edit/'.$id); ?>" enctype="multipart/form-data">
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
                      <input type="text" class="form-control" id="namalatin" name="namalatin" value="<?php echo $herbal->latin; ?>" >
                    </div>
                    <div class="form-group">
                      <label for="namasimplisia">2. Nama Simplisia</label>
                      <input type="text" class="form-control" id="namasimplisia" value="<?php echo $herbal->simplisia; ?>" name="namasimplisia" >
                    </div>
                    <div class="form-group">
                      <label for="suku">3. Suku</label>
                      <input type="text" class="form-control" id="suku" value="<?php echo $herbal->suku; ?>" name="suku" >
                    </div>

                    <div class="form-group">
                      <label for="kandungan">4. Kandungan</label>
                      <div class="row">
                        <div class="col-md-11" id="containerkandungan">
                          <?php
                          if(count($kandungan) > 0 ) {
                              foreach ($kandungan as $key => $value) { ?>
                                <div class="input-group" <?php if($key> 0) { echo 'style="margin-top:5px;"'; } ?>>
                                   <input type="text" class="form-control" id="kandungan"  name="kandungan[]" value="<?php echo $value->kandungan; ?>" >
                                   <input type="hidden" value="<?php echo $value->id; ?>" name="hiddenkandungan[]">
                                   <div class="input-group-append">
                                      <button type="button" class="btn btndelkandungan btn-xs btn-danger btn-flat" style="width: 50px;" kandunganid="<?php echo $value->id; ?>"> <i class="fas fa-trash"></i> </button>
                                   </div>
                                 </div>
                              <?php } 
                            } else { ?>
                                  <input type="text" class="form-control" id="kandungan" name="kandungan[]" >
                                  <input type="hidden"  name="hiddenkandungan[]">
                          <?php  }
                          ?>
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
                                <?php
                          if(count($cacahan) > 0 ) {
                              foreach ($cacahan as $key => $value) { ?>
                                <div class="input-group" <?php if($key> 0) { echo 'style="margin-top:5px;"'; } ?>>
                                 <input type="text" class="form-control" id="cacahan"  name="cacahan[]" value="<?php echo $value->cacahan; ?>" >
                                 <input type="hidden" value="<?php echo $value->id; ?>" name="hiddencacahan[]">
                                 <div class="input-group-append">
                                      <button type="button" class="btn btndelcacahan btn-xs btn-danger btn-flat" style="width: 50px;" cacahanid="<?php echo $value->id; ?>"> <i class="fas fa-trash"></i> </button>
                                   </div>
                                 </div>
                              <?php } 
                            } else { ?>
                                  <input type="text" class="form-control" id="cacahan" name="cacahan[]" >
                                  <input type="hidden" value="<?php echo $value->id; ?>" name="hiddencacahan[]">
                          <?php  }
                          ?>
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
                            <?php if(count($imagesimplisia) > 0) { ?>
                            <div class="row" style="margin-top: 5px;">
                              <?php foreach ($imagesimplisia as $key => $value) { ?>
                                <div class="col-md-3">
                                  <a href="<?php echo base_url('images/'.$value->filename); ?>" target="_blank">
                                    <img class="img-fluid mb-3 img-thumbnail" src="<?php echo base_url('images/'.$value->filename); ?>" alt="Photo" />
                                  </a>
                                  <button style="top: 15px; left: 15px; position: absolute;" class="btn btn-danger btn-xs float-right btndelimagesimplisia" idimagesimplisia="<?php echo $value->id; ?>" type="button"><i class="fas fa-trash"></i></button>
                                </div>
                              <?php } ?>
                            </div>                          
                          <?php } ?>
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
                      <?php if(count($imagepemerian) > 0) { ?>
                            <div class="row" style="margin-top: 5px;">
                              <?php foreach ($imagepemerian as $key => $value) { ?>
                                <div class="col-md-3">
                                  <a href="<?php echo base_url('images/'.$value->filename); ?>" target="_blank">
                                    <img class="img-fluid mb-3 img-thumbnail" src="<?php echo base_url('images/'.$value->filename); ?>" alt="Photo" />
                                  </a>
                                  <button style="top: 15px; left: 15px; position: absolute;" class="btn btn-danger btn-xs float-right btndelimagepemerian" idimagepemerian="<?php echo $value->id; ?>" type="button"><i class="fas fa-trash"></i></button>
                                </div>
                              <?php } ?>
                            </div>                          
                          <?php } ?>
                    </div>

                    <div class="form-group">
                      <label for="mikroskoppis">7. Mikroskopis (Fragmen Pengenal) </label>
                      <input type="text" class="form-control" id="mikroskoppis" value="<?php echo $herbal->mikroskopis; ?>" name="mikroskoppis" >
                    </div>

                    <div class="form-group">
                      <label for="senyawa">8. Senyawa Identitas</label>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-group">
                            <label>Senyawa Identitas</label>                          
                            <input type="text" class="form-control" id="senyawa" name="senyawa" value="<?php echo $herbal->senyawa; ?>" >
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

                      <?php if(count($imagestrukturkimia) > 0) { ?>
                            <div class="row" style="margin-top: 5px;">
                              <?php foreach ($imagestrukturkimia as $key => $value) { ?>
                                <div class="col-md-3">
                                  <a href="<?php echo base_url('images/'.$value->filename); ?>" target="_blank">
                                    <img class="img-fluid mb-3 img-thumbnail" src="<?php echo base_url('images/'.$value->filename); ?>" alt="Photo" />
                                  </a>
                                  <button style="top: 15px; left: 15px; position: absolute;" class="btn btn-danger btn-xs float-right btndelimagestrukturkimia" idimagestrukturkimia="<?php echo $value->id; ?>" type="button"><i class="fas fa-trash"></i></button>
                                </div>
                              <?php } ?>
                            </div>                          
                          <?php } ?> 
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

                      <?php 
                      if(count($kromatografi) >0 ) { ?>
                      <input type="hidden" id="jumlahversi" value="<?php echo count($kromatografi); ?>"/>
                    <?php } else { ?>
                      <input type="hidden" id="jumlahversi" value="1"/>
                    <?php } ?>

                      <div id="kromatograficontainer">
                        <?php 
                      if(count($kromatografi) >0 ) { ?>                      
                        <?php foreach ($kromatografi as $key => $value) { ?>
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Versi <?php echo $key+1; ?></h3>
                            <input type="hidden" name="hiddenkromatografi[]" value="<?php echo $value->id; ?>"/>
                            <button class="btn btn-xs btn-danger float-right btndelkromatografi" kromatografiid="<?php echo $value->id; ?>" type="button"><i class="fas fa-trash"></i> Hapus Versi</button>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                              <label for="fasegerak1">Fase Gerak</label>
                              <input type="text" class="form-control" name="fasegerak[]" id="fasegerak" value="<?php echo $value->fasegerak; ?>" >
                            </div>                
                            <div class="form-group">
                              <label for="fasediam">Fase diam</label>
                              <input type="text" class="form-control" name="fasediam[]" id="fasediam" value="<?php echo $value->fasediam; ?>">
                            </div>                
                            <div class="form-group">
                              <label for="larutanuji">Larutan Uji</label>
                              <input type="text" class="form-control" id="larutanuji" name="larutanuji[]" value="<?php echo $value->larutanuji; ?>" >
                            </div>                
                            <div class="form-group">
                              <label for="larutanpembanding">Larutan Pembanding</label>
                              <input type="text" class="form-control" id="larutanpembanding" name="larutanpembanding[]" value="<?php echo $value->larutanpembanding; ?>" >
                            </div>     
                            <div class="form-group">
                              <label for="volumepenotolan">Volume Penotolan</label>
                              <input type="text" class="form-control" id="volumepenotolan" value="<?php echo $value->volumepenotolan; ?>" name="volumepenotolan[]" >
                            </div>
                            <div class="form-group">
                              <label for="deteksi">Deteksi</label>
                              <input type="text" class="form-control" id="deteksi" value="<?php echo $value->deteksi; ?>" name="deteksi[]" >
                            </div>
                            <?php if($value->filename != '') { ?>
                              <div class="form-group">
                              <label for="cacahan">Ganti Gambar KLT</label> 
                              <div class="col-md-12">                  
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="gambarklt[]">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row" style="margin-top: 5px;">
                              <div class="col-md-3">
                                  <a href="<?php echo base_url('images/'.$value->filename); ?>" target="_blank">
                                    <img class="img-fluid mb-3 img-thumbnail" src="<?php echo base_url('images/'.$value->filename); ?>" alt="Photo" />
                                  </a>
                                </div>
                            </div>
                            <?php } else { ?>
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
                            <?php } ?>
                              
                          </div>
                        </div>  
                        <?php }
                        } else { ?>
                          <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Versi 1</h3>
                            <input type="hidden" name="hiddenkromatografi[]" />
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
                        <?php } ?>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="mikroskoppis">10. Parameter Nonspesifik</label>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-group">
                            <label for="susut_pengeringan">Susut pengeringan (%max)</label>
                            <input type="text" class="form-control" id="susut_pengeringan" name="susut_pengeringan" value="<?php echo $herbal->susut_pengeringan; ?>">
                          </div>
                          <div class="form-group">
                            <label for="abu_total">Abu total (%max)</label>
                            <input type="text" class="form-control" name="abu_total" id="abu_total" value="<?php echo $herbal->abu_total; ?>">
                          </div>
                          <div class="form-group">
                            <label for="abu_tidak_larut">Abut tidak larut asam (%max)</label>
                            <input type="text" class="form-control" id="abu_tidak_larut" name="abu_tidak_larut" value="<?php echo $herbal->abu_tidak_larut; ?>">
                          </div>
                          <div class="form-group">
                            <label for="sari_larut_air">Sari larut air (%min)</label>
                            <input type="text" class="form-control" id="sari_larut_air" name="sari_larut_air" value="<?php echo $herbal->sari_larut_air; ?>">
                          </div>
                          <div class="form-group">
                            <label for="sari_laut_etanol">Sari larut etanol (%min)</label>
                            <input type="text" class="form-control" id="sari_laut_etanol" name="sari_laut_etanol" value="<?php echo $herbal->sari_laut_etanol; ?>" >
                          </div>
                        </div>
                      </div>
                    </div>

                     <div class="form-group">
                      <label for="kandungan">11. Kandungan Kimia Simplisia</label>
                      <div class="row">
                        <div class="col-md-11" id="containerkandungankimia">
                          <?php
                          if(count($kandungankimia) > 0 ) {
                              foreach ($kandungankimia as $key => $value) { ?>
                                <div class="input-group" <?php if($key> 0) { echo 'style="margin-top:5px;"'; } ?>>
                                   <input type="text" class="form-control" id="kandungan_kimia"  name="kandungan_kimia[]" value="<?php echo $value->kandungan_kimia_simplisia; ?>" >
                                   <input type="hidden" value="<?php echo $value->id; ?>" name="hiddenkandungankimia[]">
                                   <div class="input-group-append">
                                      <button type="button" class="btn btndelkandungankimia btn-xs btn-danger btn-flat" style="width: 50px;" kandunganid="<?php echo $value->id; ?>"> <i class="fas fa-trash"></i> </button>
                                   </div>
                                 </div>
                              <?php } 
                            } else { ?>
                                  <input type="text" class="form-control" id="kandungan_kimia" name="kandungan_kimia[]" >
                                  <input type="hidden"  name="hiddenkandungankimia[]">
                          <?php  }
                          ?>
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
                      <input type="text" class="form-control" id="bentuk" name="bentuk" value="<?php echo $herbal->bentuk; ?>" >
                    </div>

                    <div class="form-group">
                      <label for="nama_ekstrak">2. Nama Ekstrak</label>
                      <input type="text" class="form-control" id="nama_ekstrak" name="nama_ekstrak" value="<?php echo $herbal->nama_ekstrak; ?>">
                    </div>

                    <div class="form-group">
                      <label for="rendemen">3. Rendemen (% min)</label>
                      <input type="text" class="form-control" id="rendemen" name="rendemen" value="<?php echo $herbal->rendemen; ?>">
                    </div>

                    <div class="form-group">
                      <label>4. Identitas Ekstrak</label>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-group">
                            <label for="pemerian">Pemerian</label>
                            <input type="text" class="form-control" id="pemerian" name="pemerian" value="<?php echo $herbal->pemerian; ?>" >
                          </div>

                          <div class="form-group">
                            <label for="senyawa_identitas">Senyawa Identitas</label>
                            <input type="text" class="form-control" id="senyawa_identitas" name="senyawa_identitas" value="<?php echo $herbal->senyawa_identitas; ?>">
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
                              <?php if(count($imagestrukturkimiaekstrak) > 0) { ?>
                            <div class="row" style="margin-top: 5px;">
                              <?php foreach ($imagestrukturkimiaekstrak as $key => $value) { ?>
                                <div class="col-md-3">
                                  <a href="<?php echo base_url('images/'.$value->filename); ?>" target="_blank">
                                    <img class="img-fluid mb-3 img-thumbnail" src="<?php echo base_url('images/'.$value->filename); ?>" alt="Photo" />
                                  </a>
                                  <button style="top: 15px; left: 15px; position: absolute;" class="btn btn-danger btn-xs float-right btndelimagestrukturkimiaekstrak" idimagestrukturkimiaekstrak="<?php echo $value->id; ?>" type="button"><i class="fas fa-trash"></i></button>
                                </div>
                              <?php } ?>
                            </div>                          
                          <?php } ?> 
                          </div>

                          <div class="form-group">
                            <label for="kadar_air">Kadar Air (% max)</label>
                            <input type="text" class="form-control" id="kadar_air" value="<?php echo $herbal->kadar_air; ?>" name="kadar_air" >
                          </div>


                          <div class="form-group">
                            <label for="abu_total_ekstrak">Abu total (%max)</label>
                            <input type="text" class="form-control" id="abu_total_ekstrak" value="<?php echo $herbal->abu_total_ekstrak; ?>" name="abu_total_ekstrak" >
                          </div>


                          <div class="form-group">
                            <label for="abu_tidak_larut_asam">Abut tidak larut asam (%max)</label>
                            <input type="text" class="form-control" id="abu_tidak_larut_asam" name="abu_tidak_larut_asam" value="<?php echo $herbal->abu_tidak_larut_asam; ?>">
                          </div>

                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="kandungan">5. Kandungan Kimia Ekstrak</label>
                      <div class="row">
                        <div class="col-md-11" id="containerkandungankimiaekstrak">
                          <?php
                          if(count($kandungankimiaekstrak) > 0 ) {
                              foreach ($kandungankimiaekstrak as $key => $value) { ?>
                                <div class="input-group" <?php if($key> 0) { echo 'style="margin-top:5px;"'; } ?>>
                                   <input type="text" class="form-control" id="kandungan_kimia_ekstrak"  name="kandungan_kimia_ekstrak[]" value="<?php echo $value->kandungan_kimia_ekstrak; ?>" >
                                   <input type="hidden" value="<?php echo $value->id; ?>" name="hiddenkandungankimiaekstrak[]">
                                   <div class="input-group-append">
                                      <button type="button" class="btn btndelkandungankimiaekstrak btn-xs btn-danger btn-flat" style="width: 50px;" kandunganid="<?php echo $value->id; ?>"> <i class="fas fa-trash"></i> </button>
                                   </div>
                                 </div>
                              <?php } 
                            } else { ?>
                                  <input type="text" class="form-control" id="kandungan_kimia_ekstrak" name="kandungan_kimia_ekstrak[]" >
                                  <input type="hidden"  name="hiddenkandungankimiaekstrak[]">
                          <?php  }
                          ?>
                        </div>
                        <div class="col-md-1">
                          <button type="button" class="btn btn-primary" id="btnkandungankimiaekstrak"><i class="fas fa-plus"></i></button>
                        </div>
                      </div>
                    </div>

                    

                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right" value="submit" name="btnsubmit">UPDATE</button>
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
