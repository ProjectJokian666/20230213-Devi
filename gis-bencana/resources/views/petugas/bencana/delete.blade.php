<div class="modal fade" id="delete_bencana_{{$bencana->id}}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
          <h5 class="modal-title">Hapus Data Bencana</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        <div class="modal-body">
          Yakin menghapus bencana {{$bencana->nama_bencana}}?. Setelah di hapus data tidak dapat dikembalikan lagi.!!
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
          <a href="{{url('petugas/bencana/'.$bencana->id.'/delete')}}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
        </div>

    </div>
  </div>
</div>