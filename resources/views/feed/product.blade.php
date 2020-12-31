<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">
    <title>{{ '#'.$product->slug }}'s Feed - {{ config('app.name') }}</title>
    <link href="https://taskord.com/feed/user/{{ $product->slug }}" rel="self" type="application/atom+xml"/>
    <link href="https://taskord.com/product/{{ $product->slug }}" rel="alternate" type="text/html"/>
    <id>https://taskord.com/feed/product/{{ $product->slug }}</id>
    <updated>{{ $product->updated_at->format('D, d M Y H:i:s') }}</updated>
    @foreach ($tasks as $task)
    <entry>
        <title>{{ $task->task }}</title>
        <link rel="alternate" href="https://taskord.com/task/{{ $task->id }}" />
        <id>https://taskord.com/task/{{ $task->id }}</id>
        <author>
            <username>{{ $task->user->username }}</username>
            <name>{{ $task->user->firstname .' '. $task->user->lastname }}</name>
        </author>
        <created>{{ $task->created_at->format('D, d M Y H:i:s') }}</created>
        <updated>{{ $task->updated_at->format('D, d M Y H:i:s') }}</updated>
    </entry>
    @endforeach
</feed>
