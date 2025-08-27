<form action="{{ route('tracking.track') }}" method="POST" class="space-y-4">
    @csrf
    <input type="text" name="awb" placeholder="Masukkan Nomor Resi" required class="border p-2 w-full">
    <select name="courier" required class="border p-2 w-full">
        <option value="jne">JNE</option>
        <option value="jnt">J&T</option>
        <option value="wahana">Wahana</option>
        <option value="sicepat">SiCepat</option>
    </select>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Lacak</button>
</form>
