@extends('admin-panel.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Daftar Pengguna PPID" />
    <div class="space-y-6">

        <x-admin::tables.basic-tables.basic-tables-three />

    </div>
@endsection
