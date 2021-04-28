<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Taskord')
<img loading=lazy src="https://ik.imagekit.io/taskordimg/logo_8lLu9EPFa.svg" class="logo" alt="Taskord Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
