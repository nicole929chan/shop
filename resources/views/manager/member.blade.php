<div class="bd-callout bd-callout-danger">
    <div class="media">
        <div class="d-flex flex-column align-items-center mr-3">
            <img src="{{ asset('storage/'.$member->logo) }}" alt="">
            @if($member->admin)
                <div class="mt-2">admin</div>
            @endif
        </div>
        <div class="media-body">
            <h5>
                <a href="{{ route('manager.show', [$member->id]) }}">{{ $member->name }}</a> <small><strong>(code: {{ $member->code }})</strong></small>
            </h5>
            <div class="d-flex justify-content-between">
                <div>
                    <div>{{ $member->email }}</div>
                    <div>{{ $member->phone_number }}</div>
                    <div>{{ $member->address }}</div>
                </div>
                <div>
                    <div><strong>{{ $member->active_start }} ~ {{ $member->active_end }}</strong></div>
                    <div>{{ $member->qrcode }}</div>
                    <a href="{{ route('user.index', [$member->id]) }}">Customers</a>
                </div>
            </div>
        </div>
    </div>
</div>