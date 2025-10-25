# Filament Settings Hub - DDD Architecture

## 🏗️ Architecture Overview

This project follows **Domain-Driven Design (DDD)** principles with a clean separation of concerns across multiple layers.

### Directory Structure

```
src/
├── Domain/                          # Core business logic (framework-agnostic)
│   └── Settings/
│       ├── Entities/               # Domain entities with business rules
│       │   └── Setting.php
│       ├── ValueObjects/           # Immutable value objects
│       │   ├── SettingKey.php
│       │   └── SettingGroup.php
│       └── Repositories/           # Repository interfaces
│           └── SettingRepositoryInterface.php
│
├── Application/                     # Application business logic
│   └── Settings/
│       ├── Commands/               # Write operations
│       │   ├── CreateSettingCommand.php
│       │   └── UpdateSettingCommand.php
│       ├── Queries/                # Read operations
│       │   ├── GetSettingByKeyQuery.php
│       │   └── GetSettingsByGroupQuery.php
│       ├── Handlers/               # Command/Query handlers
│       │   ├── CreateSettingHandler.php
│       │   ├── UpdateSettingHandler.php
│       │   ├── GetSettingByKeyHandler.php
│       │   └── GetSettingsByGroupHandler.php
│       ├── DTOs/                   # Data Transfer Objects
│       │   └── SettingData.php
│       └── Services/               # Application services
│           └── SettingService.php
│
├── Infrastructure/                  # External dependencies & implementations
│   └── Persistence/
│       └── Eloquent/
│           ├── Models/             # Eloquent models (infrastructure detail)
│           │   └── SettingModel.php
│           └── Repositories/       # Repository implementations
│               └── EloquentSettingRepository.php
│
└── Presentation/                    # UI Layer (Filament)
    └── Filament/
        ├── Pages/                  # Filament page components
        │   ├── SettingsHubPage.php
        │   ├── SiteSettingsPage.php
        │   ├── LocationSettingsPage.php
        │   ├── SocialMenuSettingsPage.php
        │   └── AuthenticationSettingsPage.php
        └── FilamentSettingsHubPlugin.php
```

## 🎯 Layer Responsibilities

### 1. Domain Layer
**Purpose:** Contains core business logic and rules, completely framework-agnostic.

- **Entities:** Business objects with identity and lifecycle
- **Value Objects:** Immutable objects representing concepts
- **Repository Interfaces:** Contracts for data persistence

**Key Principles:**
- No framework dependencies
- Pure PHP business logic
- Immutable where possible
- Type-safe with strict types

### 2. Application Layer
**Purpose:** Orchestrates domain objects to fulfill use cases.

- **Commands:** Represent write operations (CreateSetting, UpdateSetting)
- **Queries:** Represent read operations (GetSettingByKey, GetSettingsByGroup)
- **Handlers:** Process commands and queries
- **DTOs:** Transfer data between layers
- **Services:** Coordinate complex operations

**Key Principles:**
- Uses CQRS pattern (Command Query Responsibility Segregation)
- Orchestrates domain objects
- Transaction boundaries
- Business use case implementations

### 3. Infrastructure Layer
**Purpose:** Technical implementations and external dependencies.

- **Eloquent Models:** Laravel ORM models
- **Repositories:** Concrete implementations of repository interfaces
- **External Services:** Third-party integrations

**Key Principles:**
- Implements domain interfaces
- Framework-specific code
- Database access
- External API integrations

### 4. Presentation Layer
**Purpose:** User interface and interaction (Filament UI).

- **Pages:** Filament page components
- **Forms:** Form schemas and validation
- **Actions:** UI actions and events
- **Plugin:** Filament plugin configuration

**Key Principles:**
- Depends on Application layer
- No direct domain access
- Uses DTOs for data transfer
- Framework-specific UI code

## 📝 Usage Examples

### Using the Application Service

```php
use Juniyasyos\FilamentSettingsHub\Application\Settings\Services\SettingService;

// Inject via constructor
public function __construct(
    private readonly SettingService $settingService
) {}

// Get a setting
$value = $this->settingService->get('site_name', 'Default Site');

// Set a setting
$this->settingService->set('site_name', 'sites', 'My Awesome Site');

// Check if setting exists
if ($this->settingService->has('site_name')) {
    // ...
}

// Get all settings in a group
$siteSettings = $this->settingService->getByGroup('sites');
```

### Using Commands and Handlers Directly

```php
use Juniyasyos\FilamentSettingsHub\Application\Settings\Commands\CreateSettingCommand;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers\CreateSettingHandler;

$command = new CreateSettingCommand(
    key: 'site_name',
    group: 'sites',
    value: 'My Site'
);

$setting = $handler->handle($command);
```

### Using Queries

```php
use Juniyasyos\FilamentSettingsHub\Application\Settings\Queries\GetSettingByKeyQuery;
use Juniyasyos\FilamentSettingsHub\Application\Settings\Handlers\GetSettingByKeyHandler;

$query = new GetSettingByKeyQuery('site_name');
$settingData = $handler->handle($query);

echo $settingData->value; // Output: My Site
```

## 🔄 Migration from v3 to v4

### Key Changes

1. **Namespace Changes:**
   - Pages moved to `Presentation\Filament\Pages`
   - Plugin moved to `Presentation\Filament`

2. **Filament v4 Updates:**
   - `hint()` replaced with `helperText()`
   - `getFormSchema()` replaced with `form(Form $form): Form`
   - Updated to latest Filament v4 APIs

3. **DDD Structure:**
   - Business logic extracted to Domain layer
   - Application services for use cases
   - Clean separation of concerns

### Backward Compatibility

The legacy `Setting` model is preserved for backward compatibility. New code should use:
- `SettingService` for application logic
- Domain entities for business logic
- Repository interface for persistence

## 🚀 Benefits of DDD Approach

1. **Maintainability:** Clear separation of concerns makes code easier to understand and modify
2. **Testability:** Domain logic can be tested without framework dependencies
3. **Flexibility:** Easy to swap implementations (e.g., change from Eloquent to another ORM)
4. **Scalability:** Well-organized structure supports growth
5. **Type Safety:** Strict typing prevents errors
6. **Business Focus:** Domain layer reflects business requirements clearly

## 🔧 Dependency Injection

The service provider automatically binds:

```php
// Domain Repository Interface → Infrastructure Implementation
SettingRepositoryInterface::class → EloquentSettingRepository::class

// Application Service
SettingService::class (Singleton)
```

Use constructor injection in your classes:

```php
public function __construct(
    private readonly SettingService $settingService,
    private readonly SettingRepositoryInterface $repository
) {}
```

## 📚 Further Reading

- [Domain-Driven Design by Eric Evans](https://www.domainlanguage.com/ddd/)
- [CQRS Pattern](https://martinfowler.com/bliki/CQRS.html)
- [Value Objects](https://martinfowler.com/bliki/ValueObject.html)
- [Repository Pattern](https://martinfowler.com/eaaCatalog/repository.html)
