@extends('layouts.master')

@section('css')
	<!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Menu</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Simple Tables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @include('layouts.flash-message')
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <button class="btn btn-info btn-sm btn-insert" data-toggle="modal" data-target="#modal-insert" data-ids="0" data-desk="Tidak Ada">Tambah Level 0</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table text-nowrap table-sm">
                  <thead>
                    <tr>
                      <th>Level</th>
											<th>ID</th>
											<th>Nama</th>
											<th>Icon</th>
											<th>Url</th>
											<th>Urut</th>
											<th>Child</th>
											<th>Tampil</th>
											@if($_SESSION['usname'] != '')
											<th>Tambah Anak</th>
											<th>Action</th>
											@endif
                    </tr>
                  </thead>
                  <tbody>
                    {!! $menus !!}
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

        <div id="modal-insert" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form method="POST" action="{{ url('menu/form/tambahmenu') }}" class="form-horizontal" data-toggle="validator">
              @csrf
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Menu</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <label for="desk" class="col-md-2 control-label"><span style="color: red">*</span> Nama Menu </label>
                    <div class="col-md-10">
                      <input type="text" name="desk" id="modal_insert_desk" class="form-control" data-error="Masukkan nama" autocomplete="off" required>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="desk" class="col-md-2 control-label"> Keterangan </label>
                    <div class="col-md-10">
                      <textarea name="zket" id="modal_insert_zket" class="form-control" autocomplete="off"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="sao" class="col-md-2 control-label"> Parent </label>
                    <div class="col-md-10">
                      <input type="text" name="sao" id="modal_insert_sao" class="form-control" disabled>
                      <input type="hidden" name="sao" id="modal_insert_sao_real" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="urut" class="col-md-2 control-label"> Urut </label>
                    <div class="col-md-10">
                      <input type="text" name="urut" id="modal_insert_urut" class="form-control" placeholder="Boleh dikosongkan" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="iconnew" class="col-md-2 control-label"> Icon </label>
                    <div class="col-md-10">
                      <input type="text" name="iconnew" id="modal_insert_iconnew" class="form-control" placeholder="Boleh dikosongkan" autocomplete="off">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="urlnew" class="col-md-2 control-label"> URL </label>
                    <div class="col-md-10">
                      <input type="text" name="urlnew" id="modal_insert_urlnew" class="form-control" placeholder="Boleh dikosongkan" autocomplete="off">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="aksesnew" class="col-sm-2 control-label"> Hak Akses </label>
                    <div class="col-sm-10">
                      <div class="form-check">
                        <input type="checkbox" value="1" class="form-check-input" id="exampleCheck1" name="is_bpad">
                        <label class="form-check-label" for="exampleCheck1">BPAD</label>
                      </div>
                      <div class="form-check">
                        <input type="checkbox" value="1" class="form-check-input" id="exampleCheck2" name="is_skpd">
                        <label class="form-check-label" for="exampleCheck2">SKPD</label>
                      </div>
                      <div class="form-check">
                        <input type="checkbox" value="1" class="form-check-input" id="exampleCheck3" name="is_admin">
                        <label class="form-check-label" for="exampleCheck3">ADMIN</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label"><span style="color: red">*</span> Tampilkan? </label>
                    <div class="radio-list col-md-10">
                      <label class="radio-inline">
                        <div class="radio radio-info">
                          <input type="radio" name="tampilnew" id="tampil1" value="1" data-error="Pilih salah satu" required>
                          <label for="tampil1">Ya</label> 
                        </div>
                      </label>
                      <label class="radio-inline">
                        <div class="radio radio-info">
                          <input type="radio" name="tampilnew" id="tampil2" value="0">
                          <label for="tampil2">Tidak </label>
                        </div>
                      </label>
                      <div class="help-block with-errors"></div>  
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success pull-right">Simpan</button>
                  <button type="button" class="btn btn-default pull-right" style="margin-right: 10px" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div id="modal-update" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form method="POST" action="{{ url('menu/form/ubahmenu') }}" class="form-horizontal" data-toggle="validator">
              @csrf
                <div class="modal-header">
                  <h4 class="modal-title"><b>Ubah Menu</b></h4>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="ids" id="modal_update_ids">
                  <div class="form-group row">
                    <label for="desk" class="col-md-2 control-label"><span style="color: red">*</span> Nama Menu </label>
                    <div class="col-md-8">
                      <input type="text" name="desk" id="modal_update_desk" class="form-control" data-error="Masukkan nama" autocomplete="off" required>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="desk" class="col-md-2 control-label"> Keterangan </label>
                    <div class="col-md-8">
                      <textarea name="zket" id="modal_update_zket" class="form-control" autocomplete="off"></textarea>
                    </div>
                  </div>
                  <!-- <div class="form-group row">
                    <label for="sao" class="col-md-2 control-label"> Parent </label>
                    <div class="col-md-8">
                      <input type="text" name="sao" id="modal_update_sao" class="form-control" disabled>
                      <input type="hidden" name="sao" id="modal_update_sao_real" class="form-control">
                    </div>
                  </div> -->
                  <div class="form-group row">
                    <label for="urut" class="col-md-2 control-label"> Urut </label>
                    <div class="col-md-8">
                      <input type="text" name="urut" id="modal_update_urut" class="form-control" placeholder="Boleh dikosongkan" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="iconnew" class="col-md-2 control-label"> Icon </label>
                    <div class="col-md-8">
                      <input type="text" name="iconnew" id="modal_update_iconnew" class="form-control" placeholder="Boleh dikosongkan" autocomplete="off">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="urlnew" class="col-md-2 control-label"> URL </label>
                    <div class="col-md-8">
                      <input type="text" name="urlnew" id="modal_update_urlnew" class="form-control" placeholder="Boleh dikosongkan" autocomplete="off">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="aksesnew" class="col-sm-2 control-label"> Hak Akses </label>
                    <div class="col-sm-10">
                      <div class="form-check">
                        <input type="checkbox" value="1" class="form-check-input" id="update_checkbpad" name="is_bpad">
                        <label class="form-check-label" for="update_checkbpad">BPAD</label>
                      </div>
                      <div class="form-check">
                        <input type="checkbox" value="1" class="form-check-input" id="update_checkskpd" name="is_skpd">
                        <label class="form-check-label" for="update_checkskpd">SKPD</label>
                      </div>
                      <div class="form-check">
                        <input type="checkbox" value="1" class="form-check-input" id="update_checkadmin" name="is_admin">
                        <label class="form-check-label" for="update_checkadmin">ADMIN</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-2 control-label"><span style="color: red">*</span> Tampilkan? </label>
                    <div class="radio-list col-md-8">
                      <label class="radio-inline">
                        <div class="radio radio-info">
                          <input type="radio" name="tampilnew" id="update_tampil1" value="1" data-error="Pilih salah satu" required>
                          <label for="update_tampil1">Ya</label> 
                        </div>
                      </label>
                      <label class="radio-inline">
                        <div class="radio radio-info">
                          <input type="radio" name="tampilnew" id="update_tampil2" value="0">
                          <label for="update_tampil2">Tidak </label>
                        </div>
                      </label>
                      <div class="help-block with-errors"></div>  
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success pull-right">Simpan</button>
                  <button type="button" class="btn btn-default pull-right" style="margin-right: 10px" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div id="modal-delete" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="{{ url('menu/form/hapusmenu') }}" class="form-horizontal">
              @csrf
                <div class="modal-header">
                  <h4 class="modal-title">Hapus Menu</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p id="label_delete"></p>
                  <input type="hidden" name="ids" id="modal_delete_ids" value="">
                  <input type="hidden" name="sao" id="modal_delete_sao" value="">
                  <input type="hidden" name="desk" id="modal_delete_desk" value="">
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('js')
	<!-- jQuery -->
	<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="{{ asset('lte/dist/js/demo.js') }}"></script>

  <script>
		$(function () {
			$('.btn-insert').on('click', function () {
				var $el = $(this);

				$("#modal_insert_sao").val("("+$el.data('ids')+") - "+$el.data('desk'));
				$("#modal_insert_sao_real").val($el.data('ids'));
			});

			$('.btn-update').on('click', function () {
				var $el = $(this);

				$("#modal_update_ids").val($el.data('ids'));
				$("#modal_update_desk").val($el.data('desk'));
				$("#modal_update_zket").val($el.data('zket'));
				$("#modal_update_urut").val($el.data('urut'));
				$("#modal_update_iconnew").val($el.data('iconnew'));
				$("#modal_update_urlnew").val($el.data('urlnew'));

				if ($el.data('tampilnew') == 1) {
					$("#update_tampil1").attr('checked', true);
				} else {
					$("#update_tampil2").attr('checked', true);
				}

        if ($el.data('is_bpad') == 1) {
					$("#update_checkbpad").attr('checked', true);
				}

        if ($el.data('is_skpd') == 1) {
					$("#update_checkskpd").attr('checked', true);
				}

        if ($el.data('is_admin') == 1) {
					$("#update_checkadmin").attr('checked', true);
				}
			});

      $("#modal-update").on("hidden.bs.modal", function () {
				$("#update_checkbpad").attr('checked', false);
        $("#update_checkskpd").attr('checked', false);
        $("#update_checkadmin").attr('checked', false);
			});

			$('.btn-delete').on('click', function () {
				var $el = $(this);

				$("#label_delete").append('Apakah anda yakin ingin menghapus menu <b>' + $el.data('desk') + '</b>?');
				$("#modal_delete_ids").val($el.data('ids'));
				$("#modal_delete_sao").val($el.data('sao'));
				$("#modal_delete_desk").val($el.data('desk'));
			});

			$("#modal-delete").on("hidden.bs.modal", function () {
				$("#label_delete").empty();
			});
		});
	</script>
@endsection