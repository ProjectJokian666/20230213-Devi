<div class="modal fade" id="profil" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Ubah Data Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('admin/add_petugas')}}" method="POST">
        @csrf
        <div class="modal-body">

          <div class="row mb-3">
            <label for="inputText" class="col-sm-3 col-form-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" name="nama" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
              <input type="email" name="email" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-9">
              <input type="password" name="password" class="form-control">
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
          <button type="submit" class="btn btn-primary">SIMPAN</button>
        </div>

      </form>

    </div>
  </div>
</div>