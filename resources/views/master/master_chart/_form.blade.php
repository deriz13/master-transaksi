<div class="row mb-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Nama</label>
        <div class="form">
            <input class="form-control" name="name" id="name" type="text" placeholder="Nama"
                value="{{ isset($master_charts) ? old('name', $master_charts->name) : '' }}" />
            <label for="name" class="visually-hidden">Name</label>
            @if ($errors->has('name'))
            <small class="form-text help-block" style="color:red">{{ $errors->first('name') }}</small>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <label for="category" class="form-label">Kategori</label>
        <div class="form">
            <select class="form-control" name="category_id" id="category">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($category as $item)
                <option value="{{ $item->id }}"
                    {{ isset($master_charts) && old('category', $master_charts->category_id) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
                @endforeach
            </select>
            <label for="category" class="visually-hidden">Kategori</label>
            @if ($errors->has('category'))
            <small class="form-text help-block" style="color:red">{{ $errors->first('category') }}</small>
            @endif
        </div>
    </div>
</div>