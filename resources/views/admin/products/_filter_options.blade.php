@forelse ($filters as $filter)
    <optgroup label="{{ $filter->titleTranslate?->ru }}">
        @forelse($filter->filterItems as $filterItem)
            <option value="{{ $filterItem->id }}">{{ $filterItem->titleTranslate?->ru }}</option>
        @empty
            Фильтр значение не найдено
        @endforelse
    </optgroup>
@empty
    <option value="">Фильтры не найдены</option>
@endforelse
