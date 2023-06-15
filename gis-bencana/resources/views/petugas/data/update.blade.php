<div class="modal fade" id="update" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="tgl_update"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-sm-12">
            <input type="hidden" name="update_id" id="update_id">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-12">
            <input type="hidden" name="update_tgl" id="update_tgl">
          </div>
        </div>
        <div class="row mb-3">
          <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
          <div class="col-sm-9">
            <input type="number" name="update_jumlah" id="update_jumlah" class="form-control" placeholder="Jumlah Terdampak">
          </div>
        </div>
        <div class="row mb-3">
          <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
          <div class="col-sm-9">
            <textarea name="update_deskripsi" id="update_deskripsi" class="form-control" placeholder="keterangan tambahan terkait kejadian"></textarea>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
        <button class="btn btn-success" id="simpan_update"><i class="ri ri-check-fill"></i></button>
      </div>
    </div>

  </div>
</div>

@push('jss')
<script type="text/javascript">
  $('#simpan_update').on('click',function() {
    $('#update').modal('hide')

    // console.log($('#update_tgl').val(),$('#update_jumlah').val(),$('#update_deskripsi').val(),$('#update_id'))
    // console.log($('#update_tgl').val(),update_tanggal)
    $.ajax({
      url:"{{route('petugas.data.update_detail')}}",
      type:"POST",
      data:{
        '_token':"{{csrf_token()}}",
        tgl:update_tanggal,
        jumlah:$('#update_jumlah').val(),
        desc:$('#update_deskripsi').val(),
        id:$('#update_id').val(),
      },
      success:function(data){
        show_data()
      },
      error:function(data){
        console.log('gagal',data)
      }
    })

  })
</script>
@endpush