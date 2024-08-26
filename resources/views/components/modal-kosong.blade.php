<div class="modal fade " id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  {{ $modalSize ?? '' }} modal-dialog-scrollable" role="document">
        <div class="modal-content {{ $overflow ?? '' }}">
            <div class="modal-header">
                <div class="modal-title">
                    <h4 class="mb-0">{{ $title }}</h4>
                    <small class="text-muted">Scroll ke bawah jika konten terpotong</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
