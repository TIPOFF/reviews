@component('mail::message')
    # {{ $market->name }} Reviews in {{ $month }}

    Here is a snapshot of the total Google Reviews for each {{ $market->name }} escape room company and the new reviews generated in {{ $month }}.

    @component('mail::table')
        | Company | New | Total |
        | -- | :--: | :--: |
        @foreach ($competitors as $competitor)
            @if ($competitor->competitor == 0)
                | **[{{ $competitor->name }}]({{ $competitor->maps_url }})** | **{{ $competitor->monthly_reviews }}** | **{{ $competitor->reviews }}** |
            @else
                | [{{ $competitor->name }}]({{ $competitor->maps_url }}) | {{ $competitor->monthly_reviews }} | {{ $competitor->reviews }} |
            @endif
        @endforeach
    @endcomponent

    Let me know if you have any questions.

    Thanks,

    -Drew
@endcomponent
