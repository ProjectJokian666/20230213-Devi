<div class="modal fade" id="create_wilayah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Wilayah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{url('admin/add_wilayah')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">

          <div class="row mb-3">
            <label for="wilayah" class="col-sm-3 col-form-label">Wilayah</label>
            <div class="col-sm-9">
              <input type="text" name="wilayah" class="form-control" placeholder="Nama Wilayah">
            </div>
          </div>

          <div class="row mb-3">
            <label for="file_wilayah" class="col-sm-3 col-form-label">File Wilayah</label>
            <div class="col-sm-9">
              <input class="form-control" type="file" id="file_wilayah" name="file_wilayah">
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
          <button type="submit" class="btn btn-primary">SIMPAN</button>
        </div>

      </form>
      <hr>
      <div class="modal-body">
        <div id="preview"></div>
      </div>
    </div>
  </div>
</div>

@push('jss')
<script src="{{asset('Jquery')}}\jquery-3.6.4.min.js"></script>
<script type="text/javascript">
  console.log('aaaaaaaaaaaa');

  $(document).ready(function(){
    $('#file_wilayah').on('input',function(){
      var namaFile = $(this).val();
      $.ajax({
        url:"{{route('admin.cek_file')}}",
        type:"GET",
        data:{
          urlFile:namaFile,
        },
        success:function(response){
          // console.log(response);
          $('#preview').text(response.nama_file);
        },
        error:function(response){
          console.log(response);
        }
      });
    });
  });

  // const fileInput = document.getElementById('file_wilayah');
  // fileInput.addEventListener('change',(event)=>{
  //   // console.log('pilih file');
  //   console.log($("#file_wilayah").val());
  //   $.ajax({
  //     url:"{{route('admin.cek_file')}}",
  //     type:"POST",
  //     data:{
  //       urlFile:$("#file_wilayah").val(),
  //     },
  //     success:function(response){
  //       console.log(response);
  //     },
  //     error:function(response){
  //       console.log(response);
  //     }
  //   });
  // });
</script>
@endpush