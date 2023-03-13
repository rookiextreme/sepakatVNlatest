<div class="table-responsive">
    <div class="input-group mt-1">
        <span class="cux-btn bigger" onclick="addMorePassenger()">
            <i class="fa fa-plus"></i> Tambah
        </span>
    </div>
    <div class="col-12">
        <div id="res-message" class="text-center text-danger"></div>
    </div>
    <table class="table-custom no-footer stripe">
        <thead>
            <th class="col-del"></th>
            <th class="col-del">Bil</th>
            <th>Nama</th>
            <th>No Telefon</th>
            {{-- <th></th> --}}
        </thead>
        <tbody xlistPassenger>
            @foreach ($passengerList as $passenger)
                <tr data-id="{{$passenger->id}}">
                    <td style="padding-top:10px">
                        <span data-id="{{$passenger->id}}" onclick="deletePassenger(this)" style="height:46px"><i class="fal fa-trash-alt fa-lg"></i></span>
                    </td>
                    <td class="counter">{{$loop->index+1}}</td>
                    <td style="padding:4px"><input type="text" onchange="openBtnSave({{$passenger->id}})" id="name_{{$passenger->id}}" name="name_{{$passenger->id}}" value="{{$passenger->name}}"></td>
                    <td style="padding:4px"><input type="text" onchange="openBtnSave({{$passenger->id}})" id="phone_no_{{$passenger->id}}" name="phone_no_{{$passenger->id}}" value="{{$passenger->phone_no}}"></td>
                    {{-- <td><button class="cux-btn small" id="btnSave_{{$passenger->id}}" onclick="updatePassenger({{$passenger->id}}, this)">Simpan</button></td> --}}
                </tr>
            @endforeach
            <span nextRow></span>
        </tbody>
    </table>
</div>
<script>

    openBtnSave = function(id){
        console.log('#btnSave_'+id);
        $('#btnSave_'+id).prop('disabled', false).text('Simpan')
    }

    addMorePassenger = function(){

        $.post("{{route('logistic.booking.vehicle.passenger.insert')}}", {
            '_token': "{{ csrf_token() }}"
        }, function(result){

            if(result['code']== 200){
                let dataId = result['id'];
                let nextCounter = $('[xlistPassenger] tr').length;
                let element = '<tr data-id="'+dataId+'">';
                    element +='<td class="" style="padding-top:6px"><span data-id="'+dataId+'" onclick="deletePassenger(this)"><i class="fal fa-trash-alt" style="cursor:pointer"></i></span></td>';
                    element +='<td class="counter">'+(nextCounter+1)+'</td>';
                    element +='<td style="padding:4px"><input onchange="openBtnSave('+dataId+')" id="name_'+dataId+'" type="text" name="name_'+dataId+'" value=""></td>';
                    element +='<td style="padding:4px"><input onchange="openBtnSave('+dataId+')" id="phone_no_'+dataId+'" type="text" name="phone_no_'+dataId+'" value=""></td>';
                    // element +='<td><span id="btnSave_'+dataId+'" onclick="updatePassenger('+dataId+', this)" class="cux-btn small">Simpan</span></td>';
                    element +='</tr>';
                $('[xlistPassenger]:last-child').append(element);
                $('#res-message').hide();
            } else {
                $('#res-message').text(result['message']).show();
            }

        });
    }

    updatePassenger = function(id, self){
        let name = $('#name_'+id).val();
        let phone_no = $('#phone_no_'+id).val();
        $.post("{{route('logistic.booking.vehicle.passenger.update')}}", {
            id: id,
            name: name,
            phone_no: phone_no,
            '_token': "{{ csrf_token() }}"
        }, function(){
            $(self).prop('disabled', true).text('Telah Disimpan')
        });
    }

    deletePassenger = function(self){
        let id = $(self).attr('data-id');
        $.post("{{route('logistic.booking.vehicle.passenger.delete')}}", {
            ids: [id],
            '_token': "{{ csrf_token() }}"
        }, function(){
            $('tr[data-id='+id+']').remove();
        });
    }
</script>
