<div class="modal fade" id="create_data_per_wilayah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Bencana Per Wilayah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      @if($data['data_wilayah_show']==null)
      <div class="modal-body">
        Data Wilayah Sudah Terinput Semua Atau Masih Kosong!!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
        <a href="{{url('admin/wilayah')}}" type="button" class="btn btn-primary">KE HALAMAN WILAYAH</a>
      </div>
      @else
      <form action="{{url('admin/bencana/wilayah',$data['bencana']->id)}}" method="POST">
        @csrf
        <div class="modal-body">

          <div class="row mb-3">
            <label for="wilayah" class="col-sm-3 col-form-label">Wilayah</label>
            <div class="col-sm-9">
              <select name="wilayah" class="form-control">
                @foreach($data['data_wilayah_show'] as $dws)
                <option value="{{$dws['id']}}">{{$dws['nama_wilayah']}}</option>
                @endforeach
              </select>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
          <button type="submit" class="btn btn-primary">SIMPAN</button>
        </div>

      </form>
      @endif
    </div>
  </div>
</div>