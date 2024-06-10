<table style="width: 100%;">
    <thead>
    <tr>
        <th>Фильтр</th>
        <th>Фильтр значений</th>
        <th>ID Фильтра</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($filters as $filter)
        <tr>
            <td>{{ $filter['filterTitle'] }} </td>
            <td>{{ $filter['filterItemTitle'] }} </td>
            <td>{{ $filter['filterItemId'] }} </td>
        </tr>
    @endforeach
    </tbody>
</table>
