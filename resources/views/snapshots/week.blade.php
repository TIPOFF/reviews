@component('mail::message')
    # Weekly Race for Reviews

    Below are the total number of Google Reviews that were generated since last Wednesday compared to your competitors in {{ $market->name }}:

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

    Let me know if you have any questions and keep pushing to generate significantly more reviews each week than your competition. I'll send out another one of these emails next Wednesday so you can continue tracking your progress.

    Keep Racing!

    -Drew
@endcomponent
