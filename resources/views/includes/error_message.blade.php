@if (count($errors))
    <div class="alert alert-danger alert-dismissible align-items-center">
        <i class="bx bx-xs bx-info-circle me-2"></i>
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('message'))
    <div class="alert alert-success alert-dismissible align-items-center" role="alert">
        <i class="bx bx-xs bx-info-circle me-2"></i>
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
