@extends('admin.layout')

@section('content')
@php
    $content = old('content', $content);
@endphp
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h1 class="text-xl font-bold text-slate-800">Edit website content</h1>
        <p class="text-sm text-slate-500 mt-1">Changes are saved to <code class="bg-slate-200 px-1 rounded">storage/app/content.json</code>. Add new keys in the JSON file and they will appear here automatically.</p>
    </div>

    <form action="{{ route('admin.dashboard.update') }}" method="POST" class="p-6 space-y-10">
        @csrf

        @foreach($content as $sectionKey => $sectionData)
        @if(!is_array($sectionData))
            @continue
        @endif
        <fieldset class="space-y-4 border border-slate-200 rounded-lg p-5 bg-slate-50/50">
            <legend class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                <input type="hidden" name="content[{{ $sectionKey }}][enabled]" value="0">
                <input type="checkbox" name="content[{{ $sectionKey }}][enabled]" value="1" {{ !empty($sectionData['enabled']) ? 'checked' : '' }} class="rounded border-slate-300">
                <span class="capitalize">{{ str_replace('_', ' ', $sectionKey) }}</span>
            </legend>
            <div class="grid gap-4 pl-7">
                @foreach($sectionData as $fieldKey => $fieldValue)
                    @if($fieldKey === 'enabled')
                        @continue
                    @endif
                    @php
                        $inputName = "content[{$sectionKey}][{$fieldKey}]";
                        $oldValue = old("content.{$sectionKey}.{$fieldKey}", $fieldValue);
                    @endphp
                    @if(is_string($fieldValue))
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">{{ ucfirst(str_replace('_', ' ', $fieldKey)) }}</label>
                            @if(strlen($fieldValue) > 80 || str_contains($fieldValue, "\n"))
                                <textarea name="{{ $inputName }}" rows="4" class="form-control">{{ $oldValue }}</textarea>
                            @else
                                <input type="text" name="{{ $inputName }}" value="{{ $oldValue }}" class="form-control">
                            @endif
                        </div>
                    @elseif(is_array($fieldValue))
                        @php
                            $isList = array_is_list($fieldValue);
                            $listValues = $isList ? $fieldValue : [$fieldValue];
                            $listValues = array_map(fn($v) => is_string($v) ? $v : json_encode($v), $listValues);
                            $listValues = array_pad($listValues, 5, '');
                            $listValues = array_slice($listValues, 0, 15);
                        @endphp
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">{{ ucfirst(str_replace('_', ' ', $fieldKey)) }}</label>
                            @if($isList)
                                <div class="space-y-2">
                                    @foreach($listValues as $idx => $itemVal)
                                    <input type="text" name="content[{{ $sectionKey }}][{{ $fieldKey }}][]" value="{{ $itemVal }}" class="form-control" placeholder="{{ ucfirst($fieldKey) }} {{ $idx + 1 }}">
                                    @endforeach
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Leave empty to remove. Max 15 items.</p>
                            @else
                                @php
                                    $jsonVal = is_string($oldValue) ? $oldValue : json_encode($oldValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                @endphp
                                <textarea name="{{ $inputName }}" rows="6" class="form-control font-mono text-sm" placeholder="JSON object">{{ $jsonVal }}</textarea>
                                <p class="text-xs text-slate-500 mt-1">Edit as JSON object.</p>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </fieldset>
        @endforeach

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-5 py-2.5 bg-slate-800 text-white rounded-lg font-medium hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                Save content
            </button>
            <a href="{{ url('/') }}" class="px-5 py-2.5 bg-slate-200 text-slate-700 rounded-lg font-medium hover:bg-slate-300">Cancel</a>
        </div>
    </form>
</div>
@endsection
