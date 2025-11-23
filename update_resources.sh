#!/bin/bash

# Update AssetResource
sed -i '' '/protected static ?string $model = Asset::class;/a\
\
    protected static ?string $navigationGroup = '\''Assets'\'\';\
\
    protected static ?int $navigationSort = 1;\
\
    protected static ?string $recordTitleAttribute = '\''name'\'\';\
' app/Filament/Resources/Assets/AssetResource.php

# Update AssetCategoryResource
sed -i '' '/protected static ?string $model = AssetCategory::class;/a\
\
    protected static ?string $navigationGroup = '\''Assets'\'\';\
\
    protected static ?int $navigationSort = 2;\
\
    protected static ?string $navigationLabel = '\''Categories'\'\';\
' app/Filament/Resources/AssetCategories/AssetCategoryResource.php

# Update KbArticleResource
sed -i '' '/protected static ?string $model = KbArticle::class;/a\
\
    protected static ?string $navigationGroup = '\''Knowledge Base'\'\';\
\
    protected static ?int $navigationSort = 1;\
\
    protected static ?string $navigationLabel = '\''Articles'\'\';\
\
    protected static ?string $recordTitleAttribute = '\''title'\'\';\
' app/Filament/Resources/KbArticles/KbArticleResource.php

# Update KbCategoryResource
sed -i '' '/protected static ?string $model = KbCategory::class;/a\
\
    protected static ?string $navigationGroup = '\''Knowledge Base'\'\';\
\
    protected static ?int $navigationSort = 2;\
\
    protected static ?string $navigationLabel = '\''Categories'\'\';\
' app/Filament/Resources/KbCategories/KbCategoryResource.php

# Update UserResource
sed -i '' '/protected static ?string $model = User::class;/a\
\
    protected static ?string $navigationGroup = '\''System'\'\';\
\
    protected static ?int $navigationSort = 1;\
\
    protected static ?string $recordTitleAttribute = '\''name'\'\';\
' app/Filament/Resources/Users/UserResource.php

# Update TicketPriorityResource
sed -i '' '/protected static ?string $model = TicketPriority::class;/a\
\
    protected static ?string $navigationGroup = '\''Helpdesk'\'\';\
\
    protected static ?int $navigationSort = 2;\
\
    protected static ?string $navigationLabel = '\''Priorities'\'\';\
' app/Filament/Resources/TicketPriorities/TicketPriorityResource.php

# Update TicketStatusResource
sed -i '' '/protected static ?string $model = TicketStatus::class;/a\
\
    protected static ?string $navigationGroup = '\''Helpdesk'\'\';\
\
    protected static ?int $navigationSort = 3;\
\
    protected static ?string $navigationLabel = '\''Statuses'\'\';\
' app/Filament/Resources/TicketStatuses/TicketStatusResource.php

echo "Resources updated with navigation groups!"
