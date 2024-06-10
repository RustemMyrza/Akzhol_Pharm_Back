<table style="width: 100%;">
    <thead>
    <tr>
        <th>ID Категории</th>
        <th>Категория</th>
        <th>ID Подкатегории</th>
        <th>Подкатегория</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($categories as $category)
        <tr>
            <td>{{ $category['id'] }} </td>
            <td>{{ $category['title'] }} </td>
            <td>{{ $category['subCategoryId'] }} </td>
            <td>{{ $category['subCategoryTitle'] }} </td>
        </tr>
    @endforeach
    </tbody>
</table>
