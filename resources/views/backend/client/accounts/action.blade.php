<ul class="d-flex gap-30 justify-content-end align-items-center">
    <li>
        <a href="javascript:void(0)"
           onclick="delete_row('{{ route('client.accounts.delete', @$account->id) }}')"
           data-bs-toggle="tooltip"
           title="{{ __('delete') }}"><i class="las la-trash-alt"></i></a>
    </li>

</ul>
