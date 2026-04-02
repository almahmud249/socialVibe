<div class="setting-check">
	<input type="checkbox" class="status-change"
	       {{ ($ourClient->status == 1) ? 'checked' : '' }} data-id="{{ $ourClient->id }}"
	       value="ourClient-status/{{$ourClient->id}}"
	       id="customSwitch2-{{ $ourClient->id }}">
	<label for="customSwitch2-{{ $ourClient->id }}"></label>
</div>

