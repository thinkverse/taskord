<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Taskord')
<img loading=lazy src="https://ik.imagekit.io/taskordimg/email-logo_zJ5cHE2wq.png" class="logo" alt="Taskord Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
