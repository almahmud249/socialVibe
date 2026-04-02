@if(hasPermission('blog-categories.edit'))
    <div class="setting-check">
        <input type="checkbox" class="status-change" data-id="{{ $blog_category->id }}"
               {{ ($blog_category->status == 1) ? 'checked' : '' }} value="blog-category-status/{{$blog_category->id}}"
               id="customSwitch2-{{$blog_category->id}}">
        <label for="customSwitch2-{{ $blog_category->id }}"></label>
    </div>
@endif