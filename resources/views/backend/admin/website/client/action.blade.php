<ul class="d-flex gap-30 justify-content-end">
	@can('customers.edit')
		<li>
			<a href="{{ route('customers.edit',$ourClient->id ) }}"><i
						class="las la-edit"></i></a>
		</li>
	@endcan
	@can('customers.destroy')
		<li>
			<a href="javascript:void(0)"
			   onclick="delete_row('{{ route('customers.destroy', $ourClient->id) }}')"
			   data-toggle="tooltip"
			   data-original-title="{{ __('delete') }}"><i class="las la-trash-alt"></i></a>
		</li>
	@endcan
</ul>
