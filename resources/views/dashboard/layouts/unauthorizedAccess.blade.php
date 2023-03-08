@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                  <!-- Alert Section -->
                  @if(session('success'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{session('success')}}
                  </div>
                   @endif

                  @if(session('delete'))
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{session('delete')}}
                  </div>
                  @endif
                  <!-- End Alert Section -->                   
                </div>
            
            </div>
        </div>
    </div>
</div>
@endsection