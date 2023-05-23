<div class="modal fade" id="update_data" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="tgl_update"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <label for="tanggal" class="col-sm-3 col-form-label">Tanggal </label>
          <div class="col-sm-9">
            <input class="form-control" type="date" id="update_tanggal">
          </div>
        </div>
        <div class="row mb-3">
          <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
          <div class="col-sm-9">
            <input type="number" name="jumlah" id="update_jumlah" class="form-control" placeholder="Jumlah Terjadi">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
        <button class="btn btn-primary" id="simpan_update">SIMPAN</button>
      </div>
    </div>
  </div>
</div>

@push('jss')
<script type="text/javascript">
  $('#simpan_update').on('click',function() {
    $('#update_data').modal('hide')

    $.ajax({
      url:"{{route('petugas.data.update_detail')}}",
      type:"PATCH",
      data:{
        '_token':"{{csrf_token()}}",
        tgl:$('#update_tanggal').val(),
        jumlah:$('#update_jumlah').val(),
        tgl_update:tgl_for_update,
        jumlah_update:jumlah_for_update,
        id:{{$data['wilayah']->id_bencana_per_wilayah}},
      },
      success:function(data){
        $('#update_tanggal').attr('value','')
        $('#update_jumlah').attr('value','')
        tgl_for_update=0
        jumlah_for_update=0
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