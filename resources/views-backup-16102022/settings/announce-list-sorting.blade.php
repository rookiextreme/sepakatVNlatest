<ul class="sort_menu list-group">
    @foreach ($announce_list as $announce)
    <li class="list-group-item" data-id="{{$announce->id}}">
        <span class="fa fa-arrows handle"></span> &nbsp;{{$announce->title_bm}}</li>
    @endforeach
</ul>