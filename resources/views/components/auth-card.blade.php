<div class="card">
    <div class="card-body">
        <div class="logo d-flex justify-content-center">
            {{ $logo }}
        </div>

        <div class="">
            {{ $slot }}
        </div>
    </div>
</div>

@if (isset($outside_card))
    {{ $outside_card }}
@endif
