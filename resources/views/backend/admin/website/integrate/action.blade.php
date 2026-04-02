<ul class="d-flex gap-30 justify-content-end">
	@can('customers.edit')
		<li>
			<a href="{{ route('integrate.edit',$integrate->id ) }}"><i
						class="las la-edit"></i></a>
		</li>
	@endcan
	@can('customers.destroy')
		<li>
			<a href="javascript:void(0)"
			   onclick="delete_row('{{ route('integrate.destroy', $integrate->id) }}')"
			   data-toggle="tooltip"
			   data-original-title="{{ __('delete') }}"><i class="las la-trash-alt"></i></a>
		</li>
	@endcan
</ul>
