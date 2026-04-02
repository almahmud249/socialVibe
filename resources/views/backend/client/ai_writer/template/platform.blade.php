<td class="text-center">
	@if($row->platform == 1)
		<span class="badge rounded-pill badge subscription-status  bg-opacity-75" style="line-height: 15px!important; background-color: #1877F2">{{ __('facebook')}}</span>
	@elseif($row->platform == 2)
		<span class="badge rounded-pill badge subscription-status bg-opacity-75" style="line-height: 15px!important; background-color:  #cd486b;">{{ __('instagram')}}</span>
	@elseif($row->platform == 3)
		<span class="badge rounded-pill badge subscription-status bg-opacity-75" style="line-height: 15px!important; background-color: #0072b1">{{ __('linkedin')}}</span>
	@elseif($row->platform == 4)
		<span class="badge rounded-pill badge subscription-status bg-opacity-75" style="line-height: 15px!important; background-color: #1DA1F2">{{ __('twitter')}}</span>
	@elseif($row->platform == 5)
		<span class="badge rounded-pill badge subscription-status bg-opacity-75" style="line-height: 15px!important; background-color: #000000">{{ __('threads')}}</span>
	@endif
</td>