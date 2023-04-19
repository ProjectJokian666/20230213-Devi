<div class="modal fade" id="update_petugas_{{$bencana->id}}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Ubah Data Petugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('petugas/update_bencana')}}" method="POST">
        @csrf
        @method('patch')
        <div class="modal-body">
          <input type="hidden" name="id" value="{{$bencana->id}}">
          <div class="row mb-3">
            <label for="bencana" class="col-sm-3 col-form-label">Bencana</label>
            <div class="col-sm-9">
              <input type="text" name="bencana" class="form-control" placeholder="Nama Bencana" value="{{$bencana->nama_bencana}}">
            </div>
          </div>

          <div class="row mb-3">
            <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
            <div class="col-sm-9">
              <textarea class="form-control" placeholder="Deskripsi Bencana" id="deskripsi" name="deskripsi" style="height: 100px;">{{$bencana->deskripsi_bencana}}</textarea>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
          <button type="submit" class="btn btn-primary">UBAH</button>
        </div>

      </form>

    </div>
  </div>
</div>