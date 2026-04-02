@extends('backend.layouts.master')
@section('title', __('ai_writter_setting'))
@section('content')
	<div class="row justify-content-md-center">
		<div class="col col-lg-6 col-md-9">
			<h3 class="section-title">{{ __('ai_assistant_setting') }}</h3>
			<div class="bg-white redious-border p-20 p-sm-30">
				<form action="{{ route('client.ai.writer') }}" class="form-validate form" method="POST">
					@csrf
					<input type="hidden" class="is_modal" value="0"/>
					<div class="col-12">
						<div class="d-flex flex-wrap">
							<div class="custom-radio me-40 mb-20">
								<label>
									<input type="radio" value="disable"
									       name="default_ai" {{ @Auth::user()->client->default_ai == 'disable' ? 'checked' : '' }}>
									<span class="ps-30">{{ __('disable') }}</span>
								</label>
							</div>

							<div class="custom-radio me-40 mb-20">
								<label>
									<input type="radio" name="default_ai"
									       value="openai" {{ @Auth::user()->client->default_ai == 'openai' ? 'checked' : '' }}>
									<span class="ps-30">{{ __('openai') }}</span>
								</label>
							</div>

							<div class="custom-radio me-40 mb-20">
								<label>
									<input type="radio" name="default_ai"
									       value="deepseek" {{ @Auth::user()->client->default_ai == 'deepseek' ? 'checked' : '' }}>
									<span class="ps-30">{{ __('deepseek') }}</span>
								</label>
							</div>
						</div>

						<div class="mb-4 input_group {{  @Auth::user()->client->default_ai != 'disable' ? 'd-none' : '' }}">
							<div class="mb-4 openai_div {{  @Auth::user()->client->default_ai != 'openai' ? 'd-none' : '' }}">
								<div class="d-flex justify-content-between">
									<label for="secret_key" class="form-label">{{ __('openai_api_key') }} <span
												class="text-danger">*</span></label>
									<a href="https://platform.openai.com/account/api-keys"
									   target="_blank">{{ __('click_here_to_get_the_key') }}</a>
								</div>
								<input type="text" class="form-control rounded-2" id="secret_key"
								       name="openai_api_key"
								       value="{{ isDemoMode() ? '******************' : @Auth::user()->client->openai_api_key }}"
								       placeholder="{{ __('enter_secret_key') }}">
								<div class="nk-block-des text-danger">
									<p class="secret_key_error error">{{ $errors->first('secret_key') }}</p>
								</div>
							</div>
							<div class="mb-4 deepseek_div {{  @Auth::user()->client->default_ai != 'deepseek' ? 'd-none' : '' }}">
								<div class="d-flex justify-content-between">
									<label for="secret_key" class="form-label">{{ __('deepseek_api_key') }} <span
												class="text-danger">*</span></label>
									<a href="https://platform.deepseek.com/api_keys"
									   target="_blank">{{ __('click_here_to_get_the_key') }}</a>
								</div>
								<input type="text" class="form-control rounded-2" id="secret_key"
								       name="deepseek_api_key"
								       value="{{ isDemoMode() ? '******************' : @Auth::user()->client->deepseek_api_key }}"
								       placeholder="{{ __('deepseek_api_key') }}">
								<div class="nk-block-des text-danger">
									<p class="secret_key_error error">{{ $errors->first('deepseek_api_key') }}</p>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="mb-4">
									<label for="default_language"
									       class="form-label">{{__('default_language') }} <span
												class="text-danger">*</span></label>
									<select class="form-select rounded-0 mb-3 with_search"
									        aria-label=".form-select-lg example" id="default_language"
									        name="default_language"
									        style="width: 100%">
										<option value="">{{__('select_language')}}</option>
										<option value="Afrikaans" {{ old('default_language', @Auth::user()->client->default_language) == 'Afrikaans' ? 'selected' : '' }}>{{ __('Afrikaans') }}</option>
										<option value="Albanian" {{ old('default_language', @Auth::user()->client->default_language) == 'Albanian' ? 'selected' : '' }}>{{ __('Albanian') }}</option>
										<option value="Amharic" {{ old('default_language', @Auth::user()->client->default_language) == 'Amharic' ? 'selected' : '' }}>{{ __('Amharic') }}</option>
										<option value="Arabic" {{ old('default_language', @Auth::user()->client->default_language) == 'Arabic' ? 'selected' : '' }}>{{ __('Arabic') }}</option>
										<option value="Armenian" {{ old('default_language', @Auth::user()->client->default_language) == 'Armenian' ? 'selected' : '' }}>{{ __('Armenian') }}</option>
										<option value="Azerbaijani" {{ old('default_language', @Auth::user()->client->default_language) == 'Azerbaijani' ? 'selected' : '' }}>{{ __('Azerbaijani') }}</option>
										<option value="Basque" {{ old('default_language', @Auth::user()->client->default_language) == 'Basque' ? 'selected' : '' }}>{{ __('Basque') }}</option>
										<option value="Belarusian" {{ old('default_language', @Auth::user()->client->default_language) == 'Belarusian' ? 'selected' : '' }}>{{ __('Belarusian') }}</option>
										<option value="Bengali" {{ old('default_language', @Auth::user()->client->default_language) == 'Bengali' ? 'selected' : '' }}>{{ __('Bengali') }}</option>
										<option value="Bosnian" {{ old('default_language', @Auth::user()->client->default_language) == 'Bosnian' ? 'selected' : '' }}>{{ __('Bosnian') }}</option>
										<option value="Bulgarian" {{ old('default_language', @Auth::user()->client->default_language) == 'Bulgarian' ? 'selected' : '' }}>{{ __('Bulgarian') }}</option>
										<option value="Catalan" {{ old('default_language', @Auth::user()->client->default_language) == 'Catalan' ? 'selected' : '' }}>{{ __('Catalan') }}</option>
										<option value="Cebuano" {{ old('default_language', @Auth::user()->client->default_language) == 'Cebuano' ? 'selected' : '' }}>{{ __('Cebuano') }}</option>
										<option value="Chichewa" {{ old('default_language', @Auth::user()->client->default_language) == 'Chichewa' ? 'selected' : '' }}>{{ __('Chichewa') }}</option>
										<option value="Chinese" {{ old('default_language', @Auth::user()->client->default_language) == 'Chinese' ? 'selected' : '' }}>{{ __('Chinese') }}</option>
										<option value="Chinese (Simplified)" {{ old('default_language', @Auth::user()->client->default_language) == 'Chinese (Simplified)' ? 'selected' : '' }}>{{ __('Chinese (Simplified)') }}</option>
										<option value="Chinese (Traditional)" {{ old('default_language', @Auth::user()->client->default_language) == 'Chinese (Traditional)' ? 'selected' : '' }}>{{ __('Chinese (Traditional)') }}</option>
										<option value="Corsican" {{ old('default_language', @Auth::user()->client->default_language) == 'Corsican' ? 'selected' : '' }}>{{ __('Corsican') }}</option>
										<option value="Croatian" {{ old('default_language', @Auth::user()->client->default_language) == 'Croatian' ? 'selected' : '' }}>{{ __('Croatian') }}</option>
										<option value="Czech" {{ old('default_language', @Auth::user()->client->default_language) == 'Czech' ? 'selected' : '' }}>{{ __('Czech') }}</option>
										<option value="Danish" {{ old('default_language', @Auth::user()->client->default_language) == 'Danish' ? 'selected' : '' }}>{{ __('Danish') }}</option>
										<option value="Dutch" {{ old('default_language', @Auth::user()->client->default_language) == 'Dutch' ? 'selected' : '' }}>{{ __('Dutch') }}</option>
										<option value="English" {{ old('default_language', @Auth::user()->client->default_language) == 'English' ? 'selected' : '' }}>{{ __('English') }}</option>
										<option value="Esperanto" {{ old('default_language', @Auth::user()->client->default_language) == 'Esperanto' ? 'selected' : '' }}>{{ __('Esperanto') }}</option>
										<option value="Estonian" {{ old('default_language', @Auth::user()->client->default_language) == 'Estonian' ? 'selected' : '' }}>{{ __('Estonian') }}</option>
										<option value="Filipino" {{ old('default_language', @Auth::user()->client->default_language) == 'Filipino' ? 'selected' : '' }}>{{ __('Filipino') }}</option>
										<option value="Finnish" {{ old('default_language', @Auth::user()->client->default_language) == 'Finnish' ? 'selected' : '' }}>{{ __('Finnish') }}</option>
										<option value="French" {{ old('default_language', @Auth::user()->client->default_language) == 'French' ? 'selected' : '' }}>{{ __('French') }}</option>
										<option value="Frisian" {{ old('default_language', @Auth::user()->client->default_language) == 'Frisian' ? 'selected' : '' }}>{{ __('Frisian') }}</option>
										<option value="Galician" {{ old('default_language', @Auth::user()->client->default_language) == 'Galician' ? 'selected' : '' }}>{{ __('Galician') }}</option>
										<option value="Georgian" {{ old('default_language', @Auth::user()->client->default_language) == 'Georgian' ? 'selected' : '' }}>{{ __('Georgian') }}</option>
										<option value="German" {{ old('default_language', @Auth::user()->client->default_language) == 'German' ? 'selected' : '' }}>{{ __('German') }}</option>
										<option value="Greek" {{ old('default_language', @Auth::user()->client->default_language) == 'Greek' ? 'selected' : '' }}>{{ __('Greek') }}</option>
										<option value="Gujarati" {{ old('default_language', @Auth::user()->client->default_language) == 'Gujarati' ? 'selected' : '' }}>{{ __('Gujarati') }}</option>
										<option value="Haitian Creole" {{ old('default_language', @Auth::user()->client->default_language) == 'Haitian Creole' ? 'selected' : '' }}>{{ __('Haitian Creole') }}</option>
										<option value="Hausa" {{ old('default_language', @Auth::user()->client->default_language) == 'Hausa' ? 'selected' : '' }}>{{ __('Hausa') }}</option>
										<option value="Hawaiian" {{ old('default_language', @Auth::user()->client->default_language) == 'Hawaiian' ? 'selected' : '' }}>{{ __('Hawaiian') }}</option>
										<option value="Hebrew" {{ old('default_language', @Auth::user()->client->default_language) == 'Hebrew' ? 'selected' : '' }}>{{ __('Hebrew') }}</option>
										<option value="Hindi" {{ old('default_language', @Auth::user()->client->default_language) == 'Hindi' ? 'selected' : '' }}>{{ __('Hindi') }}</option>
										<option value="Hmong" {{ old('default_language', @Auth::user()->client->default_language) == 'Hmong' ? 'selected' : '' }}>{{ __('Hmong') }}</option>
										<option value="Hungarian" {{ old('default_language', @Auth::user()->client->default_language) == 'Hungarian' ? 'selected' : '' }}>{{ __('Hungarian') }}</option>
										<option value="Icelandic" {{ old('default_language', @Auth::user()->client->default_language) == 'Icelandic' ? 'selected' : '' }}>{{ __('Icelandic') }}</option>
										<option value="Igbo" {{ old('default_language', @Auth::user()->client->default_language) == 'Igbo' ? 'selected' : '' }}>{{ __('Igbo') }}</option>
										<option value="Indonesian" {{ old('default_language', @Auth::user()->client->default_language) == 'Indonesian' ? 'selected' : '' }}>{{ __('Indonesian') }}</option>
										<option value="Irish" {{ old('default_language', @Auth::user()->client->default_language) == 'Irish' ? 'selected' : '' }}>{{ __('Irish') }}</option>
										<option value="Italian" {{ old('default_language', @Auth::user()->client->default_language) == 'Italian' ? 'selected' : '' }}>{{ __('Italian') }}</option>
										<option value="Japanese" {{ old('default_language', @Auth::user()->client->default_language) == 'Japanese' ? 'selected' : '' }}>{{ __('Japanese') }}</option>
										<option value="Javanese" {{ old('default_language', @Auth::user()->client->default_language) == 'Javanese' ? 'selected' : '' }}>{{ __('Javanese') }}</option>
										<option value="Kannada" {{ old('default_language', @Auth::user()->client->default_language) == 'Kannada' ? 'selected' : '' }}>{{ __('Kannada') }}</option>
										<option value="Kazakh" {{ old('default_language', @Auth::user()->client->default_language) == 'Kazakh' ? 'selected' : '' }}>{{ __('Kazakh') }}</option>
										<option value="Khmer" {{ old('default_language', @Auth::user()->client->default_language) == 'Khmer' ? 'selected' : '' }}>{{ __('Khmer') }}</option>
										<option value="Kinyarwanda" {{ old('default_language', @Auth::user()->client->default_language) == 'Kinyarwanda' ? 'selected' : '' }}>{{ __('Kinyarwanda') }}</option>
										<option value="Korean" {{ old('default_language', @Auth::user()->client->default_language) == 'Korean' ? 'selected' : '' }}>{{ __('Korean') }}</option>
										<option value="Kurdish (Kurmanji)" {{ old('default_language', @Auth::user()->client->default_language) == 'Kurdish (Kurmanji)' ? 'selected' : '' }}>{{ __('Kurdish (Kurmanji)') }}</option>
										<option value="Kyrgyz" {{ old('default_language', @Auth::user()->client->default_language) == 'Kyrgyz' ? 'selected' : '' }}>{{ __('Kyrgyz') }}</option>
										<option value="Lao" {{ old('default_language', @Auth::user()->client->default_language) == 'Lao' ? 'selected' : '' }}>{{ __('Lao') }}</option>
										<option value="Latin" {{ old('default_language', @Auth::user()->client->default_language) == 'Latin' ? 'selected' : '' }}>{{ __('Latin') }}</option>
										<option value="Latvian" {{ old('default_language', @Auth::user()->client->default_language) == 'Latvian' ? 'selected' : '' }}>{{ __('Latvian') }}</option>
										<option value="Lithuanian" {{ old('default_language', @Auth::user()->client->default_language) == 'Lithuanian' ? 'selected' : '' }}>{{ __('Lithuanian') }}</option>
										<option value="Luxembourgish" {{ old('default_language', @Auth::user()->client->default_language) == 'Luxembourgish' ? 'selected' : '' }}>{{ __('Luxembourgish') }}</option>
										<option value="Macedonian" {{ old('default_language', @Auth::user()->client->default_language) == 'Macedonian' ? 'selected' : '' }}>{{ __('Macedonian') }}</option>
										<option value="Malagasy" {{ old('default_language', @Auth::user()->client->default_language) == 'Malagasy' ? 'selected' : '' }}>{{ __('Malagasy') }}</option>
										<option value="Malay" {{ old('default_language', @Auth::user()->client->default_language) == 'Malay' ? 'selected' : '' }}>{{ __('Malay') }}</option>
										<option value="Malayalam" {{ old('default_language', @Auth::user()->client->default_language) == 'Malayalam' ? 'selected' : '' }}>{{ __('Malayalam') }}</option>
										<option value="Maltese" {{ old('default_language', @Auth::user()->client->default_language) == 'Maltese' ? 'selected' : '' }}>{{ __('Maltese') }}</option>
										<option value="Maori" {{ old('default_language', @Auth::user()->client->default_language) == 'Maori' ? 'selected' : '' }}>{{ __('Maori') }}</option>
										<option value="Marathi" {{ old('default_language', @Auth::user()->client->default_language) == 'Marathi' ? 'selected' : '' }}>{{ __('Marathi') }}</option>
										<option value="Mongolian" {{ old('default_language', @Auth::user()->client->default_language) == 'Mongolian' ? 'selected' : '' }}>{{ __('Mongolian') }}</option>
										<option value="Myanmar (Burmese)" {{ old('default_language', @Auth::user()->client->default_language) == 'Myanmar (Burmese)' ? 'selected' : '' }}>{{ __('Myanmar (Burmese)') }}</option>
										<option value="Nepali" {{ old('default_language', @Auth::user()->client->default_language) == 'Nepali' ? 'selected' : '' }}>{{ __('Nepali') }}</option>
										<option value="Norwegian" {{ old('default_language', @Auth::user()->client->default_language) == 'Norwegian' ? 'selected' : '' }}>{{ __('Norwegian') }}</option>
										<option value="Odia (Oriya)" {{ old('default_language', @Auth::user()->client->default_language) == 'Odia (Oriya)' ? 'selected' : '' }}>{{ __('Odia (Oriya)') }}</option>
										<option value="Pashto" {{ old('default_language', @Auth::user()->client->default_language) == 'Pashto' ? 'selected' : '' }}>{{ __('Pashto') }}</option>
										<option value="Persian" {{ old('default_language', @Auth::user()->client->default_language) == 'Persian' ? 'selected' : '' }}>{{ __('Persian') }}</option>
										<option value="Polish" {{ old('default_language', @Auth::user()->client->default_language) == 'Polish' ? 'selected' : '' }}>{{ __('Polish') }}</option>
										<option value="Portuguese" {{ old('default_language', @Auth::user()->client->default_language) == 'Portuguese' ? 'selected' : '' }}>{{ __('Portuguese') }}</option>
										<option value="Punjabi" {{ old('default_language', @Auth::user()->client->default_language) == 'Punjabi' ? 'selected' : '' }}>{{ __('Punjabi') }}</option>
										<option value="Romanian" {{ old('default_language', @Auth::user()->client->default_language) == 'Romanian' ? 'selected' : '' }}>{{ __('Romanian') }}</option>
										<option value="Russian" {{ old('default_language', @Auth::user()->client->default_language) == 'Russian' ? 'selected' : '' }}>{{ __('Russian') }}</option>
										<option value="Samoan" {{ old('default_language', @Auth::user()->client->default_language) == 'Samoan' ? 'selected' : '' }}>{{ __('Samoan') }}</option>
										<option value="Scots Gaelic" {{ old('default_language', @Auth::user()->client->default_language) == 'Scots Gaelic' ? 'selected' : '' }}>{{ __('Scots Gaelic') }}</option>
										<option value="Serbian" {{ old('default_language', @Auth::user()->client->default_language) == 'Serbian' ? 'selected' : '' }}>{{ __('Serbian') }}</option>
										<option value="Sesotho" {{ old('default_language', @Auth::user()->client->default_language) == 'Sesotho' ? 'selected' : '' }}>{{ __('Sesotho') }}</option>
										<option value="Shona" {{ old('default_language', @Auth::user()->client->default_language) == 'Shona' ? 'selected' : '' }}>{{ __('Shona') }}</option>
										<option value="Sindhi" {{ old('default_language', @Auth::user()->client->default_language) == 'Sindhi' ? 'selected' : '' }}>{{ __('Sindhi') }}</option>
										<option value="Sinhala" {{ old('default_language', @Auth::user()->client->default_language) == 'Sinhala' ? 'selected' : '' }}>{{ __('Sinhala') }}</option>
										<option value="Slovak" {{ old('default_language', @Auth::user()->client->default_language) == 'Slovak' ? 'selected' : '' }}>{{ __('Slovak') }}</option>
										<option value="Slovenian" {{ old('default_language', @Auth::user()->client->default_language) == 'Slovenian' ? 'selected' : '' }}>{{ __('Slovenian') }}</option>
										<option value="Somali" {{ old('default_language', @Auth::user()->client->default_language) == 'Somali' ? 'selected' : '' }}>{{ __('Somali') }}</option>
										<option value="Spanish" {{ old('default_language', @Auth::user()->client->default_language) == 'Spanish' ? 'selected' : '' }}>{{ __('Spanish') }}</option>
										<option value="Sundanese" {{ old('default_language', @Auth::user()->client->default_language) == 'Sundanese' ? 'selected' : '' }}>{{ __('Sundanese') }}</option>
										<option value="Swahili" {{ old('default_language', @Auth::user()->client->default_language) == 'Swahili' ? 'selected' : '' }}>{{ __('Swahili') }}</option>
										<option value="Swedish" {{ old('default_language', @Auth::user()->client->default_language) == 'Swedish' ? 'selected' : '' }}>{{ __('Swedish') }}</option>
										<option value="Tajik" {{ old('default_language', @Auth::user()->client->default_language) == 'Tajik' ? 'selected' : '' }}>{{ __('Tajik') }}</option>
										<option value="Tamil" {{ old('default_language', @Auth::user()->client->default_language) == 'Tamil' ? 'selected' : '' }}>{{ __('Tamil') }}</option>
										<option value="Tatar" {{ old('default_language', @Auth::user()->client->default_language) == 'Tatar' ? 'selected' : '' }}>{{ __('Tatar') }}</option>
										<option value="Telugu" {{ old('default_language', @Auth::user()->client->default_language) == 'Telugu' ? 'selected' : '' }}>{{ __('Telugu') }}</option>
										<option value="Thai" {{ old('default_language', @Auth::user()->client->default_language) == 'Thai' ? 'selected' : '' }}>{{ __('Thai') }}</option>
										<option value="Turkish" {{ old('default_language', @Auth::user()->client->default_language) == 'Turkish' ? 'selected' : '' }}>{{ __('Turkish') }}</option>
										<option value="Turkmen" {{ old('default_language', @Auth::user()->client->default_language) == 'Turkmen' ? 'selected' : '' }}>{{ __('Turkmen') }}</option>
										<option value="Ukrainian" {{ old('default_language', @Auth::user()->client->default_language) == 'Ukrainian' ? 'selected' : '' }}>{{ __('Ukrainian') }}</option>
										<option value="Urdu" {{ old('default_language', @Auth::user()->client->default_language) == 'Urdu' ? 'selected' : '' }}>{{ __('Urdu') }}</option>
										<option value="Uyghur" {{ old('default_language', @Auth::user()->client->default_language) == 'Uyghur' ? 'selected' : '' }}>{{ __('Uyghur') }}</option>
										<option value="Uzbek" {{ old('default_language', @Auth::user()->client->default_language) == 'Uzbek' ? 'selected' : '' }}>{{ __('Uzbek') }}</option>
										<option value="Vietnamese" {{ old('default_language', @Auth::user()->client->default_language) == 'Vietnamese' ? 'selected' : '' }}>{{ __('Vietnamese') }}</option>
										<option value="Welsh" {{ old('default_language', @Auth::user()->client->default_language) == 'Welsh' ? 'selected' : '' }}>{{ __('Welsh') }}</option>
										<option value="Xhosa" {{ old('default_language', @Auth::user()->client->default_language) == 'Xhosa' ? 'selected' : '' }}>{{ __('Xhosa') }}</option>
										<option value="Yiddish" {{ old('default_language', @Auth::user()->client->default_language) == 'Yiddish' ? 'selected' : '' }}>{{ __('Yiddish') }}</option>
										<option value="Yoruba" {{ old('default_language', @Auth::user()->client->default_language) == 'Yoruba' ? 'selected' : '' }}>{{ __('Yoruba') }}</option>
										<option value="Zulu" {{ old('default_language', @Auth::user()->client->default_language) == 'Zulu' ? 'selected' : '' }}>{{ __('Zulu') }}</option>
									</select>
									<div class="nk-block-des text-danger">
										<p class="default_language_error error"></p>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="mb-4">
									<label for="default_length"
									       class="form-label">{{__('default_length') }} <span
												class="text-danger">*</span></label>
									<input type="number" class="form-control rounded-2" id="default_length"
									       name="default_length" value="{{ @Auth::user()->client->default_length }}" placeholder="{{ __('123') }}">
									<div class="nk-block-des text-danger">
										<p class="default_length_error error"></p>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="mb-4">
									<label for="default_tone"
									       class="form-label">{{__('default_tone') }} <span
												class="text-danger">*</span></label>
									<select class="form-select rounded-0 mb-3 with_search"
									        aria-label=".form-select-lg example" id="default_tone" name="default_tone"
									        style="width: 100%">
										<option value="Friendly" {{ @Auth::user()->client->default_tone == 'Friendly' ? 'selected' : '' }}>Friendly</option>
										<option value="Luxury" {{ @Auth::user()->client->default_tone == 'Luxury' ? 'selected' : '' }}>Luxury</option>
										<option value="Relaxed" {{ @Auth::user()->client->default_tone == 'Relaxed' ? 'selected' : '' }}>Relaxed</option>
										<option value="Professional" {{ @Auth::user()->client->default_tone == 'Professional' ? 'selected' : '' }}>Professional</option>
										<option value="Casual" {{ @Auth::user()->client->default_tone == 'Casual' ? 'selected' : '' }}>Casual</option>
										<option value="Excited" {{ @Auth::user()->client->default_tone == 'Excited' ? 'selected' : '' }}>Excited</option>
										<option value="Bold" {{ @Auth::user()->client->default_tone == 'Bold' ? 'selected' : '' }}>Bold</option>
										<option value="Masculine" {{ @Auth::user()->client->default_tone == 'Masculine' ? 'selected' : '' }}>Masculine</option>
										<option value="Dramatic" {{ @Auth::user()->client->default_tone == 'Dramatic' ? 'selected' : '' }}>Dramatic</option>
									</select>
									<div class="nk-block-des text-danger">
										<p class="default_tone_error error"></p>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="mb-4">
									<label for="default_level"
									       class="form-label">{{__('default_level') }} <span
												class="text-danger">*</span></label>
									<select class="form-select rounded-0 mb-3 without_search"
									        aria-label=".form-select-lg example" id="default_level" name="default_level"
									        style="width: 100%">
										<option value="high" {{ @Auth::user()->client->default_level == 'high' ? 'selected' : '' }}>{{__('high')}}</option>
										<option value="medium" {{ @Auth::user()->client->default_level == 'medium' ? 'selected' : '' }}>{{__('medium')}}</option>
										<option value="low" {{ @Auth::user()->client->default_level == 'low' ? 'selected' : '' }}>{{__('low')}}</option>
									</select>
									<div class="nk-block-des text-danger">
										<p class="title_error error"></p>
									</div>
								</div>
							</div>
						</div>

						<div class="d-flex justify-content-end align-items-center mt-30">
							<button type="submit" class="btn sg-btn-primary">{{ __('submit') }}</button>
							@include('backend.common.loading-btn', ['class' => 'btn sg-btn-primary'])
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script>
        $(document).ready(function () {
            $('.ai_reply_status').on('change', function () {
                var isChecked = $(this).is(':checked') ? 1 : 0;
                var updateUrl = $(this).data('url');
                var field = $(this).data('field_for');
                $.ajax({
                    url: updateUrl,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        field: field,
                        value: isChecked
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('An error occurred: ' + xhr.responseText);
                    }
                });
            });
        });
	</script>
	<script>
        $(document).ready(function () {
            function toggleAIDiv() {
                let provider = $('input[name="default_ai"]:checked').val();

                if (provider === 'disable' || provider === undefined || provider === null || provider === '') {
                    $('.input_group').addClass('d-none');
                } else {
                    $('.input_group').removeClass('d-none');
                    $('.openai_div, .deepseek_div').addClass('d-none');
                    $('.' + provider + '_div').removeClass('d-none');
                }
            }

            toggleAIDiv();
            $(document).on('change', 'input[name="default_ai"]', function () {
                toggleAIDiv();
            });
        });

	</script>
@endpush