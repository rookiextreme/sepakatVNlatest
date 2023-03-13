<div class="mt-2">
    @if(Session::has('submition'))
        <p class="alert alert-primary mt-2">{{ Session::get('submition') }}</p>
    @endif
    <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link {{$tab == 'pendaftaran' ? 'active' : ''}}" wire:click="$set('tab', 'pendaftaran')">Maklumat Kenderaan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{$tab == 'maklumat' ? 'active' : ''}} {{empty($saman['id']) ? 'disabled' : ''}}" wire:click="$set('tab', 'maklumat')">Maklumat Saman</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{$tab == 'upload' ? 'active' : ''}} {{empty($saman['id']) ? 'disabled' : ''}}" wire:click="$set('tab', 'upload')">Muat Naik</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        @if ($tab == 'pendaftaran')
            @livewire('vehicle.saman.components.form-maklumat-kenderaan', ['saman_id' => $saman['id']])
        @elseif($tab == 'maklumat')
            @livewire('vehicle.saman.components.form-maklumat-saman', ['saman_id' => $saman['id']])
        @elseif ($tab == 'upload')
            @livewire('vehicle.saman.components.form-dokumen', ['saman_id' => $saman['id']])
        @endif
    </div>
</div>
