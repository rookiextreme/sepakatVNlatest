<table class="table table-sm">
    <thead>
        <th><label for="" class="form-label text-dark">Nama</label></th>
        <th><label for="" class="form-label text-dark">Emel</label></th>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr onclick="selectUser_{{$field_name}}({{$user->id}}, '{{$user->name}}')" class="modal-list-row">
                <td class="focus"><a href="#">{{$user->name}}</a></td>
                <td>{{$user->email}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{$users->links('pagination.modal-user', ['field_name' => $field_name])}}
