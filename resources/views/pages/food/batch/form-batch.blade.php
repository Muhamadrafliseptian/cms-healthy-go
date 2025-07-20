@php
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
@endphp

@foreach ($days as $index => $day)
    @php
        $menu = $menus[$index] ?? null;
    @endphp

    <div class="border rounded p-3 mb-3">
        <h6 class="fw-bold">{{ $day }}</h6>
        {{-- <input type="hidden" name="menus[{{ $index }}][day]" value="{{ $day }}">

        <div class="mb-2">
            <label for="{{ $prefix }}lunch_menu_{{ $index }}" class="form-label">Lunch Menu</label>
            <input type="text" name="menus[{{ $index }}][lunch_menu]"
                id="{{ $prefix }}lunch_menu_{{ $index }}" class="form-control">
        </div>

        <div class="mb-2">
            <label for="{{ $prefix }}dinner_menu_{{ $index }}" class="form-label">Dinner Menu</label>
            <input type="text" name="menus[{{ $index }}][dinner_menu]"
                id="{{ $prefix }}dinner_menu_{{ $index }}" class="form-control">
        </div> --}}

        <div class="mb-2">
            <label class="form-label">Gambar Menu</label>
            <input type="file" name="menus[{{ $index }}][img_menu]" class="form-control" accept="image/*">
        </div>
    </div>
@endforeach
