@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<!-- <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="Lab Spars"> -->
@else
<!-- <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="Africa CDC Logo"> -->
{{ $slot }}
@endif
</a>
</td>
</tr>
