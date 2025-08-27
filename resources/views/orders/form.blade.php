<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah Data
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="name">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama"
                    autocomplete="off">
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="description">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Masukkan deskripsi"></textarea>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="price">Harga <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="price" id="price" placeholder="Masukkan harga"
                    min="0" onkeyup="format_uang(this)">
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="stock">Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="stock" id="stock" placeholder="Masukkan stok"
                    value="0" min="0">
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="category_id">Kategori <span class="text-danger">*</span></label>
                <select class="form-control category_id select2" name="category_id" id="category_id">
                    <option value="">-- Pilih Kategori --</option>
                    <!-- Tambahkan kategori dari database -->
                </select>
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="path_image">Gambar <span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="path_image" id="path_image">
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-info" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan
        </button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
