@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Library')
    <img src="https://aircinelmvc.blob.core.windows.net/resources/inovcorp_logo_book.jpg" class="logo" alt="Library Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
