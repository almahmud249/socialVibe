@foreach($post->accounts as $account)
    <img title="{{ $account->title }}" width="25" src="{{ getFileLink('original_image', @$account->image['images']) }}" alt="{{ $account->name  }}">
@endforeach