@if(hasPermission('blog-categories.edit'))
    <ul class="d-flex gap-30 justify-content-end">
        @if(hasPermission('blog-categories.edit'))
            <li>
                <a href="{{ route('blog-categories.edit',$blog_category->id) }}"><i
                        class="las la-edit"></i></a>
            </li>
        @endif
        @if(hasPermission('blog-categories.destroy'))
            <li>
                <a href="javascript:void(0)"
                   onclick="delete_row('{{ route('blog-categories.destroy', $blog_category->id) }}')"
                   data-toggle="tooltip"
                   data-original-title="{{ __('delete') }}"><i class="las la-trash-alt"></i></a>
            </li>
        @endif
    </ul>
@endif
