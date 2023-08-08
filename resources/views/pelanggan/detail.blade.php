@extends('dashboard.layouts.main')

@section('container')
<center><h1>Halaman Detail</h1></center>
{{-- create table with data from array siswa --}}

<div class="form-group p-3">
    <label for="">Nama</label>
    <input type="text" class="form-control" name="nama" id="nama" value="{{ $s->nama_pkt }} " readonly>
</div>


 
<a href="/dashboard/paket/all" class="btn btn-outline-primary">Go Back</a>
@endsection