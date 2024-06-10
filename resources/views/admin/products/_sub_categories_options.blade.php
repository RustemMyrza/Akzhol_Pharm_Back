@forelse ($subCategories as $subCategory)
    <option value="{{ $subCategory->id }}">{{ $subCategory->titleTranslate?->ru }}</option>
@empty
    <option value="">Подкатегорий не найдены</option>
@endforelse
