@if($recuuring_show->recurring_type == "invoice")
<p class="text-muted text-sm mb-3">
{{__(' Recurring Invoice')}}
</p>
@else
<p class="text-muted text-sm mb-3">
    {{__(' Recurring Bill')}}
</p>
@endif
