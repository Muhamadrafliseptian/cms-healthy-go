<div>
    <input type="hidden" name="id" id="edit_id">
    {{-- <div class="mb-3">
        <label for="edit_batch_id" class="form-label">Batch</label>
        <select name="batch_id" id="edit_batch_id" class="form-select">
            @foreach ($batches as $batch)
                <option value="{{ $batch->id }}">{{ $batch->name }}</option>
            @endforeach
        </select>
    </div> --}}
    <div class="mb-3" hidden>
        <label for="edit_day" class="form-label" hidden>Hari</label>
        <input type="text" name="day" id="edit_day" class="form-control" placeholder="Contoh: Senin" hidden>
    </div>
    <div class="mb-3">
        <label for="edit_lunch_menu" class="form-label">Menu Makan Siang</label>
        <input type="text" name="lunch_menu" id="edit_lunch_menu" class="form-control"
            placeholder="Contoh: Nasi Goreng">
    </div>
    <div class="mb-3">
        <label for="edit_dinner_menu" class="form-label">Menu Makan Malam</label>
        <input type="text" name="dinner_menu" id="edit_dinner_menu" class="form-control"
            placeholder="Contoh: Sup Ayam">
    </div>
    <div class="mb-3">
        <label for="edit_img_menu" class="form-label">Gambar Menu</label>
        <input type="file" name="img_menu" id="edit_img_menu" class="form-control">
        <small class="text-muted">Format: JPG, JPEG, PNG. Max: 2MB</small>
    </div>
</div>
