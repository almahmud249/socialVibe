<div class="setting-check">
    <input type="checkbox" class="status-change"
           {{ ($growth_list->status == 1) ? 'checked' : '' }} data-id="{{ $growth_list->id }}" value="website-growth-status/{{$growth_list->id}}"
           id="customSwitch2-{{$growth_list->id}}">
    <label for="customSwitch2-{{ $growth_list->id }}"></label>
</div>
