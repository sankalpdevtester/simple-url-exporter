namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'title',
        'description',
        'url_source_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'url_source_id' => 'integer',
    ];

    public function urlSource(): BelongsTo
    {
        return $this->belongsTo(UrlSource::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->whereHas('urlSource', function ($q) use ($type) {
            $q->where('type', $type);
        });
    }
}