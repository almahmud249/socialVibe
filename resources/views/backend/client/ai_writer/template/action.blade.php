<ul class="d-flex gap-30 justify-content-end align-items-center">
    <li>
        <a href="{{ route('client.template.edit', $template->id) }}"
           title="{{ __('edit') }}"><i class="las la-edit"></i></a>
    </li>
    <li>
        <a href="javascript:void(0)"
           onclick="delete_row('{{ route('client.template.delete', $template->id) }}')"
           data-bs-toggle="tooltip"
           title="{{ __('delete') }}"><i class="las la-trash-alt"></i></a>
    </li>

</ul>
