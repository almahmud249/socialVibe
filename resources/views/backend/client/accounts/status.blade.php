<div class="setting-check">
    <input type="checkbox" {{ $account->is_primary==1 ? 'disabled':'' }}  class="status-change"    {{ ($account->status == 1) ? 'checked' : '' }} data-id="{{$account->id}}"
           value="accounts-status/{{$account->id}}" id="customSwitch2-{{$account->id}}" >
    <label for="customSwitch2-{{ $account->id }}"></label>
</div>

