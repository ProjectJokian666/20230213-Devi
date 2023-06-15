<div class="modal fade" id="update_wilayah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Update Data Wilayah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- kosong -->
      <div class="modal-body" id="status_update_kosong">
        Data Wilayah Sudah Terinput Semua Atau Masih Kosong!!
      </div>
      <!-- ada data -->
      <div class="modal-body" id="status_update_ada">
        <div class="row mb-3">
          <label for="wilayah" class="col-sm-3 col-form-label">Wilayah</label>
          <div class="col-sm-9">
            <select name="wilayah_update" class="form-control" id="wilayah_update">
            </select>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
        <button id="btn_update" class="btn btn-success"><i class="ri ri-check-fill"></i></button>
      </div>

    </div>
  </div>
</div>

@push('jss')
<script type="text/javascript">
  $('#btn_update').on('click',function(){
    $('#update_wilayah').modal('hide')
    // console.log("wil_update",wil_update)
    $.ajax({
      url:"{{route('admin.setwilayahbencana.update_data')}}",
      type:"PATCH",
      data:{
        '_token':"{{csrf_token()}}",
        bencana : $('#bencana').val(),
        wilayah : $('#wilayah_update').val(),
        wilayah_update : wil_update,
      },
      success:function(data){
        // console.log(data)
        show_data()
      },
      error:function(data){

      }
    })
    // console.log('ass');
  })
</script>
@endpush