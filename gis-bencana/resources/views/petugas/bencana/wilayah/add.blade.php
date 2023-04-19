<div class="modal fade" id="add_wilayah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Wilayah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('petugas/bencana/wilayah',$data['wilayah']->id_bencana)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="modal-body">

          <div class="row mb-3">
            <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
            <div class="col-sm-9">
              <input class="form-control" type="date" id="tanggal" name="tanggal">
            </div>
          </div>

          <div class="row mb-3">
            <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
            <div class="col-sm-9">
              <input type="number" name="jumlah" class="form-control" placeholder="Jumlah Terjadi">
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
          <button type="submit" name="id_bencana_per_wilayah" value="{{$data['wilayah']->id_bencana_per_wilayah}}" class="btn btn-primary">SIMPAN</button>
        </div>

      </form>

    </div>
  </div>
</div>