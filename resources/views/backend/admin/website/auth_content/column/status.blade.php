<div class="setting-check">
    <input type="checkbox" class="status-change"
           {{ ($content->status == 1) ? 'checked' : '' }} data-id="{{ $content->id }}" value="auth-content-status/{{$content->id}}"
           id="customSwitch2-{{$content->id}}">
    <label for="customSwitch2-{{ $content->id }}"></label>
</div>
