<section class="blog blog-admin">
    <header class="blog-header">
        <h1>{{ __('profile.admin.profile') }}</h1>
        <button class="blog-button" type="submit" form="profile-form">{{ __('profile.admin.save') }}</button>
        <p>{{ __('profile.admin.profile_intro') }}</p>
    </header>
    @include('blog.toolbar')
    @include('blog.messages')
    <form id="profile-form" class="blog-form blog-editor profile-editor" method="POST" enctype="multipart/form-data"
        action="{{ route('admin.profile.update', ['lang' => app()->getLocale()]) }}">
        @csrf @method('PUT')
        @foreach ([
            'presentation' => ['role' => 'role', 'intro' => 'intro_text', 'availability' => 'availability'],
            'contributions' => ['contributions_title' => 'heading', 'offer1_title' => 'heading', 'offer1_body' => 'body', 'offer2_title' => 'heading', 'offer2_body' => 'body', 'offer3_title' => 'heading', 'offer3_body' => 'body'],
            'biography' => ['bio_title' => 'heading', 'bio1' => 'bio1', 'bio2' => 'bio2'],
            'research' => ['research_title' => 'heading', 'research_body' => 'body', 'research_link' => 'link_text'],
            'photo' => ['photo_alt' => 'photo_alt'],
            'seo' => ['seo_title' => 'seo_title', 'seo_description' => 'seo_description', 'about_seo_title' => 'seo_title', 'about_seo_description' => 'seo_description'],
        ] as $group => $fields)
            <details class="profile-editor__section" @if ($group === 'presentation' || $errors->any()) open @endif>
                <summary>{{ __('profile.admin.'.$group) }}</summary>
                <div class="profile-editor__section-content">
                    @if ($group === 'photo')
                        @if ($siteProfile->photoUrl())
                            <img class="profile-editor__photo" src="{{ $siteProfile->photoUrl() }}" alt="{{ $siteProfile->text('photo_alt') }}" width="240" height="300">
                        @else
                            <p>{{ __('profile.admin.no_photo') }}</p>
                        @endif
                        <div class="blog-field">
                            <label for="photo">{{ __('profile.admin.photo_upload') }}</label>
                            <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/webp"
                                aria-describedby="photo-help @error('photo') photo-error @enderror" @error('photo') aria-invalid="true" @enderror>
                            <p id="photo-help">{{ __('profile.admin.photo_help') }}</p>
                            @error('photo')<p id="photo-error">{{ $message }}</p>@enderror
                        </div>
                        <input type="hidden" name="photo_enabled" value="0">
                        <label class="blog-check"><input type="checkbox" name="photo_enabled" value="1" @checked(old('photo_enabled', $siteProfile->photo_enabled))>{{ __('profile.admin.photo_enabled') }}</label>
                    @elseif ($group === 'contributions')
                        <p>{{ __('profile.admin.proof_help') }}</p>
                        @foreach (range(1, 3) as $index)
                            @php
                                $field = "offer{$index}_project_ids";
                                $selectedProjects = session()->hasOldInput()
                                    ? old($field, [])
                                    : $siteProfile->proofProjects->where('pivot.area', $index)->modelKeys();
                                $proofErrors = array_merge($errors->get($field), ...array_values($errors->get($field.'.*')));
                            @endphp
                            <fieldset class="blog-field profile-editor__projects" @if ($proofErrors) aria-describedby="{{ $field }}-error" @endif>
                                <legend>{{ __('profile.admin.proof') }}: {{ $siteProfile->text("offer{$index}_title") }}</legend>
                                <div class="profile-editor__project-list">
                                    @forelse ($proofProjects as $project)
                                        <label class="blog-check">
                                            <input type="checkbox" name="{{ $field }}[]" value="{{ $project->id }}"
                                                @checked(in_array($project->id, (array) $selectedProjects))
                                                @if ($proofErrors) aria-invalid="true" aria-describedby="{{ $field }}-error" @endif>
                                            <span>{{ $project->localized('title') }} · {{ $project->is_published ? __('blog.published') : __('blog.draft') }}</span>
                                        </label>
                                    @empty
                                        <p>{{ __('profile.admin.no_proof') }}</p>
                                    @endforelse
                                </div>
                                @if ($proofErrors)<p id="{{ $field }}-error">{{ implode(' ', $proofErrors) }}</p>@endif
                            </fieldset>
                        @endforeach
                    @elseif ($group === 'research')
                        <p>{{ __('profile.admin.research_help') }}</p>
                        <input type="hidden" name="research_enabled" value="0">
                        <label class="blog-check"><input type="checkbox" name="research_enabled" value="1" @checked(old('research_enabled', $siteProfile->research_enabled))>{{ __('profile.admin.research_enabled') }}</label>
                        <div class="blog-field">
                            <label for="research_route">{{ __('profile.admin.link_destination') }}</label>
                            <select id="research_route" name="research_route" @error('research_route') aria-invalid="true" aria-describedby="research-route-error" @enderror>
                                @foreach (['about' => 'profile.admin.about_seo', 'projects' => 'portfolio.projects', 'blog' => 'blog.dashboard', 'contact' => 'profile.admin.contact'] as $route => $label)
                                    <option value="{{ $route }}" @selected(old('research_route', $siteProfile->research_route) === $route)>{{ __($label) }}</option>
                                @endforeach
                            </select>
                            @error('research_route')<p id="research-route-error">{{ $message }}</p>@enderror
                        </div>
                    @elseif ($group === 'seo')
                        <p>{{ __('profile.admin.seo_help') }}</p>
                    @endif
                    @include('portfolio.profile-translations')
                </div>
            </details>
        @endforeach
        <div class="blog-save">
            <button class="blog-button blog-button--secondary" type="submit">{{ __('profile.admin.save') }}</button>
            <a class="blog-link" href="{{ route('home', ['lang' => app()->getLocale()]) }}" target="_blank" rel="noopener">{{ __('profile.admin.view_site') }}</a>
        </div>
    </form>
    <div class="profile-editor__deletions">
        @foreach (['photo' => $siteProfile->photo_enabled || $siteProfile->photo_path, 'research' => $siteProfile->research_enabled || $siteProfile->text('research_title')] as $element => $exists)
            @if ($exists)
                <details class="blog-seo">
                    <summary>{{ __('profile.admin.delete_'.$element) }}</summary>
                    <form class="blog-form blog-delete" method="POST" action="{{ route('admin.profile.'.$element.'.destroy', ['lang' => app()->getLocale()]) }}">
                        @csrf @method('DELETE')
                        <label class="blog-check"><input type="checkbox" name="confirm_delete" value="1" required>{{ __('profile.admin.delete_confirm') }}</label>
                        <button class="blog-button blog-button--secondary" type="submit">{{ __('profile.admin.delete_'.$element) }}</button>
                    </form>
                </details>
            @endif
        @endforeach
    </div>
</section>
