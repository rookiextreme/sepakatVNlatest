@if(count($announce_list) > 0)
    <div class="row border" style="height: 200px;" id="display">
        <div class="col-md-12">
            <div id="announcementIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel" style="height: 90%">
                <div class="carousel-indicators" style="bottom:-60px">
                    @foreach ($announce_list as $announce)
                        <button type="button" data-bs-target="#announcementIndicators" data-bs-slide-to="{{$loop->index}}" class="{{$loop->index == 0 ? 'active' : ''}}" aria-current="true" aria-label="Slide 1"></button>
                    @endforeach
                </div>
                <div class="carousel-inner" style="height:100%">
        
                    {{-- @json($announce_list) --}}
                    @foreach ($announce_list as $announce)
                        <div class="carousel-item {{$loop->index == 0 ? 'active' : ''}}">
                            <div>
                                <div class="memo-dte">{{$announce->created_at}}</div>
                                <div class="memo-txt">{{$announce['title_bm']}}</div>
                                <div class="memo-cnt">{{$announce['desc_bm_1']}} {{$announce['desc_bm_2']}}</div>
                                <div class="memo-sig">{{$announce->createdBy->name}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" onmouseover="$(this).css({'background-color': 'silver'});" onmouseout="$(this).css({'background-color': 'transparent'})" type="button" data-bs-target="#announcementIndicators" data-bs-slide="prev" style="margin-left:-20px">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" onmouseover="$(this).css({'background-color': 'silver'});" onmouseout="$(this).css({'background-color': 'transparent'})" type="button" data-bs-target="#announcementIndicators" data-bs-slide="next" style="margin-right:-20px">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    @else
    <div class="d-flex justify-content-center">Tiada Pengumuman</div>
@endif
