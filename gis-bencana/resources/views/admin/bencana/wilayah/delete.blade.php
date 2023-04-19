<div class="modal fade" id="delete_data_{{$w->id_bencana_per_wilayah}}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Hapus Data Wilayah {{$w->wilayah->nama_wilayah}} Untuk Bencana {{$data['bencana']->nama_bencana}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('admin/bencana/wilayah',$data['bencana']->id)}}" method="POST">
        @csrf
        @method('delete')
        <input type="hidden" name="id" value="{{$w->id_bencana_per_wilayah}}">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
          <button type="submit" class="btn btn-primary">HAPUS</button>
        </div>

      </form>

    </div>
  </div>
</div>