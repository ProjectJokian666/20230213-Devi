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
          Yakin menghapus petugas {{$user->name}}?. Setelah di hapus data tidak dapat dikembalikan lagi.!!
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
          <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
        </div>

      </form>

    </div>
  </div>
</div>