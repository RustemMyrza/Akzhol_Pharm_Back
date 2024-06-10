<table style="width: 100%;">
    <thead>
    <tr>
        <th>Характеристика</th>
        <th>Характеристика значений</th>
        <th>ID Характеристика</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($features as $feature)
        <tr>
            <td>{{ $feature['featureTitle'] }} </td>
            <td>{{ $feature['featureItemTitle'] }} </td>
            <td>{{ $feature['featureItemId'] }} </td>
        </tr>
    @endforeach
    </tbody>
</table>
