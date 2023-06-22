<div class="modal fade" id="delete_wilayah_{{$wilayah->id}}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
          <h5 class="modal-title">Hapus Data Wilayah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        <div class="modal-body">
          Yakin menghapus wilayah {{$wilayah->nama_wilayah}}?. Setelah di hapus data tidak dapat dikembalikan lagi.!!
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
          <a href="{{url('petugas/wilayah/'.$wilayah->id.'/delete')}}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
        </div>

    </div>
  </div>
</div>