<div class="modal fade" id="update_wilayah_{{$wilayah->id}}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Ubah Data Wilayah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('petugas/update_wilayah')}}" method="POST"enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="modal-body">
          <input type="hidden" name="id" value="{{$wilayah->id}}">
          <div class="row mb-3">
            <label for="wilayah" class="col-sm-3 col-form-label">Wilayah</label>
            <div class="col-sm-9">
              <input type="text" name="wilayah" class="form-control" placeholder="Nama Wilayah" value="{{$wilayah->nama_wilayah}}">
            </div>
          </div>

          <div class="row mb-3">
            <label for="file_wilayah" class="col-sm-3 col-form-label">File Wilayah</label>
            <div class="col-sm-9">
              <input class="form-control" type="file" id="file_wilayah" name="file_wilayah">
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
          <button type="submit" class="btn btn-success"><i class="ri ri-check-fill"></i></button>
        </div>

      </form>

    </div>
  </div>
</div>