<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="name">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan kategori"
                    autocomplete="off">
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
    <div class="form-group">
        <label>Jenis Produk <span class="text-danger">*</span></label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ori_kw_seccond" id="ori" value="Ori">
            <label class="form-check-label" for="ori">Ori</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ori_kw_seccond" id="kw" value="KW">
            <label class="form-check-label" for="kw">KW</label>
        <div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ori_kw_seccond" id="kw" value="seccond">
            <label class="form-check-label" for="seccond">seccond</label>
        </div>
    </div>
</div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-info" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
