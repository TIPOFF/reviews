@component('mail::message')
    # Top 25 - Weekly Review Race

    For comparison purposes, here are the Top 25 escape rooms with the most reviews over the past week in our markets.

    @component('mail::table')
        | Company | Reviews |
        | -- | :--: |
        @foreach ($competitors as $competitor)
            @if ($competitor->competitor == 0)
                | **[{{ $competitor->name }}]({{ $competitor->maps_url }})** | **{{ $competitor->weekly_reviews }}** |
            @else
                | [{{ $competitor->name }}]({{ $competitor->maps_url }}) | {{ $competitor->weekly_reviews }} |
            @endif
        @endforeach
    @endcomponent

    I'll send out another one of these emails next Wednesday so continue working hard to make the top of this list.

    -Drew
@endcomponent
