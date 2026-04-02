<div class="setting-check">
	<input type="checkbox" class="status-change"
	       {{ ($integrate->status == 1) ? 'checked' : '' }} data-id="{{ $integrate->id }}"
	       value="website-integrate-status/{{$integrate->id}}"
	       id="customSwitch2-{{ $integrate->id }}">
	<label for="customSwitch2-{{ $integrate->id }}"></label>
</div>

