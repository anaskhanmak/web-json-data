<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    private ContentService $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Show the admin dashboard with editable content form.
     * All top-level keys from content.json are shown in a loop.
     */
    public function index()
    {
        $this->contentService->ensureFileExists();
        $content = $this->contentService->readFromFile();

        return view('admin.dashboard', ['content' => $content]);
    }

    /**
     * Save content from the dashboard form to JSON.
     * Accepts dynamic structure from content[section][field].
     */
    public function update(Request $request)
    {
        $raw = $request->input('content', []);

        if (! is_array($raw)) {
            return redirect()->route('admin.dashboard')
                ->withErrors(['content' => 'Invalid content structure.'])
                ->withInput();
        }

        $content = [];
        foreach ($raw as $sectionKey => $sectionData) {
            if (! is_array($sectionData)) {
                continue;
            }
            $content[$sectionKey] = [];
            foreach ($sectionData as $fieldKey => $fieldValue) {
                if ($fieldKey === 'enabled') {
                    $content[$sectionKey]['enabled'] = filter_var($fieldValue, FILTER_VALIDATE_BOOLEAN);
                    continue;
                }
                if (is_array($fieldValue)) {
                    $filtered = array_values(array_filter($fieldValue, fn($v) => $v !== '' && $v !== null));
                    $content[$sectionKey][$fieldKey] = $filtered;
                } elseif (is_string($fieldValue)) {
                    $trimmed = trim($fieldValue);
                    if ($trimmed !== '' && (str_starts_with($trimmed, '[') || str_starts_with($trimmed, '{'))) {
                        $decoded = json_decode($trimmed, true);
                        $content[$sectionKey][$fieldKey] = (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || is_object($decoded))) ? $decoded : $fieldValue;
                    } else {
                        $content[$sectionKey][$fieldKey] = $fieldValue;
                    }
                } else {
                    $content[$sectionKey][$fieldKey] = $fieldValue;
                }
            }
        }

        $rules = $this->buildValidationRules($content);
        $validator = Validator::make($content, $rules);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')
                ->withErrors($validator)
                ->withInput();
        }

        $this->contentService->saveContent($content);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Content saved successfully. Changes are live on the website.');
    }

    /**
     * Build validation rules dynamically for all sections and fields.
     */
    private function buildValidationRules(array $content): array
    {
        $rules = [];
        foreach ($content as $sectionKey => $sectionData) {
            if (! is_array($sectionData)) {
                continue;
            }
            foreach ($sectionData as $fieldKey => $fieldValue) {
                if ($fieldKey === 'enabled') {
                    continue;
                }
                $key = "{$sectionKey}.{$fieldKey}";
                if (is_array($fieldValue) && array_is_list($fieldValue)) {
                    $rules[$key] = 'nullable|array|max:20';
                    $rules["{$key}.*"] = 'nullable|string|max:500';
                } elseif (is_array($fieldValue)) {
                    $rules[$key] = 'nullable|array';
                } else {
                    $rules[$key] = 'nullable|string|max:5000';
                }
            }
        }
        return $rules;
    }
}
