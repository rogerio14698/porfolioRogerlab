<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSkillRequest;
use App\Models\Skill;
use Illuminate\Http\Request;

class AdminSkillController extends Controller
{
    public function index()
    {
        return renderSection('skillsAdmin', __('portfolio.skills'), null, 200, 'noindex,nofollow', [
            'skills' => Skill::orderBy('position')->orderBy('id')->paginate(20)->withQueryString(),
        ]);
    }

    public function create()
    {
        return $this->form(new Skill(['position' => (int) Skill::max('position') + 1]));
    }

    public function edit(Skill $skill)
    {
        return $this->form($skill);
    }

    private function form(Skill $skill)
    {
        return renderSection('skillEditor', __('portfolio.skills'), null, 200, 'noindex,nofollow', compact('skill'));
    }

    public function store(SaveSkillRequest $request)
    {
        return $this->save($request, new Skill);
    }

    public function update(SaveSkillRequest $request, Skill $skill)
    {
        return $this->save($request, $skill);
    }

    private function save(SaveSkillRequest $request, Skill $skill)
    {
        $data = $request->validated();
        $skill->fill(collect($data)->only(['translations', 'position'])->all());
        $skill->is_published = $data['status'] === 'published';
        $skill->save();

        return redirect()->route('admin.skills.edit', ['skill' => $skill, 'lang' => app()->getLocale()])
            ->with('status', __('portfolio.saved'));
    }

    public function destroy(Request $request, Skill $skill)
    {
        $request->validate(['confirm_delete' => ['accepted']]);
        $skill->delete();

        return redirect()->route('admin.skills.index', ['lang' => app()->getLocale()])->with('status', __('portfolio.deleted'));
    }
}
