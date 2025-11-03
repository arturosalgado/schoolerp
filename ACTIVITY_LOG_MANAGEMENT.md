# Activity Log Management Guide

## 📊 How to Simulate Millions of Records

### Quick Commands

```bash
# Generate 10,000 records (test)
php artisan tinker --execute="Database\Seeders\ActivityLogSeeder::seedRecords(10000)"

# Generate 100,000 records (~5-10 minutes)
php artisan tinker --execute="Database\Seeders\ActivityLogSeeder::seedRecords(100000)"

# Generate 1 million records (~30-60 minutes)
php artisan tinker --execute="Database\Seeders\ActivityLogSeeder::seedRecords(1000000)"

# Generate 5 million records (~2-4 hours)
php artisan tinker --execute="Database\Seeders\ActivityLogSeeder::seedRecords(5000000)"

# Or use the seeder directly (generates 100k by default)
php artisan db:seed --class=ActivityLogSeeder
```

## 📈 Expected Growth Rates

### Typical School Management System

| User Activity Level | Records/Day | Records/Month | Records/Year | Size/Year (MB) |
|---------------------|-------------|---------------|--------------|----------------|
| **Low** (10 users)  | 100-500     | 3K-15K        | 36K-180K     | 10-50 MB       |
| **Medium** (50 users)| 500-2,500  | 15K-75K       | 180K-900K    | 50-250 MB      |
| **High** (200 users)| 2,000-10,000| 60K-300K      | 720K-3.6M    | 200-1000 MB    |
| **Very High** (500+ users)| 5,000-25,000| 150K-750K | 1.8M-9M      | 500-2500 MB    |

### What Gets Logged (typical):
- User login/logout
- Create/Update/Delete operations on all models
- Failed authentication attempts
- Permission changes
- Data exports
- Email sends
- File uploads
- Configuration changes
- API calls

### Average Record Size: ~0.5-1 KB per record

## ⚠️ Performance Impact

### Database Size Impact:

| Records     | Estimated Size | Query Performance | Recommendations                |
|-------------|----------------|-------------------|--------------------------------|
| < 100K      | < 50 MB        | ✅ Excellent      | No action needed               |
| 100K-500K   | 50-250 MB      | ✅ Good           | Monitor growth                 |
| 500K-1M     | 250-500 MB     | ⚠️ Moderate       | Consider indexes               |
| 1M-5M       | 500MB-2.5GB    | ⚠️ Slow           | Implement cleanup/archiving    |
| > 5M        | > 2.5GB        | ❌ Very Slow      | Urgent: Archive old data       |

### Query Performance:

**Without proper maintenance:**
- Basic queries: Fast until ~1M records
- Complex filters: Slow after ~500K records
- Pagination: Slow on later pages after ~1M records

**With proper indexes and cleanup:**
- Can handle 5M+ records efficiently
- Recent data queries remain fast
- Archived old data doesn't impact performance

## 🔧 Management Commands

### Analyze Current State
```bash
php artisan activitylog:analyze
```
Shows:
- Total records
- Table size (MB)
- Records by time period
- Growth projections
- Top log types
- Performance recommendations

### Cleanup Old Logs

```bash
# Dry run (see what would be deleted)
php artisan activitylog:cleanup --days=90 --dry-run

# Delete logs older than 90 days
php artisan activitylog:cleanup --days=90

# Delete logs older than 180 days
php artisan activitylog:cleanup --days=180

# Delete logs older than 1 year
php artisan activitylog:cleanup --days=365
```

## 🚀 Performance Optimization Tips

### 1. **Add Indexes** (already exists on log_name)
```sql
CREATE INDEX idx_created_at ON activity_log(created_at);
CREATE INDEX idx_school_id ON activity_log(school_id);
CREATE INDEX idx_level ON activity_log(level);
```

### 2. **Implement Automatic Cleanup**
Add to `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    // Delete logs older than 6 months, every Sunday at 2 AM
    $schedule->command('activitylog:cleanup --days=180')
        ->weekly()
        ->sundays()
        ->at('02:00');
}
```

### 3. **Archive Instead of Delete**
```bash
# Export old logs to CSV before deletion
php artisan tinker --execute="
    \Spatie\Activitylog\Models\Activity::where('created_at', '<', now()->subMonths(6))
        ->chunk(10000, function(\$logs) {
            // Export logic here
        });
"
```

### 4. **Use Partitioning** (MySQL 5.7+)
Partition by month for better performance on large tables.

### 5. **Selective Logging**
In your models, only log important changes:
```php
// Only log specific events
protected static $recordEvents = ['created', 'deleted'];

// Don't log certain attributes
protected static $ignoreChangedAttributes = ['updated_at', 'last_login_at'];
```

## 📉 When Will It Slow Down?

### Filament UI Performance:
- **< 100K records**: No noticeable impact
- **100K-500K**: Slight delay on filters and later pages
- **500K-1M**: Noticeable delays, especially with filters
- **> 1M**: Significant slowdown, cleanup highly recommended

### Database Performance:
- **< 500K**: Fast queries
- **500K-2M**: Moderate impact, proper indexes critical
- **> 2M**: Significant impact without cleanup strategy

### Disk Space:
- **1 million records** ≈ 500 MB - 1 GB
- **10 million records** ≈ 5-10 GB

## 💡 Best Practices

1. **Regular Cleanup**: Keep only 3-6 months of logs for daily operations
2. **Archive Important Logs**: Export critical logs before deletion
3. **Monitor Growth**: Run `activitylog:analyze` monthly
4. **Add Indexes**: Especially on columns you filter by
5. **Partition by Time**: For very large tables (>5M records)
6. **Selective Logging**: Don't log every single change
7. **Use Log Levels**: Differentiate between info, warning, error
8. **Separate Critical Logs**: Store security logs separately

## 🔍 Query Examples

```bash
# Count by school
php artisan tinker --execute="
    \Spatie\Activitylog\Models\Activity::select('school_id', DB::raw('count(*) as count'))
        ->groupBy('school_id')
        ->orderByDesc('count')
        ->get()
"

# Recent errors
php artisan tinker --execute="
    \Spatie\Activitylog\Models\Activity::where('level', 'error')
        ->where('created_at', '>=', now()->subDay())
        ->count()
"
```

## 📅 Recommended Retention Policy

| Log Type       | Retention Period |
|----------------|------------------|
| Security Logs  | 2-3 years        |
| User Actions   | 6-12 months      |
| System Events  | 3-6 months       |
| Debug Logs     | 1-3 months       |
| Info Logs      | 1-3 months       |

