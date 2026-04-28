<x-mail::message>
# Status update

The status of your feedback **{{ $idea->title }}** changed from **{{ $oldStatus->label() }}** to **{{ $idea->status->label() }}**.

<x-mail::button :url="$ideaUrl">
View your idea
</x-mail::button>

Thanks for sharing your ideas with us.

<x-slot:subcopy>
Don't want updates on this idea? [Unsubscribe]({{ $unsubscribeUrl }}) — you'll still get notifications for your other ideas.
</x-slot:subcopy>
</x-mail::message>
