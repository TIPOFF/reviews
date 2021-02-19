@component('mail::message')
    # Google Reviews in {{ $month }}

    Below are the number of reviews generated in {{ $month }}:

    @component('mail::table')
        | Location | Reviews |
        | -- | :--: |
        @foreach ($locations as $location)
            | {{ $location->name }} | {{ $location->reviews_count }} |
        @endforeach
    @endcomponent

    Feel free to contact me if you have any questions regarding your goals. Keep pushing to generate more reviews and continue making them a priority in your operations.

    Thank you,

    -Drew
@endcomponent
