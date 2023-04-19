<div class="modal fade" id="delete_wilayah_{{$b->tgl_terjadi}}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Hapus Data {{$data['wilayah']->bencana->nama_bencana}} Wilayah {{$data['wilayah']->wilayah->nama_wilayah}} Pada Tanggal {{DATE('d F Y',strtotime($b->tgl_terjadi))}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('petugas/bencana/wilayah',$data['wilayah']->id_bencana)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('delete')
        <input type="hidden" name="tanggal" value="{{$b->tgl_terjadi}}">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
          <button type="submit" name="id_bencana_per_wilayah" value="{{$data['wilayah']->id_bencana_per_wilayah}}" class="btn btn-danger">HAPUS</button>
        </div>

      </form>

    </div>
  </div>
</div>