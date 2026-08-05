namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UrlSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'type',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function urls(): HasMany
    {
        return $this->hasMany(Url::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}