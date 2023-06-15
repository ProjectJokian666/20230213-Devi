<div class="modal fade" id="create_data" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <label for="tanggal" class="col-sm-3 col-form-label">Bencana</label>
          <div class="col-sm-9">
            <select name="bencana" class="form-control" id="bencana">
              @foreach($data['bencana'] as $key => $value)
              <option value="{{$value['id']}}">{{$value['nama_bencana']}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <label for="tanggal" class="col-sm-3 col-form-label">Wilayah</label>
          <div class="col-sm-9">
            <select name="wilayah" class="form-control" id="wilayah">
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
          <div class="col-sm-9">
            <input class="form-control" type="date" id="tanggal" name="tanggal">
          </div>
        </div>
        <div class="row mb-3">
          <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
          <div class="col-sm-9">
            <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah Terdampak">
          </div>
        </div>
        <div class="row mb-3">
          <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
          <div class="col-sm-9">
            <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="keterangan tambahan terkait kejadian"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
        <button type="button" class="btn btn-success" id="simpan_data"><i class="ri ri-check-fill"></i></button>
      </div>

    </div>
  </div>
</div>

@push('jss')
<script type="text/javascript">
  show_create()
  $('#bencana').on('change',function() {
    show_create()
  })
  function show_create(){
    $('#simpan_data').hide();
    // console.log($('#bencana').val())
    $.ajax({
      url:"{{route('petugas.data.wilayah_by_id')}}",
      type:"GET",
      data:{
        id:$('#bencana').val(),
      },
      success:function(data) {
        // console.log(data)
        $('#wilayah').empty()
        data.wilayah.forEach(function(data) {
          // console.log(data)
          if(data.nama_wilayah!=null){
            var option="<option value='"+data.id_bencana_per_wilayah+"'>"+data.nama_wilayah+"</option>"
            $('#wilayah').append(option);
          }
          if(data.nama_wilayah==null){
            var option="<option disable>Data Kosong</option>"
            $('#wilayah').append(option);
          }
        })

      },
      error:function(data){
        console.log(data)
      }
    })
  }
  $('#simpan_data').on('click',function(){
    $('#create_data').modal('hide')
    // console.log($('#wilayah').val())
    // console.log($('#tanggal').val())
    // console.log($('#jumlah').val())
    // console.log($('#deskripsi').val())
    $.ajax({
      url:"{{route('petugas.data.wilayah_by_id')}}",
      type:"POST",
      data:{
        '_token':"{{csrf_token()}}",
        wilayah:$('#wilayah').val(),
        tanggal:$('#tanggal').val(),
        jumlah:$('#jumlah').val(),
        deskripsi:$('#deskripsi').val(),
      },
      success:function(data) {
        if (data.status=="sukses") {
          location.reload(true)
        }
        console.log(data);
      },
      error:function(data) {
        console.log(data);
      }
    })
  })
  setInterval(function(){
    // console.log('aa')
    var wilayah=$('#wilayah').val()
    var tanggal=$('#tanggal').val()
    var jumlah=$('#jumlah').val()
    var deskripsi=$('#deskripsi').val()
    if (wilayah!=""&&wilayah>0&&tanggal!=""&&jumlah>0&&jumlah!=""&&deskripsi!="") {
      $("#simpan_data").show()
    }
    else{
      $("#simpan_data").hide()
    }
  },1000);
</script>
@endpush