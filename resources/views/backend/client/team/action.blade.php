<ul class="d-flex gap-30 justify-content-center align-items-center">
	@if (!(auth()->user()->id == $user->id))
		@if(!$user->is_primary)
			<li>
				<a class="edit_modal" href="{{ route('client.team.edit',$user->id) }}"
				   title="{{ __('edit') }}"><i class="las la-edit"></i></a>
			</li>
		@endif
	@endif
</ul>