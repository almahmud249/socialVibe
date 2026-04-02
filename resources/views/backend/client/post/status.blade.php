@if($post->status == 1)
    <span class="badge rounded-pill badge subscription-status bg-opacity-75" style="line-height: 15px!important; background-color: #25ab7c!important;">{{ __('published')}}</span>
@elseif($post->status == 3)
    <span class="badge rounded-pill badge subscription-status bg-info bg-opacity-75" style="line-height: 15px!important;">{{ __('scheduled')}}</span>
@elseif($post->status == 2)
    <span class="badge rounded-pill badge subscription-status bg-warning bg-opacity-75" style="line-height: 15px!important;">{{ __('draft')}}</span>
@else
    <span class="badge rounded-pill badge subscription-status bg-danger bg-opacity-75" style="line-height: 15px!important;">{{ __('failed')}}</span>
@endif