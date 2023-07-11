<?php

namespace Codions\FilamentCustomFields\CustomFields;

use Codions\FilamentCustomFields\Models\CustomField;
use Codions\FilamentCustomFields\Models\CustomFieldResponse;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class FilamentCustomFieldsHelper
{
    public static function getTypes(): array
    {
        return [
            'number' => 'number',
            'text' => 'text',
            'select' => 'select',
            'textarea' => 'textarea',
            'rich_editor' => 'rich_editor',
            'toggle' => 'toggle',
        ];
    }

    public static function handleCustomFieldsRequest($data, $model, $id = null): void
    {
        $customFieldsData = [];
        foreach ($data as $key => $value) {
            if (Str::startsWith($key, 'customField_')) {
                $customFieldsData[$key] = $value;
            }
        }

        foreach ($customFieldsData as $customFieldDatum => $value) {
            $keys = explode('_', $customFieldDatum);

            $response = CustomFieldResponse::firstOrCreate(
                [
                    'model_id' => $id,
                    'model_type' => $model,
                    'field_id' => $keys[1],
                ],
                [
                    'model_id' => $id,
                    'model_type' => $model,
                    'field_id' => $keys[1],
                    'value' => $value,
                ]
            );
            $response->update(['value' => $value]);
        }
    }

    public static function customFieldsColumn(): TextColumn
    {
        return TextColumn::make('responses')->formatUsing(function ($record) {
            $customFieldResponses = CustomFieldResponse::with('field')
                ->where('model_type', get_class($record))
                ->where('model_id', $record->id)
                ->get();

            $htmlString = '';
            foreach ($customFieldResponses as $response) {
                if ($response->field->show_in_columns) {
                    $htmlString .= $response->field->title . '<br>' . $response->value . '<br>';
                }
            }

            return new \Illuminate\Support\HtmlString($htmlString);
        });
    }

    public static function customFieldsForm($model, $id = null): array
    {
        if ($id) {
            $fields = CustomField::with(['responses' => function ($query) use ($id) {
                $query->where('model_id', $id);
            }])
                ->orderByDesc('order')
                ->where('model_type', $model)
                ->get();
        } else {
            $fields = CustomField::where('model_type', $model)
                ->orderByDesc('order')
                ->get();
        }

        if ($fields->isEmpty()) {
            return [];
        }

        $form = [];
        foreach ($fields as $field) {
            $default = $field->default_value;

            if ($id) {
                foreach ($field->responses as $response) {
                    if ($response->model_id == $id) {
                        $default = $response->value;

                        break;
                    }
                }
            }

            $columnSpan = $field->column_span;

            $input = null;
            switch ($field->type) {
                case 'select':
                    $input = Select::make('customField_' . $field->id)
                        ->label($field->title)
                        ->hint($field->hint)
                        ->options($field->options)
                        ->columnSpan($columnSpan)
                        ->required($field->required == 1)
                        ->afterStateHydrated(fn ($component) => $component->state($default))
                        ->default($default);

                    break;

                case 'textarea':
                    $input = Textarea::make('customField_' . $field->id)
                        ->label($field->title)
                        ->hint($field->hint)
                        ->columnSpan($columnSpan)
                        ->required($field->required == 1)
                        ->afterStateHydrated(fn ($component) => $component->state($default))
                        ->default($default);

                    break;

                case 'toggle':
                    $input = Toggle::make('customField_' . $field->id)
                        ->label($field->title)
                        ->hint($field->hint)
                        ->columnSpan($columnSpan)
                        ->required($field->required == 1)
                        ->afterStateHydrated(fn ($component) => $component->state($default))
                        ->default($default);

                    break;

                case 'rich_editor':
                    $input = RichEditor::make('customField_' . $field->id)
                        ->label($field->title)
                        ->hint($field->hint)
                        ->columnSpan($columnSpan)
                        ->required($field->required == 1)
                        ->afterStateHydrated(fn ($component) => $component->state($default))
                        ->default($default);

                    break;

                default:
                    $input = TextInput::make('customField_' . $field->id)
                        ->label($field->title)
                        ->hint($field->hint)
                        ->columnSpan($columnSpan)
                        ->required($field->required == 1)
                        ->afterStateHydrated(fn ($component) => $component->state($default))
                        ->default($default);

                    if ($field->type == 'number') {
                        $input->numeric();
                    }

                    break;
            }

            if ($field->rules) {
                $input->rules($field->rules);
            }

            $form[] = $input;
        }

        if (! empty($form)) {
            return $form;
        }

        return [];
    }
}
