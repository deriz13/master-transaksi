<div class="row mb-3">
    <div class="col-md-12">
        <label for="name" class="form-label">Nama</label>
        <div class="form">
            <input class="form-control" name="name" id="name" type="text" placeholder="Nama"
                value="{{ isset($master_categories) ? old('name', $master_categories->name) : '' }}" />
            <label for="name" class="visually-hidden">Name</label>
            @if ($errors->has('name'))
            <small class="form-text help-block" style="color:red">{{ $errors->first('name') }}</small>
            @endif
        </div>
    </div>
</div>