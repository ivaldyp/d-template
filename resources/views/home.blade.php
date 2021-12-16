@extends('layouts.master')

@section('css')
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
	<input type="hidden" id="activemenus" value="{{ $activemenus }}">
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1>Blank Page</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Blank Page</li>
						</ol>
					</div>
				</div>
			</div><!-- /.container-fluid -->
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Title</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
							<i class="fas fa-times"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					Start creating your amazing application!
				</div>
				<!-- /.card-body -->
				<div class="card-footer">
					Footer
				</div>
				<!-- /.card-footer-->
			</div>
			<!-- /.card -->

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
	@include('layouts.activate-menu')
@endsection