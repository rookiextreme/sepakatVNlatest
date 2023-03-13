<div class="btn-group">
    <a class="btn cux-btn bigger" href="{{route('logistic.booking.register')}}" ><i class="fal fa-plus"></i> Jenis Kenderaan</a>
</div>
<form class="row" id="frm_info">
    <table id="fleet-ls" class="table display compact stripe hover compact table-bordered">
        <thead>
            <th><input name="chkall" id="chkall" type="checkbox"></th>
            <th></th>
            <th class="text-center">Kategori</th>
            <th class="text-center">SubKategori</th>
            <th class="text-center">Jenis</th>
            <th class="text-center">Bilangan Penumpang</th>
            <th class="text-center">Buatan</th>
            <th class="text-center">Model</th>
        </thead>
        <tbody id="sortable">
                <tr>
                    <td>
                        <input name="chkdel" id="chkdel" type="checkbox" value=""/>
                    </td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
        </tbody>
    </table>
</form>


<script type="text/javascript">

    function submitInfo(data) {
        parent.startLoading();
        $.ajax({
            url: "{{ route('logistic.booking.register.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                window.location = response['url'];
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;

                var errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><ul>';

                $.each(errors, function(key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div';

                $('.messages').html(errorsHtml);
                parent.stopLoading();
            }
        });
    }

    $(document).ready(function(){

        $('#frm_info').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitInfo(formData);

        });

    })

</script>
