<div class="mb-3">
    <label for="{{ $prefix }}name" class="form-label">Nama Customer</label>
    <input type="text" name="name" id="{{ $prefix }}name" class="form-control">
</div>

<div class="mb-3">
    <label for="{{ $prefix }}program_name" class="form-label">Program Customer</label>
    <input type="text" name="program_name" id="{{ $prefix }}program_name" class="form-control">
</div>

<div class="mb-3">
    <label for="{{ $prefix }}content" class="form-label">Review Customer</label>
    <textarea name="content" id="{{ $prefix }}content" rows="5" class="form-control"></textarea>
</div>

<div class="mb-3">
    <label for="{{ $prefix }}ava_testimoni" class="form-label">Pilih Gambar</label>
    <input type="file" class="form-control" name="ava_testimoni" id="{{ $prefix }}ava_testimoni" accept="image/*">
</div>
