<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LegalContentController extends Controller
{
    public function terms(): Response
    {
        $content = $this->content();

        return Inertia::render('Legal/Terms', [
            'content' => $content,
        ]);
    }

    public function privacy(): Response
    {
        $content = $this->content();

        return Inertia::render('Legal/Privacy', [
            'content' => $content,
        ]);
    }

    public function edit(): Response
    {
        return Inertia::render('Legal/Edit', [
            'content' => $this->content(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'project.project_name' => ['required', 'string', 'max:255'],
            'project.developed_by' => ['required', 'string', 'max:255'],
            'project.team_members' => ['array'],
            'project.team_members.*.name' => ['required', 'string', 'max:255'],
            'project.team_members.*.role' => ['required', 'string', 'max:255'],
            'project.upcoming_plans' => ['array'],
            'project.upcoming_plans.*' => ['required', 'string', 'max:500'],

            'documents.terms.page_title' => ['required', 'string', 'max:255'],
            'documents.terms.heading' => ['required', 'string', 'max:255'],
            'documents.terms.last_updated' => ['required', 'string', 'max:255'],
            'documents.terms.intro' => ['required', 'string'],
            'documents.terms.sections' => ['array'],
            'documents.terms.sections.*.title' => ['required', 'string', 'max:255'],
            'documents.terms.sections.*.paragraphs' => ['array'],
            'documents.terms.sections.*.paragraphs.*' => ['required', 'string'],

            'documents.privacy.page_title' => ['required', 'string', 'max:255'],
            'documents.privacy.heading' => ['required', 'string', 'max:255'],
            'documents.privacy.last_updated' => ['required', 'string', 'max:255'],
            'documents.privacy.intro' => ['required', 'string'],
            'documents.privacy.sections' => ['array'],
            'documents.privacy.sections.*.title' => ['required', 'string', 'max:255'],
            'documents.privacy.sections.*.paragraphs' => ['array'],
            'documents.privacy.sections.*.paragraphs.*' => ['required', 'string'],
        ]);

        SiteSetting::putValue('legal_content', $validated);

        return back()->with('status', 'Konten legal berhasil diperbarui.');
    }

    private function content(): array
    {
        return SiteSetting::getValue('legal_content', config('legal'));
    }
}
