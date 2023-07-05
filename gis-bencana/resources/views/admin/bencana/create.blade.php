<div class="modal fade" id="create_petugas" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Bencana</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('admin/add_bencana')}}" method="POST">
        @csrf
        <div class="modal-body">

          <div class="row mb-3">
            <label for="bencana" class="col-sm-3 col-form-label">Bencana</label>
            <div class="col-sm-9">
              <input type="text" name="bencana" class="form-control" placeholder="Nama Bencana">
            </div>
          </div>

          <!-- <div class="row mb-3">
            <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
            <div class="col-sm-9">
              <textarea class="form-control" placeholder="Deskripsi Bencana" id="deskripsi" name="deskripsi" style="height: 100px;"></textarea>
            </div>
          </div> -->

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
          <button type="submit" class="btn btn-success"><i class="ri ri-check-fill"></i></button>
        </div>

      </form>

    </div>
  </div>
</div>