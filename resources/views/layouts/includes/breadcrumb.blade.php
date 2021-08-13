<div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
    <h3 class="content-header-title mb-0 d-inline-block">
        {{ end($breadcrumbs) }}
    </h3>
    <div class="row breadcrumbs-top d-inline-block">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if(!empty($breadcrumbs) && count($breadcrumbs) > 0)
                    @foreach($breadcrumbs as $title => $url)
                        @if(!$loop->last)
                            <li class="breadcrumb-item text-capitalize"><a href="{{ $url }}">{{ $title }}</a></li>
                        @else
                            <li class="breadcrumb-item active">{{ $url }}</li>
                        @endif
                    @endforeach
                @endif
            </ol>
        </div>
    </div>
</div>
