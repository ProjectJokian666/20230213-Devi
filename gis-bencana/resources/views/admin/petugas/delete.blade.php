<div class="modal fade" id="delete_petugas_{{$user->id}}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Hapus Data Petugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('admin/delete_petugas')}}" method="POST">
        @csrf
        @method('delete')
        <div class="modal-body">
          <input type="hidden" name="id" value="{{$user->id}}">
          <div class="row mb-3">
            <label for="inputText" class="col-sm-3 col-form-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" name="nama" class="form-control" value="{{$user->name}}">
            </div>
          </div>

          <div class="row mb-3">
            <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
              <input type="email" name="email" class="form-control" value="{{$user->email}}">
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
          <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
        </div>

      </form>

    </div>
  </div>
</div>