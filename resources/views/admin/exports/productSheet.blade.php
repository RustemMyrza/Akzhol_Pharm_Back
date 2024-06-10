<table style="width: 100%;">
    <thead>
    <tr>
        <th>Загаловок ru</th>
        <th>Загаловок en</th>
        <th>Описание ru</th>
        <th>Описание en</th>
        <th>Инструкция ru</th>
        <th>Инструкция en</th>
        <th>Артикул</th>
        <th>Цена в розницу</th>
        <th>Скидка</th>
{{--        <th>Цена оптом</th>--}}
{{--        <th>Количество на складе</th>--}}
        <th>Статус на складе</th>
        <th>ID Категории</th>
        <th>ID Подкатегории</th>
        <th>ID Фильтра</th>
        <th>ID Характеристики товара</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product['titleRu'] }} </td>
            <td>{{ $product['titleEn'] }} </td>
            <td style="width: 190px;">{{ $product['descriptionRu'] }} </td>
            <td style="width: 190px;">{{ $product['descriptionEn'] }} </td>
            <td style="width: 190px;">{{ $product['instructionRu'] }} </td>
            <td style="width: 190px;">{{ $product['instructionEn'] }} </td>
            <td>{{ $product['vendorCode'] }} </td>
            <td>{{ $product['price'] }} </td>
            <td>{{ $product['discount'] }} </td>
{{--            <td>{{ $product['bulkPrice'] }} </td>--}}
{{--            <td>{{ $product['stockQuantity'] }} </td>--}}
            <td>{{ $product['status'] }} </td>
            <td>{{ $product['categoryId'] }} </td>
            <td>{{ $product['subCategoryId'] }} </td>
            <td>{{ $product['productFilterItems'] }} </td>
            <td>{{ $product['productFeatureItems'] }} </td>
        </tr>
    @endforeach
    </tbody>
</table>
