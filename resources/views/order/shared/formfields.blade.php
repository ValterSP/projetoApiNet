<div class="form-group">
    <label for="statusInput">Estado: </label>
    <select name="status" id="statusInput">
        <option {{ old('status', $filterByStatus) === '' ? 'selected' : '' }} value="">Todos os estados
        </option>
        <option {{ old('status', $filterByStatus) == 'pending' ? 'selected' : '' }} value="pending">PENDENTE
        </option>
        <option {{ old('status', $filterByStatus) == 'paid' ? 'selected' : '' }} value="paid">PAGO</option>
        @if (Auth::user()->user_type != 'E')
            <option {{ old('status', $filterByStatus) == 'closed' ? 'selected' : '' }} value="closed">FECHADO
            </option>
            <option {{ old('status', $filterByStatus) == 'canceled' ? 'selected' : '' }} value="canceled">
                CANCELADO</option>
        @endif
    </select>
</div>
<div class="form-group">
    <label for="dateInput">De:</label>
    <input type="date" id="dateInput" name="dateMin" value="{{ old('dateMin', $filterByDateMin ?? '') }}"
           class="date-input">
</div>
<div class="form-group">
    <label for="dateInput">Para:</label>
    <input type="date" id="dateInput" name="dateMax"
           value="{{ old('dateMax', $filterByDateMax ?? '') ?: $dataAtual }}" class="date-input">
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary filtrar-btn" name="filtrar">Filtrar</button>
</div>
<div class="form-group">
    <a href="{{ route($view) }}" class="btn btn-secondary limpar-btn">Limpar</a>
</div>
