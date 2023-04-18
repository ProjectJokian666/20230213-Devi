@extends('layouts.app')

@section('content')
<div class="container">

  <section class="section register min-vh-40 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

          <div class="card mb-3">

            <div class="card-body">

              <form class="row g-3 pt-4 needs-validation" novalidate method="POST" action="{{url('profil')}}">
                @csrf
                <div class="col-12">
                  <label for="yourName" class="form-label">Nama</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="yourName" value="{{Auth()->User()->name}}">
                  @error('name')
                  <div class="invalid-feedback">Masukkan Nama</div>
                  @enderror
                </div>

                <div class="col-12">
                  <label for="yourEmail" class="form-label">Email</label>
                  <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="yourEmail" value="{{Auth()->User()->email}}">
                  @error('email')
                  <div class="invalid-feedback">Masukkan Email</div>
                  @enderror
                </div>
                
                <div class="col-12">
                  <label for="yourPassword" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="yourPassword">
                  @error('password')
                  <div class="invalid-feedback">Masukkan password</div>
                  @enderror
                </div>
                
                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit">UBAH</button>
                </div>
              
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

</div>
@endsection