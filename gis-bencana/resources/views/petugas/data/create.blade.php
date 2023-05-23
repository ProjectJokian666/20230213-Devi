<div class="modal fade" id="create_data" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
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
            <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah Terjadi">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
        <button type="button" class="btn btn-primary" id="simpan_detail">SIMPAN</button>
      </div>
    </div>
  </div>
</div>

@push('jss')
<script type="text/javascript">
  $('#simpan_detail').on('click',function() {
    $('#create_data').modal('hide')
    $.ajax({
      url:"{{route('petugas.data.post_detail')}}",
      type:"POST",
      data:{
        '_token':"{{csrf_token()}}",
        tgl:$('#tanggal').val(),
        jumlah:$('#jumlah').val(),
        id:{{$data['wilayah']->id_bencana_per_wilayah}},
      },
      success:function(data){
        $('#tanggal').val('')
        $('#jumlah').val('')
        // console.log(data)
        show_data()
      },
      error:function(data){
        console.log(data)
      }
    })
  })
</script>
@endpush