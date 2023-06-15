<div class="modal fade" id="create_wilayah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Wilayah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- kosong -->
      <div class="modal-body" id="status_kosong">
        Data Wilayah Sudah Terinput Semua Atau Masih Kosong!!
      </div>
      <!-- ada data -->
      <div class="modal-body" id="status_ada">
        <div class="row mb-3">
          <label for="wilayah" class="col-sm-3 col-form-label">Wilayah</label>
          <div class="col-sm-9">
            <select name="wilayah_option" class="form-control" id="wilayah_option">
            </select>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
        <button id="btn_simpan" class="btn btn-success"><i class="ri ri-check-fill"></i></button>
      </div>

    </div>
  </div>
</div>

@push('jss')
<script type="text/javascript">
  $('#btn_simpan').on('click',function(){
    $('#create_wilayah').modal('hide')
    $.ajax({
      url:"{{route('admin.setwilayahbencana.post_data')}}",
      type:"POST",
      data:{
        '_token':"{{csrf_token()}}",
        bencana : $('#bencana').val(),
        wilayah : $('#wilayah_option').val(),
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