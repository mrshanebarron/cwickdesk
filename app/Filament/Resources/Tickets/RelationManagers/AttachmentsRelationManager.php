<?php

namespace App\Filament\Resources\Tickets\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';

    protected static ?string $recordTitleAttribute = 'original_filename';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                FileUpload::make('file')
                    ->label('Upload File')
                    ->required()
                    ->maxSize(10240) // 10MB max
                    ->acceptedFileTypes([
                        'image/*',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'text/plain',
                        'application/zip',
                    ])
                    ->disk('local')
                    ->directory('ticket-attachments')
                    ->preserveFilenames()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('original_filename')
                    ->label('File Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-paper-clip'),

                TextColumn::make('mime_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'image') => 'success',
                        str_contains($state, 'pdf') => 'danger',
                        str_contains($state, 'word') => 'primary',
                        str_contains($state, 'excel') => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('file_size')
                    ->label('Size')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 2) . ' KB' : '—')
                    ->alignEnd(),

                TextColumn::make('uploadedBy.name')
                    ->label('Uploaded By')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Handle file upload
                        $file = $data['file'];

                        return [
                            'uploaded_by_id' => auth()->id(),
                            'filename' => $file,
                            'original_filename' => $file->getClientOriginalName(),
                            'mime_type' => $file->getMimeType(),
                            'file_size' => $file->getSize(),
                            'storage_path' => $file->store('ticket-attachments', 'local'),
                        ];
                    }),
            ])
            ->actions([
                DeleteAction::make()
                    ->after(function ($record) {
                        // Delete the actual file from storage
                        if ($record->storage_path && Storage::disk('local')->exists($record->storage_path)) {
                            Storage::disk('local')->delete($record->storage_path);
                        }
                    }),
            ]);
    }
}
