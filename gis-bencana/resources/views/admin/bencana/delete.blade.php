<div class="modal fade" id="delete_petugas_{{$value['id']}}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Hapus Data Bencana</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('admin/delete_bencana')}}" method="POST">
        @csrf
        @method('delete')
        <div class="modal-body">
          <input type="hidden" name="id" value="{{$value['id']}}">
          <div class="row mb-3">
            <label for="bencana" class="col-sm-3 col-form-label">Bencana</label>
            <div class="col-sm-9">
              <input type="text" name="bencana" class="form-control" placeholder="Nama Bencana" value="{{$value['deskripsi_bencana']}}">
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
          <button type="submit" class="btn btn-primary">HAPUS</button>
        </div>

      </form>

    </div>
  </div>
</div>