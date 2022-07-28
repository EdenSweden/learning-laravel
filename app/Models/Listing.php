<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Because it extends Model which contains lots of functionality out of the box, not much else needs to be added to Listing model.

class Listing extends Model
{
    use HasFactory;

    //These must be entered as fillable properties like so, or an error will be thrown when someone tries to create a new listing:
    // protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description', 'tags'];
    //If you don't want to do the above, go to app/Providers/AppServiceProvider.php and write Model::unguard() in the boot() function.

    public function scopeFilter($query, array $filters) {
        // won't run if statement if !$filters['tag']:
        if($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
            ->orWhere('description', 'like', '%' . request('search') . '%')
            ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }
}
