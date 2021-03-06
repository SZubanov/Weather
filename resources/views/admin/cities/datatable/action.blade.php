<div class="btn-group btn-group-sm">
    <button class="btn btn-primary" onclick="Weather.get('{{ route('weathers.get', $city) }}')">
        <i class="fas fa-sync-alt"></i>
    </button>

    <a href="{{ route('cities.edit', $city) }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
        <button type="button" class="btn btn-danger"
                data-route="{{ route('cities.destroy', $city) }}"
                data-message="{{ __('cities.table.delete', ['name' => $city->name]) }}"
                data-success-message="{{ __('cities.table.deleted', ['name' => $city->name]) }}"
                onclick="DatatableHelper.deleteButton(this)">
            <i class="fas fa-times"></i>
        </button>
</div>
