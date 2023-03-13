<div class="dropdown inline float-end">
    <div style="display: inline-block;width:70px;padding-right:5px;">
        <div style="position: absolute;left:-50px;line-height:40px;">Papar</div>
        <select class="form-select" id='option_per_page' name='option_per_page'>
            <option value="5" {{$limit==5 ? "selected" : ""}}>5</option>
            <option value="10" {{$limit==10 ? "selected" : ""}}>10</option>
            <option value="25" {{$limit==25 ? "selected" : ""}}>25</option>
            <option value="50" {{$limit==50 ? "selected" : ""}}>50</option>
            <option value="100" {{$limit==100 ? "selected" : ""}}>100</option>
        </select>
    </div>
    <div style="display: inline-block;width:200px;">
        <div class="input-group">
            <input id='option_search' onkeyup="optionSearching(this)" type="text" class="form-control" placeholder="{{$placeholder}}" value='{{$search}}'>
            <div style="height:40px;max-height:50xp;background-color:#ffffff; -webkit-border-radius: 0px 8px 8px 0px;-moz-border-radius: 0px 8px 8px 0px;border-radius: 0px 8px 8px 0px;">
              <span class="input-group-text" onclick="optionSearching($('#option_search').val(), 'click')" id='search-btn'><i class="fa fa-search"></i></span>
            </div>
        </div>
    </div>
</div>

<script>

    const optionSearching = function(self, trigger){
        let searchText = self.value;
        if(trigger == 'click'){
            searchText = self;
        }
        if(event.key === 'Enter' || self.value == '' || trigger == 'click') {
            let limit = {{$limit}};
            let url = "{{$paginator->url(1)}}&limit="+limit+"&search="+searchText;
            parent.openPgInFrame(url);
        }
    }
     $(document).ready(function() {
        $('#option_per_page').on('change', function(e){
            e.preventDefault();
            let limit = this.value;
            let url = "{{$paginator->url(1)}}&limit="+limit;
            parent.openPgInFrame(url);
        });

        $('[xaction="search"]').on('click', function(e){
            e.preventDefault();
            let searchElem = $('#option_search').val();
            optionSearching(searchElem, 'click');
        })
    });
</script>