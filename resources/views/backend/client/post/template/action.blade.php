<ul class="d-flex gap-30 justify-content-end align-items-center">
	<li><a href="{{ route('client.post.template.edit', $postTemplate->id) }}" title="{{ __('edit') }}"><i class="las la-edit" title="{{__('edit')}}"></i></a></li>
	<li><a onclick="delete_row('{{ route('client.post.template.destroy', $postTemplate->id) }}')"
	       href="javascript:void(0)"><i class="las la-trash-alt" title="{{__('delete')}}"></i></a></li>
</ul>