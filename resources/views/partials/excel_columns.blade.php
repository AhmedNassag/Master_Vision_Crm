<!-- resources/views/partials/excel_columns.blade.php -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Excel Column</th>
            <th>Contact Field</th>
            <th>Operator</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($excelColumns as $column)
            @if($column != null && $column != "")
            <tr>
                <td>{{ $column }}</td>
                <td>
                    <select name="column_mappings[{{ $column }}][contact_field]">
                        <option value="">Select Contact Field</option>
                        @foreach ($contactFields as $key=>$field)
                            <option value="{{ $key }}">{{ $field }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="column_mappings[{{ $column }}][operator]">
                        <option value="equal">Equal</option>
                        <option value="like">Like</option>
                    </select>
                </td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>
