<x-mail::message>
# New comment on your idea

**{{ $commenterName }}** commented on **{{ $idea->title }}**:

> {{ $excerpt }}

<x-mail::button :url="$ideaUrl">
View the discussion
</x-mail::button>

<x-slot:subcopy>
Don't want updates on this idea? [Unsubscribe]({{ $unsubscribeUrl }}).
</x-slot:subcopy>
</x-mail::message>
