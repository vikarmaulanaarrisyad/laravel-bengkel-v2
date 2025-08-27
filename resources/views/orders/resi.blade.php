<!-- Modal Input Resi -->
<div class="modal fade" id="resiModal" tabindex="-1" role="dialog" aria-labelledby="resiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="resiForm" method="POST" action="{{ route('orders.update.resi') }}">
            @csrf
            <input type="hidden" name="order_id" id="modal_order_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Nomor Resi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="awb">Nomor Resi</label>
                        <input type="text" name="awb" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="courier">Kurir</label>
                        <select name="courier" class="form-control" required>
                            <option value="">Pilih Kurir</option>
                            <option value="jne">JNE</option>
                            <!-- Tambahkan kurir lain jika perlu -->
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
