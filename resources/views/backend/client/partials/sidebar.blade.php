<header class="navbar-dark-v1">
	<div class="header-position">
        <span class="sidebar-toggler">
            <i class="las la-times"></i>
        </span>
		<div class="dashboard-logo d-flex justify-content-center align-items-center py-20">
			<a class="logo" href="">
				<img src="{{ setting('admin_logo') && @is_file_exists(setting('admin_logo')['original_image']) ? get_media(setting('admin_logo')['original_image']) : get_media('images/default/logo/logo.png') }}"
				     alt="Logo">
			</a>
			<a class="logo-icon" href="">
				<img src="{{ setting('admin_mini_logo') && @is_file_exists(setting('admin_mini_logo')['original_image']) ? get_media(setting('admin_mini_logo')['original_image']) : get_media('images/default/logo/logo-mini.png') }}"
				     alt="Logo">
			</a>
		</div>
		<nav class="side-nav">
			<ul id="accordionSidebar">
				<li class="{{ menuActivation(['client/dashboard'], 'active') }}">
					<a href="{{ route('client.dashboard') }}" role="button" aria-expanded="false"
					   aria-controls="dashboard">
						<i class="las la-tachometer-alt"></i>
						<span>{{ __('dashboard') }}</span>
					</a>
				</li>
				@can('manage_post')
					<li class="{{ menuActivation(['client/posts/*','client/post/*','client/calendar'], 'active') }}">
						<a href="#manage_post" class="dropdown-icon" data-bs-toggle="collapse" role="button"
						   aria-expanded="{{ menuActivation(['client/posts/*','client/post/*','client/calendar'], 'true', 'false') }}"
						   aria-controls="manageClient">
							<i class="las la-list-alt"></i>
							<span>{{ __('manage_post') }}</span>
						</a>
						<ul class="sub-menu collapse {{ menuActivation(['client/posts/*','client/post/*','client/calendar'], 'show') }}"
						    id="manage_post" data-bs-parent="#accordionSidebar">
							<li>
								<a class="{{ menuActivation(['client/posts/index', 'client/post/create'], 'active') }}"
								   href="{{ route('client.posts.index', ['type' => 'index']) }}">{{ __('all_post') }}</a>
							</li>
							<li>
								<a class="{{ menuActivation(['client/posts/draft'], 'active')}}"
								   href="{{ route('client.posts.index', ['type' => 'draft']) }}">{{ __('draft_post') }}</a>
							</li>
							<li>
								<a class="{{ menuActivation(['client/posts/schedule'], 'active')}}"
								   href="{{ route('client.posts.index', ['type' => 'schedule']) }}">{{ __('scheduled_post') }}</a>
							</li>
							<li>
								<a class="{{ menuActivation(['client/posts/published'], 'active')}}"
								   href="{{ route('client.posts.index', ['type' => 'published']) }}">{{ __('published_post') }}</a>
							</li>
							<li>
								<a class="{{ menuActivation(['client/post/template','client/posts/template/edit/*'], 'active') }}"
								   href="{{ route('client.post.template.index') }}">{{ __('post_template') }}</a>
							</li>
							<li>
								<a class="{{ menuActivation(['client/calendar'], 'active') }}" href="{{ route('client.calendar') }}">
									{{ __('calendar') }}
								</a>
							</li>
						</ul>
					</li>
				@endcan
				@can('manage_social_profile')
					<li
							class="{{ menuActivation(['client/accounts/*', 'client/contact/import', 'client/bot-reply*', 'client/whatsapp/overview',  'client/segments', 'client/segment/edit/*', 'client/contacts', 'client/contact/create', 'client/contact/edit/*', 'client/chat-widget/list', 'client/chat-widget/create', 'client/chat-widget/edit/*', 'client/chat-widget/view/*', 'client/flow-builders', 'client/flow-builders/*', 'client/whatsapp/embedded-signup', 'client/contact-attributes/*'], 'active') }}">
						<a href="#manage_social_profile" class="dropdown-icon" data-bs-toggle="collapse" role="button"
						   aria-expanded="{{ menuActivation(['client/accounts/*', 'client/contact/import', 'client/whatsapp/overview', 'client/segments', 'client/segments-edit/*', 'client/contacts', 'client/contact/create', 'client/contact/edit/*', 'client/chat-widget/list', 'client/chat-widget/create', 'client/chat-widget/edit/*', 'client/chat-widget/view/*', 'client/flow-builders', 'client/flow-builders/*', 'client/whatsapp/embedded-signup', 'client/contact-attributes/*'], 'true', 'false') }}"
						   aria-controls="manageClient">
							<i class="las la-users-cog"></i>
							<span>{{ __('social_profile') }}</span>
						</a>
						<ul class="sub-menu collapse {{ menuActivation(['client/accounts/*', 'client/contact/import', 'client/bot-reply*', 'client/whatsapp/overview', 'client/segments', 'client/segment/edit/*', 'client/contacts', 'client/contact/create', 'client/contact/edit/*', 'client/chat-widget/list', 'client/chat-widget/create', 'client/chat-widget/edit/*', 'client/chat-widget/view/*', 'client/flow-builders', 'client/flow-builders/*', 'client/whatsapp/embedded-signup', 'client/contact-attributes/*'], 'show') }}"
						    id="manage_social_profile" data-bs-parent="#accordionSidebar">
							@if(setting('is_facebook_activated'))
								<li>
									<a class="{{ menuActivation(['client/accounts/*'], 'active') && request('plat_form') == 'facebook' ? 'active' : '' }}"
									   href="{{ route('client.accounts.index', ['plat_form' => 'facebook']) }}">{{ __('facebook') }}</a>
								</li>
							@endif
							@if(setting('is_instagram_activated'))
								<li>
									<a class="{{ menuActivation(['client/accounts/*'], 'active') && request('plat_form') == 'instagram' ? 'active' : '' }}"
									   href="{{ route('client.accounts.index', ['plat_form' => 'instagram']) }}">{{ __('instagram') }}</a>
								</li>
							@endif
							@if(setting('is_linkedin_activated'))
								<li>
									<a class="{{ menuActivation(['client/accounts/*'], 'active') && request('plat_form') == 'linkedin' ? 'active' : '' }}"
									   href="{{ route('client.accounts.index', ['plat_form' => 'linkedin']) }}">{{ __('linkedin') }}</a>
								</li>
							@endif
							@if(setting('is_x_activated'))
								<li>
									<a class="{{ menuActivation(['client/accounts/*'], 'active') && request('plat_form') == 'twitter' ? 'active' : '' }}"
									   href="{{ route('client.accounts.index', ['plat_form' => 'twitter']) }}">{{ __('X/Twitter') }}</a>
								</li>
							@endif
							@if(setting('is_tiktok_activated'))
								<li>
									<a class="{{ menuActivation(['client/accounts/*'], 'active') && request('plat_form') == 'tiktok' ? 'active' : '' }}"
									   href="{{ route('client.accounts.index', ['plat_form' => 'tiktok']) }}">{{ __('tiktok') }}</a>
								</li>
							@endif
							@if(setting('is_threads_activated'))
								<li>
									<a class="{{ menuActivation(['client/accounts/*'], 'active') && request('plat_form') == 'threads' ? 'active' : '' }}"
									   href="{{ route('client.accounts.index', ['plat_form' => 'threads']) }}">{{ __('threads') }}</a>
								</li>
							@endif

						</ul>
					</li>
				@endcan

				@can('manage_ticket')
					<li class="{{ menuActivation(['client/tickets', 'client/tickets/*'], 'active') }}">
						<a href="{{ route('client.tickets.index') }}">
							<i class="las la-ticket-alt"></i>
							<span>{{ __('support_ticket') }}</span>
						</a>

					</li>
				@endcan

				@can('manage_setting')
					<li class="{{ menuActivation(['client/ai-writer','client/template*', 'client/ai-writer-setting'], 'active') }}">
						<a href="#ai" class="dropdown-icon" data-bs-toggle="collapse" role="button"
						   aria-expanded="{{ menuActivation(['client/ai-writer','client/template*','template/create', 'client/ai-writer-setting'], 'true', 'false') }}"
						   aria-controls="ai">
							<i class="las la-robot"></i>
							<span>{{ __('ai_assistent') }}</span>
						</a>
						<ul class="sub-menu collapse {{ menuActivation(['client/ai-writer','client/template*','client/template/create', 'client/ai-writer-setting'], 'show') }}"
						    id="ai" data-bs-parent="#ai">
							<li>
								<a class="{{ menuActivation('client/template*','active') }}"
								   href="{{ route('client.templates.index') }}">
									<span>{{ __('ai_template') }}</span>
								</a>
							</li>
							<li>
								<a class="{{ menuActivation('client/ai-writer', 'active') }}"
								   href="{{ route('client.ai.writer') }}">
									<span>{{ __('ai_writer') }}</span>
								</a>
							</li>
							<li><a class="{{ menuActivation('client/ai-writer-setting', 'active') }}"
							       href="{{ route('client.ai_writer.setting') }}">{{ __('ai_config') }}</a></li>
						</ul>
					</li>
				@else
					<li class="{{ menuActivation(['client/ai-writer'], 'active') }}">
						<a href="{{ route('client.ai.writer') }}">
							<i class="las la-robot"></i>
							<span>{{ __('ai_writer') }}</span>
						</a>

					</li>
				@endcan

				@can('manage_setting')
					<li
							class="{{ menuActivation(['client/whatsapp-settings', 'client/telegram-settings', 'client/general-settings'], 'active') }}">
						<a href="#setting" class="dropdown-icon" data-bs-toggle="collapse" role="button"
						   aria-expanded="{{ menuActivation(['client/whatsapp-settings', 'client/telegram-settings', 'client/general-settings'], 'true', 'false') }}"
						   aria-controls="setting">
							<i class="las la-tools"></i>
							<span>{{ __('setting') }}</span>
						</a>
						<ul class="sub-menu collapse {{ menuActivation(['client/whatsapp-settings', 'client/telegram-settings', 'client/general-settings'], 'show') }}"
						    id="setting" data-bs-parent="#accordionSidebar">
							<li>
								<a class="{{ menuActivation(['client/general-settings'], 'active') }}"
								   href="{{ route('client.general.settings') }}">{{ __('general_setting') }}</a>
							</li>
						</ul>
					</li>
				@endcan
				@can('manage_api')
					<li class="{{ menuActivation(['client/api'], 'active') }}">
						<a href="{{ route('client.settings.api') }}">

							<i class="las la-link"></i>
							<span>{{ __('api') }}</span>
						</a>
					</li>
				@endcan
			</ul>
		</nav>
	</div>
</header>
