<ul class="d-flex gap-30 justify-content-end">
	@can('advantage.edit')
		<li>
			<a href="{{ route('content.edit',$content->id) }}"><i
						class="las la-edit"></i></a>
		</li>
	@endcan
	@can('advantage.destroy')
		<li>
			<a href="javascript:void(0)"
			   onclick="delete_row('{{ route('content.destroy', $content->id) }}')"
			   data-toggle="tooltip"
			   data-original-title="{{ __('delete') }}"><i class="las la-trash-alt"></i></a>
		</li>
	@endcan
</ul>
