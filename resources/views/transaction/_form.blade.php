<div class="row mb-3">
    <div class="col-md-6">
        <label for="date" class="form-label">Tanggal</label>
        <div class="form">
            <input class="form-control" name="date" id="name" type="date" placeholder="Date"
                value="{{ isset($transactions) ? old('date', $transactions->date) : '' }}" />
            <label for="date" class="visually-hidden">Tanggal</label>
            @if ($errors->has('date'))
                <small class="form-text help-block" style="color:red">{{ $errors->first('date') }}</small>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <label for="category" class="form-label">COA Nama</label>
        <div class="form">
            <select class="form-control" name="master_charts_id" id="master_charts">
                <option value="">-- Pilih Nama --</option>
                @foreach ($master_charts as $item)
                    <option value="{{ $item->id }}"
                        {{ old('master_charts_id', isset($transactions) ? $transactions->master_charts_id : '') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            <label for="master_charts_id" class="visually-hidden">COA Nama</label>
            @if ($errors->has('master_charts_id'))
                <small class="form-text help-block" style="color:red">{{ $errors->first('master_charts_id') }}</small>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <label for="desc" class="form-label">Deskripsi</label>
        <div class="form">
            <textarea class="form-control" name="desc" id="desc" placeholder="Deskripsi">{{ isset($transactions) ? old('desc', $transactions->desc) : '' }}</textarea>
            @if ($errors->has('desc'))
                <small class="form-text help-block" style="color:red">{{ $errors->first('desc') }}</small>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <label for="debit" class="form-label">Debit</label>
        <div class="form">
            <input class="form-control" name="debit" id="debit" type="number" step="any" placeholder="Debit"
                value="{{ isset($transactions) ? old('debit', $transactions->debit) : '' }}" />
            <label for="debit" class="visually-hidden">Debit</label>
            @if ($errors->has('debit'))
                <small class="form-text help-block" style="color:red">{{ $errors->first('debit') }}</small>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <label for="credit" class="form-label">Credit</label>
        <div class="form">
            <input class="form-control" name="credit" id="credit" type="number" step="any" placeholder="Credit"
                value="{{ isset($transactions) ? old('credit', $transactions->credit) : '' }}" />
            <label for="credit" class="visually-hidden">Credit</label>
            @if ($errors->has('credit'))
                <small class="form-text help-block" style="color:red">{{ $errors->first('credit') }}</small>
            @endif
        </div>
    </div>
</div>