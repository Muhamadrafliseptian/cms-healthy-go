<div class="form-group mb-3">
    <label for="menu_id">Pilih Menu</label>
    <select name="menu_id" class="form-control" {{ $type == 'edit' ? 'readonly' : '' }}>
        <option value="">-- Pilih Menu --</option>
        @foreach ($data as $menu)
            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group mb-3">
    <label for="title">Meta Title</label>
    <input type="text" name="title" class="form-control">
</div>

<div class="form-group mb-3">
    <label for="keywords">Meta Keywords</label>
    <textarea name="keywords" rows="3" class="form-control ckeditor"></textarea>
</div>

<div class="form-group mb-3">
    <label for="description">Meta Description</label>
    <textarea name="description" rows="3" class="form-control ckeditor"></textarea>
</div>

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        let editors = {}; // Simpan instance CKEditor

        function initializeEditors() {
            document.querySelectorAll('.ckeditor').forEach(function(el) {
                const name = el.getAttribute('name');

                // Destroy jika sudah ada instance
                if (editors[name]) {
                    editors[name].destroy().then(() => {
                        createEditor(el, name);
                    });
                } else {
                    createEditor(el, name);
                }
            });
        }

        function createEditor(element, name) {
            ClassicEditor
                .create(element)
                .then(editor => {
                    editors[name] = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        }

        // Inisialisasi CKEditor saat modal dibuka
        document.addEventListener("DOMContentLoaded", function() {
            initializeEditors();

            // Modal edit dibuka, reinit CKEditor
            document.getElementById('editModal').addEventListener('shown.bs.modal', function() {
                initializeEditors();
            });
        });
    </script>
@endsection
