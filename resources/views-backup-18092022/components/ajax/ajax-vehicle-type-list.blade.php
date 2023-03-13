<table class="table table-sm">
    <thead>
        <th><label for="" class="form-label text-dark">Kod</label></th>
        <th><label for="" class="form-label text-dark">Jenis</label></th>
    </thead>
    <tbody>
        @foreach ($vehicleTypes as $vehicleType)
            <tr onclick="selectUser_{{$field_name}}({{$vehicleType->id}}, '{{$vehicleType->name}}')" class="modal-list-row">
                <td class="focus"><a class="cursor-pointer" >{{$vehicleType->code}}</a></td>
                <td class="focus"><a class="cursor-pointer" >{{$vehicleType->name}}</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{$vehicleTypes->links('pagination.modal-vehicle-type', ['field_name' => $field_name])}}
