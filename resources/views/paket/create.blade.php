@extends('dashboard.layouts.main')

@section('container')
<center><h1>Halaman Detail</h1></center>
{{-- create table with data from array siswa --}}

<form method="post" action="/dashboard/paket/add">
    @csrf

<div class="card">
    <div class="card-body">

            <div class="mb-3">
                <label for="">Nama</label>
                <input type="text" class="form-control" name="nama_pkt" id="nama_pkt" placeholder="Masukkan nama">
            </div>
            
            </div>
            <button type="submit" class="btn btn-primary" name="kirim">Kirim</button>
            
        </div>
        <a href="dashboard/paket/all" class="btn btn-outline-primary">Go Back</a>
    </div>     
    
</form> 
 

@endsection