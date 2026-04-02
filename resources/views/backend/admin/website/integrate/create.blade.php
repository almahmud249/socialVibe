<form action="{{ route('integrate.store') }}" method="POST" class="form">@csrf
    <div class="row gx-20 add-coupon">
        <input type="hidden" class="is_modal" value="0"/>
        <div class="row gx-20 add-coupon">
            <input type="hidden" value="{{ $lang }}" name="lang">
            <input type="hidden" class="is_modal" value="0"/>
            <div class="col-lg-12">
                <div class="mb-4">
                    <label for="title" class="form-label">{{ __('title') }}</label>
                    <input type="text" class="form-control rounded-2 ai_content_name" id="title"
                           name="title">
                    <div class="nk-block-des text-danger">
                        <p class="title_error error"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 input_file_div mb-4">
            <div class="mb-3">
                <label class="form-label mb-1">{{__('image') }}(30x30)</label>
                <label for="image" class="file-upload-text">
                    <p></p>
                    <span class="file-btn">{{__('choose_file') }}</span>
                </label>
                <input class="d-none file_picker" type="file" id="image"
                       name="image" accept=".jpg,.png,.svg">
                <div class="nk-block-des text-danger">
                    <p class="image_error error">{{ $errors->first('image') }}</p>
                </div>
            </div>
            <div class="selected-files d-flex flex-wrap gap-20">
                <div class="selected-files-item">
                    <img class="selected-img" src="{{ getFileLink('80x80',[]) }}"
                         alt="favicon">
                </div>
            </div>
        </div>
        <div class="d-flex gap-12 sandbox_mode_div">
            <input type="hidden" name="status" value="1">
            <label class="form-label"
                   for="status">{{ __('status') }}</label>
            <div class="setting-check">
                <input type="checkbox" value="1" id="status"
                       class="sandbox_mode" checked>
                <label for="status"></label>
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-center mt-30">
            <button type="submit" class="btn sg-btn-primary">{{__('submit') }}</button>
            @include('backend.common.loading-btn',['class' => 'btn sg-btn-primary'])
        </div>
    </div>
</form>
