@extends('dashboard.layouts.main')


@section('container')
<h1 align="center" style="margin-top: 30px" >Halaman Siswa</h1>
@if (session()->has('success'))
    <div class="alert alert-success col-lg-12" role="alert">
        {{ session('success') }}
    </div>    
@endif



<table class="table table-dark table-striped table-hover" style= "text-align: center;">
    <div class="row">
        
        
      
    
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nama</th>
            <th scope="col">Alamat</th>
            <th scope="col">No Telp</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($data_pelanggan->count())  
        
        @foreach ($data_pelanggan as $s)
        <tr>
            <td>{{ $s -> id}}</td>
            <td>{{ $s -> name}}</td>
            <td>{{ $s -> email}}</td>
            <td>{{ $s -> number}}</td>
            <td>{{ $s -> address}}</td>
            <td>
            <a type="button" class="btn btn-warning m-1"   href="detail/{{ $s -> id }}">detail page</a>
            

            </td>
           
        </tr>
        
    

    
            <!-- Modal -->
            <div class="modal fade" id="modalData{{ $s -> id }}" tabindex="-1" aria-labelledby="modaldataLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modaldataLabel">Detail Data Character</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                               
                                    <p>
                                    {{ $s -> nama }}
                                    </p>
                                
                               
                               
                            
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                               
                            </div>
                            </div>
                        </div>
                        </div>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center">Data tidak Ditemukan</td>
                        </tr>
                        @endif
                        
                    
            </tbody>
        </table>
        <div class="d-flex">
        {{ $data_pelanggan->links() }}
    </div>
@endsection