<div class="bd-callout bd-callout-danger">
    <div class="media">
        <div class="d-flex flex-column align-items-center mr-3">
            <img src="{{ asset('storage/'.$member->logo) }}"  width="100" alt="">
            @if($member->admin)
                <div class="mt-2"><strong>admin</strong></div>
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
                    @if(!$member->admin)
                        <div><strong>{{ $member->start_date }} ~ {{ $member->finish_date }}</strong></div>
                        <div>{{ $member->qrcode }}</div>
                        <div class="mt-2">
                            <a href="{{ route('user.index', [$member->id]) }}">Customers</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
