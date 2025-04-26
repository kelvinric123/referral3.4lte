# Specialties Management Setup

This document provides instructions for setting up the Specialties Management functionality in the Medical Referral System.

## Implementation Details

The following files have been created/modified:

1. Model: `app/Models/Specialty.php`
2. Controller: `app/Http/Controllers/Admin/SpecialtyController.php`
3. Views: 
   - `resources/views/admin/specialties/index.blade.php`
   - `resources/views/admin/specialties/create.blade.php`
   - `resources/views/admin/specialties/edit.blade.php`
   - `resources/views/admin/specialties/show.blade.php`
4. Migration: `database/migrations/2024_05_05_000000_create_specialties_table.php`
5. Seeder: `database/seeders/SpecialtySeeder.php`
6. Routes added to `routes/web.php`
7. Menu item added to `config/adminlte.php`

## Setup Instructions

1. Run the migration to create the specialties table:

```bash
php artisan migrate
```

2. Run the seeder to populate the specialties:

```bash
php artisan db:seed --class=SpecialtySeeder
```

Or, alternatively, run all seeders:

```bash
php artisan db:seed
```

## Accessing the Specialties Management

Once the setup is completed, you can access the specialties management at:

```
http://localhost:8000/admin/specialties
```

## Specialty Relationship to Hospitals

Each specialty belongs to a hospital. The relationship is defined as:

- A Hospital has many Specialties (`hasMany` relationship)
- A Specialty belongs to a Hospital (`belongsTo` relationship)

When creating or editing a specialty, you need to select which hospital it belongs to.

## Feature Capabilities

The Specialties Management feature allows you to:

1. View all specialties in a list
2. Create new specialties
3. View details of a specialty
4. Edit existing specialties
5. Delete specialties

All these operations include proper validation and error handling. 