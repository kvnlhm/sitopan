@extends('master')
@section('judul', 'Dashboard')
@section('konten')
	<div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
		<div class="page-title d-flex flex-column me-3">
			<h1 class="d-flex text-dark fw-bold my-1 fs-3">Dashboard</h1>
		</div>
	</div>
	<div class="content flex-column-fluid" id="kt_content">
		<div class="row gy-5 g-xl-10">
			<div class="col-sm-6 col-xl-3 mb-xl-10">
				<div class="card h-lg-100">
					<div class="card-body d-flex justify-content-between align-items-start flex-column">
						<div class="m-0">
							<i class="ki-duotone ki-{{ $data['total_proses_audit']['icon'] }} fs-2hx text-gray-600">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
							</i>
						</div>
						<div class="d-flex flex-column my-7">
							<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $data['total_proses_audit']['value'] }}</span>
							<div class="m-0">
								<span class="fw-semibold fs-6 text-gray-400">Total Proses Assessment</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3 mb-xl-10">
				<div class="card h-lg-100">
					<div class="card-body d-flex justify-content-between align-items-start flex-column">
						<div class="m-0">
							<i class="ki-duotone ki-{{ $data['total_pertanyaan']['icon'] }} fs-2hx text-gray-600">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
							</i>
						</div>
						<div class="d-flex flex-column my-7">
							<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $data['total_pertanyaan']['value'] }}</span>
							<div class="m-0">
								<span class="fw-semibold fs-6 text-gray-400">Total Pertanyaan</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3 mb-xl-10">
				<div class="card h-lg-100">
					<div class="card-body d-flex justify-content-between align-items-start flex-column">
						<div class="m-0">
							<i class="ki-duotone ki-{{ $data['total_proyek']['icon'] }} fs-2hx text-gray-600">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
							</i>
						</div>
						<div class="d-flex flex-column my-7">
							<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $data['total_proyek']['value'] }}</span>
							<div class="m-0">
								<span class="fw-semibold fs-6 text-gray-400">Total Proyek</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3 mb-xl-10">
				<div class="card h-lg-100">
					<div class="card-body d-flex justify-content-between align-items-start flex-column">
						<div class="m-0">
							<i class="ki-duotone ki-{{ $data['total_audit']['icon'] }} fs-2hx text-gray-600">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
						<div class="d-flex flex-column my-7">
							<span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $data['total_audit']['value'] }}</span>
							<div class="m-0">
								<span class="fw-semibold fs-6 text-gray-400">Total Assessment</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	@include('my_components.toastr')
	@include('my_components.datatables')
@endsection
