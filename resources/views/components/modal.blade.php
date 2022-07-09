<div id="{{ $modalId }}" class="cms-modal cms-closed-modal">
    <div class="cms-modal-box">
        <div class="cms-modal-box-header">
            <span class="cms-modal-box-title">{{ $modalTitle }}</span>
            <span class="cms-modal-close">&times;</span>
        </div>
        {{-- Modal content div created dinamically --}}
    </div>
    <div class="cms-modal-selected-option-box cms-selected-box-hidden">
        <div class="cms-modal-selected-option-content">
            <ul></ul>
        </div>
        <img id="categoryOkButton" class="cms-modal-ok-button" src="{{asset('img/true-trimmy.png')}}" alt="ok icon" title="Confirmar">
    </div>
</div>