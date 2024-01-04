<div class="modal fade " id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  {{ $modalSize ?? '' }} modal-dialog-scrollable" role="document">
        <div class="modal-content {{ $overflow ?? '' }}">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $route ?? '' }}" method="post" enctype="multipart/form-data">
                {{ $method ?? '' }}
                @csrf
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn {{ $btnSecondaryClass ?? 'btn-secondary' }}"
                        data-bs-dismiss="modal">{{ $btnSecondaryTitle ?? 'Batal' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
